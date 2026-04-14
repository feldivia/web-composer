<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Block;
use Illuminate\Database\Seeder;

/**
 * Seeder de bloques precargados para WebComposer.
 *
 * Crea 30 bloques organizados en 8 categorias, cada uno con HTML y CSS
 * listos para produccion y compatibles con GrapesJS.
 */
class BlockSeeder extends Seeder
{
    /**
     * Ejecuta el seeder de bloques.
     */
    public function run(): void
    {
        foreach ($this->getBlocks() as $block) {
            Block::updateOrCreate(
                ['name' => $block['name']],
                [
                    'category' => $block['category'],
                    'description' => $block['description'],
                    'content' => [
                        'html' => $block['html'],
                        'css' => $block['css'],
                    ],
                    'thumbnail' => null,
                ]
            );
        }
    }

    /**
     * Retorna la definicion de los 30 bloques precargados.
     *
     * @return list<array{name: string, category: string, description: string, html: string, css: string}>
     */
    private function getBlocks(): array
    {
        return [
            // ================================================================
            // HEROES (4 bloques)
            // ================================================================
            $this->heroCenter(),
            $this->heroImage(),
            $this->heroVideo(),
            $this->heroMinimal(),

            // ================================================================
            // CONTENIDO (5 bloques)
            // ================================================================
            $this->contentTextImage(),
            $this->contentImageText(),
            $this->content2Columns(),
            $this->content3Columns(),
            $this->contentQuote(),

            // ================================================================
            // FEATURES (4 bloques)
            // ================================================================
            $this->features3Icons(),
            $this->features4Icons(),
            $this->featuresIconList(),
            $this->featuresAlternating(),

            // ================================================================
            // TESTIMONIOS (3 bloques)
            // ================================================================
            $this->testimonialsGrid(),
            $this->testimonialFeatured(),
            $this->testimonialsLogo(),

            // ================================================================
            // PRECIOS (3 bloques)
            // ================================================================
            $this->pricing3Plans(),
            $this->pricing2Plans(),
            $this->pricingComparison(),

            // ================================================================
            // CONTACTO (4 bloques)
            // ================================================================
            $this->contactFull(),
            $this->contactSimple(),
            $this->contactMap(),
            $this->contactCta(),

            // ================================================================
            // GALERIA (4 bloques)
            // ================================================================
            $this->gallery3x2(),
            $this->gallery4x2(),
            $this->logoCloud(),
            $this->stats(),

            // ================================================================
            // FOOTER (3 bloques)
            // ================================================================
            $this->footerFull(),
            $this->footerSimple(),
            $this->footerNewsletter(),

            // ================================================================
            // HEROES — nuevos (2 bloques)
            // ================================================================
            $this->heroSplit(),
            $this->heroGradientAnimado(),

            // ================================================================
            // CONTENIDO — nuevos (3 bloques)
            // ================================================================
            $this->bentoGrid(),
            $this->timeline(),
            $this->calloutAlertBoxes(),

            // ================================================================
            // TESTIMONIOS — nuevo (1 bloque)
            // ================================================================
            $this->testimonialCarousel(),

            // ================================================================
            // PRECIOS — nuevo (1 bloque)
            // ================================================================
            $this->pricingToggle(),

            // ================================================================
            // GALERIA — nuevos (2 bloques)
            // ================================================================
            $this->beforeAfterSlider(),
            $this->videoThumbnail(),

            // ================================================================
            // SOCIAL (4 bloques)
            // ================================================================
            $this->teamCards(),
            $this->socialProofBar(),
            $this->logoCarouselInfinito(),
            $this->appDownloadSection(),

            // ================================================================
            // SITIO (2 bloques)
            // ================================================================
            $this->notificationBar(),
            $this->comparisonTable(),
        ];
    }

    // ========================================================================
    // HEROES
    // ========================================================================

    private function heroCenter(): array
    {
        return [
            'name' => 'Hero Centrado',
            'category' => 'heroes',
            'description' => 'Hero con fondo degradado oscuro, titulo con texto degradado, subtitulo, 2 botones CTA y fila de estadisticas.',
            'html' => '<section class="hero-centered" data-reveal>
    <div class="hero-centered-container">
        <h1 class="hero-centered-title">Transforma tu <span class="hero-centered-gradient">presencia digital</span> hoy</h1>
        <p class="hero-centered-subtitle">Creamos experiencias digitales excepcionales que conectan con tu audiencia y generan resultados medibles para tu negocio.</p>
        <div class="hero-centered-buttons">
            <a href="#contacto" class="hero-centered-btn-primary">Comenzar Ahora</a>
            <a href="#servicios" class="hero-centered-btn-secondary">Ver Servicios</a>
        </div>
        <div class="hero-centered-stats">
            <div class="hero-centered-stat">
                <span class="hero-centered-stat-number" data-count="500" data-count-suffix="+">500+</span>
                <span class="hero-centered-stat-label">Clientes Satisfechos</span>
            </div>
            <div class="hero-centered-stat">
                <span class="hero-centered-stat-number" data-count="12">12</span>
                <span class="hero-centered-stat-label">Anos de Experiencia</span>
            </div>
            <div class="hero-centered-stat">
                <span class="hero-centered-stat-number" data-count="98" data-count-suffix="%">98%</span>
                <span class="hero-centered-stat-label">Tasa de Retencion</span>
            </div>
        </div>
    </div>
</section>',
            'css' => '.hero-centered {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    padding: 120px 24px;
    text-align: center;
    color: #ffffff;
}
.hero-centered-container {
    max-width: 800px;
    margin: 0 auto;
}
.hero-centered-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.hero-centered-gradient {
    background: linear-gradient(135deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-centered-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.25rem;
    line-height: 1.7;
    color: #94a3b8;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}
.hero-centered-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 64px;
}
.hero-centered-btn-primary {
    display: inline-block;
    padding: 16px 32px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hero-centered-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
}
.hero-centered-btn-secondary {
    display: inline-block;
    padding: 16px 32px;
    background: transparent;
    color: #ffffff;
    border: 2px solid #334155;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: border-color 0.2s;
}
.hero-centered-btn-secondary:hover {
    border-color: var(--color-primary, #6366f1);
}
.hero-centered-stats {
    display: flex;
    justify-content: center;
    gap: 48px;
}
.hero-centered-stat {
    text-align: center;
}
.hero-centered-stat-number {
    display: block;
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2rem;
    font-weight: 800;
    color: #ffffff;
}
.hero-centered-stat-label {
    font-size: 0.875rem;
    color: #64748b;
}
@media (max-width: 768px) {
    .hero-centered { padding: 80px 16px; }
    .hero-centered-title { font-size: 2.25rem; }
    .hero-centered-subtitle { font-size: 1rem; }
    .hero-centered-buttons { flex-direction: column; align-items: center; }
    .hero-centered-stats { flex-direction: column; gap: 24px; }
}',
        ];
    }

    private function heroImage(): array
    {
        return [
            'name' => 'Hero con Imagen Lateral',
            'category' => 'heroes',
            'description' => 'Hero de 2 columnas: texto con CTA a la izquierda e imagen a la derecha. Fondo claro.',
            'html' => '<section class="hero-image" data-reveal>
    <div class="hero-image-container">
        <div class="hero-image-text">
            <span class="hero-image-badge">Novedades 2026</span>
            <h1 class="hero-image-title">Soluciones digitales para empresas modernas</h1>
            <p class="hero-image-subtitle">Impulsamos el crecimiento de tu negocio con tecnologia de vanguardia, diseno innovador y estrategias que generan resultados reales.</p>
            <div class="hero-image-buttons">
                <a href="#contacto" class="hero-image-btn-primary">Solicitar Demo</a>
                <a href="#casos" class="hero-image-btn-link">Ver casos de exito &rarr;</a>
            </div>
        </div>
        <div class="hero-image-visual">
            <img src="https://picsum.photos/600/500" alt="Soluciones digitales" class="hero-image-img" />
        </div>
    </div>
</section>',
            'css' => '.hero-image {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.hero-image-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}
.hero-image-badge {
    display: inline-block;
    padding: 6px 16px;
    background: rgba(99, 102, 241, 0.1);
    color: var(--color-primary, #6366f1);
    border-radius: 100px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 20px;
}
.hero-image-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3rem;
    font-weight: 800;
    line-height: 1.15;
    color: var(--color-text, #1e293b);
    margin-bottom: 20px;
}
.hero-image-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 32px;
}
.hero-image-buttons {
    display: flex;
    gap: 24px;
    align-items: center;
}
.hero-image-btn-primary {
    display: inline-block;
    padding: 14px 28px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hero-image-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
}
.hero-image-btn-link {
    color: var(--color-primary, #6366f1);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}
.hero-image-btn-link:hover {
    color: var(--color-secondary, #0ea5e9);
}
.hero-image-img {
    width: 100%;
    height: auto;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}
@media (max-width: 768px) {
    .hero-image { padding: 60px 16px; }
    .hero-image-container { grid-template-columns: 1fr; gap: 40px; }
    .hero-image-title { font-size: 2.25rem; }
    .hero-image-buttons { flex-direction: column; align-items: flex-start; }
}',
        ];
    }

    private function heroVideo(): array
    {
        return [
            'name' => 'Hero con Video',
            'category' => 'heroes',
            'description' => 'Hero con fondo de video placeholder, overlay oscuro, texto blanco centrado y boton CTA.',
            'html' => '<section class="hero-video">
    <div class="hero-video-bg">
        <img src="https://picsum.photos/1920/800" alt="Video de fondo" class="hero-video-poster" />
        <div class="hero-video-overlay"></div>
    </div>
    <div class="hero-video-content" data-reveal>
        <h1 class="hero-video-title">Experiencias que inspiran</h1>
        <p class="hero-video-subtitle">Descubre una nueva forma de conectar con tus clientes a traves de contenido visual impactante y estrategias creativas.</p>
        <a href="#contacto" class="hero-video-btn">Descubrir Mas</a>
    </div>
</section>',
            'css' => '.hero-video {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.hero-video-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.hero-video-poster {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.hero-video-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(30, 41, 59, 0.75));
}
.hero-video-content {
    position: relative;
    z-index: 1;
    text-align: center;
    max-width: 700px;
    padding: 80px 24px;
    color: #ffffff;
}
.hero-video-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 24px;
}
.hero-video-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.25rem;
    line-height: 1.7;
    color: #cbd5e1;
    margin-bottom: 40px;
}
.hero-video-btn {
    display: inline-block;
    padding: 16px 40px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hero-video-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.5);
}
@media (max-width: 768px) {
    .hero-video { min-height: 480px; }
    .hero-video-title { font-size: 2.25rem; }
    .hero-video-subtitle { font-size: 1rem; }
    .hero-video-content { padding: 60px 16px; }
}',
        ];
    }

    private function heroMinimal(): array
    {
        return [
            'name' => 'Hero Minimalista',
            'category' => 'heroes',
            'description' => 'Hero limpio con fondo blanco, tipografia grande, un solo CTA y decoracion minima.',
            'html' => '<section class="hero-minimal" data-reveal>
    <div class="hero-minimal-container">
        <h1 class="hero-minimal-title">Diseno simple.<br/>Impacto extraordinario.</h1>
        <p class="hero-minimal-subtitle">Menos es mas. Creamos soluciones elegantes y funcionales que hablan por si mismas.</p>
        <a href="#contacto" class="hero-minimal-btn">Empezar Proyecto</a>
    </div>
</section>',
            'css' => '.hero-minimal {
    padding: 140px 24px;
    background: var(--color-background, #ffffff);
    text-align: center;
}
.hero-minimal-container {
    max-width: 700px;
    margin: 0 auto;
}
.hero-minimal-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 4rem;
    font-weight: 800;
    line-height: 1.1;
    color: var(--color-text, #1e293b);
    margin-bottom: 24px;
}
.hero-minimal-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.25rem;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 40px;
}
.hero-minimal-btn {
    display: inline-block;
    padding: 16px 40px;
    background: var(--color-text, #1e293b);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: transform 0.2s, background 0.2s;
}
.hero-minimal-btn:hover {
    transform: translateY(-2px);
    background: var(--color-primary, #6366f1);
}
@media (max-width: 768px) {
    .hero-minimal { padding: 80px 16px; }
    .hero-minimal-title { font-size: 2.5rem; }
}',
        ];
    }

    // ========================================================================
    // CONTENIDO
    // ========================================================================

    private function contentTextImage(): array
    {
        return [
            'name' => 'Texto + Imagen',
            'category' => 'contenido',
            'description' => 'Bloque de 2 columnas: imagen a la izquierda y bloque de texto con titulo y parrafos a la derecha.',
            'html' => '<section class="text-image" data-reveal>
    <div class="text-image-container">
        <div class="text-image-visual">
            <img src="https://picsum.photos/580/420" alt="Nuestra historia" class="text-image-img" />
        </div>
        <div class="text-image-content">
            <span class="text-image-label">Sobre Nosotros</span>
            <h2 class="text-image-title">Una historia de innovacion y compromiso</h2>
            <p class="text-image-text">Desde nuestros inicios, nos hemos dedicado a crear soluciones que transforman la manera en que las empresas se conectan con sus clientes.</p>
            <p class="text-image-text">Nuestro equipo de profesionales apasionados combina creatividad con tecnologia de punta para ofrecer resultados excepcionales en cada proyecto.</p>
        </div>
    </div>
</section>',
            'css' => '.text-image {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.text-image-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}
.text-image-img {
    width: 100%;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
}
.text-image-label {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-primary, #6366f1);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}
.text-image-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    line-height: 1.2;
    margin-bottom: 20px;
}
.text-image-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 16px;
}
@media (max-width: 768px) {
    .text-image { padding: 60px 16px; }
    .text-image-container { grid-template-columns: 1fr; gap: 32px; }
    .text-image-title { font-size: 1.75rem; }
}',
        ];
    }

    private function contentImageText(): array
    {
        return [
            'name' => 'Imagen + Texto',
            'category' => 'contenido',
            'description' => 'Bloque de 2 columnas: texto a la izquierda e imagen a la derecha (inverso del anterior).',
            'html' => '<section class="image-text" data-reveal>
    <div class="image-text-container">
        <div class="image-text-content">
            <span class="image-text-label">Nuestra Mision</span>
            <h2 class="image-text-title">Impulsamos tu negocio hacia el futuro digital</h2>
            <p class="image-text-text">Creemos que cada empresa merece una presencia digital que refleje su verdadero potencial. Trabajamos de la mano con nuestros clientes para crear experiencias unicas.</p>
            <p class="image-text-text">Con mas de una decada de experiencia, hemos ayudado a cientos de empresas a alcanzar sus objetivos digitales y superar las expectativas de sus usuarios.</p>
        </div>
        <div class="image-text-visual">
            <img src="https://picsum.photos/580/420?random=2" alt="Nuestra mision" class="image-text-img" />
        </div>
    </div>
</section>',
            'css' => '.image-text {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.image-text-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}
.image-text-img {
    width: 100%;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.08);
}
.image-text-label {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-primary, #6366f1);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}
.image-text-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    line-height: 1.2;
    margin-bottom: 20px;
}
.image-text-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 16px;
}
@media (max-width: 768px) {
    .image-text { padding: 60px 16px; }
    .image-text-container { grid-template-columns: 1fr; gap: 32px; }
    .image-text-title { font-size: 1.75rem; }
}',
        ];
    }

    private function content2Columns(): array
    {
        return [
            'name' => '2 Columnas',
            'category' => 'contenido',
            'description' => 'Dos columnas iguales de texto, cada una con su propio titulo y parrafo.',
            'html' => '<section class="cols-2" data-reveal>
    <div class="cols-2-container">
        <div class="cols-2-header">
            <h2 class="cols-2-title">Nuestro enfoque estrategico</h2>
            <p class="cols-2-subtitle">Combinamos experiencia y tecnologia para ofrecer soluciones integrales.</p>
        </div>
        <div class="cols-2-grid">
            <div class="cols-2-item">
                <h3 class="cols-2-item-title">Estrategia Digital</h3>
                <p class="cols-2-item-text">Analizamos tu mercado, definimos objetivos claros y creamos una hoja de ruta personalizada para maximizar el retorno de tu inversion digital. Cada decision esta respaldada por datos y experiencia.</p>
            </div>
            <div class="cols-2-item">
                <h3 class="cols-2-item-title">Desarrollo a Medida</h3>
                <p class="cols-2-item-text">Construimos soluciones tecnologicas adaptadas a las necesidades especificas de tu negocio. Desde sitios web hasta aplicaciones complejas, cada proyecto refleja tu identidad y valores unicos.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.cols-2 {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.cols-2-container {
    max-width: 1200px;
    margin: 0 auto;
}
.cols-2-header {
    text-align: center;
    margin-bottom: 56px;
}
.cols-2-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 16px;
}
.cols-2-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.cols-2-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
}
.cols-2-item-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.cols-2-item-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1rem;
    line-height: 1.7;
    color: #64748b;
}
@media (max-width: 768px) {
    .cols-2 { padding: 60px 16px; }
    .cols-2-title { font-size: 2rem; }
    .cols-2-grid { grid-template-columns: 1fr; gap: 32px; }
}',
        ];
    }

    private function content3Columns(): array
    {
        return [
            'name' => '3 Columnas',
            'category' => 'contenido',
            'description' => 'Tres columnas iguales de texto, cada una con titulo y parrafo.',
            'html' => '<section class="cols-3" data-reveal>
    <div class="cols-3-container">
        <div class="cols-3-header">
            <h2 class="cols-3-title">Por que elegirnos</h2>
            <p class="cols-3-subtitle">Tres razones por las que somos la mejor opcion para tu proyecto.</p>
        </div>
        <div class="cols-3-grid">
            <div class="cols-3-item">
                <h3 class="cols-3-item-title">Experiencia Comprobada</h3>
                <p class="cols-3-item-text">Mas de 500 proyectos exitosos avalan nuestro trabajo. Cada cliente es una nueva oportunidad de superar expectativas y crear algo extraordinario.</p>
            </div>
            <div class="cols-3-item">
                <h3 class="cols-3-item-title">Equipo Multidisciplinario</h3>
                <p class="cols-3-item-text">Disenadores, desarrolladores y estrategas trabajan juntos para entregar soluciones integrales que cubren todas las necesidades de tu negocio.</p>
            </div>
            <div class="cols-3-item">
                <h3 class="cols-3-item-title">Soporte Continuo</h3>
                <p class="cols-3-item-text">No desaparecemos despues de la entrega. Ofrecemos acompanamiento permanente para asegurar que tu proyecto evolucione y se mantenga actualizado.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.cols-3 {
    padding: 100px 24px;
    background: #f8fafc;
}
.cols-3-container {
    max-width: 1200px;
    margin: 0 auto;
}
.cols-3-header {
    text-align: center;
    margin-bottom: 56px;
}
.cols-3-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 16px;
}
.cols-3-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.cols-3-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
}
.cols-3-item-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.cols-3-item-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1rem;
    line-height: 1.7;
    color: #64748b;
}
@media (max-width: 768px) {
    .cols-3 { padding: 60px 16px; }
    .cols-3-title { font-size: 2rem; }
    .cols-3-grid { grid-template-columns: 1fr; gap: 32px; }
}',
        ];
    }

    private function contentQuote(): array
    {
        return [
            'name' => 'Cita Destacada',
            'category' => 'contenido',
            'description' => 'Cita grande con comillas decorativas, nombre del autor y su cargo.',
            'html' => '<section class="quote-block" data-reveal>
    <div class="quote-block-container">
        <div class="quote-block-marks">&ldquo;</div>
        <blockquote class="quote-block-text">La innovacion distingue a un lider de un seguidor. No se trata de tener ideas, sino de tener la capacidad de ejecutarlas y transformar la realidad.</blockquote>
        <div class="quote-block-author">
            <p class="quote-block-name">Maria Gonzalez</p>
            <p class="quote-block-role">Directora de Innovacion, TechCorp</p>
        </div>
    </div>
</section>',
            'css' => '.quote-block {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.quote-block-container {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}
.quote-block-marks {
    font-size: 6rem;
    line-height: 1;
    color: var(--color-primary, #6366f1);
    opacity: 0.3;
    font-family: Georgia, serif;
    margin-bottom: -20px;
}
.quote-block-text {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.75rem;
    font-weight: 500;
    line-height: 1.5;
    color: var(--color-text, #1e293b);
    font-style: italic;
    margin-bottom: 32px;
}
.quote-block-name {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 4px;
}
.quote-block-role {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #64748b;
}
@media (max-width: 768px) {
    .quote-block { padding: 60px 16px; }
    .quote-block-text { font-size: 1.25rem; }
    .quote-block-marks { font-size: 4rem; }
}',
        ];
    }

    // ========================================================================
    // FEATURES
    // ========================================================================

    private function features3Icons(): array
    {
        return [
            'name' => 'Grid 3 Iconos',
            'category' => 'features',
            'description' => '3 tarjetas con iconos emoji, titulo y descripcion. Efecto hover.',
            'html' => '<section class="feat3" data-reveal>
    <div class="feat3-container">
        <div class="feat3-header">
            <span class="feat3-label">Servicios</span>
            <h2 class="feat3-title">Lo que hacemos mejor</h2>
            <p class="feat3-subtitle">Soluciones completas para potenciar tu presencia digital.</p>
        </div>
        <div class="feat3-grid">
            <div class="feat3-card">
                <div class="feat3-icon">&#127912;</div>
                <h3 class="feat3-card-title">Diseno Creativo</h3>
                <p class="feat3-card-text">Interfaces visualmente impactantes que reflejan la esencia de tu marca y cautivan a tus usuarios desde el primer momento.</p>
            </div>
            <div class="feat3-card">
                <div class="feat3-icon">&#128187;</div>
                <h3 class="feat3-card-title">Desarrollo Web</h3>
                <p class="feat3-card-text">Sitios web rapidos, seguros y escalables construidos con las mejores tecnologias y practicas del mercado actual.</p>
            </div>
            <div class="feat3-card">
                <div class="feat3-icon">&#128200;</div>
                <h3 class="feat3-card-title">Marketing Digital</h3>
                <p class="feat3-card-text">Estrategias basadas en datos que aumentan tu visibilidad, generan leads cualificados y maximizan tus conversiones.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.feat3 {
    padding: 100px 24px;
    background: #f8fafc;
}
.feat3-container {
    max-width: 1200px;
    margin: 0 auto;
}
.feat3-header {
    text-align: center;
    margin-bottom: 56px;
}
.feat3-label {
    display: inline-block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--color-primary, #6366f1);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}
.feat3-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.feat3-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.feat3-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}
.feat3-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 40px 32px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s, box-shadow 0.3s;
}
.feat3-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}
.feat3-icon {
    font-size: 3rem;
    margin-bottom: 20px;
}
.feat3-card-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.feat3-card-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    line-height: 1.7;
    color: #64748b;
}
@media (max-width: 768px) {
    .feat3 { padding: 60px 16px; }
    .feat3-title { font-size: 2rem; }
    .feat3-grid { grid-template-columns: 1fr; }
}',
        ];
    }

    private function features4Icons(): array
    {
        return [
            'name' => 'Grid 4 Iconos',
            'category' => 'features',
            'description' => '4 tarjetas en fila con fondos de icono de color.',
            'html' => '<section class="feat4" data-reveal>
    <div class="feat4-container">
        <div class="feat4-header">
            <h2 class="feat4-title">Soluciones integrales para tu negocio</h2>
            <p class="feat4-subtitle">Todo lo que necesitas en un solo lugar.</p>
        </div>
        <div class="feat4-grid">
            <div class="feat4-card">
                <div class="feat4-icon feat4-icon-purple">&#9998;</div>
                <h3 class="feat4-card-title">Diseno UX/UI</h3>
                <p class="feat4-card-text">Interfaces intuitivas centradas en la experiencia del usuario.</p>
            </div>
            <div class="feat4-card">
                <div class="feat4-icon feat4-icon-blue">&#9881;</div>
                <h3 class="feat4-card-title">Desarrollo</h3>
                <p class="feat4-card-text">Codigo limpio y arquitecturas escalables para tu proyecto.</p>
            </div>
            <div class="feat4-card">
                <div class="feat4-icon feat4-icon-amber">&#128640;</div>
                <h3 class="feat4-card-title">Optimizacion</h3>
                <p class="feat4-card-text">Rendimiento y velocidad para una mejor experiencia.</p>
            </div>
            <div class="feat4-card">
                <div class="feat4-icon feat4-icon-green">&#128274;</div>
                <h3 class="feat4-card-title">Seguridad</h3>
                <p class="feat4-card-text">Proteccion avanzada para tus datos y los de tus clientes.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.feat4 {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.feat4-container {
    max-width: 1200px;
    margin: 0 auto;
}
.feat4-header {
    text-align: center;
    margin-bottom: 56px;
}
.feat4-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.feat4-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.feat4-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
}
.feat4-card {
    background: #f8fafc;
    border-radius: 16px;
    padding: 36px 28px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}
.feat4-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
}
.feat4-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px;
    height: 64px;
    border-radius: 16px;
    font-size: 1.75rem;
    margin-bottom: 20px;
}
.feat4-icon-purple { background: rgba(99, 102, 241, 0.1); }
.feat4-icon-blue { background: rgba(14, 165, 233, 0.1); }
.feat4-icon-amber { background: rgba(245, 158, 11, 0.1); }
.feat4-icon-green { background: rgba(34, 197, 94, 0.1); }
.feat4-card-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 8px;
}
.feat4-card-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    line-height: 1.6;
    color: #64748b;
}
@media (max-width: 1024px) {
    .feat4-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .feat4 { padding: 60px 16px; }
    .feat4-title { font-size: 2rem; }
    .feat4-grid { grid-template-columns: 1fr; }
}',
        ];
    }

    private function featuresIconList(): array
    {
        return [
            'name' => 'Lista con Iconos',
            'category' => 'features',
            'description' => 'Lista vertical donde cada item tiene icono, titulo y descripcion lado a lado.',
            'html' => '<section class="feat-list" data-reveal>
    <div class="feat-list-container">
        <div class="feat-list-header">
            <h2 class="feat-list-title">Nuestro proceso de trabajo</h2>
            <p class="feat-list-subtitle">Un metodo probado que garantiza resultados excepcionales.</p>
        </div>
        <div class="feat-list-items">
            <div class="feat-list-item">
                <div class="feat-list-icon">&#128269;</div>
                <div class="feat-list-info">
                    <h3 class="feat-list-item-title">Investigacion y Analisis</h3>
                    <p class="feat-list-item-text">Estudiamos tu mercado, competencia y audiencia objetivo para definir la estrategia mas efectiva para tu proyecto.</p>
                </div>
            </div>
            <div class="feat-list-item">
                <div class="feat-list-icon">&#127912;</div>
                <div class="feat-list-info">
                    <h3 class="feat-list-item-title">Diseno y Prototipado</h3>
                    <p class="feat-list-item-text">Creamos wireframes y prototipos interactivos que validan la experiencia del usuario antes del desarrollo.</p>
                </div>
            </div>
            <div class="feat-list-item">
                <div class="feat-list-icon">&#128187;</div>
                <div class="feat-list-info">
                    <h3 class="feat-list-item-title">Desarrollo e Implementacion</h3>
                    <p class="feat-list-item-text">Construimos tu solucion con tecnologias modernas, codigo limpio y las mejores practicas de la industria.</p>
                </div>
            </div>
            <div class="feat-list-item">
                <div class="feat-list-icon">&#128640;</div>
                <div class="feat-list-info">
                    <h3 class="feat-list-item-title">Lanzamiento y Soporte</h3>
                    <p class="feat-list-item-text">Publicamos tu proyecto y proporcionamos soporte continuo para garantizar su funcionamiento optimo.</p>
                </div>
            </div>
        </div>
    </div>
</section>',
            'css' => '.feat-list {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.feat-list-container {
    max-width: 800px;
    margin: 0 auto;
}
.feat-list-header {
    text-align: center;
    margin-bottom: 56px;
}
.feat-list-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.feat-list-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.feat-list-items {
    display: flex;
    flex-direction: column;
    gap: 32px;
}
.feat-list-item {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding: 28px;
    border-radius: 16px;
    background: #f8fafc;
    transition: transform 0.2s, box-shadow 0.2s;
}
.feat-list-item:hover {
    transform: translateX(8px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
}
.feat-list-icon {
    font-size: 2rem;
    flex-shrink: 0;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(99, 102, 241, 0.1);
    border-radius: 12px;
}
.feat-list-item-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 8px;
}
.feat-list-item-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    line-height: 1.7;
    color: #64748b;
}
@media (max-width: 768px) {
    .feat-list { padding: 60px 16px; }
    .feat-list-title { font-size: 2rem; }
    .feat-list-item { flex-direction: column; gap: 16px; }
}',
        ];
    }

    private function featuresAlternating(): array
    {
        return [
            'name' => 'Features Alternadas',
            'category' => 'features',
            'description' => 'Filas alternadas imagen-izquierda/imagen-derecha (patron zigzag).',
            'html' => '<section class="feat-alt" data-reveal>
    <div class="feat-alt-container">
        <div class="feat-alt-header">
            <h2 class="feat-alt-title">Caracteristicas principales</h2>
            <p class="feat-alt-subtitle">Herramientas poderosas para alcanzar tus objetivos.</p>
        </div>
        <div class="feat-alt-row">
            <div class="feat-alt-image">
                <img src="https://picsum.photos/520/380?random=3" alt="Analisis avanzado" />
            </div>
            <div class="feat-alt-content">
                <h3 class="feat-alt-item-title">Analisis avanzado en tiempo real</h3>
                <p class="feat-alt-item-text">Monitorea el rendimiento de tu sitio con metricas detalladas. Entiende el comportamiento de tus usuarios y toma decisiones informadas basadas en datos reales.</p>
            </div>
        </div>
        <div class="feat-alt-row feat-alt-row-reverse">
            <div class="feat-alt-image">
                <img src="https://picsum.photos/520/380?random=4" alt="Automatizacion" />
            </div>
            <div class="feat-alt-content">
                <h3 class="feat-alt-item-title">Automatizacion inteligente</h3>
                <p class="feat-alt-item-text">Ahorra tiempo con flujos de trabajo automatizados. Desde la publicacion de contenido hasta el envio de notificaciones, todo funciona de manera automatica y eficiente.</p>
            </div>
        </div>
        <div class="feat-alt-row">
            <div class="feat-alt-image">
                <img src="https://picsum.photos/520/380?random=5" alt="Integraciones" />
            </div>
            <div class="feat-alt-content">
                <h3 class="feat-alt-item-title">Integraciones sin limites</h3>
                <p class="feat-alt-item-text">Conecta con tus herramientas favoritas facilmente. Nuestro sistema se integra con los servicios mas populares para crear un ecosistema digital completo.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.feat-alt {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.feat-alt-container {
    max-width: 1100px;
    margin: 0 auto;
}
.feat-alt-header {
    text-align: center;
    margin-bottom: 64px;
}
.feat-alt-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.feat-alt-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.feat-alt-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 56px;
    align-items: center;
    margin-bottom: 64px;
}
.feat-alt-row:last-child {
    margin-bottom: 0;
}
.feat-alt-row-reverse {
    direction: rtl;
}
.feat-alt-row-reverse > * {
    direction: ltr;
}
.feat-alt-image img {
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
}
.feat-alt-item-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 16px;
}
.feat-alt-item-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    line-height: 1.7;
    color: #64748b;
}
@media (max-width: 768px) {
    .feat-alt { padding: 60px 16px; }
    .feat-alt-title { font-size: 2rem; }
    .feat-alt-row, .feat-alt-row-reverse { grid-template-columns: 1fr; gap: 24px; direction: ltr; }
}',
        ];
    }

    // ========================================================================
    // TESTIMONIOS
    // ========================================================================

    private function testimonialsGrid(): array
    {
        return [
            'name' => 'Grid Testimonios',
            'category' => 'testimonios',
            'description' => '3 tarjetas de testimonio con avatar, estrellas, cita y nombre.',
            'html' => '<section class="testi-grid" data-reveal>
    <div class="testi-grid-container">
        <div class="testi-grid-header">
            <h2 class="testi-grid-title">Lo que dicen nuestros clientes</h2>
            <p class="testi-grid-subtitle">Historias reales de empresas que confiaron en nosotros.</p>
        </div>
        <div class="testi-grid-cards">
            <div class="testi-grid-card">
                <div class="testi-grid-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testi-grid-quote">El equipo supero todas nuestras expectativas. La nueva web incremento nuestras ventas en un 40% en los primeros tres meses.</p>
                <div class="testi-grid-author">
                    <img src="https://picsum.photos/48/48?random=10" alt="Carlos Mendez" class="testi-grid-avatar" />
                    <div>
                        <p class="testi-grid-name">Carlos Mendez</p>
                        <p class="testi-grid-role">CEO, InnovaTech</p>
                    </div>
                </div>
            </div>
            <div class="testi-grid-card">
                <div class="testi-grid-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testi-grid-quote">Profesionalismo y atencion al detalle. Cada sugerencia fue implementada con precision. Recomendados al 100%.</p>
                <div class="testi-grid-author">
                    <img src="https://picsum.photos/48/48?random=11" alt="Ana Torres" class="testi-grid-avatar" />
                    <div>
                        <p class="testi-grid-name">Ana Torres</p>
                        <p class="testi-grid-role">Directora, Estudio Creativo</p>
                    </div>
                </div>
            </div>
            <div class="testi-grid-card">
                <div class="testi-grid-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testi-grid-quote">La mejor inversion que hemos hecho. El sitio web que crearon transmite exactamente lo que somos como marca.</p>
                <div class="testi-grid-author">
                    <img src="https://picsum.photos/48/48?random=12" alt="Roberto Silva" class="testi-grid-avatar" />
                    <div>
                        <p class="testi-grid-name">Roberto Silva</p>
                        <p class="testi-grid-role">Fundador, SilvaGroup</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>',
            'css' => '.testi-grid {
    padding: 100px 24px;
    background: #f8fafc;
}
.testi-grid-container {
    max-width: 1200px;
    margin: 0 auto;
}
.testi-grid-header {
    text-align: center;
    margin-bottom: 56px;
}
.testi-grid-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.testi-grid-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.testi-grid-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}
.testi-grid-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 36px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s;
}
.testi-grid-card:hover {
    transform: translateY(-4px);
}
.testi-grid-stars {
    color: var(--color-accent, #f59e0b);
    font-size: 1.25rem;
    margin-bottom: 16px;
    letter-spacing: 2px;
}
.testi-grid-quote {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1rem;
    line-height: 1.7;
    color: #475569;
    margin-bottom: 24px;
    font-style: italic;
}
.testi-grid-author {
    display: flex;
    align-items: center;
    gap: 12px;
}
.testi-grid-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}
.testi-grid-name {
    font-family: var(--font-body, "Inter", sans-serif);
    font-weight: 700;
    color: var(--color-text, #1e293b);
    font-size: 0.95rem;
}
.testi-grid-role {
    font-size: 0.85rem;
    color: #64748b;
}
@media (max-width: 768px) {
    .testi-grid { padding: 60px 16px; }
    .testi-grid-title { font-size: 2rem; }
    .testi-grid-cards { grid-template-columns: 1fr; }
}',
        ];
    }

    private function testimonialFeatured(): array
    {
        return [
            'name' => 'Testimonio Destacado',
            'category' => 'testimonios',
            'description' => 'Un testimonio grande y destacado con foto grande, comillas decorativas y nombre del autor.',
            'html' => '<section class="testi-feat" data-reveal>
    <div class="testi-feat-container">
        <div class="testi-feat-photo">
            <img src="https://picsum.photos/280/280?random=13" alt="Laura Fernandez" />
        </div>
        <div class="testi-feat-content">
            <div class="testi-feat-marks">&ldquo;</div>
            <p class="testi-feat-quote">Trabajar con este equipo fue una experiencia transformadora para nuestro negocio. No solo entregaron un producto excepcional, sino que nos acompanaron en cada paso del proceso con profesionalismo y dedicacion.</p>
            <div class="testi-feat-author">
                <p class="testi-feat-name">Laura Fernandez</p>
                <p class="testi-feat-role">Gerente General, FutureMedia</p>
            </div>
            <div class="testi-feat-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        </div>
    </div>
</section>',
            'css' => '.testi-feat {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.testi-feat-container {
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 48px;
    align-items: center;
}
.testi-feat-photo img {
    width: 200px;
    height: 200px;
    border-radius: 20px;
    object-fit: cover;
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.1);
}
.testi-feat-marks {
    font-size: 5rem;
    line-height: 1;
    color: var(--color-primary, #6366f1);
    opacity: 0.2;
    font-family: Georgia, serif;
    margin-bottom: -10px;
}
.testi-feat-quote {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.25rem;
    line-height: 1.7;
    color: #475569;
    font-style: italic;
    margin-bottom: 24px;
}
.testi-feat-name {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-weight: 700;
    color: var(--color-text, #1e293b);
    font-size: 1.1rem;
}
.testi-feat-role {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 12px;
}
.testi-feat-stars {
    color: var(--color-accent, #f59e0b);
    font-size: 1.25rem;
    letter-spacing: 2px;
}
@media (max-width: 768px) {
    .testi-feat { padding: 60px 16px; }
    .testi-feat-container { grid-template-columns: 1fr; text-align: center; }
    .testi-feat-photo { display: flex; justify-content: center; }
    .testi-feat-photo img { width: 140px; height: 140px; }
}',
        ];
    }

    private function testimonialsLogo(): array
    {
        return [
            'name' => 'Testimonios con Logo',
            'category' => 'testimonios',
            'description' => '3 testimonios con logo de empresa placeholder encima de la cita.',
            'html' => '<section class="testi-logo" data-reveal>
    <div class="testi-logo-container">
        <div class="testi-logo-header">
            <h2 class="testi-logo-title">Empresas que confian en nosotros</h2>
        </div>
        <div class="testi-logo-cards">
            <div class="testi-logo-card">
                <img src="https://picsum.photos/120/40?random=14" alt="TechCorp" class="testi-logo-img" />
                <p class="testi-logo-quote">Una solucion robusta que escalo perfectamente con nuestro crecimiento. El soporte tecnico es excepcional.</p>
                <p class="testi-logo-name">Pedro Ramirez, CTO</p>
            </div>
            <div class="testi-logo-card">
                <img src="https://picsum.photos/120/40?random=15" alt="DesignLab" class="testi-logo-img" />
                <p class="testi-logo-quote">La atencion al detalle en el diseno supero nuestras expectativas. Cada pixel esta cuidado con precision.</p>
                <p class="testi-logo-name">Sofia Martinez, Directora Creativa</p>
            </div>
            <div class="testi-logo-card">
                <img src="https://picsum.photos/120/40?random=16" alt="GrowthHub" class="testi-logo-img" />
                <p class="testi-logo-quote">Incrementamos nuestra conversion online en un 65% desde que implementamos la nueva plataforma.</p>
                <p class="testi-logo-name">Diego Lopez, CMO</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.testi-logo {
    padding: 100px 24px;
    background: #f8fafc;
}
.testi-logo-container {
    max-width: 1200px;
    margin: 0 auto;
}
.testi-logo-header {
    text-align: center;
    margin-bottom: 56px;
}
.testi-logo-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
.testi-logo-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
}
.testi-logo-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 36px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
}
.testi-logo-img {
    height: 32px;
    margin-bottom: 24px;
    opacity: 0.6;
}
.testi-logo-quote {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1rem;
    line-height: 1.7;
    color: #475569;
    font-style: italic;
    margin-bottom: 20px;
}
.testi-logo-name {
    font-family: var(--font-body, "Inter", sans-serif);
    font-weight: 600;
    color: var(--color-text, #1e293b);
    font-size: 0.9rem;
}
@media (max-width: 768px) {
    .testi-logo { padding: 60px 16px; }
    .testi-logo-title { font-size: 2rem; }
    .testi-logo-cards { grid-template-columns: 1fr; }
}',
        ];
    }

    // ========================================================================
    // PRECIOS
    // ========================================================================

    private function pricing3Plans(): array
    {
        return [
            'name' => 'Tabla 3 Planes',
            'category' => 'precios',
            'description' => '3 columnas de precios (Basico/Pro/Enterprise) con el plan Pro destacado como Popular.',
            'html' => '<section class="price3" data-reveal>
    <div class="price3-container">
        <div class="price3-header">
            <h2 class="price3-title">Planes y precios</h2>
            <p class="price3-subtitle">Elige el plan que mejor se adapta a tus necesidades.</p>
        </div>
        <div class="price3-grid">
            <div class="price3-card">
                <h3 class="price3-plan">Basico</h3>
                <p class="price3-desc">Ideal para emprendedores que inician su presencia digital.</p>
                <div class="price3-price">$29<span class="price3-period">/mes</span></div>
                <ul class="price3-features">
                    <li>&#10003; 1 Sitio Web</li>
                    <li>&#10003; 5 Paginas</li>
                    <li>&#10003; SSL Incluido</li>
                    <li>&#10003; Soporte por Email</li>
                    <li class="price3-disabled">&#10007; Dominio Personalizado</li>
                    <li class="price3-disabled">&#10007; Analiticas Avanzadas</li>
                </ul>
                <a href="#contacto" class="price3-btn">Comenzar</a>
            </div>
            <div class="price3-card price3-card-popular">
                <div class="price3-badge">Popular</div>
                <h3 class="price3-plan">Profesional</h3>
                <p class="price3-desc">Para negocios en crecimiento que necesitan mas potencia.</p>
                <div class="price3-price">$79<span class="price3-period">/mes</span></div>
                <ul class="price3-features">
                    <li>&#10003; 3 Sitios Web</li>
                    <li>&#10003; Paginas Ilimitadas</li>
                    <li>&#10003; SSL Incluido</li>
                    <li>&#10003; Soporte Prioritario</li>
                    <li>&#10003; Dominio Personalizado</li>
                    <li>&#10003; Analiticas Avanzadas</li>
                </ul>
                <a href="#contacto" class="price3-btn-primary">Comenzar</a>
            </div>
            <div class="price3-card">
                <h3 class="price3-plan">Empresa</h3>
                <p class="price3-desc">Para empresas que requieren soluciones a medida y escalables.</p>
                <div class="price3-price">$199<span class="price3-period">/mes</span></div>
                <ul class="price3-features">
                    <li>&#10003; Sitios Ilimitados</li>
                    <li>&#10003; Paginas Ilimitadas</li>
                    <li>&#10003; SSL Incluido</li>
                    <li>&#10003; Soporte 24/7</li>
                    <li>&#10003; Dominio Personalizado</li>
                    <li>&#10003; Analiticas + IA</li>
                </ul>
                <a href="#contacto" class="price3-btn">Contactar</a>
            </div>
        </div>
    </div>
</section>',
            'css' => '.price3 {
    padding: 100px 24px;
    background: #f8fafc;
}
.price3-container {
    max-width: 1200px;
    margin: 0 auto;
}
.price3-header {
    text-align: center;
    margin-bottom: 56px;
}
.price3-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.price3-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.price3-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    align-items: start;
}
.price3-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
    position: relative;
}
.price3-card-popular {
    border: 2px solid var(--color-primary, #6366f1);
    transform: scale(1.05);
    box-shadow: 0 12px 40px rgba(99, 102, 241, 0.15);
}
.price3-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    padding: 4px 20px;
    border-radius: 100px;
    font-size: 0.85rem;
    font-weight: 700;
}
.price3-plan {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 8px;
}
.price3-desc {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 24px;
}
.price3-price {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3rem;
    font-weight: 800;
    color: var(--color-text, #1e293b);
    margin-bottom: 28px;
}
.price3-period {
    font-size: 1rem;
    font-weight: 400;
    color: #64748b;
}
.price3-features {
    list-style: none;
    padding: 0;
    margin-bottom: 32px;
    text-align: left;
}
.price3-features li {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    padding: 8px 0;
    color: #475569;
    border-bottom: 1px solid #f1f5f9;
}
.price3-disabled {
    color: #cbd5e1 !important;
}
.price3-btn {
    display: inline-block;
    width: 100%;
    padding: 14px;
    border: 2px solid var(--color-primary, #6366f1);
    color: var(--color-primary, #6366f1);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
}
.price3-btn:hover {
    background: var(--color-primary, #6366f1);
    color: #ffffff;
}
.price3-btn-primary {
    display: inline-block;
    width: 100%;
    padding: 14px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    border: 2px solid var(--color-primary, #6366f1);
    transition: transform 0.2s, box-shadow 0.2s;
}
.price3-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
@media (max-width: 1024px) {
    .price3-card-popular { transform: scale(1); }
}
@media (max-width: 768px) {
    .price3 { padding: 60px 16px; }
    .price3-title { font-size: 2rem; }
    .price3-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
}',
        ];
    }

    private function pricing2Plans(): array
    {
        return [
            'name' => 'Tabla 2 Planes',
            'category' => 'precios',
            'description' => '2 columnas de precios lado a lado, una destacada.',
            'html' => '<section class="price2" data-reveal>
    <div class="price2-container">
        <div class="price2-header">
            <h2 class="price2-title">Planes simples y transparentes</h2>
            <p class="price2-subtitle">Sin costos ocultos. Cancela cuando quieras.</p>
        </div>
        <div class="price2-grid">
            <div class="price2-card">
                <h3 class="price2-plan">Starter</h3>
                <div class="price2-price">$49<span class="price2-period">/mes</span></div>
                <p class="price2-desc">Todo lo esencial para comenzar tu proyecto web.</p>
                <ul class="price2-features">
                    <li>&#10003; Hasta 10 paginas</li>
                    <li>&#10003; Editor visual</li>
                    <li>&#10003; Blog integrado</li>
                    <li>&#10003; SSL gratuito</li>
                    <li>&#10003; Soporte por email</li>
                </ul>
                <a href="#contacto" class="price2-btn">Elegir Starter</a>
            </div>
            <div class="price2-card price2-card-featured">
                <div class="price2-badge">Recomendado</div>
                <h3 class="price2-plan">Premium</h3>
                <div class="price2-price">$99<span class="price2-period">/mes</span></div>
                <p class="price2-desc">Para negocios serios que quieren crecer sin limites.</p>
                <ul class="price2-features">
                    <li>&#10003; Paginas ilimitadas</li>
                    <li>&#10003; Editor visual + IA</li>
                    <li>&#10003; Blog + Newsletter</li>
                    <li>&#10003; Dominio personalizado</li>
                    <li>&#10003; Soporte prioritario 24/7</li>
                </ul>
                <a href="#contacto" class="price2-btn-primary">Elegir Premium</a>
            </div>
        </div>
    </div>
</section>',
            'css' => '.price2 {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.price2-container {
    max-width: 800px;
    margin: 0 auto;
}
.price2-header {
    text-align: center;
    margin-bottom: 56px;
}
.price2-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.price2-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.price2-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
}
.price2-card {
    background: #f8fafc;
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    position: relative;
}
.price2-card-featured {
    background: #ffffff;
    border: 2px solid var(--color-primary, #6366f1);
    box-shadow: 0 12px 40px rgba(99, 102, 241, 0.12);
}
.price2-badge {
    position: absolute;
    top: -14px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    padding: 4px 20px;
    border-radius: 100px;
    font-size: 0.85rem;
    font-weight: 700;
}
.price2-plan {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.price2-price {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.75rem;
    font-weight: 800;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.price2-period {
    font-size: 1rem;
    font-weight: 400;
    color: #64748b;
}
.price2-desc {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 24px;
}
.price2-features {
    list-style: none;
    padding: 0;
    margin-bottom: 28px;
    text-align: left;
}
.price2-features li {
    font-size: 0.95rem;
    padding: 8px 0;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
}
.price2-btn {
    display: inline-block;
    width: 100%;
    padding: 14px;
    border: 2px solid #cbd5e1;
    color: var(--color-text, #1e293b);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: border-color 0.2s;
}
.price2-btn:hover {
    border-color: var(--color-primary, #6366f1);
    color: var(--color-primary, #6366f1);
}
.price2-btn-primary {
    display: inline-block;
    width: 100%;
    padding: 14px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: 2px solid var(--color-primary, #6366f1);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: transform 0.2s, box-shadow 0.2s;
}
.price2-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
@media (max-width: 768px) {
    .price2 { padding: 60px 16px; }
    .price2-title { font-size: 2rem; }
    .price2-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
}',
        ];
    }

    private function pricingComparison(): array
    {
        return [
            'name' => 'Comparativa Features',
            'category' => 'precios',
            'description' => 'Tabla comparativa con checks mostrando features por plan.',
            'html' => '<section class="price-comp" data-reveal>
    <div class="price-comp-container">
        <div class="price-comp-header">
            <h2 class="price-comp-title">Compara nuestros planes</h2>
            <p class="price-comp-subtitle">Encuentra el plan perfecto para tu proyecto.</p>
        </div>
        <div class="price-comp-table-wrap">
            <table class="price-comp-table">
                <thead>
                    <tr>
                        <th>Caracteristica</th>
                        <th>Basico</th>
                        <th class="price-comp-highlight">Pro</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Paginas</td>
                        <td>5</td>
                        <td class="price-comp-highlight">Ilimitadas</td>
                        <td>Ilimitadas</td>
                    </tr>
                    <tr>
                        <td>Editor Visual</td>
                        <td>&#10003;</td>
                        <td class="price-comp-highlight">&#10003;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>Blog Integrado</td>
                        <td>&#10003;</td>
                        <td class="price-comp-highlight">&#10003;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>IA para Contenido</td>
                        <td>&#10007;</td>
                        <td class="price-comp-highlight">&#10003;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>Dominio Personalizado</td>
                        <td>&#10007;</td>
                        <td class="price-comp-highlight">&#10003;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>Analiticas Avanzadas</td>
                        <td>&#10007;</td>
                        <td class="price-comp-highlight">&#10003;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>E-commerce</td>
                        <td>&#10007;</td>
                        <td class="price-comp-highlight">&#10007;</td>
                        <td>&#10003;</td>
                    </tr>
                    <tr>
                        <td>Soporte</td>
                        <td>Email</td>
                        <td class="price-comp-highlight">Prioritario</td>
                        <td>24/7 Dedicado</td>
                    </tr>
                    <tr>
                        <td><strong>Precio</strong></td>
                        <td><strong>$29/mes</strong></td>
                        <td class="price-comp-highlight"><strong>$79/mes</strong></td>
                        <td><strong>$199/mes</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>',
            'css' => '.price-comp {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.price-comp-container {
    max-width: 900px;
    margin: 0 auto;
}
.price-comp-header {
    text-align: center;
    margin-bottom: 48px;
}
.price-comp-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.price-comp-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.price-comp-table-wrap {
    overflow-x: auto;
}
.price-comp-table {
    width: 100%;
    border-collapse: collapse;
    font-family: var(--font-body, "Inter", sans-serif);
}
.price-comp-table th, .price-comp-table td {
    padding: 16px 20px;
    text-align: center;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.95rem;
    color: #475569;
}
.price-comp-table th {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-weight: 700;
    color: var(--color-text, #1e293b);
    font-size: 1rem;
    padding-bottom: 20px;
}
.price-comp-table td:first-child, .price-comp-table th:first-child {
    text-align: left;
}
.price-comp-highlight {
    background: rgba(99, 102, 241, 0.04);
}
.price-comp-table th.price-comp-highlight {
    color: var(--color-primary, #6366f1);
}
@media (max-width: 768px) {
    .price-comp { padding: 60px 16px; }
    .price-comp-title { font-size: 2rem; }
    .price-comp-table th, .price-comp-table td { padding: 12px 10px; font-size: 0.85rem; }
}',
        ];
    }

    // ========================================================================
    // CONTACTO
    // ========================================================================

    private function contactFull(): array
    {
        return [
            'name' => 'Formulario Completo',
            'category' => 'contacto',
            'description' => 'Formulario con nombre, email, telefono, asunto, mensaje y sidebar con informacion de la empresa.',
            'html' => '<section class="contact-full" data-reveal>
    <div class="contact-full-container">
        <div class="contact-full-info">
            <h2 class="contact-full-title">Contactanos</h2>
            <p class="contact-full-text">Estamos listos para ayudarte con tu proximo proyecto. Envianos un mensaje y te responderemos en menos de 24 horas.</p>
            <div class="contact-full-details">
                <div class="contact-full-detail">
                    <span class="contact-full-detail-icon">&#128205;</span>
                    <div>
                        <p class="contact-full-detail-label">Direccion</p>
                        <p class="contact-full-detail-value">Av. Providencia 1208, Santiago, Chile</p>
                    </div>
                </div>
                <div class="contact-full-detail">
                    <span class="contact-full-detail-icon">&#128231;</span>
                    <div>
                        <p class="contact-full-detail-label">Email</p>
                        <p class="contact-full-detail-value">contacto@miempresa.cl</p>
                    </div>
                </div>
                <div class="contact-full-detail">
                    <span class="contact-full-detail-icon">&#128222;</span>
                    <div>
                        <p class="contact-full-detail-label">Telefono</p>
                        <p class="contact-full-detail-value">+56 9 1234 5678</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-full-form-wrap">
            <form class="contact-full-form" data-contact-form>
                <input type="text" name="website_url" style="display:none" tabindex="-1" autocomplete="off" />
                <div class="contact-full-row">
                    <div class="contact-full-field">
                        <label>Nombre</label>
                        <input type="text" name="name" placeholder="Tu nombre completo" required />
                    </div>
                    <div class="contact-full-field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="tu@email.com" required />
                    </div>
                </div>
                <div class="contact-full-row">
                    <div class="contact-full-field">
                        <label>Telefono</label>
                        <input type="tel" name="phone" placeholder="+56 9 1234 5678" />
                    </div>
                    <div class="contact-full-field">
                        <label>Asunto</label>
                        <input type="text" name="subject" placeholder="Asunto del mensaje" />
                    </div>
                </div>
                <div class="contact-full-field">
                    <label>Mensaje</label>
                    <textarea name="message" rows="5" placeholder="Cuentanos sobre tu proyecto..." required></textarea>
                </div>
                <button type="submit" class="contact-full-submit">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</section>',
            'css' => '.contact-full {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.contact-full-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 64px;
}
.contact-full-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 16px;
}
.contact-full-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    line-height: 1.7;
    color: #64748b;
    margin-bottom: 40px;
}
.contact-full-details {
    display: flex;
    flex-direction: column;
    gap: 24px;
}
.contact-full-detail {
    display: flex;
    gap: 16px;
    align-items: flex-start;
}
.contact-full-detail-icon {
    font-size: 1.5rem;
    flex-shrink: 0;
}
.contact-full-detail-label {
    font-weight: 600;
    color: var(--color-text, #1e293b);
    font-size: 0.9rem;
    margin-bottom: 2px;
}
.contact-full-detail-value {
    color: #64748b;
    font-size: 0.95rem;
}
.contact-full-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.contact-full-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.contact-full-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.contact-full-field label {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-text, #1e293b);
}
.contact-full-field input, .contact-full-field textarea {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--font-body, "Inter", sans-serif);
    color: var(--color-text, #1e293b);
    transition: border-color 0.2s;
    background: #f8fafc;
}
.contact-full-field input:focus, .contact-full-field textarea:focus {
    outline: none;
    border-color: var(--color-primary, #6366f1);
}
.contact-full-submit {
    padding: 14px 32px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    align-self: flex-start;
}
.contact-full-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
@media (max-width: 768px) {
    .contact-full { padding: 60px 16px; }
    .contact-full-container { grid-template-columns: 1fr; gap: 40px; }
    .contact-full-row { grid-template-columns: 1fr; }
}',
        ];
    }

    private function contactSimple(): array
    {
        return [
            'name' => 'Formulario Simple',
            'category' => 'contacto',
            'description' => 'Formulario compacto con nombre, email, mensaje y boton de envio.',
            'html' => '<section class="contact-simple" data-reveal>
    <div class="contact-simple-container">
        <h2 class="contact-simple-title">Envianos un mensaje</h2>
        <p class="contact-simple-subtitle">Te responderemos en menos de 24 horas.</p>
        <form class="contact-simple-form" data-contact-form>
            <input type="text" name="website_url" style="display:none" tabindex="-1" autocomplete="off" />
            <div class="contact-simple-row">
                <input type="text" name="name" placeholder="Tu nombre" required />
                <input type="email" name="email" placeholder="tu@email.com" required />
            </div>
            <textarea name="message" rows="4" placeholder="Tu mensaje..." required></textarea>
            <button type="submit" class="contact-simple-btn">Enviar</button>
        </form>
    </div>
</section>',
            'css' => '.contact-simple {
    padding: 100px 24px;
    background: #f8fafc;
}
.contact-simple-container {
    max-width: 600px;
    margin: 0 auto;
    text-align: center;
}
.contact-simple-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 8px;
}
.contact-simple-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    color: #64748b;
    margin-bottom: 36px;
}
.contact-simple-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.contact-simple-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.contact-simple-form input, .contact-simple-form textarea {
    padding: 14px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--font-body, "Inter", sans-serif);
    color: var(--color-text, #1e293b);
    background: #ffffff;
    transition: border-color 0.2s;
}
.contact-simple-form input:focus, .contact-simple-form textarea:focus {
    outline: none;
    border-color: var(--color-primary, #6366f1);
}
.contact-simple-btn {
    padding: 14px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}
.contact-simple-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.3);
}
@media (max-width: 768px) {
    .contact-simple { padding: 60px 16px; }
    .contact-simple-title { font-size: 1.75rem; }
    .contact-simple-row { grid-template-columns: 1fr; }
}',
        ];
    }

    private function contactMap(): array
    {
        return [
            'name' => 'Mapa + Contacto',
            'category' => 'contacto',
            'description' => '2 columnas: mapa placeholder a la izquierda, datos de contacto y formulario a la derecha.',
            'html' => '<section class="contact-map" data-reveal>
    <div class="contact-map-container">
        <div class="contact-map-left">
            <div class="contact-map-placeholder">
                <p>&#128205; Mapa interactivo</p>
                <p class="contact-map-placeholder-sub">Inserta aqui tu iframe de Google Maps</p>
            </div>
        </div>
        <div class="contact-map-right">
            <h2 class="contact-map-title">Visitanos</h2>
            <div class="contact-map-details">
                <p><strong>Direccion:</strong> Av. Providencia 1208, Santiago</p>
                <p><strong>Horario:</strong> Lunes a Viernes, 9:00 - 18:00</p>
                <p><strong>Telefono:</strong> +56 9 1234 5678</p>
                <p><strong>Email:</strong> info@miempresa.cl</p>
            </div>
            <form class="contact-map-form" data-contact-form>
                <input type="text" name="website_url" style="display:none" tabindex="-1" autocomplete="off" />
                <input type="text" name="name" placeholder="Tu nombre" required />
                <input type="email" name="email" placeholder="tu@email.com" required />
                <textarea name="message" rows="3" placeholder="Mensaje breve..." required></textarea>
                <button type="submit" class="contact-map-btn">Enviar</button>
            </form>
        </div>
    </div>
</section>',
            'css' => '.contact-map {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.contact-map-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
}
.contact-map-placeholder {
    background: #e2e8f0;
    border-radius: 16px;
    height: 100%;
    min-height: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 1.25rem;
}
.contact-map-placeholder-sub {
    font-size: 0.9rem;
    margin-top: 8px;
    opacity: 0.7;
}
.contact-map-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 20px;
}
.contact-map-details {
    margin-bottom: 28px;
}
.contact-map-details p {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #475569;
    margin-bottom: 8px;
}
.contact-map-details strong {
    color: var(--color-text, #1e293b);
}
.contact-map-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.contact-map-form input, .contact-map-form textarea {
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    font-family: var(--font-body, "Inter", sans-serif);
    background: #f8fafc;
    transition: border-color 0.2s;
}
.contact-map-form input:focus, .contact-map-form textarea:focus {
    outline: none;
    border-color: var(--color-primary, #6366f1);
}
.contact-map-btn {
    padding: 12px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s;
}
.contact-map-btn:hover {
    transform: translateY(-2px);
}
@media (max-width: 768px) {
    .contact-map { padding: 60px 16px; }
    .contact-map-container { grid-template-columns: 1fr; }
    .contact-map-placeholder { min-height: 250px; }
}',
        ];
    }

    private function contactCta(): array
    {
        return [
            'name' => 'CTA con Formulario',
            'category' => 'contacto',
            'description' => 'Seccion con fondo degradado, titulo, subtitulo y formulario inline de email + boton.',
            'html' => '<section class="contact-cta" data-reveal>
    <div class="contact-cta-container">
        <h2 class="contact-cta-title">Listo para empezar?</h2>
        <p class="contact-cta-subtitle">Dejanos tu email y te contactaremos con una propuesta personalizada para tu proyecto.</p>
        <form class="contact-cta-form" data-contact-form>
            <input type="text" name="website_url" style="display:none" tabindex="-1" autocomplete="off" />
            <input type="email" name="email" placeholder="tu@email.com" required class="contact-cta-input" />
            <button type="submit" class="contact-cta-btn">Enviar</button>
        </form>
    </div>
</section>',
            'css' => '.contact-cta {
    padding: 100px 24px;
    background: linear-gradient(135deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    text-align: center;
}
.contact-cta-container {
    max-width: 600px;
    margin: 0 auto;
}
.contact-cta-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 16px;
}
.contact-cta-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 36px;
}
.contact-cta-form {
    display: flex;
    gap: 12px;
    max-width: 480px;
    margin: 0 auto;
}
.contact-cta-input {
    flex: 1;
    padding: 14px 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 12px;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
    font-family: var(--font-body, "Inter", sans-serif);
    transition: border-color 0.2s;
}
.contact-cta-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
.contact-cta-input:focus {
    outline: none;
    border-color: #ffffff;
}
.contact-cta-btn {
    padding: 14px 32px;
    background: #ffffff;
    color: var(--color-primary, #6366f1);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    white-space: nowrap;
}
.contact-cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}
@media (max-width: 768px) {
    .contact-cta { padding: 60px 16px; }
    .contact-cta-title { font-size: 2rem; }
    .contact-cta-form { flex-direction: column; }
}',
        ];
    }

    // ========================================================================
    // GALERIA
    // ========================================================================

    private function gallery3x2(): array
    {
        return [
            'name' => 'Grid Imagenes 3x2',
            'category' => 'galeria',
            'description' => '6 imagenes en grid de 3 columnas con bordes redondeados y zoom hover.',
            'html' => '<section class="gallery3x2" data-reveal>
    <div class="gallery3x2-container">
        <div class="gallery3x2-header">
            <h2 class="gallery3x2-title">Nuestra galeria</h2>
            <p class="gallery3x2-subtitle">Exploranos a traves de nuestro trabajo reciente.</p>
        </div>
        <div class="gallery3x2-grid">
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=20" alt="Proyecto 1" /></div>
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=21" alt="Proyecto 2" /></div>
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=22" alt="Proyecto 3" /></div>
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=23" alt="Proyecto 4" /></div>
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=24" alt="Proyecto 5" /></div>
            <div class="gallery3x2-item"><img src="https://picsum.photos/400/300?random=25" alt="Proyecto 6" /></div>
        </div>
    </div>
</section>',
            'css' => '.gallery3x2 {
    padding: 100px 24px;
    background: var(--color-background, #ffffff);
}
.gallery3x2-container {
    max-width: 1200px;
    margin: 0 auto;
}
.gallery3x2-header {
    text-align: center;
    margin-bottom: 48px;
}
.gallery3x2-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin-bottom: 12px;
}
.gallery3x2-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.125rem;
    color: #64748b;
}
.gallery3x2-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
.gallery3x2-item {
    overflow: hidden;
    border-radius: 16px;
}
.gallery3x2-item img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    transition: transform 0.4s;
}
.gallery3x2-item:hover img {
    transform: scale(1.08);
}
@media (max-width: 768px) {
    .gallery3x2 { padding: 60px 16px; }
    .gallery3x2-title { font-size: 2rem; }
    .gallery3x2-grid { grid-template-columns: 1fr; }
    .gallery3x2-item img { height: 200px; }
}',
        ];
    }

    private function gallery4x2(): array
    {
        return [
            'name' => 'Grid Imagenes 4x2',
            'category' => 'galeria',
            'description' => '8 imagenes en grid de 4 columnas compacto.',
            'html' => '<section class="gallery4x2" data-reveal>
    <div class="gallery4x2-container">
        <div class="gallery4x2-header">
            <h2 class="gallery4x2-title">Portafolio de proyectos</h2>
        </div>
        <div class="gallery4x2-grid">
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=30" alt="Proyecto 1" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=31" alt="Proyecto 2" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=32" alt="Proyecto 3" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=33" alt="Proyecto 4" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=34" alt="Proyecto 5" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=35" alt="Proyecto 6" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=36" alt="Proyecto 7" /></div>
            <div class="gallery4x2-item"><img src="https://picsum.photos/300/220?random=37" alt="Proyecto 8" /></div>
        </div>
    </div>
</section>',
            'css' => '.gallery4x2 {
    padding: 100px 24px;
    background: #f8fafc;
}
.gallery4x2-container {
    max-width: 1200px;
    margin: 0 auto;
}
.gallery4x2-header {
    text-align: center;
    margin-bottom: 40px;
}
.gallery4x2-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
.gallery4x2-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.gallery4x2-item {
    overflow: hidden;
    border-radius: 12px;
}
.gallery4x2-item img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    transition: transform 0.4s;
}
.gallery4x2-item:hover img {
    transform: scale(1.06);
}
@media (max-width: 1024px) {
    .gallery4x2-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .gallery4x2 { padding: 60px 16px; }
    .gallery4x2-title { font-size: 2rem; }
    .gallery4x2-grid { grid-template-columns: 1fr; }
}',
        ];
    }

    private function logoCloud(): array
    {
        return [
            'name' => 'Logo Cloud',
            'category' => 'galeria',
            'description' => 'Seccion "Confian en nosotros" con 6 logos placeholder en fila.',
            'html' => '<section class="logo-cloud" data-reveal>
    <div class="logo-cloud-container">
        <p class="logo-cloud-label">Empresas que confian en nosotros</p>
        <div class="logo-cloud-grid">
            <img src="https://picsum.photos/140/50?random=40" alt="Cliente 1" class="logo-cloud-img" />
            <img src="https://picsum.photos/140/50?random=41" alt="Cliente 2" class="logo-cloud-img" />
            <img src="https://picsum.photos/140/50?random=42" alt="Cliente 3" class="logo-cloud-img" />
            <img src="https://picsum.photos/140/50?random=43" alt="Cliente 4" class="logo-cloud-img" />
            <img src="https://picsum.photos/140/50?random=44" alt="Cliente 5" class="logo-cloud-img" />
            <img src="https://picsum.photos/140/50?random=45" alt="Cliente 6" class="logo-cloud-img" />
        </div>
    </div>
</section>',
            'css' => '.logo-cloud {
    padding: 80px 24px;
    background: var(--color-background, #ffffff);
}
.logo-cloud-container {
    max-width: 1000px;
    margin: 0 auto;
    text-align: center;
}
.logo-cloud-label {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 36px;
}
.logo-cloud-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 48px;
    flex-wrap: wrap;
}
.logo-cloud-img {
    height: 36px;
    opacity: 0.4;
    filter: grayscale(100%);
    transition: opacity 0.3s, filter 0.3s;
}
.logo-cloud-img:hover {
    opacity: 1;
    filter: grayscale(0%);
}
@media (max-width: 768px) {
    .logo-cloud { padding: 60px 16px; }
    .logo-cloud-grid { gap: 32px; }
    .logo-cloud-img { height: 28px; }
}',
        ];
    }

    private function stats(): array
    {
        return [
            'name' => 'Estadisticas',
            'category' => 'galeria',
            'description' => '4 numeros grandes en fila con etiquetas y atributos data-count para animacion.',
            'html' => '<section class="stats-block" data-reveal>
    <div class="stats-block-container">
        <div class="stats-block-item">
            <span class="stats-block-number" data-count="500" data-count-suffix="+">500+</span>
            <p class="stats-block-label">Clientes Satisfechos</p>
        </div>
        <div class="stats-block-item">
            <span class="stats-block-number" data-count="10">10</span>
            <p class="stats-block-label">Anos de Experiencia</p>
        </div>
        <div class="stats-block-item">
            <span class="stats-block-number" data-count="1200" data-count-suffix="+">1200+</span>
            <p class="stats-block-label">Proyectos Completados</p>
        </div>
        <div class="stats-block-item">
            <span class="stats-block-number" data-count="98" data-count-suffix="%">98%</span>
            <p class="stats-block-label">Satisfaccion</p>
        </div>
    </div>
</section>',
            'css' => '.stats-block {
    padding: 80px 24px;
    background: linear-gradient(135deg, #0f172a, #1e293b);
}
.stats-block-container {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 32px;
    text-align: center;
}
.stats-block-number {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3rem;
    font-weight: 800;
    color: #ffffff;
    display: block;
    margin-bottom: 8px;
}
.stats-block-label {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #94a3b8;
}
@media (max-width: 768px) {
    .stats-block { padding: 60px 16px; }
    .stats-block-container { grid-template-columns: repeat(2, 1fr); gap: 40px; }
    .stats-block-number { font-size: 2.25rem; }
}',
        ];
    }

    // ========================================================================
    // FOOTER
    // ========================================================================

    private function footerFull(): array
    {
        return [
            'name' => 'Footer Completo',
            'category' => 'footer',
            'description' => 'Footer de 4 columnas: about/logo, enlaces, contacto, redes sociales. Fondo oscuro.',
            'html' => '<footer class="footer-full">
    <div class="footer-full-container">
        <div class="footer-full-col">
            <h3 class="footer-full-brand">MiEmpresa</h3>
            <p class="footer-full-about">Soluciones digitales innovadoras que transforman negocios y conectan marcas con sus audiencias de manera efectiva.</p>
        </div>
        <div class="footer-full-col">
            <h4 class="footer-full-heading">Empresa</h4>
            <ul class="footer-full-links">
                <li><a href="#about">Sobre Nosotros</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </div>
        <div class="footer-full-col">
            <h4 class="footer-full-heading">Contacto</h4>
            <ul class="footer-full-links">
                <li>&#128205; Av. Providencia 1208, Santiago</li>
                <li>&#128231; contacto@miempresa.cl</li>
                <li>&#128222; +56 9 1234 5678</li>
            </ul>
        </div>
        <div class="footer-full-col">
            <h4 class="footer-full-heading">Siguenos</h4>
            <div class="footer-full-social">
                <a href="#" class="footer-full-social-link">FB</a>
                <a href="#" class="footer-full-social-link">IG</a>
                <a href="#" class="footer-full-social-link">TW</a>
                <a href="#" class="footer-full-social-link">LI</a>
            </div>
        </div>
    </div>
    <div class="footer-full-bottom">
        <p>&copy; 2026 MiEmpresa. Todos los derechos reservados.</p>
    </div>
</footer>',
            'css' => '.footer-full {
    background: #0f172a;
    padding: 80px 24px 0;
    color: #94a3b8;
}
.footer-full-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1fr;
    gap: 48px;
    padding-bottom: 48px;
}
.footer-full-brand {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 16px;
}
.footer-full-about {
    font-size: 0.9rem;
    line-height: 1.7;
}
.footer-full-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 20px;
}
.footer-full-links {
    list-style: none;
    padding: 0;
}
.footer-full-links li {
    font-size: 0.9rem;
    margin-bottom: 10px;
}
.footer-full-links a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.2s;
}
.footer-full-links a:hover {
    color: #ffffff;
}
.footer-full-social {
    display: flex;
    gap: 12px;
}
.footer-full-social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #1e293b;
    border-radius: 10px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 700;
    transition: background 0.2s, color 0.2s;
}
.footer-full-social-link:hover {
    background: var(--color-primary, #6366f1);
    color: #ffffff;
}
.footer-full-bottom {
    border-top: 1px solid #1e293b;
    padding: 20px 0;
    text-align: center;
    font-size: 0.85rem;
    max-width: 1200px;
    margin: 0 auto;
}
@media (max-width: 768px) {
    .footer-full { padding: 60px 16px 0; }
    .footer-full-container { grid-template-columns: 1fr; gap: 32px; }
}',
        ];
    }

    private function footerSimple(): array
    {
        return [
            'name' => 'Footer Simple',
            'category' => 'footer',
            'description' => 'Footer de una fila: logo a la izquierda, enlaces al centro, redes sociales a la derecha.',
            'html' => '<footer class="footer-simple">
    <div class="footer-simple-container">
        <div class="footer-simple-brand">
            <span class="footer-simple-logo">MiEmpresa</span>
        </div>
        <nav class="footer-simple-nav">
            <a href="#about">Nosotros</a>
            <a href="#servicios">Servicios</a>
            <a href="/blog">Blog</a>
            <a href="#contacto">Contacto</a>
        </nav>
        <div class="footer-simple-social">
            <a href="#" class="footer-simple-social-link">FB</a>
            <a href="#" class="footer-simple-social-link">IG</a>
            <a href="#" class="footer-simple-social-link">TW</a>
        </div>
    </div>
    <div class="footer-simple-bottom">
        <p>&copy; 2026 MiEmpresa. Todos los derechos reservados.</p>
    </div>
</footer>',
            'css' => '.footer-simple {
    background: var(--color-background, #ffffff);
    border-top: 1px solid #e2e8f0;
    padding: 40px 24px 0;
}
.footer-simple-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 24px;
}
.footer-simple-logo {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--color-text, #1e293b);
}
.footer-simple-nav {
    display: flex;
    gap: 28px;
}
.footer-simple-nav a {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s;
}
.footer-simple-nav a:hover {
    color: var(--color-primary, #6366f1);
}
.footer-simple-social {
    display: flex;
    gap: 10px;
}
.footer-simple-social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: #f1f5f9;
    border-radius: 8px;
    color: #64748b;
    text-decoration: none;
    font-size: 0.8rem;
    font-weight: 700;
    transition: background 0.2s, color 0.2s;
}
.footer-simple-social-link:hover {
    background: var(--color-primary, #6366f1);
    color: #ffffff;
}
.footer-simple-bottom {
    border-top: 1px solid #e2e8f0;
    padding: 16px 0;
    text-align: center;
    font-size: 0.8rem;
    color: #94a3b8;
    max-width: 1200px;
    margin: 0 auto;
}
@media (max-width: 768px) {
    .footer-simple-container { flex-direction: column; gap: 20px; text-align: center; }
    .footer-simple-nav { flex-wrap: wrap; justify-content: center; gap: 16px; }
}',
        ];
    }

    private function footerNewsletter(): array
    {
        return [
            'name' => 'Footer con Newsletter',
            'category' => 'footer',
            'description' => 'Footer de 3 columnas: about, enlaces rapidos y formulario de suscripcion a newsletter.',
            'html' => '<footer class="footer-news">
    <div class="footer-news-container">
        <div class="footer-news-col">
            <h3 class="footer-news-brand">MiEmpresa</h3>
            <p class="footer-news-about">Creamos experiencias digitales que impulsan el crecimiento de tu negocio.</p>
        </div>
        <div class="footer-news-col">
            <h4 class="footer-news-heading">Enlaces</h4>
            <ul class="footer-news-links">
                <li><a href="#about">Nosotros</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </div>
        <div class="footer-news-col">
            <h4 class="footer-news-heading">Newsletter</h4>
            <p class="footer-news-desc">Recibe nuestras novedades y consejos directamente en tu email.</p>
            <form class="footer-news-form">
                <input type="email" placeholder="tu@email.com" required class="footer-news-input" />
                <button type="submit" class="footer-news-btn">Suscribir</button>
            </form>
        </div>
    </div>
    <div class="footer-news-bottom">
        <p>&copy; 2026 MiEmpresa. Todos los derechos reservados.</p>
    </div>
</footer>',
            'css' => '.footer-news {
    background: #0f172a;
    padding: 80px 24px 0;
    color: #94a3b8;
}
.footer-news-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.3fr 1fr 1.3fr;
    gap: 48px;
    padding-bottom: 48px;
}
.footer-news-brand {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 12px;
}
.footer-news-about {
    font-size: 0.9rem;
    line-height: 1.7;
}
.footer-news-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 20px;
}
.footer-news-links {
    list-style: none;
    padding: 0;
}
.footer-news-links li {
    margin-bottom: 10px;
}
.footer-news-links a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s;
}
.footer-news-links a:hover {
    color: #ffffff;
}
.footer-news-desc {
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 16px;
}
.footer-news-form {
    display: flex;
    gap: 8px;
}
.footer-news-input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #334155;
    border-radius: 8px;
    background: #1e293b;
    color: #ffffff;
    font-size: 0.9rem;
    font-family: var(--font-body, "Inter", sans-serif);
}
.footer-news-input::placeholder {
    color: #64748b;
}
.footer-news-input:focus {
    outline: none;
    border-color: var(--color-primary, #6366f1);
}
.footer-news-btn {
    padding: 10px 20px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}
.footer-news-btn:hover {
    background: var(--color-secondary, #0ea5e9);
}
.footer-news-bottom {
    border-top: 1px solid #1e293b;
    padding: 20px 0;
    text-align: center;
    font-size: 0.85rem;
    max-width: 1100px;
    margin: 0 auto;
}
@media (max-width: 768px) {
    .footer-news { padding: 60px 16px 0; }
    .footer-news-container { grid-template-columns: 1fr; gap: 32px; }
    .footer-news-form { flex-direction: column; }
}',
        ];
    }

    // ========================================================================
    // HEROES — NUEVOS
    // ========================================================================

    private function heroSplit(): array
    {
        return [
            'name' => 'Hero Split',
            'category' => 'heroes',
            'description' => 'Hero de 2 columnas: lado izquierdo oscuro con texto y 2 CTAs, lado derecho con imagen completa.',
            'html' => '<section class="hsplit">
    <div class="hsplit-text" data-animate="fade-right">
        <span class="hsplit-badge">Nuevo Lanzamiento</span>
        <h1 class="hsplit-title">Soluciones digitales que <span class="hsplit-highlight">impulsan</span> tu negocio</h1>
        <p class="hsplit-subtitle">Conectamos tecnologia y creatividad para crear experiencias web que generan resultados reales y medibles.</p>
        <div class="hsplit-buttons">
            <a href="#contacto" class="hsplit-btn-primary">Solicitar Demo</a>
            <a href="#servicios" class="hsplit-btn-secondary">Conocer Mas &#10140;</a>
        </div>
    </div>
    <div class="hsplit-image" data-animate="fade-left">
        <img src="https://picsum.photos/800/900?random=50" alt="Solucion digital" />
        <div class="hsplit-accent-line"></div>
    </div>
</section>',
            'css' => '.hsplit {
    display: grid;
    grid-template-columns: 1fr 1fr;
    min-height: 100vh;
}
.hsplit-text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: clamp(48px, 8vw, 120px) clamp(24px, 5vw, 80px);
    background: #0f172a;
    color: #ffffff;
    position: relative;
}
.hsplit-badge {
    display: inline-block;
    width: fit-content;
    padding: 6px 16px;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.3);
    border-radius: 50px;
    color: var(--color-primary, #818cf8);
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 24px;
    font-family: var(--font-body, "Inter", sans-serif);
}
.hsplit-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    line-height: 1.1;
    margin: 0 0 20px;
}
.hsplit-highlight {
    background: linear-gradient(135deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hsplit-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: clamp(1rem, 1.5vw, 1.2rem);
    line-height: 1.7;
    color: #94a3b8;
    margin-bottom: 36px;
    max-width: 480px;
}
.hsplit-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}
.hsplit-btn-primary {
    display: inline-block;
    padding: 14px 32px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hsplit-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
}
.hsplit-btn-secondary {
    display: inline-flex;
    align-items: center;
    padding: 14px 24px;
    background: transparent;
    color: #e2e8f0;
    border: 2px solid #334155;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1rem;
    transition: border-color 0.2s;
}
.hsplit-btn-secondary:hover {
    border-color: var(--color-primary, #6366f1);
}
.hsplit-image {
    position: relative;
    overflow: hidden;
}
.hsplit-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.hsplit-accent-line {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(180deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9), var(--color-accent, #f59e0b));
}
@media (max-width: 1024px) {
    .hsplit { grid-template-columns: 1fr; min-height: auto; }
    .hsplit-image { order: -1; height: 50vh; }
}
@media (max-width: 768px) {
    .hsplit-text { padding: 48px 20px; }
    .hsplit-image { height: 40vh; }
    .hsplit-buttons { flex-direction: column; }
}
@media (max-width: 480px) {
    .hsplit-title { font-size: 1.75rem; }
}',
        ];
    }

    private function heroGradientAnimado(): array
    {
        return [
            'name' => 'Hero Gradiente Animado',
            'category' => 'heroes',
            'description' => 'Hero de ancho completo con fondo de gradiente animado de 3 colores, texto centrado y efecto de particulas CSS.',
            'html' => '<section class="hgrad">
    <div class="hgrad-particles"></div>
    <div class="hgrad-particles hgrad-particles-2"></div>
    <div class="hgrad-content" data-animate="fade-up">
        <h1 class="hgrad-title">Innovacion sin limites</h1>
        <p class="hgrad-subtitle">Llevamos tu marca al siguiente nivel con tecnologia de vanguardia y diseno que conecta con tu audiencia.</p>
        <a href="#contacto" class="hgrad-btn">Comenzar Proyecto</a>
    </div>
</section>',
            'css' => '.hgrad {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(-45deg, #0f172a, #4f46e5, #0ea5e9, #7c3aed);
    background-size: 400% 400%;
    animation: hgradShift 15s ease infinite;
}
@keyframes hgradShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.hgrad-particles,
.hgrad-particles-2 {
    position: absolute;
    inset: 0;
    overflow: hidden;
    pointer-events: none;
}
.hgrad-particles::before,
.hgrad-particles::after,
.hgrad-particles-2::before,
.hgrad-particles-2::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
}
.hgrad-particles::before {
    width: 300px; height: 300px;
    top: 10%; left: 15%;
    animation: hgradFloat 8s ease-in-out infinite;
}
.hgrad-particles::after {
    width: 200px; height: 200px;
    top: 60%; right: 10%;
    animation: hgradFloat 10s ease-in-out infinite reverse;
}
.hgrad-particles-2::before {
    width: 150px; height: 150px;
    bottom: 15%; left: 40%;
    animation: hgradFloat 12s ease-in-out infinite 2s;
}
.hgrad-particles-2::after {
    width: 100px; height: 100px;
    top: 30%; right: 30%;
    animation: hgradFloat 9s ease-in-out infinite 1s;
}
@keyframes hgradFloat {
    0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.6; }
    50% { transform: translate(30px, -30px) scale(1.1); opacity: 1; }
}
.hgrad-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 700px;
    padding: 40px 24px;
}
.hgrad-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 24px;
    line-height: 1.1;
    text-shadow: 0 2px 20px rgba(0,0,0,0.2);
}
.hgrad-subtitle {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: clamp(1rem, 2vw, 1.25rem);
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.7;
    margin-bottom: 40px;
}
.hgrad-btn {
    display: inline-block;
    padding: 16px 40px;
    background: #ffffff;
    color: #1e293b;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.05rem;
    transition: transform 0.2s, box-shadow 0.2s;
}
.hgrad-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
}
@media (max-width: 768px) {
    .hgrad { min-height: 80vh; }
    .hgrad-content { padding: 32px 16px; }
}
@media (max-width: 480px) {
    .hgrad-title { font-size: 2rem; }
    .hgrad-btn { padding: 14px 28px; }
}',
        ];
    }

    // ========================================================================
    // CONTENIDO — NUEVOS
    // ========================================================================

    private function bentoGrid(): array
    {
        return [
            'name' => 'Bento Grid',
            'category' => 'contenido',
            'description' => 'Grid irregular tipo bento con 6 tarjetas: 1 grande (2 filas), 5 normales. Iconos, titulos y descripciones.',
            'html' => '<section class="bento" data-animate="fade-up">
    <div class="bento-container">
        <h2 class="bento-heading">Todo lo que necesitas</h2>
        <p class="bento-subheading">Herramientas poderosas para impulsar tu presencia digital</p>
        <div class="bento-grid">
            <div class="bento-card bento-card-large" data-hover="lift">
                <div class="bento-icon">&#9889;</div>
                <h3 class="bento-card-title">Rendimiento Ultra Rapido</h3>
                <p class="bento-card-desc">Optimizacion avanzada para tiempos de carga inferiores a 1 segundo. Tu sitio siempre veloz.</p>
            </div>
            <div class="bento-card" data-hover="lift">
                <div class="bento-icon">&#128274;</div>
                <h3 class="bento-card-title">Seguridad Total</h3>
                <p class="bento-card-desc">Certificado SSL, firewall y backups automaticos diarios.</p>
            </div>
            <div class="bento-card" data-hover="lift">
                <div class="bento-icon">&#127912;</div>
                <h3 class="bento-card-title">Diseno Personalizado</h3>
                <p class="bento-card-desc">Editor visual intuitivo para crear sin codigo.</p>
            </div>
            <div class="bento-card" data-hover="lift">
                <div class="bento-icon">&#128200;</div>
                <h3 class="bento-card-title">Analiticas</h3>
                <p class="bento-card-desc">Metricas en tiempo real para tomar mejores decisiones.</p>
            </div>
            <div class="bento-card" data-hover="lift">
                <div class="bento-icon">&#129302;</div>
                <h3 class="bento-card-title">IA Integrada</h3>
                <p class="bento-card-desc">Generacion de contenido y SEO con inteligencia artificial.</p>
            </div>
            <div class="bento-card" data-hover="lift">
                <div class="bento-icon">&#128241;</div>
                <h3 class="bento-card-title">100% Responsive</h3>
                <p class="bento-card-desc">Perfecto en todos los dispositivos sin configuracion extra.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.bento {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.bento-container {
    max-width: 1100px;
    margin: 0 auto;
}
.bento-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.bento-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: clamp(1rem, 1.5vw, 1.15rem);
    color: #64748b;
    text-align: center;
    margin: 0 0 48px;
}
.bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-template-rows: auto auto;
    gap: 20px;
}
.bento-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 32px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.bento-card-large {
    grid-row: span 2;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    color: #ffffff;
    border: none;
}
.bento-card-large .bento-card-title,
.bento-card-large .bento-card-desc {
    color: #ffffff;
}
.bento-card-large .bento-card-desc {
    color: rgba(255,255,255,0.85);
}
.bento-icon {
    font-size: 2rem;
    margin-bottom: 16px;
}
.bento-card-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin: 0 0 8px;
}
.bento-card-desc {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}
@media (max-width: 1024px) {
    .bento-grid { grid-template-columns: repeat(2, 1fr); }
    .bento-card-large { grid-row: span 1; }
}
@media (max-width: 768px) {
    .bento-grid { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
    .bento-card { padding: 24px; }
}',
        ];
    }

    private function timeline(): array
    {
        return [
            'name' => 'Timeline',
            'category' => 'contenido',
            'description' => 'Linea de tiempo vertical con 5 puntos alternados izquierda/derecha, conectados por una linea central.',
            'html' => '<section class="tline">
    <div class="tline-container">
        <h2 class="tline-heading">Nuestra Trayectoria</h2>
        <p class="tline-subheading">Hitos que han marcado nuestro camino</p>
        <div class="tline-wrapper">
            <div class="tline-line"></div>
            <div class="tline-item tline-left" data-animate="fade-right">
                <div class="tline-dot"></div>
                <div class="tline-content">
                    <span class="tline-year">2019</span>
                    <h3 class="tline-item-title">Fundacion de la Empresa</h3>
                    <p class="tline-item-desc">Iniciamos operaciones con un equipo de 3 personas y una vision clara de transformar el mercado digital.</p>
                </div>
            </div>
            <div class="tline-item tline-right" data-animate="fade-left">
                <div class="tline-dot"></div>
                <div class="tline-content">
                    <span class="tline-year">2020</span>
                    <h3 class="tline-item-title">Primer Gran Cliente</h3>
                    <p class="tline-item-desc">Cerramos nuestro primer contrato corporativo y expandimos el equipo a 10 profesionales.</p>
                </div>
            </div>
            <div class="tline-item tline-left" data-animate="fade-right">
                <div class="tline-dot"></div>
                <div class="tline-content">
                    <span class="tline-year">2021</span>
                    <h3 class="tline-item-title">Expansion Regional</h3>
                    <p class="tline-item-desc">Abrimos oficinas en 3 nuevas ciudades y lanzamos nuestra plataforma de servicios en la nube.</p>
                </div>
            </div>
            <div class="tline-item tline-right" data-animate="fade-left">
                <div class="tline-dot"></div>
                <div class="tline-content">
                    <span class="tline-year">2023</span>
                    <h3 class="tline-item-title">Innovacion con IA</h3>
                    <p class="tline-item-desc">Integramos inteligencia artificial en todos nuestros productos, revolucionando la experiencia del usuario.</p>
                </div>
            </div>
            <div class="tline-item tline-left" data-animate="fade-right">
                <div class="tline-dot"></div>
                <div class="tline-content">
                    <span class="tline-year">2025</span>
                    <h3 class="tline-item-title">Lider del Mercado</h3>
                    <p class="tline-item-desc">Mas de 500 clientes activos y reconocidos como lider en soluciones digitales de la region.</p>
                </div>
            </div>
        </div>
    </div>
</section>',
            'css' => '.tline {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.tline-container {
    max-width: 900px;
    margin: 0 auto;
}
.tline-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.tline-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin: 0 0 56px;
}
.tline-wrapper {
    position: relative;
    padding: 20px 0;
}
.tline-line {
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    transform: translateX(-50%);
    border-radius: 2px;
}
.tline-item {
    position: relative;
    width: 50%;
    padding: 0 40px 48px;
}
.tline-left {
    left: 0;
    text-align: right;
    padding-right: 50px;
}
.tline-right {
    left: 50%;
    text-align: left;
    padding-left: 50px;
}
.tline-dot {
    position: absolute;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--color-primary, #6366f1);
    border: 3px solid var(--color-background, #ffffff);
    box-shadow: 0 0 0 3px var(--color-primary, #6366f1);
}
.tline-left .tline-dot { right: -8px; }
.tline-right .tline-dot { left: -8px; }
.tline-content {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px;
}
.tline-year {
    display: inline-block;
    padding: 4px 14px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 10px;
    font-family: var(--font-body, "Inter", sans-serif);
}
.tline-item-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin: 0 0 8px;
}
.tline-item-desc {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
}
@media (max-width: 768px) {
    .tline-line { left: 20px; }
    .tline-item { width: 100%; left: 0; text-align: left; padding-left: 52px; padding-right: 0; }
    .tline-left { padding-right: 0; }
    .tline-right { padding-left: 52px; }
    .tline-left .tline-dot, .tline-right .tline-dot { left: 12px; right: auto; }
}
@media (max-width: 480px) {
    .tline-content { padding: 18px; }
}',
        ];
    }

    private function calloutAlertBoxes(): array
    {
        return [
            'name' => 'Callout / Alert Boxes',
            'category' => 'contenido',
            'description' => '4 cajas de alerta apiladas: informacion (azul), exito (verde), advertencia (ambar), error (rojo).',
            'html' => '<section class="calert-section" data-animate="fade-up">
    <div class="calert-container">
        <div class="calert calert-info">
            <div class="calert-icon">&#9432;</div>
            <div class="calert-body">
                <h4 class="calert-title">Informacion</h4>
                <p class="calert-desc">Tu cuenta ha sido verificada exitosamente. Ya puedes acceder a todas las funcionalidades de la plataforma.</p>
            </div>
            <button class="calert-close" data-dismiss>&times;</button>
        </div>
        <div class="calert calert-success">
            <div class="calert-icon">&#10004;</div>
            <div class="calert-body">
                <h4 class="calert-title">Operacion Exitosa</h4>
                <p class="calert-desc">Los cambios se han guardado correctamente. El nuevo contenido ya esta publicado en tu sitio web.</p>
            </div>
            <button class="calert-close" data-dismiss>&times;</button>
        </div>
        <div class="calert calert-warning">
            <div class="calert-icon">&#9888;</div>
            <div class="calert-body">
                <h4 class="calert-title">Advertencia</h4>
                <p class="calert-desc">Tu plan actual vence en 5 dias. Renueva ahora para no perder acceso a las funciones premium.</p>
            </div>
            <button class="calert-close" data-dismiss>&times;</button>
        </div>
        <div class="calert calert-error">
            <div class="calert-icon">&#10006;</div>
            <div class="calert-body">
                <h4 class="calert-title">Error</h4>
                <p class="calert-desc">No se pudo procesar la solicitud. Verifica tu conexion a internet e intentalo nuevamente.</p>
            </div>
            <button class="calert-close" data-dismiss>&times;</button>
        </div>
    </div>
</section>',
            'css' => '.calert-section {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.calert-container {
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.calert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 18px 20px;
    border-radius: 14px;
    border-left: 4px solid;
    transition: opacity 0.3s, transform 0.3s;
}
.calert-info {
    background: #eff6ff;
    border-left-color: #3b82f6;
}
.calert-info .calert-icon { color: #3b82f6; }
.calert-success {
    background: #f0fdf4;
    border-left-color: #22c55e;
}
.calert-success .calert-icon { color: #22c55e; }
.calert-warning {
    background: #fffbeb;
    border-left-color: #f59e0b;
}
.calert-warning .calert-icon { color: #f59e0b; }
.calert-error {
    background: #fef2f2;
    border-left-color: #ef4444;
}
.calert-error .calert-icon { color: #ef4444; }
.calert-icon {
    font-size: 1.3rem;
    flex-shrink: 0;
    margin-top: 2px;
}
.calert-body { flex: 1; }
.calert-title {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin: 0 0 4px;
}
.calert-desc {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    color: #475569;
    line-height: 1.6;
    margin: 0;
}
.calert-close {
    flex-shrink: 0;
    background: none;
    border: none;
    font-size: 1.3rem;
    color: #94a3b8;
    cursor: pointer;
    padding: 0 4px;
    line-height: 1;
    transition: color 0.2s;
}
.calert-close:hover { color: #475569; }
@media (max-width: 480px) {
    .calert { padding: 14px 16px; }
}',
        ];
    }

    // ========================================================================
    // TESTIMONIOS — NUEVO
    // ========================================================================

    private function testimonialCarousel(): array
    {
        return [
            'name' => 'Testimonios Carrusel',
            'category' => 'testimonios',
            'description' => 'Carrusel de 4 testimonios con citas grandes, estrellas, avatar, nombre y cargo. Autoplay de 5 segundos.',
            'html' => '<section class="tcarousel">
    <div class="tcarousel-container">
        <h2 class="tcarousel-heading">Lo que dicen nuestros clientes</h2>
        <div class="tcarousel-slider" data-carousel data-carousel-autoplay="5000" data-carousel-dots="true" data-carousel-arrows="true">
            <div class="tcarousel-slide">
                <div class="tcarousel-quote">&ldquo;</div>
                <p class="tcarousel-text">Transformaron completamente nuestra presencia digital. Los resultados superaron todas nuestras expectativas y el retorno de inversion fue inmediato.</p>
                <div class="tcarousel-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <div class="tcarousel-author">
                    <img src="https://picsum.photos/64/64?random=60" alt="Avatar" class="tcarousel-avatar" />
                    <div>
                        <strong class="tcarousel-name">Maria Garcia</strong>
                        <span class="tcarousel-role">CEO, TechStart</span>
                    </div>
                </div>
            </div>
            <div class="tcarousel-slide">
                <div class="tcarousel-quote">&ldquo;</div>
                <p class="tcarousel-text">El equipo es excepcional. Entendieron nuestra vision desde el primer dia y entregaron un producto que realmente refleja nuestra marca.</p>
                <div class="tcarousel-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <div class="tcarousel-author">
                    <img src="https://picsum.photos/64/64?random=61" alt="Avatar" class="tcarousel-avatar" />
                    <div>
                        <strong class="tcarousel-name">Carlos Mendez</strong>
                        <span class="tcarousel-role">Director, InnovaGroup</span>
                    </div>
                </div>
            </div>
            <div class="tcarousel-slide">
                <div class="tcarousel-quote">&ldquo;</div>
                <p class="tcarousel-text">Increible atencion al detalle. Cada pagina, cada interaccion esta cuidadosamente disenada. Nuestros clientes lo notan.</p>
                <div class="tcarousel-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <div class="tcarousel-author">
                    <img src="https://picsum.photos/64/64?random=62" alt="Avatar" class="tcarousel-avatar" />
                    <div>
                        <strong class="tcarousel-name">Ana Torres</strong>
                        <span class="tcarousel-role">Marketing Manager, FreshBrand</span>
                    </div>
                </div>
            </div>
            <div class="tcarousel-slide">
                <div class="tcarousel-quote">&ldquo;</div>
                <p class="tcarousel-text">La mejor inversion que hemos hecho. Nuestro trafico web aumento un 300% en los primeros 3 meses despues del rediseno.</p>
                <div class="tcarousel-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <div class="tcarousel-author">
                    <img src="https://picsum.photos/64/64?random=63" alt="Avatar" class="tcarousel-avatar" />
                    <div>
                        <strong class="tcarousel-name">Roberto Silva</strong>
                        <span class="tcarousel-role">Fundador, EcoSolutions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>',
            'css' => '.tcarousel {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: #f8fafc;
}
.tcarousel-container {
    max-width: 700px;
    margin: 0 auto;
}
.tcarousel-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 48px;
}
.tcarousel-slide {
    text-align: center;
    padding: 40px 32px;
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
}
.tcarousel-quote {
    font-size: 4rem;
    line-height: 1;
    color: var(--color-primary, #6366f1);
    opacity: 0.3;
    font-family: Georgia, serif;
    margin-bottom: -10px;
}
.tcarousel-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: clamp(1rem, 1.5vw, 1.15rem);
    color: #475569;
    line-height: 1.7;
    margin: 0 0 20px;
    max-width: 550px;
    margin-left: auto;
    margin-right: auto;
}
.tcarousel-stars {
    color: #f59e0b;
    font-size: 1.2rem;
    letter-spacing: 4px;
    margin-bottom: 20px;
}
.tcarousel-author {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    text-align: left;
}
.tcarousel-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
}
.tcarousel-name {
    display: block;
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
.tcarousel-role {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.85rem;
    color: #94a3b8;
}
@media (max-width: 768px) {
    .tcarousel-slide { padding: 28px 20px; }
}
@media (max-width: 480px) {
    .tcarousel-quote { font-size: 3rem; }
}',
        ];
    }

    // ========================================================================
    // PRECIOS — NUEVO
    // ========================================================================

    private function pricingToggle(): array
    {
        return [
            'name' => 'Precios con Toggle',
            'category' => 'precios',
            'description' => '3 planes de precios con switch mensual/anual. El plan del medio destacado como Popular. Badge de ahorro 20%.',
            'html' => '<section class="ptoggle" data-pricing-toggle>
    <div class="ptoggle-container">
        <h2 class="ptoggle-heading">Planes y Precios</h2>
        <p class="ptoggle-subheading">Elige el plan que mejor se adapte a tu negocio</p>
        <div class="ptoggle-switch-wrap">
            <span class="ptoggle-label ptoggle-label-active" data-pricing-label="monthly">Mensual</span>
            <button class="ptoggle-switch" data-pricing-switch aria-label="Cambiar entre mensual y anual">
                <span class="ptoggle-switch-knob"></span>
            </button>
            <span class="ptoggle-label" data-pricing-label="annual">Anual <span class="ptoggle-badge-save">Ahorra 20%</span></span>
        </div>
        <div class="ptoggle-grid">
            <div class="ptoggle-plan" data-hover="lift">
                <h3 class="ptoggle-plan-name">Basico</h3>
                <p class="ptoggle-plan-desc">Para proyectos personales y sitios simples</p>
                <div class="ptoggle-price">
                    <span class="ptoggle-currency">$</span>
                    <span class="ptoggle-amount" data-price-monthly="19" data-price-annual="15">19</span>
                    <span class="ptoggle-period">/mes</span>
                </div>
                <ul class="ptoggle-features">
                    <li>&#10003; 1 sitio web</li>
                    <li>&#10003; 5 GB almacenamiento</li>
                    <li>&#10003; SSL gratis</li>
                    <li>&#10003; Soporte por email</li>
                    <li class="ptoggle-feat-disabled">&#10007; IA integrada</li>
                    <li class="ptoggle-feat-disabled">&#10007; Dominio personalizado</li>
                </ul>
                <a href="#contacto" class="ptoggle-btn">Comenzar</a>
            </div>
            <div class="ptoggle-plan ptoggle-plan-featured" data-hover="lift">
                <div class="ptoggle-popular-tag">Popular</div>
                <h3 class="ptoggle-plan-name">Profesional</h3>
                <p class="ptoggle-plan-desc">Para negocios en crecimiento</p>
                <div class="ptoggle-price">
                    <span class="ptoggle-currency">$</span>
                    <span class="ptoggle-amount" data-price-monthly="49" data-price-annual="39">49</span>
                    <span class="ptoggle-period">/mes</span>
                </div>
                <ul class="ptoggle-features">
                    <li>&#10003; 5 sitios web</li>
                    <li>&#10003; 50 GB almacenamiento</li>
                    <li>&#10003; SSL gratis</li>
                    <li>&#10003; Soporte prioritario</li>
                    <li>&#10003; IA integrada</li>
                    <li>&#10003; Dominio personalizado</li>
                </ul>
                <a href="#contacto" class="ptoggle-btn ptoggle-btn-featured">Comenzar</a>
            </div>
            <div class="ptoggle-plan" data-hover="lift">
                <h3 class="ptoggle-plan-name">Empresarial</h3>
                <p class="ptoggle-plan-desc">Para empresas y agencias</p>
                <div class="ptoggle-price">
                    <span class="ptoggle-currency">$</span>
                    <span class="ptoggle-amount" data-price-monthly="99" data-price-annual="79">99</span>
                    <span class="ptoggle-period">/mes</span>
                </div>
                <ul class="ptoggle-features">
                    <li>&#10003; Sitios ilimitados</li>
                    <li>&#10003; 500 GB almacenamiento</li>
                    <li>&#10003; SSL gratis</li>
                    <li>&#10003; Soporte 24/7</li>
                    <li>&#10003; IA avanzada</li>
                    <li>&#10003; API acceso completo</li>
                </ul>
                <a href="#contacto" class="ptoggle-btn">Comenzar</a>
            </div>
        </div>
    </div>
</section>',
            'css' => '.ptoggle {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.ptoggle-container {
    max-width: 1100px;
    margin: 0 auto;
}
.ptoggle-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.ptoggle-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin: 0 0 32px;
}
.ptoggle-switch-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 48px;
}
.ptoggle-label {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: #94a3b8;
    font-weight: 500;
    transition: color 0.3s;
}
.ptoggle-label-active {
    color: var(--color-text, #1e293b);
    font-weight: 700;
}
.ptoggle-switch {
    position: relative;
    width: 56px;
    height: 30px;
    background: #e2e8f0;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    padding: 0;
    transition: background 0.3s;
}
.ptoggle-switch.active {
    background: var(--color-primary, #6366f1);
}
.ptoggle-switch-knob {
    position: absolute;
    top: 3px;
    left: 3px;
    width: 24px;
    height: 24px;
    background: #ffffff;
    border-radius: 50%;
    transition: transform 0.3s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
.ptoggle-switch.active .ptoggle-switch-knob {
    transform: translateX(26px);
}
.ptoggle-badge-save {
    display: inline-block;
    padding: 2px 8px;
    background: #dcfce7;
    color: #16a34a;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    margin-left: 6px;
}
.ptoggle-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    align-items: start;
}
.ptoggle-plan {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 36px 28px;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
}
.ptoggle-plan-featured {
    border: 2px solid var(--color-primary, #6366f1);
    box-shadow: 0 8px 32px rgba(99, 102, 241, 0.12);
    transform: scale(1.03);
}
.ptoggle-popular-tag {
    position: absolute;
    top: -13px;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px 20px;
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    font-family: var(--font-body, "Inter", sans-serif);
}
.ptoggle-plan-name {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin: 0 0 6px;
}
.ptoggle-plan-desc {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    color: #64748b;
    margin: 0 0 24px;
}
.ptoggle-price {
    display: flex;
    align-items: baseline;
    gap: 2px;
    margin-bottom: 24px;
}
.ptoggle-currency {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
.ptoggle-amount {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 3rem;
    font-weight: 800;
    color: var(--color-text, #1e293b);
    line-height: 1;
    transition: opacity 0.2s;
}
.ptoggle-period {
    font-size: 0.95rem;
    color: #94a3b8;
}
.ptoggle-features {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.ptoggle-features li {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    color: var(--color-text, #1e293b);
}
.ptoggle-feat-disabled {
    color: #cbd5e1 !important;
}
.ptoggle-btn {
    display: block;
    width: 100%;
    padding: 14px;
    text-align: center;
    background: #f1f5f9;
    color: var(--color-text, #1e293b);
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: background 0.2s;
}
.ptoggle-btn:hover { background: #e2e8f0; }
.ptoggle-btn-featured {
    background: var(--color-primary, #6366f1);
    color: #ffffff;
}
.ptoggle-btn-featured:hover { background: var(--color-secondary, #0ea5e9); }
@media (max-width: 1024px) {
    .ptoggle-grid { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
    .ptoggle-plan-featured { transform: none; }
}
@media (max-width: 480px) {
    .ptoggle-plan { padding: 28px 20px; }
}',
        ];
    }

    // ========================================================================
    // GALERIA — NUEVOS
    // ========================================================================

    private function beforeAfterSlider(): array
    {
        return [
            'name' => 'Before/After Slider',
            'category' => 'galeria',
            'description' => 'Comparador de dos imagenes con slider vertical arrastrable. Antes y Despues con manija central.',
            'html' => '<section class="ba-section">
    <div class="ba-container">
        <h2 class="ba-heading">Antes y Despues</h2>
        <p class="ba-subheading">Desliza para ver la transformacion</p>
        <div class="ba-slider" data-before-after>
            <img src="https://picsum.photos/900/500?random=70&grayscale" alt="Antes" class="ba-image-before" />
            <img src="https://picsum.photos/900/500?random=71" alt="Despues" class="ba-image-after" />
            <div class="ba-handle">
                <div class="ba-handle-line"></div>
                <div class="ba-handle-circle">&#8596;</div>
                <div class="ba-handle-line"></div>
            </div>
            <span class="ba-label ba-label-before">Antes</span>
            <span class="ba-label ba-label-after">Despues</span>
        </div>
    </div>
</section>',
            'css' => '.ba-section {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.ba-container {
    max-width: 900px;
    margin: 0 auto;
}
.ba-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.ba-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin: 0 0 40px;
}
.ba-slider {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    cursor: col-resize;
    user-select: none;
    -webkit-user-select: none;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}
.ba-slider img {
    display: block;
    width: 100%;
    height: auto;
    pointer-events: none;
}
.ba-image-after {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    clip-path: inset(0 0 0 50%);
}
.ba-handle {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 4px;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 5;
    pointer-events: none;
}
.ba-handle-line {
    flex: 1;
    width: 3px;
    background: #ffffff;
    box-shadow: 0 0 6px rgba(0,0,0,0.3);
}
.ba-handle-circle {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #ffffff;
    color: var(--color-text, #1e293b);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 700;
    box-shadow: 0 2px 12px rgba(0,0,0,0.25);
    flex-shrink: 0;
}
.ba-label {
    position: absolute;
    bottom: 16px;
    padding: 6px 16px;
    background: rgba(0,0,0,0.6);
    color: #ffffff;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    font-family: var(--font-body, "Inter", sans-serif);
    z-index: 3;
}
.ba-label-before { left: 16px; }
.ba-label-after { right: 16px; }
@media (max-width: 768px) {
    .ba-handle-circle { width: 36px; height: 36px; font-size: 1rem; }
}
@media (max-width: 480px) {
    .ba-label { font-size: 0.7rem; padding: 4px 10px; }
}',
        ];
    }

    private function videoThumbnail(): array
    {
        return [
            'name' => 'Video con Thumbnail',
            'category' => 'galeria',
            'description' => 'Imagen grande con boton play central. Al hacer clic se reemplaza por un iframe de YouTube.',
            'html' => '<section class="vthumbnail-section">
    <div class="vthumbnail-container">
        <h2 class="vthumbnail-heading">Mira Como Funciona</h2>
        <p class="vthumbnail-subheading">Descubre en 2 minutos todo lo que puedes lograr</p>
        <div class="vthumbnail" data-video-src="https://www.youtube.com/embed/dQw4w9WgXcQ">
            <img src="https://picsum.photos/1000/562?random=75" alt="Video thumbnail" class="vthumbnail-img" />
            <div class="vthumbnail-overlay">
                <div class="vthumbnail-play">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#ffffff"><polygon points="6,3 20,12 6,21"/></svg>
                </div>
            </div>
        </div>
    </div>
</section>',
            'css' => '.vthumbnail-section {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: #0f172a;
}
.vthumbnail-container {
    max-width: 900px;
    margin: 0 auto;
}
.vthumbnail-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: #ffffff;
    text-align: center;
    margin: 0 0 12px;
}
.vthumbnail-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #94a3b8;
    text-align: center;
    margin: 0 0 40px;
}
.vthumbnail {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    aspect-ratio: 16 / 9;
}
.vthumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.5s;
}
.vthumbnail:hover .vthumbnail-img {
    transform: scale(1.03);
}
.vthumbnail-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.35);
    transition: background 0.3s;
}
.vthumbnail:hover .vthumbnail-overlay {
    background: rgba(0, 0, 0, 0.45);
}
.vthumbnail-play {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--color-primary, #6366f1);
    display: flex;
    align-items: center;
    justify-content: center;
    padding-left: 4px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.vthumbnail:hover .vthumbnail-play {
    transform: scale(1.1);
    box-shadow: 0 0 0 12px rgba(99, 102, 241, 0.25);
}
.vthumbnail iframe {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    border: none;
}
@media (max-width: 768px) {
    .vthumbnail-play { width: 56px; height: 56px; }
    .vthumbnail-play svg { width: 18px; height: 18px; }
}
@media (max-width: 480px) {
    .vthumbnail { border-radius: 12px; }
}',
        ];
    }

    // ========================================================================
    // SOCIAL (4 bloques)
    // ========================================================================

    private function teamCards(): array
    {
        return [
            'name' => 'Team Cards',
            'category' => 'social',
            'description' => 'Grid de 4 tarjetas de equipo con foto circular, nombre, cargo y overlay de redes sociales al hacer hover.',
            'html' => '<section class="team-section" data-animate="fade-up">
    <div class="team-container">
        <h2 class="team-heading">Nuestro Equipo</h2>
        <p class="team-subheading">Profesionales apasionados por la tecnologia</p>
        <div class="team-grid">
            <div class="team-card" data-hover="lift">
                <div class="team-photo-wrap">
                    <img src="https://picsum.photos/300/300?random=80" alt="Miembro del equipo" class="team-photo" />
                    <div class="team-overlay">
                        <a href="#" class="team-social-link" aria-label="LinkedIn">in</a>
                        <a href="#" class="team-social-link" aria-label="Twitter">X</a>
                        <a href="#" class="team-social-link" aria-label="Email">@</a>
                    </div>
                </div>
                <h3 class="team-name">Laura Martinez</h3>
                <span class="team-role">Directora Creativa</span>
                <p class="team-bio">Mas de 10 anos liderando proyectos de diseno e innovacion digital para marcas globales.</p>
            </div>
            <div class="team-card" data-hover="lift">
                <div class="team-photo-wrap">
                    <img src="https://picsum.photos/300/300?random=81" alt="Miembro del equipo" class="team-photo" />
                    <div class="team-overlay">
                        <a href="#" class="team-social-link" aria-label="LinkedIn">in</a>
                        <a href="#" class="team-social-link" aria-label="Twitter">X</a>
                        <a href="#" class="team-social-link" aria-label="Email">@</a>
                    </div>
                </div>
                <h3 class="team-name">Diego Fernandez</h3>
                <span class="team-role">CTO</span>
                <p class="team-bio">Ingeniero full-stack con pasion por arquitectura escalable y soluciones cloud-native.</p>
            </div>
            <div class="team-card" data-hover="lift">
                <div class="team-photo-wrap">
                    <img src="https://picsum.photos/300/300?random=82" alt="Miembro del equipo" class="team-photo" />
                    <div class="team-overlay">
                        <a href="#" class="team-social-link" aria-label="LinkedIn">in</a>
                        <a href="#" class="team-social-link" aria-label="Twitter">X</a>
                        <a href="#" class="team-social-link" aria-label="Email">@</a>
                    </div>
                </div>
                <h3 class="team-name">Valentina Rojas</h3>
                <span class="team-role">Head of Marketing</span>
                <p class="team-bio">Experta en estrategias de crecimiento y posicionamiento de marca en mercados digitales.</p>
            </div>
            <div class="team-card" data-hover="lift">
                <div class="team-photo-wrap">
                    <img src="https://picsum.photos/300/300?random=83" alt="Miembro del equipo" class="team-photo" />
                    <div class="team-overlay">
                        <a href="#" class="team-social-link" aria-label="LinkedIn">in</a>
                        <a href="#" class="team-social-link" aria-label="Twitter">X</a>
                        <a href="#" class="team-social-link" aria-label="Email">@</a>
                    </div>
                </div>
                <h3 class="team-name">Andres Morales</h3>
                <span class="team-role">Lead Developer</span>
                <p class="team-bio">Especialista en Laravel y React. Comprometido con el codigo limpio y las mejores practicas.</p>
            </div>
        </div>
    </div>
</section>',
            'css' => '.team-section {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.team-container {
    max-width: 1100px;
    margin: 0 auto;
}
.team-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.team-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin: 0 0 48px;
}
.team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
}
.team-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 32px 24px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}
.team-photo-wrap {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
}
.team-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.team-overlay {
    position: absolute;
    inset: 0;
    background: rgba(99, 102, 241, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    opacity: 0;
    transition: opacity 0.3s;
    border-radius: 50%;
}
.team-photo-wrap:hover .team-overlay {
    opacity: 1;
}
.team-social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ffffff;
    color: var(--color-primary, #6366f1);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.75rem;
    transition: transform 0.2s;
}
.team-social-link:hover { transform: scale(1.15); }
.team-name {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
    margin: 0 0 4px;
}
.team-role {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.85rem;
    color: var(--color-primary, #6366f1);
    font-weight: 600;
    display: block;
    margin-bottom: 10px;
}
.team-bio {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.88rem;
    color: #64748b;
    line-height: 1.5;
    margin: 0;
}
@media (max-width: 1024px) {
    .team-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .team-grid { grid-template-columns: 1fr; max-width: 360px; margin: 0 auto; }
}
@media (max-width: 480px) {
    .team-card { padding: 24px 16px; }
}',
        ];
    }

    private function socialProofBar(): array
    {
        return [
            'name' => 'Social Proof Bar',
            'category' => 'social',
            'description' => 'Barra compacta con avatares superpuestos, texto de confianza, 5 estrellas y puntuacion 4.9/5.',
            'html' => '<section class="sproof" data-animate="fade-up">
    <div class="sproof-content">
        <div class="sproof-avatars">
            <img src="https://picsum.photos/40/40?random=90" alt="" class="sproof-avatar" />
            <img src="https://picsum.photos/40/40?random=91" alt="" class="sproof-avatar" />
            <img src="https://picsum.photos/40/40?random=92" alt="" class="sproof-avatar" />
            <img src="https://picsum.photos/40/40?random=93" alt="" class="sproof-avatar" />
            <img src="https://picsum.photos/40/40?random=94" alt="" class="sproof-avatar" />
        </div>
        <span class="sproof-text">500+ clientes confian en nosotros</span>
        <div class="sproof-rating">
            <span class="sproof-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            <span class="sproof-score">4.9/5</span>
        </div>
    </div>
</section>',
            'css' => '.sproof {
    padding: 24px clamp(16px, 4vw, 24px);
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}
.sproof-content {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}
.sproof-avatars {
    display: flex;
}
.sproof-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    object-fit: cover;
    margin-left: -10px;
}
.sproof-avatar:first-child { margin-left: 0; }
.sproof-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--color-text, #1e293b);
}
.sproof-rating {
    display: flex;
    align-items: center;
    gap: 8px;
}
.sproof-stars {
    color: #f59e0b;
    font-size: 1rem;
    letter-spacing: 2px;
}
.sproof-score {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
@media (max-width: 768px) {
    .sproof-content { flex-direction: column; gap: 12px; text-align: center; }
}
@media (max-width: 480px) {
    .sproof-text { font-size: 0.85rem; }
}',
        ];
    }

    private function logoCarouselInfinito(): array
    {
        return [
            'name' => 'Logo Carousel Infinito',
            'category' => 'social',
            'description' => 'Marquesina infinita con 8 logos de empresas. Efecto grayscale que coloriza al hover.',
            'html' => '<section class="lcarousel">
    <div class="lcarousel-container">
        <h3 class="lcarousel-heading">Confian en Nosotros</h3>
        <div class="lcarousel-track" data-marquee data-marquee-speed="40" data-marquee-pause-hover="true">
            <div class="lcarousel-logo">Acme Corp</div>
            <div class="lcarousel-logo">TechFlow</div>
            <div class="lcarousel-logo">InnovaLab</div>
            <div class="lcarousel-logo">CloudBase</div>
            <div class="lcarousel-logo">DataPrime</div>
            <div class="lcarousel-logo">NexGen</div>
            <div class="lcarousel-logo">PixelWorks</div>
            <div class="lcarousel-logo">StartHub</div>
        </div>
    </div>
</section>',
            'css' => '.lcarousel {
    padding: clamp(40px, 6vw, 80px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
    overflow: hidden;
}
.lcarousel-container {
    max-width: 1100px;
    margin: 0 auto;
}
.lcarousel-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(1rem, 2vw, 1.15rem);
    font-weight: 600;
    color: #94a3b8;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0 0 32px;
}
.lcarousel-track {
    display: flex;
    gap: 48px;
    align-items: center;
}
.lcarousel-logo {
    flex-shrink: 0;
    padding: 14px 32px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: 1rem;
    font-weight: 700;
    color: #94a3b8;
    white-space: nowrap;
    filter: grayscale(100%);
    opacity: 0.6;
    transition: filter 0.3s, opacity 0.3s;
}
.lcarousel-logo:hover {
    filter: grayscale(0%);
    opacity: 1;
    color: var(--color-primary, #6366f1);
}
@media (max-width: 768px) {
    .lcarousel-track { gap: 24px; }
    .lcarousel-logo { padding: 10px 20px; font-size: 0.9rem; }
}
@media (max-width: 480px) {
    .lcarousel-heading { font-size: 0.85rem; }
}',
        ];
    }

    private function appDownloadSection(): array
    {
        return [
            'name' => 'App Download Section',
            'category' => 'social',
            'description' => '2 columnas: texto con bullets y badges de descarga a la izquierda, mockup de telefono a la derecha.',
            'html' => '<section class="appdown" data-animate="fade-up">
    <div class="appdown-container">
        <div class="appdown-text">
            <h2 class="appdown-heading">Descarga Nuestra App</h2>
            <p class="appdown-desc">Lleva toda la potencia de la plataforma en tu bolsillo. Gestiona tu sitio web, revisa metricas y publica contenido desde cualquier lugar.</p>
            <ul class="appdown-features">
                <li>&#10003; Edicion en tiempo real desde el movil</li>
                <li>&#10003; Notificaciones push de actividad</li>
                <li>&#10003; Metricas y analiticas al instante</li>
                <li>&#10003; Sincronizacion automatica con tu sitio</li>
            </ul>
            <div class="appdown-badges">
                <a href="#" class="appdown-badge">
                    <span class="appdown-badge-icon">&#63743;</span>
                    <span class="appdown-badge-text"><small>Descargar en</small><strong>App Store</strong></span>
                </a>
                <a href="#" class="appdown-badge">
                    <span class="appdown-badge-icon">&#9654;</span>
                    <span class="appdown-badge-text"><small>Disponible en</small><strong>Google Play</strong></span>
                </a>
            </div>
        </div>
        <div class="appdown-mockup" data-animate="fade-left">
            <div class="appdown-phone">
                <img src="https://picsum.photos/280/560?random=85" alt="App preview" class="appdown-screen" />
            </div>
        </div>
    </div>
</section>',
            'css' => '.appdown {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: linear-gradient(135deg, #f0f9ff 0%, #ede9fe 100%);
}
.appdown-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 48px;
    align-items: center;
}
.appdown-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 2.75rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    margin: 0 0 16px;
}
.appdown-desc {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.05rem;
    color: #475569;
    line-height: 1.7;
    margin: 0 0 24px;
}
.appdown-features {
    list-style: none;
    padding: 0;
    margin: 0 0 32px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.appdown-features li {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    color: var(--color-text, #1e293b);
}
.appdown-badges {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}
.appdown-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: #0f172a;
    color: #ffffff;
    border-radius: 14px;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}
.appdown-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}
.appdown-badge-icon {
    font-size: 1.5rem;
}
.appdown-badge-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}
.appdown-badge-text small {
    font-size: 0.65rem;
    opacity: 0.7;
}
.appdown-badge-text strong {
    font-size: 0.95rem;
    font-weight: 700;
}
.appdown-mockup {
    display: flex;
    justify-content: center;
}
.appdown-phone {
    width: 260px;
    height: 520px;
    background: #0f172a;
    border-radius: 36px;
    padding: 12px;
    box-shadow: 0 24px 64px rgba(0,0,0,0.15);
    overflow: hidden;
}
.appdown-screen {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 24px;
    display: block;
}
@media (max-width: 1024px) {
    .appdown-container { grid-template-columns: 1fr; text-align: center; }
    .appdown-features { align-items: center; }
    .appdown-badges { justify-content: center; }
    .appdown-mockup { order: -1; }
    .appdown-phone { width: 220px; height: 440px; }
}
@media (max-width: 768px) {
    .appdown-phone { width: 200px; height: 400px; border-radius: 28px; }
}
@media (max-width: 480px) {
    .appdown-badges { flex-direction: column; align-items: center; }
    .appdown-badge { width: 100%; max-width: 220px; justify-content: center; }
}',
        ];
    }

    // ========================================================================
    // SITIO (2 bloques)
    // ========================================================================

    private function notificationBar(): array
    {
        return [
            'name' => 'Notification Bar',
            'category' => 'sitio',
            'description' => 'Barra de notificacion full-width con texto, enlace y boton de cerrar. Fondo degradado.',
            'html' => '<div class="notifbar">
    <div class="notifbar-content">
        <span class="notifbar-text">&#127881; Nuevo: Acabamos de lanzar la version 3.0 con IA integrada.</span>
        <a href="#" class="notifbar-link">Ver novedades &#10140;</a>
    </div>
    <button class="notifbar-close" data-dismiss aria-label="Cerrar">&times;</button>
</div>',
            'css' => '.notifbar {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--color-primary, #6366f1), var(--color-secondary, #0ea5e9));
    padding: 12px 20px;
    position: relative;
    min-height: 48px;
    overflow: hidden;
    transition: max-height 0.4s ease, padding 0.4s ease, opacity 0.3s ease;
    max-height: 80px;
}
.notifbar.notifbar-dismissed {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    opacity: 0;
    pointer-events: none;
}
.notifbar-content {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: center;
}
.notifbar-text {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    font-weight: 500;
    color: #ffffff;
}
.notifbar-link {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.9rem;
    font-weight: 700;
    color: #ffffff;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: opacity 0.2s;
}
.notifbar-link:hover { opacity: 0.8; }
.notifbar-close {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.3rem;
    cursor: pointer;
    padding: 4px 8px;
    line-height: 1;
    transition: color 0.2s;
}
.notifbar-close:hover { color: #ffffff; }
@media (max-width: 768px) {
    .notifbar { padding: 10px 48px 10px 16px; }
    .notifbar-content { gap: 6px; }
    .notifbar-text { font-size: 0.8rem; }
}
@media (max-width: 480px) {
    .notifbar-content { flex-direction: column; gap: 4px; }
}',
        ];
    }

    private function comparisonTable(): array
    {
        return [
            'name' => 'Comparison Table',
            'category' => 'sitio',
            'description' => 'Tabla comparativa de 3 planes con 8 caracteristicas. Columna Pro destacada. Scroll horizontal en movil.',
            'html' => '<section class="ctable-section" data-animate="fade-up">
    <div class="ctable-container">
        <h2 class="ctable-heading">Compara Nuestros Planes</h2>
        <p class="ctable-subheading">Encuentra el plan perfecto para tu proyecto</p>
        <div class="ctable-wrapper">
            <table class="ctable">
                <thead>
                    <tr>
                        <th class="ctable-feature-header">Caracteristica</th>
                        <th class="ctable-plan-header">Basico</th>
                        <th class="ctable-plan-header ctable-highlighted">Pro</th>
                        <th class="ctable-plan-header">Enterprise</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ctable-feature">Paginas ilimitadas</td>
                        <td><span class="ctable-check">&#10003;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">Dominio personalizado</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">SSL gratuito</td>
                        <td><span class="ctable-check">&#10003;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">Asistente IA</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">Analiticas avanzadas</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">Soporte prioritario</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-check">&#10003;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">API acceso completo</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-x">&#10007;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                    <tr>
                        <td class="ctable-feature">White-label</td>
                        <td><span class="ctable-x">&#10007;</span></td>
                        <td class="ctable-highlighted"><span class="ctable-x">&#10007;</span></td>
                        <td><span class="ctable-check">&#10003;</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>',
            'css' => '.ctable-section {
    padding: clamp(48px, 8vw, 120px) clamp(16px, 4vw, 24px);
    background: var(--color-background, #ffffff);
}
.ctable-container {
    max-width: 900px;
    margin: 0 auto;
}
.ctable-heading {
    font-family: var(--font-heading, "Inter", sans-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--color-text, #1e293b);
    text-align: center;
    margin: 0 0 12px;
}
.ctable-subheading {
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 1.1rem;
    color: #64748b;
    text-align: center;
    margin: 0 0 40px;
}
.ctable-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
}
.ctable {
    width: 100%;
    border-collapse: collapse;
    font-family: var(--font-body, "Inter", sans-serif);
    font-size: 0.95rem;
    min-width: 600px;
}
.ctable thead {
    background: #f8fafc;
}
.ctable th,
.ctable td {
    padding: 16px 20px;
    text-align: center;
    border-bottom: 1px solid #f1f5f9;
}
.ctable-feature-header {
    text-align: left;
    font-weight: 700;
    color: var(--color-text, #1e293b);
}
.ctable-plan-header {
    font-weight: 700;
    font-size: 1rem;
    color: var(--color-text, #1e293b);
}
.ctable-feature {
    text-align: left;
    font-weight: 500;
    color: #475569;
}
.ctable-highlighted {
    background: rgba(99, 102, 241, 0.04);
}
thead .ctable-highlighted {
    background: var(--color-primary, #6366f1);
    color: #ffffff;
    position: relative;
}
.ctable-check {
    color: #22c55e;
    font-weight: 700;
    font-size: 1.1rem;
}
.ctable-x {
    color: #cbd5e1;
    font-size: 1.1rem;
}
.ctable tbody tr:nth-child(even) {
    background: #fafbfc;
}
.ctable tbody tr:nth-child(even) .ctable-highlighted {
    background: rgba(99, 102, 241, 0.06);
}
@media (max-width: 768px) {
    .ctable-feature { position: sticky; left: 0; background: #ffffff; z-index: 1; }
    .ctable tbody tr:nth-child(even) .ctable-feature { background: #fafbfc; }
    .ctable th, .ctable td { padding: 12px 14px; font-size: 0.88rem; }
}
@media (max-width: 480px) {
    .ctable th, .ctable td { padding: 10px 10px; font-size: 0.82rem; }
}',
        ];
    }
}
