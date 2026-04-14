# PENDIENTES.md — WebComposer

**Fecha:** 2026-04-13
**Ultima actualizacion:** 2026-04-13

---

## Estado General

WebComposer tiene implementadas las **Fases 0 a 6 + Bloque A + Componentes Modernos + Section Library**.

**Arquitectura actual del builder:** Secciones pre-fabricadas (26) + IA solo genera contenido textual + Editor simplificado de secciones.

---

## Fases Pendientes

### Fase 7 — E-commerce

| Componente | Descripcion |
|---|---|
| Catalogo | Tabla products, ProductResource Filament, vistas publicas |
| Carrito | Tabla carts/cart_items, CartService, session-based |
| Checkout | Tabla orders/order_items, CheckoutService, formulario multi-step |
| MercadoPago | mercadopago/dx-php, webhook controller |
| Transbank | transbank-sdk, WebPay Plus |
| Stripe | stripe-php, Payment Intents |
| Notificaciones | Email confirmacion, cambio estado, Filament notifications |
| Dashboard ventas | Widget ingresos, pedidos, productos top |

### Fase 8 — Integraciones + Marketplace

| Componente | Descripcion |
|---|---|
| Plugins | Arquitectura hooks, tabla plugins, activacion/desactivacion |
| Marketplace templates | Import/export JSON, thumbnails, previews |
| Embeds sociales | Instagram, Twitter/X, TikTok (oEmbed) |
| Calendly | Widget embed configurable |
| Chat en vivo | Tawk.to/Crisp via settings |
| Mailchimp | Newsletter sync, mailchimp/marketing |
| Export HTML | Pagina completa como ZIP (HTML+CSS+assets) |
| API publica | REST endpoints documentados, tokens, Swagger |
| Webhooks | Tabla webhooks, dispatch eventos, reintentos |

---

## Bloque B — Mejoras Pendientes

| # | Feature | Prioridad | Complejidad |
|---|---------|-----------|-------------|
| 1 | Historial de versiones de paginas | Alta | Media |
| 2 | Busqueda en blog (full-text) | Media | Baja |
| 3 | Redirecciones 301 (tabla + middleware) | Media | Baja |
| 4 | Optimizacion automatica de imagenes (resize, WebP) | Alta | Media |
| 5 | Acciones masivas en admin (bulk status change, delete) | Media | Baja |

## Bloque C — Polish

| # | Feature | Prioridad | Complejidad |
|---|---------|-----------|-------------|
| 1 | Modo mantenimiento configurable desde admin | Baja | Baja |
| 2 | Exportar pagina como HTML/ZIP | Media | Media |
| 3 | Biblioteca de medios con carpetas/organizacion | Media | Media |
| 4 | Analytics basico integrado (page views sin GA) | Baja | Media |

---

## Tareas Tecnicas Pendientes

### Infraestructura
- [ ] Configurar Vite correctamente para produccion (npm run build)
- [ ] Reemplazar Tailwind CDN con Tailwind compilado
- [ ] Fijar versiones de GrapesJS CDN con SRI hashes
- [ ] Crear migration para tabla sessions (SESSION_DRIVER=database)
- [ ] Configurar queue worker para jobs (email notifications)

### Testing
- [ ] Feature tests para endpoints API (page load/store, media, AI)
- [ ] Unit tests para SectionLibraryService
- [ ] Unit tests para AIService (mock HTTP)
- [ ] Unit tests para SettingsService
- [ ] Unit tests para HtmlSanitizerService
- [ ] Factories para: Page, Post, Category, Tag, Block, PageTemplate

### Codigo
- [ ] Crear Form Requests dedicados para endpoints AI (actualmente validacion inline)
- [ ] Implementar HasMedia de Spatie en modelos Post/Page
- [ ] Sanitizar input de IA contra prompt injection
- [ ] Corregir SettingsService::getMany() cache de valores null (usar Cache::has())
- [ ] Agregar JSON_HEX_TAG a SEOService::generateSchemaMarkup()

### Secciones Premium
- [ ] Agregar mas variantes por seccion (light/dark/with-image)
- [ ] Crear thumbnails/previews para cada seccion
- [ ] Agregar secciones especializadas por industria
- [ ] Mejorar responsive de secciones en dispositivos intermedios (tablet landscape)

---

## Errores Conocidos

### 1. Vite no genera assets para produccion
**Archivos:** vite.config.js, layout.blade.php
**Problema:** Layout carga assets con `asset()` en vez de `@vite()`. Assets copiados manualmente.
**Workaround:** Tailwind CDN en desarrollo + archivos estaticos en public/.

### 2. CDN de GrapesJS sin version fija ni SRI
**Archivo:** builder/editor.blade.php
**Problema:** GrapesJS cargado desde unpkg sin pinear version.
**Riesgo:** Version incompatible o supply chain attack.

### 3. TipTap instalado pero no usado
**Problema:** @tiptap/core, @tiptap/pm, @tiptap/starter-kit en package.json pero no se usan. El editor de posts usa Filament RichEditor.
**Accion:** Remover de package.json o integrar en editor de posts.

### 4. Paquetes npm del builder no usados
**Problema:** grapesjs, grapesjs-blocks-basic, grapesjs-preset-webpage instalados via npm pero el editor carga desde CDN.
**Accion:** Remover de package.json o migrar a imports via Vite.

### 5. Archivos JS del builder son stubs
**Archivos:** resources/js/builder/index.js, config.js, blocks.js, panels.js, storage.js, fonts.js
**Problema:** Son placeholders vacios. Toda la logica esta inline en editor.blade.php.
**Accion:** Mantener como referencia o eliminar.

### 6. Spatie Media Library instalada pero no integrada en modelos
**Problema:** HasMedia no implementado en ningun modelo. Upload manual via MediaService.
**Accion:** Implementar HasMedia en Post y Page para aprovechar conversions/responsive images.

---

## Seguridad — Vulnerabilidades Pendientes (Severidad Media/Baja)

| # | Vulnerabilidad | Severidad | Estado |
|---|---------------|-----------|--------|
| 1 | No hay Content Security Policy (CSP) | Media | Pendiente |
| 2 | Prompt injection en inputs de IA | Media | Pendiente |
| 3 | API keys podrian filtrarse en logs de error | Media | Pendiente |
| 4 | No hay proteccion contra ataques de fuerza bruta en login | Baja | Filament tiene throttle basico |
| 5 | Schema markup sin JSON_HEX_TAG | Baja | Pendiente |

---

## Checklist Pre-Produccion

- [ ] Ejecutar `npm run build` y configurar `@vite()` en layout
- [ ] Cambiar APP_DEBUG=false en .env
- [ ] Configurar ANTHROPIC_API_KEY y OPENAI_API_KEY reales
- [ ] Ejecutar `php artisan config:cache && route:cache && view:cache`
- [ ] Crear cron job: `* * * * * php artisan schedule:run`
- [ ] Verificar MEDIA_MAX_FILE_SIZE y MEDIA_ALLOWED_TYPES
- [ ] Configurar dominio real en APP_URL
- [ ] Configurar MAIL_MAILER para notificaciones reales
- [ ] Crear migration de sessions table
- [ ] Revisar y eliminar usuarios de prueba
- [ ] Configurar SSL/HTTPS
- [ ] Configurar backups de BD
- [ ] Testear flujo completo: crear pagina → wizard → editar → publicar → ver publica
