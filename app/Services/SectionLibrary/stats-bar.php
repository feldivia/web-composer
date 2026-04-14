<?php

declare(strict_types=1);

/**
 * Stats Bar — Dark bg, accent top border, 4 stats columns.
 */
return [
    'id' => 'stats-bar',
    'name' => 'Barra de Estadísticas',
    'category' => 'trust',
    'description' => 'Barra oscura con borde accent y 4 estadísticas destacadas',
    'icon' => '📊',
    'placeholders' => [
        'stats' => ['type' => 'stats', 'label' => 'Estadísticas (4)', 'default' => [
            ['number' => '500+', 'label' => 'Clientes satisfechos'],
            ['number' => '15', 'label' => 'Años de experiencia'],
            ['number' => '1200+', 'label' => 'Proyectos completados'],
            ['number' => '98%', 'label' => 'Tasa de satisfacción'],
        ]],
    ],
    'html' => '<section class="wc-stats-bar-section">
  <div class="wc-stats-bar-container">
    {{stats}}
  </div>
</section>',
    'css' => '.wc-stats-bar-section {
  padding: clamp(2.5rem, 5vw, 3.5rem) 0;
  background: linear-gradient(145deg, #0F172A, #1E293B);
  border-top: 3px solid var(--color-accent, #F59E0B);
  position: relative;
}
.wc-stats-bar-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
  text-align: center;
}
.wc-stats-bar-stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.3rem;
}
.wc-stats-bar-stat-number {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3vw, 2.4rem);
  font-weight: 700;
  color: var(--color-accent, #F59E0B);
}
.wc-stats-bar-stat-label {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.68rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(255, 255, 255, 0.45);
}
@media (max-width: 768px) {
  .wc-stats-bar-container { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
}
@media (max-width: 480px) {
  .wc-stats-bar-container { grid-template-columns: 1fr; gap: 1.2rem; }
}',
];
