<?php

declare(strict_types=1);

/**
 * Footer Simple — Centered brand, single row of links, copyright.
 */
return [
    'id' => 'footer-simple',
    'name' => 'Footer Simple',
    'category' => 'footer',
    'description' => 'Footer minimalista centrado con marca, fila de links y copyright',
    'icon' => '📎',
    'placeholders' => [
        'brand_name' => ['type' => 'text', 'label' => 'Nombre de marca', 'default' => 'WebComposer'],
        'nav_links' => ['type' => 'links', 'label' => 'Links', 'default' => [
            ['text' => 'Inicio', 'url' => '#'],
            ['text' => 'Nosotros', 'url' => '#'],
            ['text' => 'Servicios', 'url' => '#'],
            ['text' => 'Contacto', 'url' => '#'],
        ]],
        'copyright' => ['type' => 'text', 'label' => 'Copyright', 'default' => '© 2026 WebComposer. Todos los derechos reservados.'],
    ],
    'html' => '<footer class="wc-footer-simple-section">
  <div class="wc-footer-simple-container">
    <h3 class="wc-footer-simple-brand">{{brand_name}}</h3>
    <ul class="wc-footer-simple-links">{{nav_links}}</ul>
    <p class="wc-footer-simple-copyright">{{copyright}}</p>
  </div>
</footer>',
    'css' => '.wc-footer-simple-section {
  padding: clamp(2.5rem, 5vw, 3.5rem) 0;
  background: linear-gradient(145deg, #0F172A, #1E293B);
  text-align: center;
}
.wc-footer-simple-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-footer-simple-brand {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.3rem;
  font-weight: 700;
  color: #FFFFFF;
  margin: 0 0 1.2rem 0;
}
.wc-footer-simple-links {
  list-style: none;
  padding: 0;
  margin: 0 0 1.5rem 0;
  display: flex;
  justify-content: center;
  gap: 1.5rem;
  flex-wrap: wrap;
}
.wc-footer-simple-link {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.4);
  text-decoration: none;
  transition: color 0.3s ease;
}
.wc-footer-simple-link:hover {
  color: var(--color-accent, #F59E0B);
}
.wc-footer-simple-copyright {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 300;
  color: rgba(255, 255, 255, 0.25);
  margin: 0;
}
@media (max-width: 480px) {
  .wc-footer-simple-links { flex-direction: column; gap: 0.8rem; }
}',
];
