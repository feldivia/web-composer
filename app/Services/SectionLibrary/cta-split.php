<?php

declare(strict_types=1);

/**
 * CTA Split — Image background with overlay + centered text and button.
 */
return [
    'id' => 'cta-split',
    'name' => 'CTA con Imagen',
    'category' => 'cta',
    'description' => 'Sección CTA con imagen de fondo, overlay oscuro y texto centrado',
    'icon' => '📢',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Transforma tu visión en realidad'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Descripción', 'default' => 'Nuestro equipo de expertos está listo para llevar tu proyecto al siguiente nivel.'],
        'cta_text' => ['type' => 'text', 'label' => 'Texto del botón', 'default' => 'Solicitar presupuesto'],
        'image_1' => ['type' => 'image', 'label' => 'Imagen de fondo', 'default' => 'https://picsum.photos/seed/ctasplit/1400/500'],
    ],
    'html' => '<section class="wc-cta-split-section" style="background-image: url(\'{{image_1}}\');">
  <div class="wc-cta-split-overlay"></div>
  <div class="wc-cta-split-container">
    <h2 class="wc-cta-split-title">{{title}}</h2>
    <p class="wc-cta-split-subtitle">{{subtitle}}</p>
    <a href="#" class="wc-cta-split-btn">{{cta_text}}</a>
  </div>
</section>',
    'css' => '.wc-cta-split-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  position: relative;
  text-align: center;
}
.wc-cta-split-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(145deg, rgba(15, 23, 42, 0.85), rgba(30, 41, 59, 0.8));
}
.wc-cta-split-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
}
.wc-cta-split-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.8rem);
  font-weight: 700;
  color: #FFFFFF;
  margin: 0 0 1rem 0;
}
.wc-cta-split-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(0.95rem, 1.2vw, 1.05rem);
  font-weight: 300;
  line-height: 1.85;
  color: rgba(255, 255, 255, 0.6);
  max-width: 550px;
  margin: 0 auto 2rem;
}
.wc-cta-split-btn {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #FFFFFF;
  background: var(--color-accent, #F59E0B);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-cta-split-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(245, 158, 11, 0.35);
}
@media (max-width: 768px) {
  .wc-cta-split-section { background-attachment: scroll; }
}
@media (max-width: 480px) {
  .wc-cta-split-section { padding: clamp(3rem, 6vw, 4rem) 0; }
}',
];
