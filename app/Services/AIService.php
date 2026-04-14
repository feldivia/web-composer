<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\SectionLibraryService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Servicio de integración con IA (Claude API como principal, GPT como fallback).
 *
 * Provee generación de textos, sugerencias SEO, traducción y generación
 * de estructuras de página completas.
 */
class AIService
{
    private string $provider;
    private int $maxTokens;
    private int $rateLimitPerHour;

    public function __construct()
    {
        $this->provider = config('webcomposer.ai.default_provider', 'anthropic');
        $this->maxTokens = config('webcomposer.ai.max_tokens', 2048);
        $this->rateLimitPerHour = config('webcomposer.ai.rate_limit_per_hour', 50);
    }

    /**
     * Genera texto para una sección específica.
     *
     * @param  string  $sectionType  Tipo de sección (hero, features, about, cta, etc.)
     * @param  string  $businessType  Tipo de negocio (restaurante, startup, clínica, etc.)
     * @param  string  $tone  Tono de escritura (profesional, casual, formal, divertido)
     * @param  string  $language  Idioma (es, en, pt)
     * @return array{title: string, subtitle: string, description: string, cta: string}
     */
    public function generateText(string $sectionType, string $businessType, string $tone = 'profesional', string $language = 'es'): array
    {
        $this->checkRateLimit();

        $prompt = $this->buildTextPrompt($sectionType, $businessType, $tone, $language);

        $response = $this->callAI($prompt, 'Genera contenido de texto para una sección de sitio web. Responde SOLO con JSON válido.');

        return $this->parseJsonResponse($response, [
            'title' => 'Título de ejemplo',
            'subtitle' => 'Subtítulo de ejemplo',
            'description' => 'Descripción de ejemplo para esta sección.',
            'cta' => 'Comenzar',
        ]);
    }

    /**
     * Genera sugerencias SEO para una página o post.
     *
     * @param  string  $title  Título actual
     * @param  string  $content  Contenido HTML o texto
     * @param  string  $language  Idioma
     * @return array{seo_title: string, seo_description: string, keywords: string[], og_title: string}
     */
    public function generateSEO(string $title, string $content, string $language = 'es'): array
    {
        $this->checkRateLimit();

        $cleanContent = strip_tags(mb_substr($content, 0, 2000));

        $prompt = "Analiza el siguiente contenido y genera sugerencias SEO optimizadas en idioma '{$language}'.

Título: {$title}
Contenido: {$cleanContent}

Responde SOLO con JSON válido con esta estructura:
{
    \"seo_title\": \"título SEO optimizado (máx 60 chars)\",
    \"seo_description\": \"meta description optimizada (máx 160 chars)\",
    \"keywords\": [\"keyword1\", \"keyword2\", \"keyword3\", \"keyword4\", \"keyword5\"],
    \"og_title\": \"título para Open Graph\"
}";

        $response = $this->callAI($prompt, 'Eres un experto en SEO. Responde SOLO con JSON válido.');

        return $this->parseJsonResponse($response, [
            'seo_title' => $title,
            'seo_description' => mb_substr($cleanContent, 0, 160),
            'keywords' => [],
            'og_title' => $title,
        ]);
    }

    /**
     * Traduce contenido a otro idioma.
     *
     * @param  string  $content  Contenido a traducir
     * @param  string  $targetLanguage  Idioma destino (es, en, pt, fr, de, it)
     * @param  string  $sourceLanguage  Idioma origen (auto-detectar si vacío)
     * @return array{translated: string, source_language: string}
     */
    public function translate(string $content, string $targetLanguage, string $sourceLanguage = ''): array
    {
        $this->checkRateLimit();

        $sourceInfo = $sourceLanguage ? "desde {$sourceLanguage}" : '(detecta el idioma automáticamente)';

        $prompt = "Traduce el siguiente texto {$sourceInfo} al idioma '{$targetLanguage}'. Mantén el formato HTML si existe. Responde SOLO con JSON válido.

Texto:
{$content}

Formato de respuesta:
{
    \"translated\": \"texto traducido aquí\",
    \"source_language\": \"código del idioma detectado\"
}";

        $response = $this->callAI($prompt, 'Eres un traductor profesional. Responde SOLO con JSON válido.');

        return $this->parseJsonResponse($response, [
            'translated' => $content,
            'source_language' => $sourceLanguage ?: 'unknown',
        ]);
    }

    /**
     * Genera una estructura de página completa basada en un brief.
     *
     * @param  string  $businessType  Tipo de negocio
     * @param  string  $description  Descripción del negocio
     * @param  string  $sections  Secciones deseadas separadas por coma
     * @param  string  $language  Idioma
     * @return array{html: string, css: string}
     */
    public function generatePage(string $businessType, string $description, string $sections = '', string $language = 'es'): array
    {
        $this->checkRateLimit();

        $sectionsList = $sections ?: 'hero, features, about, testimonials, cta, footer';

        $prompt = "Genera el HTML completo para una landing page moderna para un negocio de tipo '{$businessType}'.

Descripción: {$description}
Secciones requeridas: {$sectionsList}
Idioma: {$language}

Requisitos:
- HTML semántico con estilos inline
- Diseño moderno, minimalista, mobile-first
- Colores: primario #6366F1, secundario #0EA5E9, texto #1E293B
- Usar fuente 'Inter' para body y 'Montserrat' para headings
- Cada sección debe tener padding generoso (60-80px vertical)
- Incluir contenido realista y relevante (NO lorem ipsum)
- Responsive: usar max-width, grid con fr units

Responde SOLO con JSON válido:
{
    \"html\": \"<section>...</section><section>...</section>\",
    \"css\": \"estilos CSS adicionales si son necesarios\"
}";

        $response = $this->callAI($prompt, 'Eres un diseñador web experto. Genera HTML moderno con estilos inline. Responde SOLO con JSON válido.', 4096);

        return $this->parseJsonResponse($response, [
            'html' => '<section style="padding:80px 20px; text-align:center;"><h1>Página generada</h1><p>No se pudo generar el contenido. Intenta de nuevo.</p></section>',
            'css' => '',
        ]);
    }

    /**
     * Genera una página completa basada en información del negocio del wizard de IA.
     *
     * Construye un prompt detallado que incluye contexto del negocio, secciones
     * seleccionadas, paleta de colores y tipografías para generar HTML/CSS completo.
     *
     * @param  string  $businessName         Nombre del negocio
     * @param  string  $businessDescription  Descripción detallada del negocio
     * @param  array   $sections             Lista de secciones a generar (ej: ['hero', 'services', 'contact'])
     * @param  array   $colors               Paleta de colores {primary, secondary, accent, background, text}
     * @param  array   $fonts                Par de fuentes {heading, body}
     * @return array{html: string, css: string}
     */
    public function generateFullPage(
        string $businessName,
        string $businessDescription,
        array $sections,
        array $colors,
        array $fonts,
    ): array {
        $this->checkRateLimit();

        $sectionDescriptions = [
            'hero' => 'HERO — Seccion de impacto visual. Layout a 2 columnas (grid 1.1fr 0.9fr): columna izquierda con badge superior (texto pequeno uppercase con linea decorativa antes), titulo h1 grande (usa font-size: clamp(2.5rem, 4.5vw, 3.8rem), font-weight 400, con una palabra clave en cursiva <em> y color primario), subtitulo en gris claro (font-weight 300, max-width 500px), 2 botones (primario solido + outline). Columna derecha: placeholder de imagen (aspect-ratio 3/4 con borde decorativo en esquinas usando ::before/::after). Fondo con gradiente sutil entre tonos del background. Agregar ornamentos decorativos con radial-gradient circulares semitransparentes en posicion absoluta.',
            'services' => 'SERVICIOS — Encabezado centrado con tag uppercase pequeno (con lineas decorativas a ambos lados), titulo h2 con palabra en cursiva <em>. Grid de 3 columnas con tarjetas: cada tarjeta tiene borde sutil, icono emoji en circulo con fondo suave, titulo h3 (font-display), descripcion en gris, link "Consultar →" con efecto hover que aumenta el gap. Efecto hover en tarjetas: translateY(-4px), sombra, y barra de color gradient en la parte superior (transform scaleX 0 a 1). Padding generoso 2.5rem.',
            'about' => 'SOBRE NOSOTROS — Grid de 2 columnas (0.8fr 1.2fr): izquierda imagen placeholder (aspect-ratio 4/5) con borde decorativo interno usando ::after (border 1px semitransparente con inset 15px). Derecha: tag uppercase, titulo h2 con palabra en <em>, 2 parrafos descriptivos (font-weight 300, color gris, line-height 1.8), lista de credenciales/logros con icono circular + texto en filas, separadas por border-top sutil.',
            'pricing' => 'PRECIOS — Encabezado centrado. Grid de 3 tarjetas de precios: cada una con nombre del plan, precio grande (font-display, 2.5rem), periodo (/mes), lista de caracteristicas con checks, boton CTA. La tarjeta central debe tener borde de color primario, badge "Mas popular" y fondo ligeramente diferente. Hover con sombra y translateY.',
            'testimonials' => 'TESTIMONIOS — Encabezado centrado. Grid de 3 tarjetas: cada una con comillas grandes decorativas (font-size 4rem, color primario, opacity 0.15), texto del testimonio en cursiva, separador fino, foto circular (60px, border 2px color primario), nombre en negrita, cargo en gris pequeno. Fondo blanco con sombra sutil y hover lift.',
            'gallery' => 'GALERIA — Encabezado centrado. Grid de 3 columnas con 6 imagenes (aspect-ratio 1, usa https://picsum.photos/400/400?random=N). Cada imagen con overflow hidden, hover scale(1.05) en la imagen. Overlay que sube desde abajo (translateY 100% a 0) con gradiente transparente a oscuro y texto descriptivo blanco.',
            'faq' => 'FAQ — Encabezado centrado. Contenedor centrado (max-width 750px). 5 preguntas relevantes al negocio. Cada pregunta: border-bottom sutil, button con display flex justify-between, font-display, + icono que rota a × cuando activo. Respuesta con max-height 0 y overflow hidden, transicion suave. Clase .active expande la respuesta. Texto de respuesta en gris con font-weight 300.',
            'team' => 'EQUIPO — Encabezado centrado. Grid de 3-4 tarjetas: foto placeholder circular grande (150px), nombre en font-display, cargo en uppercase pequeno color primario, bio breve. Hover: overlay con iconos de redes sociales. Tarjeta con padding generoso y transicion suave.',
            'stats' => 'ESTADISTICAS — Fondo oscuro (charcoal/dark) con borde superior de 3px color acento. Grid de 4 columnas centradas. Cada stat: numero grande (font-display, 2.4rem, color dorado/acento), label en uppercase pequeno blanco semitransparente. Numeros relevantes al negocio.',
            'contact' => 'CONTACTO — Grid de 2 columnas: izquierda formulario (campos nombre, email, telefono, mensaje con estilos limpios: border 1px, padding 1rem, font-family inherit, focus con border color primario) y boton enviar. El form debe tener atributo data-contact-form. Derecha: info de contacto (direccion, telefono, email, horario) con iconos. Agregar campo oculto honeypot.',
            'newsletter' => 'NEWSLETTER — Fondo con gradiente del color primario al secundario. Contenido centrado (max-width 500px): titulo blanco, descripcion semitransparente, formulario inline (input email + boton) con input de fondo blanco semi-transparente y boton blanco con texto primario.',
            'map' => 'UBICACION — Grid de 2 columnas: izquierda placeholder de mapa (rectangulo gris 100% height con texto centrado "Ver en Google Maps"), derecha info de ubicacion, horarios en tabla limpia, indicaciones de como llegar.',
        ];

        $sectionInstructions = '';
        foreach ($sections as $index => $section) {
            $desc = $sectionDescriptions[$section] ?? "Seccion de tipo '{$section}'";
            $order = $index + 1;
            $sectionInstructions .= "\n{$order}. {$desc}";
        }

        $prompt = "Genera el HTML y CSS para una pagina web de ALTA CALIDAD visual para este negocio:

NEGOCIO: {$businessName}
DESCRIPCION: {$businessDescription}

COLORES CSS (usarlos como variables):
--primary: {$colors['primary']}
--secondary: {$colors['secondary']}
--accent: {$colors['accent']}
--bg: {$colors['background']}
--text: {$colors['text']}

TIPOGRAFIAS:
--font-display: '{$fonts['heading']}', serif
--font-body: '{$fonts['body']}', sans-serif

SECCIONES (generar en este orden):
{$sectionInstructions}

REGLAS DE DISENO PREMIUM (OBLIGATORIAS — SEGUIR AL PIE DE LA LETRA):

ESTRUCTURA:
1. Cada seccion en <section data-section-type=\"TIPO\">
2. CSS SEPARADO del HTML (no inline styles). Usar clases CSS con prefijo por seccion (ej: .wc-hero-*, .wc-services-*)
3. CSS usa variables: var(--color-primary), var(--color-secondary), var(--color-accent), var(--color-background), var(--color-text), var(--font-heading), var(--font-body)
4. NO incluir <html>, <head>, <body>, <style>, <link>. Solo secciones HTML y CSS separado

TIPOGRAFIA:
5. Titulos h1: font-family var(--font-heading); font-size clamp(2.5rem, 5vw, 4.2rem); font-weight 600; line-height 1.08-1.15
6. Titulos h2: font-family var(--font-heading); font-size clamp(1.8rem, 3.5vw, 2.8rem); font-weight 600; line-height 1.2
7. Usar <em> con font-style italic y color primario para palabras clave dentro de titulos
8. Parrafos: font-weight 300; color gris medio (#6B6B6B); line-height 1.85; font-size 0.95-1.05rem
9. Section labels: contenedor flex con div.line (width 30px, height 2px, background acento) + span (0.65rem, uppercase, letter-spacing 3px, font-weight 600, color acento)

BOTONES:
10. Primario: padding 0.9rem 2.4rem; border-radius 50px; font-size 0.85rem; font-weight 500; uppercase NO; letter-spacing 0.5px; background primario; color claro
11. Hover PREMIUM: translateY(-2px) + box-shadow 0 10px 30px rgba(color,0.25); transition cubic-bezier(0.22,1,0.36,1)
12. Boton ghost: border 1.5px solid gris; mismo padding; hover borde acento + color acento

TARJETAS:
13. Background blanco; border-radius 14-16px; border 1px solid color sand/gris muy claro; padding 2rem
14. Hover: translateY(-5px a -8px); box-shadow 0 15px 40px rgba(0,0,0,0.06); transition cubic-bezier(0.22,1,0.36,1)
15. Barra superior: ::before con height 3px, background gradient primario→acento, scaleX(0)→scaleX(1) en hover

LAYOUT:
16. Contenedores: max-width 1100px; margin 0 auto; padding 0 8%
17. Padding secciones: clamp(4rem, 8vw, 7rem) vertical
18. Grids: usar CSS Grid con gap 1.5-2rem
19. Ritmo visual: alternar fondos cream (#FAF8F4), blanco (#FFFFFF), oscuro (#1A2744 o #2B2426)

HERO:
20. Grid 2 columnas (1.1fr 1fr). Izquierda: eyebrow badge (inline-flex, gap 0.6rem, background rgba acento 0.15, border-radius 50px, padding 0.4rem 1.2rem, con dot animado 8px), h1 grande, descripcion max-width 480px, 2 botones, trust bar con numeros debajo (border-top sutil)
21. Derecha: visual con fondo oscuro gradient, o imagen con overlay

RESPONSIVE:
22. 4 breakpoints: @media (max-width: 1024px), (max-width: 768px), (max-width: 480px)
23. Mobile: grids a 1 columna, hero single column, padding reducido, font-sizes ajustados
24. Botones en mobile: flex-direction column, width 100%

CONTENIDO:
25. 100% en ESPANOL. Contenido realista, especifico para este negocio. NUNCA lorem ipsum
26. Textos profesionales, persuasivos y relevantes. Nombres, datos y cifras creibles
27. Imagenes: https://picsum.photos/WIDTH/HEIGHT?random=N (diferente N cada una)

Responde SOLO con JSON valido sin markdown ni backticks:
{\"html\":\"<section data-section-type=...>...</section>...\",\"css\":\".wc-hero { ... } @media (max-width:768px) { ... }\"}";

        $systemMessage = 'Eres un disenador web de agencia premium que cobra $15,000 USD por landing page. Tu nivel de calidad es comparable a Vercel.com, Linear.app, o sitios de clinicas de lujo. Cada pixel importa. Usas tipografia serif elegante para titulos (font-weight medio, nunca heavy), sans-serif light para cuerpo, spacing generoso, colores sofisticados (nunca saturados), transiciones con cubic-bezier premium, y elementos decorativos sutiles (lineas, gradientes radiales, badges con dots animados). Tu CSS es limpio, organizado por seccion, con clases semanticas. Tu HTML es semantico y accesible. El resultado final debe verse como un sitio hecho a medida, no como un template generico. Responde SOLO con JSON valido.';

        $response = $this->callAI($prompt, $systemMessage, 16000);

        return $this->parseJsonResponse($response, [
            'html' => '<section data-section-type="hero" style="padding:80px 20px; text-align:center;"><h1 style="font-size:2.5rem; margin-bottom:16px;">' . e($businessName) . '</h1><p style="font-size:1.2rem; color:#666;">No se pudo generar el contenido automaticamente. Usa el editor para crear tu pagina.</p></section>',
            'css' => '',
        ]);
    }

    /**
     * Genera contenido de texto para secciones pre-construidas.
     *
     * NO genera HTML/CSS. Solo rellena los placeholders de texto de cada seccion
     * usando la biblioteca de secciones premium (SectionLibraryService).
     *
     * @param  string  $businessName         Nombre del negocio
     * @param  string  $businessDescription  Descripcion detallada del negocio
     * @param  array   $sections             Array de IDs de seccion (ej: ['hero-split', 'services-cards'])
     * @param  string  $language             Idioma del contenido generado
     * @return array<string, array>          Contenido por seccion: ['hero-split' => ['eyebrow' => '...', 'title' => '...'], ...]
     */
    public function generateSectionContent(
        string $businessName,
        string $businessDescription,
        array $sections,
        string $language = 'es'
    ): array {
        $this->checkRateLimit();

        // Obtener definiciones de placeholders de cada seccion
        $sectionPromptParts = [];
        $sectionIndex = 0;

        foreach ($sections as $sectionId) {
            $sectionIndex++;
            $section = SectionLibraryService::get($sectionId);

            if ($section === null) {
                continue;
            }

            $name = $section['name'] ?? $sectionId;
            $placeholders = $section['placeholders'] ?? [];

            $fieldsDesc = '';
            foreach ($placeholders as $key => $placeholder) {
                $label = $placeholder['label'] ?? $key;
                $hint = $placeholder['hint'] ?? '';
                $type = $placeholder['type'] ?? 'text';

                if ($type === 'array') {
                    $itemFields = $placeholder['fields'] ?? [];
                    $count = $placeholder['count'] ?? 3;
                    $itemDesc = [];
                    foreach ($itemFields as $fKey => $fMeta) {
                        $fHint = is_string($fMeta) ? $fMeta : ($fMeta['hint'] ?? $fKey);
                        $itemDesc[] = $fKey . ': ' . $fHint;
                    }
                    $fieldsDesc .= "- {$key}: Array de {$count} elementos, cada uno con: " . implode(', ', $itemDesc) . "\n";
                } else {
                    $hintText = $hint ? " ({$hint})" : '';
                    $fieldsDesc .= "- {$key}: {$label}{$hintText}\n";
                }
            }

            $sectionPromptParts[] = "SECCION {$sectionIndex}: {$name} ({$sectionId})\n{$fieldsDesc}";
        }

        if (empty($sectionPromptParts)) {
            return [];
        }

        $sectionsPrompt = implode("\n", $sectionPromptParts);

        $prompt = "Genera contenido en '{$language}' para un sitio web de: {$businessName}
Descripcion: {$businessDescription}

Necesito contenido para estas secciones:

{$sectionsPrompt}

REGLAS:
1. Todo el contenido debe ser especifico y relevante para este negocio
2. Textos persuasivos, profesionales y realistas (NUNCA lorem ipsum)
3. Titulos impactantes pero no exagerados (8-15 palabras max)
4. Descripciones concisas y claras (2-3 lineas max)
5. CTAs directos y accionables (2-4 palabras)
6. Estadisticas y numeros creibles para el tipo de negocio
7. Si un campo pide 'highlight', devuelve 1-3 palabras del titulo que se puedan resaltar

Responde SOLO con JSON valido donde las claves de primer nivel son los IDs de seccion:
{
    \"seccion-id\": {
        \"campo1\": \"valor\",
        \"campo2\": \"valor\"
    }
}";

        $systemMessage = 'Eres un copywriter profesional especializado en sitios web. Generas contenido persuasivo, claro y especifico para cada negocio. Responde SOLO con JSON valido, sin markdown ni backticks.';

        $response = $this->callAI($prompt, $systemMessage, 4096);

        $result = $this->parseJsonResponse($response, []);

        // Asegurar que cada seccion solicitada tenga al menos un array vacio
        $output = [];
        foreach ($sections as $sectionId) {
            $output[$sectionId] = $result[$sectionId] ?? [];
        }

        return $output;
    }

    /**
     * Genera variantes de copy para un texto dado.
     *
     * @param  string  $originalText  Texto original
     * @param  int     $variants  Número de variantes (1-5)
     * @param  string  $tone  Tono deseado
     * @return array{variants: string[]}
     */
    public function generateVariants(string $originalText, int $variants = 3, string $tone = 'profesional'): array
    {
        $this->checkRateLimit();

        $variants = min(max($variants, 1), 5);

        $prompt = "Genera {$variants} variantes alternativas del siguiente texto con tono '{$tone}'.

Texto original: {$originalText}

Responde SOLO con JSON válido:
{
    \"variants\": [\"variante 1\", \"variante 2\", \"variante 3\"]
}";

        $response = $this->callAI($prompt, 'Eres un copywriter experto. Responde SOLO con JSON válido.');

        return $this->parseJsonResponse($response, [
            'variants' => [$originalText],
        ]);
    }

    /**
     * Genera una paleta de colores ideal para un negocio usando IA.
     *
     * @return array{primary: string, secondary: string, accent: string, background: string, text: string}
     */
    public function generateColorPalette(string $businessName, string $businessDescription): array
    {
        $prompt = "Genera una paleta de 5 colores en formato hexadecimal ideal para este negocio:
Negocio: {$businessName}
Descripcion: {$businessDescription}

Los colores deben ser:
- primary: color principal de la marca (botones, links, destacados)
- secondary: color complementario
- accent: color de acento para CTAs y detalles
- background: color de fondo (claro, casi blanco)
- text: color del texto principal (oscuro, casi negro)

Los colores deben verse profesionales y modernos, con buen contraste entre background y text.
Responde SOLO con JSON valido:
{\"primary\":\"#hex\",\"secondary\":\"#hex\",\"accent\":\"#hex\",\"background\":\"#hex\",\"text\":\"#hex\"}";

        $response = $this->callAI($prompt, 'Eres un disenador experto en branding y paletas de color. Responde SOLO con JSON valido.', 256);

        $fallback = [
            'primary' => '#6366F1',
            'secondary' => '#0EA5E9',
            'accent' => '#F59E0B',
            'background' => '#FFFFFF',
            'text' => '#1E293B',
        ];

        return $this->parseJsonResponse($response, $fallback);
    }

    /**
     * Llama a la API de IA (Claude o GPT).
     */
    private function callAI(string $prompt, string $systemMessage = '', ?int $maxTokens = null): string
    {
        $maxTokens = $maxTokens ?? $this->maxTokens;

        try {
            if ($this->provider === 'anthropic') {
                return $this->callClaude($prompt, $systemMessage, $maxTokens);
            }
            return $this->callGPT($prompt, $systemMessage, $maxTokens);
        } catch (\Exception $e) {
            Log::warning("AI primary provider ({$this->provider}) failed: {$e->getMessage()}");

            // Fallback al proveedor alternativo (solo si tiene API key)
            $fallbackProvider = $this->provider === 'anthropic' ? 'openai' : 'anthropic';
            $fallbackKey = $fallbackProvider === 'openai'
                ? config('services.openai.api_key')
                : config('services.anthropic.api_key');

            if (empty($fallbackKey)) {
                Log::error("AI fallback ({$fallbackProvider}) no tiene API key configurada. Relanzando error original.");
                throw $e;
            }

            try {
                if ($this->provider === 'anthropic') {
                    return $this->callGPT($prompt, $systemMessage, $maxTokens);
                }
                return $this->callClaude($prompt, $systemMessage, $maxTokens);
            } catch (\Exception $fallbackException) {
                Log::error("AI fallback also failed: {$fallbackException->getMessage()}");
                throw $fallbackException;
            }
        }
    }

    /**
     * Llama a Claude API (Anthropic).
     * Intenta con Opus, si falla por sobrecarga reintenta con Sonnet.
     */
    private function callClaude(string $prompt, string $systemMessage, int $maxTokens): string
    {
        $apiKey = config('services.anthropic.api_key');

        if (empty($apiKey)) {
            throw new \RuntimeException('ANTHROPIC_API_KEY no configurada.');
        }

        $models = ['claude-opus-4-20250514', 'claude-sonnet-4-20250514'];

        foreach ($models as $index => $model) {
            $attempts = $index === 0 ? 2 : 1; // 2 intentos para Opus, 1 para Sonnet

            for ($attempt = 1; $attempt <= $attempts; $attempt++) {
                $response = Http::withHeaders([
                    'x-api-key' => $apiKey,
                    'anthropic-version' => '2023-06-01',
                    'content-type' => 'application/json',
                ])->timeout(180)->post('https://api.anthropic.com/v1/messages', [
                    'model' => $model,
                    'max_tokens' => $maxTokens,
                    'system' => $systemMessage,
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

                if ($response->successful()) {
                    if ($index > 0) {
                        Log::info("Claude fallback a {$model} exitoso.");
                    }
                    $data = $response->json();
                    return $data['content'][0]['text'] ?? '';
                }

                $body = $response->body();
                $isOverloaded = str_contains($body, 'overloaded') || $response->status() === 529;
                $isRateLimit = $response->status() === 429;

                if ($isOverloaded || $isRateLimit) {
                    Log::warning("Claude {$model} intento {$attempt}: sobrecargado/rate-limit. " .
                        ($attempt < $attempts ? 'Reintentando en 3s...' : 'Probando siguiente modelo...'));
                    if ($attempt < $attempts) {
                        sleep(3);
                    }
                    continue;
                }

                // Error no recuperable
                throw new \RuntimeException("Claude API error ({$model}): " . $body);
            }
        }

        throw new \RuntimeException('Claude API: todos los modelos sobrecargados. Intenta de nuevo en unos minutos.');
    }

    /**
     * Llama a GPT API (OpenAI) como fallback.
     */
    private function callGPT(string $prompt, string $systemMessage, int $maxTokens): string
    {
        $apiKey = config('services.openai.api_key');

        if (empty($apiKey)) {
            throw new \RuntimeException('OPENAI_API_KEY no configurada.');
        }

        $messages = [];
        if ($systemMessage) {
            $messages[] = ['role' => 'system', 'content' => $systemMessage];
        }
        $messages[] = ['role' => 'user', 'content' => $prompt];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'max_tokens' => $maxTokens,
            'messages' => $messages,
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('OpenAI API error: ' . $response->body());
        }

        $data = $response->json();

        return $data['choices'][0]['message']['content'] ?? '';
    }

    /**
     * Verifica el rate limit por hora.
     *
     * @throws \RuntimeException Si se excede el límite de solicitudes
     */
    private function checkRateLimit(): void
    {
        $key = 'ai_rate_limit_' . (auth()->id() ?? 'global');
        $count = (int) Cache::get($key, 0);

        if ($count >= $this->rateLimitPerHour) {
            throw new \RuntimeException('Límite de solicitudes IA alcanzado. Intenta más tarde.');
        }

        Cache::put($key, $count + 1, now()->endOfHour());
    }

    /**
     * Parsea una respuesta JSON de la IA con fallback a valores por defecto.
     *
     * @param  string  $response  Respuesta cruda de la IA
     * @param  array   $fallback  Valores por defecto si el parseo falla
     * @return array
     */
    private function parseJsonResponse(string $response, array $fallback): array
    {
        // Intentar extraer JSON de la respuesta (la IA a veces envuelve en markdown)
        $cleaned = $response;
        if (preg_match('/```(?:json)?\s*([\s\S]*?)```/', $response, $matches)) {
            $cleaned = $matches[1];
        }

        $cleaned = trim($cleaned);

        $parsed = json_decode($cleaned, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
            return array_merge($fallback, $parsed);
        }

        Log::warning('AI response could not be parsed as JSON', ['response' => mb_substr($response, 0, 500)]);

        return $fallback;
    }

    /**
     * Regenera una sección existente con nuevas instrucciones.
     *
     * @param  string  $sectionType  Tipo de sección (hero, features, pricing, etc.)
     * @param  string  $currentHtml  HTML actual de la sección
     * @param  string  $instructions  Instrucciones del usuario sobre qué cambiar
     * @param  string  $tone  Tono de escritura (profesional, casual, formal, divertido, inspirador)
     * @param  array   $colors  Paleta de colores { primary, secondary, accent, background, text }
     * @return string  HTML de la sección regenerada
     */
    public function regenerateSection(string $sectionType, string $currentHtml, string $instructions, string $tone, array $colors = []): string
    {
        $this->checkRateLimit();

        $colorInfo = '';
        if (!empty($colors)) {
            $colorInfo = "Usa estos colores: primario {$colors['primary']}, secundario {$colors['secondary']}, acento {$colors['accent']}, fondo {$colors['background']}, texto {$colors['text']}.";
        }

        $prompt = "Regenera esta seccion de tipo '{$sectionType}' con calidad PREMIUM.

HTML ACTUAL:
{$currentHtml}

INSTRUCCIONES: " . ($instructions ?: 'Mejora significativamente el diseno visual, el espaciado y la calidad del contenido') . "
TONO: {$tone}
{$colorInfo}

REGLAS DE DISENO PREMIUM:
- Envolver en <section data-section-type=\"{$sectionType}\">
- Usar CSS variables: var(--color-primary), var(--color-secondary), var(--color-accent), var(--color-text), var(--color-background), var(--font-heading), var(--font-body)
- Titulos: font-weight 400 (ligero), usar <em> para palabras clave en cursiva con color primario
- Tags/badges: 0.65rem, font-weight 600, letter-spacing 0.2em, uppercase, con linea decorativa
- Texto cuerpo: font-weight 300, color gris medio, line-height 1.8
- Botones: rectangulares (sin border-radius excesivo), uppercase, letter-spacing 0.14em, hover translateY(-2px)
- Tarjetas: borde sutil, hover translateY(-4px), sombra suave, barra gradient superior con ::before
- Espaciado: padding clamp(4rem, 8vw, 6rem) vertical
- Max-width: 1100px contenedores
- Responsive: @media (max-width: 900px) colapsar grids
- Contenido en espanol, realista, relevante al negocio (NUNCA lorem ipsum)
- Estilos inline en style attributes (no bloque CSS separado)
- Transiciones: all 0.35s

Responde SOLO con el HTML de la seccion, sin markdown, sin backticks, sin explicaciones.";

        $response = $this->callAI(
            $prompt,
            'Eres un disenador web de elite. Tu estilo es sofisticado, minimalista y elegante. Produces HTML con estilos inline de calidad premium. Responde SOLO con HTML puro.',
            8192
        );

        // Limpiar markdown si la IA lo envuelve
        $cleaned = $response;
        if (preg_match('/```(?:html)?\s*([\s\S]*?)```/', $response, $matches)) {
            $cleaned = $matches[1];
        }

        return trim($cleaned);
    }

    /**
     * Genera una nueva sección individual.
     *
     * @param  string  $sectionType  Tipo de sección a generar
     * @param  string  $businessContext  Contexto del negocio (nombre + descripción)
     * @param  string  $description  Descripción adicional de lo que el usuario quiere
     * @param  array   $colors  Paleta de colores { primary, secondary, accent, background, text }
     * @return string  HTML de la nueva sección
     */
    public function generateSection(string $sectionType, string $businessContext, string $description, array $colors = []): string
    {
        $this->checkRateLimit();

        $colorInfo = '';
        if (!empty($colors)) {
            $colorInfo = "Usa estos colores: primario {$colors['primary']}, secundario {$colors['secondary']}, acento {$colors['accent']}, fondo {$colors['background']}, texto {$colors['text']}.";
        }

        $sectionDescriptions = [
            'hero' => 'sección hero/banner principal con título impactante, subtítulo y call-to-action',
            'features' => 'sección de características/beneficios con 3-4 items en grid',
            'about' => 'sección "sobre nosotros" con historia y valores',
            'services' => 'sección de servicios ofrecidos con iconos y descripciones',
            'testimonials' => 'sección de testimonios de clientes con fotos y nombres',
            'cta' => 'sección de call-to-action final con botón prominente',
            'pricing' => 'sección de planes y precios con 3 opciones',
            'faq' => 'sección de preguntas frecuentes con acordeón',
            'contact' => 'sección de contacto con formulario',
            'team' => 'sección del equipo con fotos y roles',
            'stats' => 'sección de estadísticas/números impactantes',
            'gallery' => 'sección de galería de imágenes en grid',
            'newsletter' => 'sección de suscripción a newsletter',
            'footer' => 'footer con columnas de enlaces, contacto y redes sociales',
        ];

        $sectionDesc = $sectionDescriptions[$sectionType] ?? "sección de tipo '{$sectionType}'";

        $prompt = "Genera una {$sectionDesc} para un sitio web.

Contexto del negocio: " . ($businessContext ?: 'Negocio general') . "
Descripción adicional: " . ($description ?: 'Genera contenido apropiado para este tipo de sección') . "
{$colorInfo}

Requisitos:
- Devuelve SOLO el HTML de la sección, envuelto en <section data-section-type=\"{$sectionType}\">
- Estilos inline, diseño moderno y minimalista
- Usa fuente 'Inter' para body y 'Montserrat' para headings
- Padding generoso (60-80px vertical)
- max-width: 1100px con margin: 0 auto para el contenedor interno
- Contenido realista y relevante (NO lorem ipsum)
- NO incluyas etiquetas <style>, solo estilos inline
- Responsive: usa grid con fr units donde aplique
- Devuelve SOLO HTML, sin explicaciones ni markdown

Responde SOLO con el HTML de la sección.";

        $response = $this->callAI(
            $prompt,
            'Eres un diseñador web experto. Genera HTML moderno con estilos inline. Responde SOLO con HTML puro, sin markdown ni explicaciones.',
            4096
        );

        // Limpiar markdown si la IA lo envuelve
        $cleaned = $response;
        if (preg_match('/```(?:html)?\s*([\s\S]*?)```/', $response, $matches)) {
            $cleaned = $matches[1];
        }

        return trim($cleaned);
    }

    /**
     * Construye el prompt para generación de texto por sección.
     */
    private function buildTextPrompt(string $sectionType, string $businessType, string $tone, string $language): string
    {
        $sectionDescriptions = [
            'hero' => 'sección hero/banner principal con título impactante, subtítulo y call-to-action',
            'features' => 'sección de características/beneficios con 3-4 items',
            'about' => 'sección "sobre nosotros" con historia y valores',
            'services' => 'sección de servicios ofrecidos',
            'testimonials' => 'sección de testimonios de clientes',
            'cta' => 'sección de call-to-action final',
            'pricing' => 'sección de planes y precios',
            'faq' => 'sección de preguntas frecuentes',
            'contact' => 'sección de contacto',
            'team' => 'sección de equipo',
            'stats' => 'sección de estadísticas/números',
        ];

        $sectionDesc = $sectionDescriptions[$sectionType] ?? "sección de tipo '{$sectionType}'";

        return "Genera contenido de texto en '{$language}' para una {$sectionDesc} de un sitio web de '{$businessType}'.

Tono: {$tone}

Responde SOLO con JSON válido:
{
    \"title\": \"título principal de la sección\",
    \"subtitle\": \"subtítulo o tagline\",
    \"description\": \"descripción o párrafo principal\",
    \"cta\": \"texto del botón de acción\"
}

El contenido debe ser realista, convincente y específico para el tipo de negocio.";
    }
}
