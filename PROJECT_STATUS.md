# WebComposer - Estado del Proyecto

> Documento actualizado el 13 de abril de 2026.
> Resumen completo del estado actual del desarrollo de WebComposer.

---

## 1. Resumen del Proyecto

**WebComposer** es un CMS moderno y simplificado (alternativa a WordPress) con editor visual basado en secciones premium, blog integrado e IA nativa para generacion de contenido. Es **single-tenant**: una instalacion = un sitio web. Desplegable en hosting compartido (cPanel).

**Diferenciador:** La IA NO genera diseño — genera solo contenido textual. El diseño viene de una biblioteca de 26 secciones pre-fabricadas de calidad premium. Esto garantiza resultado visual consistente y profesional.

---

## 2. Stack Tecnologico

| Componente | Tecnologia | Version |
|---|---|---|
| Backend | Laravel | 11.x |
| PHP | PHP | 8.3.30 |
| Panel Admin | Filament | ^3.3 |
| Page Builder | Section Editor (custom) + GrapesJS (avanzado) | Custom + ^0.22.15 |
| Section Library | 26 secciones PHP pre-fabricadas | Custom |
| Base de Datos | MySQL | 8 |
| Frontend CSS | CSS custom + Tailwind CDN (dev) | Custom + CDN |
| Frontend JS | Vanilla JS (site.js — 1000+ lineas) | Custom |
| Gestion de Medios | Spatie Media Library | ^11.0 |
| IA Principal | Claude API (Anthropic) | claude-opus-4-20250514 |
| IA Fallback | Claude Sonnet → OpenAI GPT | claude-sonnet-4 / gpt-4o-mini |
| HTML Sanitization | HTMLPurifier | ^4.19 |
| Build Tool | Vite (configurado, no usado en dev) | ^6.0.11 |

---

## 3. Arquitectura del Page Builder

### Flujo de creacion de paginas

```
Usuario crea pagina → Wizard IA (4 pasos)
  1. Describe tu negocio (nombre + descripcion)
  2. Elige secciones (26 opciones, drag & reorder)
  3. Elige estilo (9 paletas + 8 pares fuentes)
  4. IA genera SOLO textos → secciones premium se renderizan
     ↓
Section Editor (edicion simple)
  - Reordenar secciones (mover arriba/abajo)
  - Edicion inline de textos (click para editar)
  - Agregar/eliminar secciones del catalogo
  - Panel de estilos (colores + fuentes)
  - Regenerar seccion con IA
     ↓
Publicar
```

### Componentes del builder

| Componente | Archivo | Funcion |
|---|---|---|
| SectionLibraryService | app/Services/SectionLibraryService.php | Registro de 26 secciones premium |
| Section Library (26 archivos) | app/Services/SectionLibrary/*.php | HTML+CSS de cada seccion |
| AI Wizard | resources/views/builder/ai-wizard.blade.php | Wizard de 4 pasos |
| Section Editor | resources/views/builder/section-editor.blade.php | Editor simplificado |
| GrapesJS Editor | resources/views/builder/editor.blade.php | Editor avanzado (legacy) |
| AIWizardController | app/Http/Controllers/Builder/AIWizardController.php | Logica del wizard |
| SectionEditorController | app/Http/Controllers/Builder/SectionEditorController.php | Logica del editor |

### Biblioteca de Secciones (26)

| Categoria | Secciones | IDs |
|---|---|---|
| Heroes (4) | Split, Centered, Minimal, Dark | hero-split, hero-centered, hero-minimal, hero-dark |
| Services (4) | Cards 3, Cards 4, Alternating, Icons List | services-cards, services-cards-4, features-alternating, features-icons-list |
| About (2) | Split, Cards 3D | about-split, about-cards |
| Trust/Stats (2) | Bar, Counters | stats-bar, stats-counters |
| Testimonials (2) | Grid, Featured | testimonials-grid, testimonials-featured |
| Pricing (2) | 3 Columns, Comparison | pricing-3-columns, pricing-comparison |
| FAQ (1) | Accordion | faq-accordion |
| Contact (2) | Split, Simple | contact-split, contact-simple |
| CTA (2) | Gradient, Split Image | cta-gradient, cta-split |
| Gallery (1) | Grid Hover | gallery-grid |
| Quote (1) | Dark Centered | quote-section |
| Footer (2) | 4 Columns, Simple | footer-4col, footer-simple |
| Marquee (1) | Infinite Scroll | marquee-bar |

---

## 4. Fases Completadas

### Fase 0 — Sistema Base ✅
- Autenticacion Filament con 3 roles (admin, editor, writer)
- 4 Policies (Page, Post, User, Setting)
- CRUD: Pages, Posts, Categories, Tags, Blocks, Templates, Users
- FormSubmission system (contacto con honeypot anti-spam)
- SettingsService con cache (21 configuraciones)
- Middleware: InjectSiteSettings, SecurityHeaders
- 15 migraciones, seeders completos
- API REST interna (65 rutas)

### Fase 1 — Layout Builder ✅
- GrapesJS editor con dark theme (Catppuccin)
- Save/Load via API, auto-save 30s
- Template picker con 3 templates
- Device preview (Desktop/Tablet/Mobile)
- **NUEVO:** Section Editor simplificado como alternativa
- **NUEVO:** AI Wizard para generacion de paginas

### Fase 2 — Componentes + Estilos ✅
- 10 Google Fonts configuradas
- 45 bloques en GrapesJS (8 categorias + efectos)
- **NUEVO:** 26 secciones premium pre-fabricadas (SectionLibrary)
- Panel de efectos en GrapesJS (traits para animaciones, hover, parallax, etc.)
- 8 bloques de efectos (carousel, tabs, progress, marquee, lightbox, counters, typewriter, sticky)

### Fase 3 — Blog ✅
- Posts con categorias/tags, estados, SEO
- Blog index con cards modernas, paginacion custom
- Blog show con hero image, breadcrumbs, tags
- RSS feed, Schema.org BlogPosting
- Publicacion programada automatica (artisan command)
- Duplicar posts

### Fase 4 — IA ✅
- Claude Opus 4 (principal) con fallback: Opus → Sonnet → GPT
- Retry automatico en sobrecarga (2 intentos Opus + 1 Sonnet)
- 7 endpoints: generateText, generateSEO, translate, generatePage, generateVariants, regenerateSection, generateSection
- **NUEVO:** generateSectionContent (solo texto para secciones pre-fabricadas)
- **NUEVO:** generateColorPalette (paleta de colores por IA)
- Rate limiting: 10 req/min IA, 60 req/min general
- Timeout: 180s para Opus

### Fase 5 — Efectos JS ✅ (11 efectos, 0 dependencias externas)
| Efecto | Atributo | Descripcion |
|---|---|---|
| Scroll Animations | data-animate="fade-up\|fade-down\|fade-left\|fade-right\|fade-zoom\|flip-up\|flip-left" | 7 tipos + delay + duration |
| Typewriter | data-typewriter | Speed, delay, cursor |
| Parallax | data-parallax="0.3" | Velocidad 0.1–0.9 |
| Lightbox | data-lightbox | Grupos, caption, teclado, swipe |
| Carousel | data-carousel | Autoplay, loop, dots, arrows, touch |
| Tabs | data-tabs | Triggers + contenido, fade |
| Sticky Navbar | data-sticky | Offset, clase CSS |
| Progress Bar | data-progress="75" | Color, duracion |
| Marquee | data-marquee | Velocidad, direccion, pausa hover |
| Hover Effects | data-hover="scale\|shadow\|lift\|glow\|border" | 5 tipos |
| Counters | data-count="500" | Suffix, duracion |
| Before/After | data-before-after | Drag + touch |
| Video Thumbnail | data-video-src | Click to embed |
| Pricing Toggle | data-pricing-toggle | Mensual/anual |
| Dismiss | data-dismiss | Cerrar notificaciones |

### Fase 6 — SEO + Marketing ✅
- Meta tags OG + Twitter Cards en pages y posts
- Schema.org: WebPage, BlogPosting, BreadcrumbList
- Sitemap XML automatico
- Google Analytics + Meta Pixel (condicional a cookies)
- Boton WhatsApp flotante
- Cookie consent banner (GDPR)
- Dark mode toggle + localStorage
- Breadcrumbs con Schema.org

### Bloque A — Funcionalidades Core ✅
- 3 roles (admin/editor/writer) con policies
- Duplicar paginas y posts
- Formulario de contacto integrado (honeypot, rate-limit)
- Publicacion programada automatica
- Paginas de error personalizadas (404, 500, 503)
- CRUD de usuarios (admin only)
- Menu organizado: Contenido / Diseno / Sistema

### Bloque Extra — Componentes Modernos ✅
- 15 bloques modernos nuevos (total 45 en GrapesJS)
- Bento Grid, Timeline, Before/After Slider, Team Cards, Comparison Table
- Social Proof Bar, Logo Carousel, App Download Section
- Notification Bar, Video Thumbnail, Pricing Toggle
- Dark mode CSS completo
- Responsive mejorado: 4 breakpoints + clamp() + ultra-wide

### Proteccion de Sesion ✅
- Heartbeat cada 5 min (refresca CSRF)
- Backup localStorage en cada cambio
- Modal sesion expirada (persistente)
- Restaurar backup al abrir editor
- beforeunload warning
- Smart auto-save (diferencia 401/419/429/500)
- Deteccion offline con indicador

---

## 5. Base de Datos

### Tablas (15 total)

| Tabla | Registros | Descripcion |
|---|---|---|
| users | 4 | Admin, Editor, Writer, Viewer |
| pages | 1 | Homepage |
| posts | 0 | — |
| categories | 3 | — |
| tags | 0 | — |
| category_post | 0 | Pivot |
| post_tag | 0 | Pivot |
| blocks | 45 | 10 categorias |
| settings | 21 | Config del sitio |
| page_templates | 3 | Landing, Restaurante, Portafolio |
| form_submissions | 0 | Mensajes de contacto |
| sessions | — | Sesiones de usuario |
| cache | — | Cache de app |
| jobs | — | Queue |

### Usuarios de prueba

| Email | Password | Rol |
|---|---|---|
| admin@webcomposer.test | password | Admin |
| editor@webcomposer.test | password | Editor |
| writer@webcomposer.test | password | Writer |
| viewer@webcomposer.test | password | Writer |

---

## 6. Rutas Principales (65 total)

### Publicas
| Ruta | Funcion |
|---|---|
| GET / | Homepage |
| GET /{slug} | Pagina CMS |
| GET /blog | Blog index |
| GET /blog/{slug} | Post individual |
| GET /sitemap.xml | Sitemap XML |
| GET /feed.xml | RSS Feed |
| POST /contact | Envio formulario contacto |

### Builder (autenticado)
| Ruta | Funcion |
|---|---|
| GET /builder/{page}/wizard | Wizard IA |
| POST /builder/{page}/wizard/generate | Generar con IA |
| GET /builder/{page}/sections | Section Editor |
| GET /builder/{page} | GrapesJS Editor (avanzado) |
| GET /templates | Galeria de templates |
| GET /templates/{slug}/preview | Preview template |
| GET /preview/page/{page} | Preview pagina (cualquier estado) |

### API (autenticado)
| Ruta | Funcion |
|---|---|
| GET /api/pages/{page}/load | Cargar pagina para editor |
| POST /api/pages/{page}/store | Guardar pagina |
| GET/POST /api/media/* | CRUD medios |
| GET /api/templates/* | Templates |
| GET /api/sections/* | Biblioteca de secciones |
| POST /api/ai/* | 7 endpoints IA |
| POST /api/heartbeat | Keep-alive sesion |

### Admin Filament
| Ruta | Funcion |
|---|---|
| /admin | Dashboard |
| /admin/pages | CRUD Paginas |
| /admin/posts | CRUD Posts |
| /admin/categories | CRUD Categorias |
| /admin/tags | CRUD Tags |
| /admin/blocks | Bloques (45) |
| /admin/page-templates | Templates (3) |
| /admin/users | Usuarios (admin only) |
| /admin/form-submissions | Mensajes contacto |
| /admin/site-settings | Configuracion sitio |

---

## 7. Seguridad Implementada

| Mecanismo | Estado |
|---|---|
| HTMLPurifier (XSS) | ✅ Implementado |
| CSRF protection | ✅ Con auto-refresh via heartbeat |
| Sanctum API auth | ✅ Sesion web para builder |
| Rate limiting | ✅ 60/min general, 10/min IA |
| Honeypot anti-spam | ✅ En formularios contacto |
| File validation | ✅ MIME, size, SVG blocking |
| Input sanitization | ✅ CSS peligroso bloqueado |
| Security headers | ✅ X-Frame, X-Content-Type, Referrer |
| Role-based access | ✅ 3 roles con policies |
| Session protection | ✅ Heartbeat + backup + beforeunload |
| Cookie consent | ✅ GDPR con analytics condicional |

---

## 8. Fases Pendientes

### Fase 7 — E-commerce
Catalogo de productos, carrito, checkout, MercadoPago, Transbank, Stripe, notificaciones, dashboard ventas.

### Fase 8 — Integraciones + Marketplace
Sistema de plugins, marketplace templates, embeds sociales, Calendly, chat en vivo, Mailchimp, export HTML, API publica, webhooks.

### Bloque B — Mejoras pendientes
- Historial de versiones de paginas
- Busqueda en blog
- Redirecciones 301
- Optimizacion automatica de imagenes
- Acciones masivas en admin

### Bloque C — Polish
- Modo mantenimiento configurable
- Exportar pagina como HTML/ZIP
- Biblioteca de medios con carpetas
- Analytics basico integrado (page views)
