<?php

declare(strict_types=1);

/**
 * Stats Counters — Dark bg with image overlay + gradient, large numbers.
 */
return [
    'id' => 'stats-counters',
    'name' => 'Contadores de Impacto',
    'category' => 'trust',
    'description' => 'Fondo oscuro con overlay de imagen, 4 contadores grandes con números animados',
    'icon' => '🔢',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Nuestro impacto'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Números que hablan por sí solos'],
        'image_1' => ['type' => 'image', 'label' => 'Imagen de fondo', 'default' => 'https://picsum.photos/seed/statscount/1400/600'],
        'stats' => ['type' => 'stats', 'label' => 'Estadísticas (4)', 'default' => [
            ['number' => '2500', 'label' => 'Clientes activos'],
            ['number' => '180', 'label' => 'Profesionales'],
            ['number' => '35', 'label' => 'Países'],
            ['number' => '99.9', 'label' => 'Uptime %'],
        ]],
    ],
    'html' => '<section class="wc-stats-counters-section" style="background-image: url(\'{{image_1}}\');">
  <div class="wc-stats-counters-overlay"></div>
  <div class="wc-stats-counters-container">
    <div class="wc-stats-counters-header">
      <div class="wc-stats-counters-label">
        <span class="wc-stats-counters-line"></span>
        <span>{{label}}</span>
        <span class="wc-stats-counters-line"></span>
      </div>
      <h2 class="wc-stats-counters-title">{{title}}</h2>
    </div>
    <div class="wc-stats-counters-grid">
      {{stats}}
    </div>
  </div>
</section>',
    'css' => '.wc-stats-counters-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  position: relative;
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}
.wc-stats-counters-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(145deg, rgba(15, 23, 42, 0.92), rgba(30, 41, 59, 0.88));
}
.wc-stats-counters-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
}
.wc-stats-counters-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-stats-counters-label {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 1rem;
}
.wc-stats-counters-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-stats-counters-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: #FFFFFF;
  margin: 0;
}
.wc-stats-counters-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
  text-align: center;
}
.wc-stats-counters-stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.4rem;
}
.wc-stats-counters-stat-number {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2.4rem, 4vw, 3.8rem);
  font-weight: 700;
  color: var(--color-accent, #F59E0B);
  line-height: 1;
}
.wc-stats-counters-stat-label {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(255, 255, 255, 0.45);
}
@media (max-width: 768px) {
  .wc-stats-counters-grid { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
  .wc-stats-counters-section { background-attachment: scroll; }
}
@media (max-width: 480px) {
  .wc-stats-counters-grid { grid-template-columns: 1fr; gap: 1.5rem; }
}',
];
