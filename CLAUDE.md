# CLAUDE.md — WebComposer

## Identidad del Proyecto

WebComposer es un CMS moderno y simplificado (alternativa a WordPress) con editor visual drag-and-drop, blog integrado e IA nativa para generación de contenido. Es **single-tenant**: una instalación = un sitio web. Stack: Laravel 11 + Filament 3 + GrapesJS + MySQL 8. Desplegable en cPanel (shared hosting).

---

## Stack Tecnológico

- **Backend:** Laravel 11 (PHP 8.2+)
- **Admin Panel:** Filament 3
- **Page Builder:** GrapesJS + grapesjs-preset-webpage + grapesjs-blocks-basic
- **Base de Datos:** MySQL 8
- **Frontend público:** Tailwind CSS + Alpine.js
- **Editor Rich Text:** TipTap (@tiptap/core, @tiptap/starter-kit)
- **Gestión de Medios:** Spatie Media Library
- **IA:** Claude API (Anthropic) como motor principal, GPT API como fallback
- **Carrusel:** Swiper.js
- **Animaciones:** AOS (Animate On Scroll)
- **Lightbox:** GLightbox
- **Build:** Vite

---

## Tipografías Disponibles

WebComposer ofrece exactamente **10 Google Fonts** precargadas. El usuario selecciona desde el panel de configuración y el editor. No se permite cargar fuentes externas adicionales.

| # | Font Family | Categoría | Uso recomendado |
|---|------------|-----------|-----------------|
| 1 | Inter | Sans-serif | UI, cuerpo de texto moderno |
| 2 | Roboto | Sans-serif | Uso general, muy legible |
| 3 | Open Sans | Sans-serif | Cuerpo de texto, profesional |
| 4 | Montserrat | Sans-serif | Títulos, headers llamativos |
| 5 | Poppins | Sans-serif | Moderno, headings + body |
| 6 | Lato | Sans-serif | Corporativo, limpio |
| 7 | Playfair Display | Serif | Títulos elegantes, editorial |
| 8 | Merriweather | Serif | Lectura larga, blogs |
| 9 | Raleway | Sans-serif | Títulos delgados, minimalista |
| 10 | Space Grotesk | Sans-serif | Tech, startups, moderno |

### Implementación

- Las 10 fuentes se cargan via Google Fonts CDN en el `<head>` del sitio público y del editor
- En configuración del sitio se eligen 2 fuentes: una para headings y otra para body
- En el editor GrapesJS, el selector de fuentes solo muestra estas 10 opciones
- Archivo de configuración: `config/webcomposer.php` → `fonts` array

```php
// config/webcomposer.php
'fonts' => [
    'Inter', 'Roboto', 'Open Sans', 'Montserrat', 'Poppins',
    'Lato', 'Playfair Display', 'Merriweather', 'Raleway', 'Space Grotesk',
],
```

---

## Templates Precargados

WebComposer incluye **templates modernos por industria** listos para usar. Cada template es una estructura GrapesJS completa (JSON) con HTML, CSS y contenido placeholder. El usuario selecciona un template al crear una nueva página y luego lo personaliza.

### Templates incluidos

| # | Template | Descripción | Secciones incluidas |
|---|----------|-------------|---------------------|
| 1 | **Landing Startup** | Landing page tecnológica moderna | Hero con CTA, features grid, pricing cards, testimonios, footer |
| 2 | **Restaurante** | Sitio para restaurantes y cafés | Hero con imagen fullscreen, menú/carta, galería, horarios, reservas, mapa |
| 3 | **Portafolio** | Portfolio profesional/creativo | Hero minimalista, grid de proyectos, about me, skills, contacto |
| 4 | **Consultorio / Clínica** | Profesionales de salud | Hero con agenda, servicios, equipo médico, testimonios, ubicación |
| 5 | **Tienda / Catálogo** | Exhibición de productos | Hero con producto destacado, catálogo grid, categorías, contacto/WhatsApp |
| 6 | **Inmobiliaria** | Propiedades y bienes raíces | Hero con buscador, listado de propiedades cards, detalle, contacto agente |
| 7 | **Gimnasio / Fitness** | Centros deportivos | Hero motivacional, clases/horarios, planes/precios, entrenadores, CTA |
| 8 | **Educación / Cursos** | Instituciones y cursos online | Hero, catálogo de cursos, instructores, testimonios alumnos, inscripción |
| 9 | **Blog / Magazine** | Blog o revista digital | Hero con post destacado, grid de posts, sidebar, categorías, newsletter |
| 10 | **Evento / Conferencia** | Eventos y conferencias | Hero con countdown, speakers, agenda/schedule, sponsors, tickets CTA |

### Estructura de cada template

Cada template se almacena como un seeder y un archivo JSON en `database/seeders/templates/`:

```
database/
└── seeders/
    └── templates/
        ├── landing-startup.json
        ├── restaurante.json
        ├── portafolio.json
        ├── consultorio.json
        ├── tienda.json
        ├── inmobiliaria.json
        ├── gimnasio.json
        ├── educacion.json
        ├── blog-magazine.json
        └── evento.json
```

Cada JSON contiene:

```json
{
  "name": "Landing Startup",
  "slug": "landing-startup",
  "category": "tecnologia",
  "thumbnail": "templates/landing-startup.png",
  "description": "Landing page moderna para startups y productos tech",
  "fonts": {
    "heading": "Space Grotesk",
    "body": "Inter"
  },
  "colors": {
    "primary": "#6366F1",
    "secondary": "#0EA5E9",
    "accent": "#F59E0B",
    "background": "#FFFFFF",
    "text": "#1E293B"
  },
  "grapesjs": {
    "html": "<section class='hero'>...</section>...",
    "css": ".hero { ... }",
    "components": [],
    "styles": []
  }
}
```

### Flujo del usuario

1. El usuario va a "Crear nueva página" en el admin
2. Se muestra una galería de templates con thumbnails
3. El usuario elige un template (o "Página en blanco")
4. GrapesJS carga la estructura del template seleccionado
5. El usuario personaliza colores, textos, imágenes y layout
6. Guarda y publica

### Diseño de los templates

Todos los templates deben seguir estas reglas de diseño:

- **Modernos y minimalistas:** Espaciado generoso, tipografía limpia, sin elementos decorativos innecesarios
- **Mobile-first:** Responsive por defecto, diseñados primero para mobile
- **Colores neutros como base:** Cada template define una paleta de 5 colores que el usuario puede cambiar
- **Imágenes placeholder:** Usar URLs de placeholder (picsum.photos o similar) que el usuario reemplaza
- **Secciones independientes:** Cada sección del template es un bloque que se puede mover, duplicar o eliminar
- **Consistencia:** Todos usan las mismas convenciones de clases CSS y estructura HTML

---

## Estructura de Base de Datos

> **IMPORTANTE:** WebComposer es single-tenant. NO existe tabla `sites`. NO existe campo `site_id` en ninguna tabla. La configuración del sitio se almacena en la tabla `settings`.

### Tablas principales

```
pages
├── id, title, slug, type (page/landing)
├── content (JSON: estructura GrapesJS completa)
├── css (TEXT: estilos generados por GrapesJS)
├── is_homepage (boolean)
├── status (draft/published/archived)
├── published_at, sort_order
├── seo_title, seo_description, og_image
├── template (string nullable: slug del template usado como base)
└── timestamps

blocks (templates de bloques reutilizables)
├── id, name, category
├── content (JSON: estructura GrapesJS)
├── thumbnail
└── timestamps

posts
├── id, user_id, title, slug
├── body (TEXT: contenido HTML del post)
├── excerpt, featured_image
├── status (draft/scheduled/published/archived)
├── published_at
├── seo_title, seo_description, og_image
└── timestamps

categories
├── id, name, slug, parent_id
└── timestamps

tags
├── id, name, slug
└── timestamps

category_post (pivot)
post_tag (pivot)

media (gestionado por Spatie Media Library)

settings
├── id, key, value (JSON)
└── timestamps

page_templates (templates precargados)
├── id, name, slug, category, description
├── thumbnail
├── fonts (JSON: { heading, body })
├── colors (JSON: { primary, secondary, accent, background, text })
├── content (JSON: estructura GrapesJS)
├── is_default (boolean)
└── timestamps
```

---

## Estructura de Carpetas

```
web-composer/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── PageResource.php
│   │   │   ├── PostResource.php
│   │   │   ├── CategoryResource.php
│   │   │   ├── TagResource.php
│   │   │   ├── BlockResource.php
│   │   │   ├── MediaResource.php
│   │   │   └── PageTemplateResource.php
│   │   ├── Pages/
│   │   │   ├── Dashboard.php
│   │   │   └── SiteSettings.php
│   │   └── Widgets/
│   │       ├── StatsOverview.php
│   │       └── RecentPages.php
│   ├── Models/
│   │   ├── Page.php
│   │   ├── Post.php
│   │   ├── Category.php
│   │   ├── Tag.php
│   │   ├── Block.php
│   │   ├── Setting.php
│   │   └── PageTemplate.php
│   ├── Services/
│   │   ├── AIService.php          # Integración Claude/GPT API
│   │   ├── PageBuilderService.php # Lógica de guardado/renderizado GrapesJS
│   │   ├── MediaService.php       # Upload, resize, optimización
│   │   ├── SEOService.php         # Generación de meta tags, sitemap
│   │   ├── SettingsService.php    # Lectura/escritura de configuración
│   │   └── TemplateService.php    # Carga y aplicación de templates
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── PageBuilderController.php  # API para GrapesJS (load/store)
│   │   │   │   ├── MediaUploadController.php  # Upload desde el builder
│   │   │   │   ├── AIController.php           # Endpoints de IA
│   │   │   │   └── TemplateController.php     # Listar/cargar templates
│   │   │   └── Public/
│   │   │       ├── PageController.php         # Renderizado de páginas
│   │   │       └── BlogController.php         # Blog público
│   │   └── Middleware/
│   │       └── InjectSiteSettings.php         # Inyectar config global en vistas
│   └── Traits/
│       └── HasSEO.php             # Campos SEO compartidos
├── database/
│   ├── migrations/
│   │   ├── create_pages_table.php
│   │   ├── create_blocks_table.php
│   │   ├── create_posts_table.php
│   │   ├── create_categories_table.php
│   │   ├── create_tags_table.php
│   │   ├── create_category_post_table.php
│   │   ├── create_post_tag_table.php
│   │   ├── create_settings_table.php
│   │   └── create_page_templates_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── SettingsSeeder.php         # Config inicial del sitio
│       ├── PageTemplateSeeder.php     # Carga los 10 templates
│       └── templates/                 # JSONs de templates
│           ├── landing-startup.json
│           ├── restaurante.json
│           ├── portafolio.json
│           ├── consultorio.json
│           ├── tienda.json
│           ├── inmobiliaria.json
│           ├── gimnasio.json
│           ├── educacion.json
│           ├── blog-magazine.json
│           └── evento.json
├── resources/
│   ├── views/
│   │   ├── builder/
│   │   │   ├── editor.blade.php       # Vista del editor GrapesJS
│   │   │   └── template-picker.blade.php  # Galería de templates
│   │   ├── public/
│   │   │   ├── layout.blade.php       # Layout base del sitio público
│   │   │   ├── page.blade.php         # Renderizado de página
│   │   │   └── blog/
│   │   │       ├── index.blade.php    # Listado de posts
│   │   │       ├── show.blade.php     # Post individual
│   │   │       └── partials/
│   │   └── components/               # Blade components reutilizables
│   ├── js/
│   │   ├── builder/
│   │   │   ├── index.js              # Init GrapesJS
│   │   │   ├── config.js             # Configuración del editor
│   │   │   ├── blocks.js             # Bloques custom
│   │   │   ├── panels.js             # Paneles del editor
│   │   │   ├── storage.js            # Guardado/carga via API
│   │   │   ├── fonts.js              # Las 10 fuentes disponibles
│   │   │   └── plugins/
│   │   │       ├── ai-block.js       # Plugin IA para generar contenido
│   │   │       └── custom-blocks.js  # Bloques predefinidos
│   │   └── public/
│   │       └── site.js               # JS del sitio público (AOS, Swiper, etc.)
│   └── css/
│       ├── builder.css               # Estilos del editor
│       └── public.css                # Estilos base del sitio público
├── routes/
│   ├── web.php                       # Rutas públicas + builder
│   └── api.php                       # API para GrapesJS + IA
├── config/
│   └── webcomposer.php               # Config del CMS (fonts, templates, media)
├── public/
│   └── assets/                       # Assets compilados
├── .env
├── CLAUDE.md                         # Este archivo
└── vite.config.js
```

---

## Configuración del Sitio (Settings)

Al ser single-tenant, la configuración global del sitio se almacena en la tabla `settings` como key-value:

```php
// Settings keys
'site_name'         → "Mi Sitio Web"
'site_description'  → "Descripción del sitio"
'site_logo'         → "/media/logo.png"
'site_favicon'      → "/media/favicon.ico"
'font_heading'      → "Montserrat"          // Una de las 10 fuentes
'font_body'         → "Inter"               // Una de las 10 fuentes
'color_primary'     → "#6366F1"
'color_secondary'   → "#0EA5E9"
'color_accent'      → "#F59E0B"
'color_background'  → "#FFFFFF"
'color_text'        → "#1E293B"
'analytics_id'      → "G-XXXXXXXXXX"        // Google Analytics
'meta_pixel_id'     → "123456789"           // Meta Pixel
'whatsapp_number'   → "+56912345678"        // Botón WhatsApp
'whatsapp_message'  → "Hola, necesito información"
'footer_text'       → "© 2026 Mi Sitio"
'social_facebook'   → "https://facebook.com/..."
'social_instagram'  → "https://instagram.com/..."
'social_twitter'    → "https://x.com/..."
'social_linkedin'   → "https://linkedin.com/..."
'social_youtube'    → "https://youtube.com/..."
```

### SettingsService

```php
// Uso en código
SettingsService::get('site_name');                    // Leer
SettingsService::set('site_name', 'Nuevo Nombre');    // Escribir
SettingsService::getMany(['site_name', 'font_heading']); // Leer múltiples
```

---

## Rutas Públicas

```php
// routes/web.php

// Rutas fijas (admin se maneja por Filament automáticamente)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/feed.xml', [BlogController::class, 'feed'])->name('blog.feed');

// Builder (autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/builder/{page}', [PageBuilderController::class, 'editor'])->name('builder.editor');
    Route::get('/builder/{page}/templates', [TemplateController::class, 'picker'])->name('builder.templates');
});

// Ruta catch-all para páginas del CMS (SIEMPRE al final)
Route::get('/', [PageController::class, 'homepage'])->name('page.home');
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
```

---

## API Endpoints

### Page Builder API

```
GET    /api/pages/{page}/load      → Cargar estructura de página para GrapesJS
POST   /api/pages/{page}/store     → Guardar estructura de página desde GrapesJS
GET    /api/templates              → Listar templates disponibles
GET    /api/templates/{slug}       → Cargar estructura de un template
POST   /api/media/upload           → Subir imagen desde el editor
GET    /api/media                  → Listar medios disponibles
DELETE /api/media/{media}          → Eliminar medio
```

### AI API

```
POST   /api/ai/generate-text       → Generar texto para una sección
POST   /api/ai/generate-seo        → Generar meta tags SEO
POST   /api/ai/translate           → Traducir contenido
POST   /api/ai/generate-page       → Generar estructura de página completa
```

### Blog API (público)

```
GET    /api/blog/posts             → Listar posts publicados
GET    /api/blog/posts/{slug}      → Post individual
GET    /api/blog/categories        → Listar categorías
GET    /api/blog/tags              → Listar tags
```

---

## Convenciones de Código

### General
- PHP 8.2+ con tipado estricto (`declare(strict_types=1)`)
- PSR-12 para estilo de código
- Nombres de variables y métodos en camelCase
- Nombres de clases en PascalCase
- Nombres de tablas en snake_case plural
- Comentarios en español cuando agregan contexto, código en inglés
- Commits en español con prefijo: `feat:`, `fix:`, `refactor:`, `docs:`, `test:`

### Laravel
- Usar Form Requests para validación (nunca validar en el controller)
- Usar Resources/Transformers para respuestas API
- Usar Services para lógica de negocio compleja
- Usar Traits para funcionalidad compartida entre modelos
- Usar Policies para autorización
- Migrations siempre con `down()` funcional
- Seeders para datos de prueba y templates por defecto
- Usar `config()` en vez de `env()` fuera de config files
- Eager loading siempre (prevenir N+1)

### Filament
- Un Resource por modelo principal
- Usar RelationManagers para relaciones
- Custom Pages para vistas especiales (editor GrapesJS)
- Widgets para el dashboard
- Usar `->searchable()`, `->sortable()` en columnas de tablas

### GrapesJS
- Toda la comunicación con el backend via API REST (JSON)
- Guardar estructura completa (HTML + CSS + componentes) en campo `content` como JSON
- Bloques custom registrados en `resources/js/builder/blocks.js`
- Plugins custom en carpeta `resources/js/builder/plugins/`
- Nunca manipular el DOM directamente fuera de GrapesJS
- El selector de fuentes solo muestra las 10 fuentes definidas en `config/webcomposer.php`

### Frontend Público
- Tailwind CSS para estilos (compilado con Vite)
- Alpine.js para interactividad ligera
- Lazy loading de imágenes por defecto
- Minificar JS/CSS en producción
- Google Fonts cargadas via `<link>` en el `<head>` (solo las 2 seleccionadas por el usuario)

---

## Fases de Desarrollo

### Fase 0 — Sistema Base (ACTUAL)
Autenticación, CRUD de pages, gestión de medios, roles, estructura de BD, API interna, settings del sitio.

### Fase 1 — Layout Builder
Integración GrapesJS, bloques de layout (columnas), contenedores, guardado automático, publish/unpublish, galería de templates.

### Fase 2 — Componentes + Estilos
Texto (TipTap), imagen, botones, formularios, video embed, iconos, maps, panel de propiedades, responsive editing, selector de fuentes (10 opciones), paleta de colores.

### Fase 3 — Blog
Editor de posts, categorías/tags, estados de publicación, slugs, versionado, RSS, widget de posts recientes.

### Fase 4 — IA
Generación de textos por sección, sugerencias SEO, auto-traducción, variantes de copy, asistente de escritura, Claude API.

### Fase 5 — Efectos JS
Swiper.js, AOS, GLightbox, menú hamburguesa, smooth scroll, contadores, acordeones/tabs, parallax.

### Fase 6 — SEO + Marketing
Meta tags, sitemap XML, Google Analytics, pop-ups, WhatsApp button, schema markup, redirecciones 301.

### Fase 7 — E-commerce
Catálogo, carrito, checkout, MercadoPago, Transbank, Stripe, notificaciones, dashboard ventas.

### Fase 8 — Integraciones + Marketplace
Sistema de plugins, marketplace de templates, embeds sociales, Calendly, chat en vivo, Mailchimp, export HTML, API pública, webhooks.

---

## Reglas para IA (Claude Code)

1. **Single-tenant:** NO crear tabla `sites`. NO usar `site_id` en ninguna tabla. Una instalación = un sitio.
2. **Fase por fase:** Desarrollar en orden secuencial. No saltar fases ni implementar features de fases posteriores.
3. **10 fuentes fijas:** Solo las 10 Google Fonts listadas. No agregar más ni permitir carga de fuentes externas.
4. **Templates:** Los 10 templates se cargan via seeder. Cada template es un JSON con estructura GrapesJS completa.
5. **Tests:** Crear Feature Tests para cada endpoint API y Unit Tests para Services.
6. **Migraciones:** Siempre crear migraciones separadas, nunca modificar migraciones existentes.
7. **Seeders:** Crear seeders con datos de ejemplo realistas y los 10 templates precargados.
8. **Sin over-engineering:** Implementar lo mínimo funcional primero, iterar después.
9. **Compatibilidad cPanel:** No usar features que requieran acceso root (supervisord, redis obligatorio, etc.). SQLite como fallback para caché si Redis no está disponible.
10. **Seguridad:** Sanitizar todo input del page builder. Validar JSON de GrapesJS. CSRF en forms. Rate limiting en API de IA.
11. **Responsive:** Todo el admin y el builder deben funcionar en desktop. Los sitios generados deben ser responsive.
12. **Documentación:** Cada Service debe tener docblocks completos. Cada endpoint API documentado con ejemplo de request/response.
13. **Git:** Un commit por funcionalidad completa. No commits de WIP salvo en branches de feature.

---

## Comandos de Desarrollo

```bash
# Setup inicial
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan filament:install --panels
npm run dev

# Desarrollo
php artisan serve                    # Servidor local
npm run dev                          # Vite en modo watch
php artisan make:model Nombre -mfs   # Modelo + migración + factory + seeder
php artisan make:filament-resource Nombre --generate  # Resource Filament
php artisan test                     # Correr tests
php artisan test --filter=NombreTest # Test específico

# Producción
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Variables de Entorno Requeridas

```env
# App
APP_NAME=WebComposer
APP_URL=http://web-composer.test

# Database
DB_CONNECTION=mysql
DB_DATABASE=web_composer
DB_USERNAME=root
DB_PASSWORD=

# AI
ANTHROPIC_API_KEY=sk-ant-...
OPENAI_API_KEY=sk-...           # Fallback
AI_DEFAULT_PROVIDER=anthropic
AI_MAX_TOKENS=2048
AI_RATE_LIMIT_PER_HOUR=50

# Media
MEDIA_MAX_FILE_SIZE=10240       # KB
MEDIA_ALLOWED_TYPES=jpg,jpeg,png,gif,webp,svg,mp4,pdf
MEDIA_DISK=public

# Filament
FILAMENT_PATH=admin
```