<?php

declare(strict_types=1);

/**
 * Footer 4 Columns — Dark bg, brand + nav + services + newsletter.
 */
return [
    'id' => 'footer-4col',
    'name' => 'Footer 4 Columnas',
    'category' => 'footer',
    'description' => 'Footer oscuro con 4 columnas: marca, navegación, servicios y newsletter',
    'icon' => '🔻',
    'placeholders' => [
        'brand_name' => ['type' => 'text', 'label' => 'Nombre de marca', 'default' => 'WebComposer'],
        'brand_desc' => ['type' => 'textarea', 'label' => 'Descripción de marca', 'default' => 'Creamos experiencias digitales excepcionales que conectan marcas con sus audiencias.'],
        'nav_links' => ['type' => 'links', 'label' => 'Links navegación', 'default' => [
            ['text' => 'Inicio', 'url' => '#'],
            ['text' => 'Nosotros', 'url' => '#'],
            ['text' => 'Servicios', 'url' => '#'],
            ['text' => 'Portfolio', 'url' => '#'],
            ['text' => 'Contacto', 'url' => '#'],
        ]],
        'service_links' => ['type' => 'links', 'label' => 'Links servicios', 'default' => [
            ['text' => 'Diseño Web', 'url' => '#'],
            ['text' => 'Desarrollo', 'url' => '#'],
            ['text' => 'Marketing', 'url' => '#'],
            ['text' => 'Consultoría', 'url' => '#'],
            ['text' => 'Soporte', 'url' => '#'],
        ]],
        'newsletter_title' => ['type' => 'text', 'label' => 'Titulo newsletter', 'default' => 'Newsletter'],
        'newsletter_desc' => ['type' => 'text', 'label' => 'Desc newsletter', 'default' => 'Recibe novedades y consejos en tu email.'],
        'copyright' => ['type' => 'text', 'label' => 'Copyright', 'default' => '© 2026 WebComposer. Todos los derechos reservados.'],
        'credits' => ['type' => 'text', 'label' => 'Créditos', 'default' => 'Diseñado con WebComposer'],
    ],
    'html' => '<footer class="wc-footer-4col-section">
  <div class="wc-footer-4col-container">
    <div class="wc-footer-4col-grid">
      <div class="wc-footer-4col-brand">
        <h3 class="wc-footer-4col-brand-name">{{brand_name}}</h3>
        <p class="wc-footer-4col-brand-desc">{{brand_desc}}</p>
      </div>
      <div class="wc-footer-4col-col">
        <h4 class="wc-footer-4col-col-title">Navegación</h4>
        <ul class="wc-footer-4col-list">{{nav_links}}</ul>
      </div>
      <div class="wc-footer-4col-col">
        <h4 class="wc-footer-4col-col-title">Servicios</h4>
        <ul class="wc-footer-4col-list">{{service_links}}</ul>
      </div>
      <div class="wc-footer-4col-col">
        <h4 class="wc-footer-4col-col-title">{{newsletter_title}}</h4>
        <p class="wc-footer-4col-newsletter-desc">{{newsletter_desc}}</p>
        <div class="wc-footer-4col-newsletter">
          <input type="email" class="wc-footer-4col-input" placeholder="tu@email.com">
          <button class="wc-footer-4col-btn">Enviar</button>
        </div>
      </div>
    </div>
    <div class="wc-footer-4col-bottom">
      <span class="wc-footer-4col-copyright">{{copyright}}</span>
      <span class="wc-footer-4col-credits">{{credits}}</span>
    </div>
  </div>
</footer>',
    'css' => '.wc-footer-4col-section {
  padding: clamp(3rem, 6vw, 5rem) 0 0;
  background: linear-gradient(145deg, #0F172A, #1E293B);
}
.wc-footer-4col-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-footer-4col-grid {
  display: grid;
  grid-template-columns: 1.3fr 0.8fr 0.8fr 1.1fr;
  gap: 2.5rem;
  padding-bottom: 3rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}
.wc-footer-4col-brand-name {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.3rem;
  font-weight: 700;
  color: #FFFFFF;
  margin: 0 0 0.8rem 0;
}
.wc-footer-4col-brand-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  font-weight: 300;
  line-height: 1.75;
  color: rgba(255, 255, 255, 0.4);
  margin: 0;
}
.wc-footer-4col-col-title {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(255, 255, 255, 0.7);
  margin: 0 0 1.2rem 0;
}
.wc-footer-4col-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}
.wc-footer-4col-link {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.4);
  text-decoration: none;
  transition: color 0.3s ease;
}
.wc-footer-4col-link:hover {
  color: var(--color-accent, #F59E0B);
}
.wc-footer-4col-newsletter-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  font-weight: 300;
  line-height: 1.65;
  color: rgba(255, 255, 255, 0.4);
  margin: 0 0 1rem 0;
}
.wc-footer-4col-newsletter {
  display: flex;
  gap: 0;
}
.wc-footer-4col-input {
  flex: 1;
  padding: 0.7rem 0.9rem;
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 8px 0 0 8px;
  background: rgba(255, 255, 255, 0.05);
  color: #FFFFFF;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  outline: none;
  transition: border-color 0.3s ease;
}
.wc-footer-4col-input:focus {
  border-color: var(--color-accent, #F59E0B);
}
.wc-footer-4col-btn {
  padding: 0.7rem 1.2rem;
  border: none;
  border-radius: 0 8px 8px 0;
  background: var(--color-accent, #F59E0B);
  color: #FFFFFF;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.78rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.3s ease;
}
.wc-footer-4col-btn:hover {
  background: var(--color-primary, #6366F1);
}
.wc-footer-4col-bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem 0;
}
.wc-footer-4col-copyright,
.wc-footer-4col-credits {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.25);
}
@media (max-width: 1024px) {
  .wc-footer-4col-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .wc-footer-4col-grid { grid-template-columns: 1fr; gap: 2rem; }
  .wc-footer-4col-bottom { flex-direction: column; gap: 0.5rem; text-align: center; }
}
@media (max-width: 480px) {
  .wc-footer-4col-newsletter { flex-direction: column; }
  .wc-footer-4col-input { border-radius: 8px; }
  .wc-footer-4col-btn { border-radius: 8px; }
}',
];
