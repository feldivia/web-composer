<?php

declare(strict_types=1);

/**
 * Features Alternating — Zigzag layout: image + text alternating sides.
 */
return [
    'id' => 'features-alternating',
    'name' => 'Features Zigzag',
    'category' => 'services',
    'description' => 'Layout alternado: imagen izquierda + texto derecha, luego se invierte',
    'icon' => '↔️',
    'placeholders' => [
        'label_1' => ['type' => 'text', 'label' => 'Etiqueta bloque 1', 'default' => 'Innovación'],
        'title_1' => ['type' => 'text', 'label' => 'Titulo bloque 1', 'default' => 'Tecnología de vanguardia'],
        'desc_1' => ['type' => 'textarea', 'label' => 'Descripción bloque 1', 'default' => 'Utilizamos las herramientas más avanzadas del mercado para entregar soluciones que superan las expectativas de nuestros clientes.'],
        'image_1' => ['type' => 'image', 'label' => 'Imagen bloque 1', 'default' => 'https://picsum.photos/seed/feat1/600/450'],
        'label_2' => ['type' => 'text', 'label' => 'Etiqueta bloque 2', 'default' => 'Calidad'],
        'title_2' => ['type' => 'text', 'label' => 'Titulo bloque 2', 'default' => 'Estándares que marcan la diferencia'],
        'desc_2' => ['type' => 'textarea', 'label' => 'Descripción bloque 2', 'default' => 'Cada proyecto pasa por rigurosos controles de calidad que garantizan resultados excepcionales y duraderos.'],
        'image_2' => ['type' => 'image', 'label' => 'Imagen bloque 2', 'default' => 'https://picsum.photos/seed/feat2/600/450'],
    ],
    'html' => '<section class="wc-features-alternating-section">
  <div class="wc-features-alternating-container">
    <div class="wc-features-alternating-row">
      <div class="wc-features-alternating-img-wrap">
        <img src="{{image_1}}" alt="{{title_1}}" class="wc-features-alternating-img" loading="lazy">
      </div>
      <div class="wc-features-alternating-text">
        <div class="wc-features-alternating-label">
          <span class="wc-features-alternating-line"></span>
          <span>{{label_1}}</span>
        </div>
        <h3 class="wc-features-alternating-title">{{title_1}}</h3>
        <p class="wc-features-alternating-desc">{{desc_1}}</p>
      </div>
    </div>
    <div class="wc-features-alternating-row wc-features-alternating-row--reverse">
      <div class="wc-features-alternating-img-wrap">
        <img src="{{image_2}}" alt="{{title_2}}" class="wc-features-alternating-img" loading="lazy">
      </div>
      <div class="wc-features-alternating-text">
        <div class="wc-features-alternating-label">
          <span class="wc-features-alternating-line"></span>
          <span>{{label_2}}</span>
        </div>
        <h3 class="wc-features-alternating-title">{{title_2}}</h3>
        <p class="wc-features-alternating-desc">{{desc_2}}</p>
      </div>
    </div>
  </div>
</section>',
    'css' => '.wc-features-alternating-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-features-alternating-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: flex;
  flex-direction: column;
  gap: clamp(3rem, 6vw, 5rem);
}
.wc-features-alternating-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  align-items: center;
}
.wc-features-alternating-row--reverse {
  direction: rtl;
}
.wc-features-alternating-row--reverse > * {
  direction: ltr;
}
.wc-features-alternating-img-wrap {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
}
.wc-features-alternating-img {
  width: 100%;
  height: auto;
  display: block;
  border-radius: 16px;
  transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-features-alternating-img-wrap:hover .wc-features-alternating-img {
  transform: scale(1.03);
}
.wc-features-alternating-label {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 1rem;
}
.wc-features-alternating-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-features-alternating-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.4rem, 2.5vw, 1.8rem);
  font-weight: 600;
  line-height: 1.25;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-features-alternating-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.92rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0;
}
@media (max-width: 768px) {
  .wc-features-alternating-row,
  .wc-features-alternating-row--reverse {
    grid-template-columns: 1fr;
    direction: ltr;
  }
  .wc-features-alternating-text { text-align: center; }
  .wc-features-alternating-label { justify-content: center; }
}
@media (max-width: 480px) {
  .wc-features-alternating-section { padding: clamp(2.5rem, 6vw, 4rem) 0; }
}',
];
