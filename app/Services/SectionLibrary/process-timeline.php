<?php

declare(strict_types=1);

/**
 * Process Timeline — Pasos numerados con línea de progreso. "Cómo trabajamos".
 */
return [
    'id' => 'process-timeline',
    'name' => 'Proceso / Timeline',
    'category' => 'services',
    'description' => 'Pasos del proceso con números, línea de progreso y descripciones. Ideal para "Cómo trabajamos"',
    'icon' => '📋',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Cómo Trabajamos'],
        'subtitle' => ['type' => 'text', 'label' => 'Subtítulo', 'default' => 'Un proceso simple y efectivo para llevar tu proyecto al siguiente nivel'],
        'steps' => ['type' => 'features', 'label' => 'Pasos del proceso', 'default' => [
            ['icon' => '01', 'title' => 'Consulta Inicial', 'description' => 'Escuchamos tus necesidades, objetivos y visión. Analizamos tu situación actual y definimos el alcance del proyecto.', 'link_text' => ''],
            ['icon' => '02', 'title' => 'Estrategia y Diseño', 'description' => 'Creamos un plan detallado y diseñamos la solución ideal. Presentamos mockups y prototipos para tu aprobación.', 'link_text' => ''],
            ['icon' => '03', 'title' => 'Desarrollo', 'description' => 'Implementamos la solución con las mejores prácticas y tecnologías. Entregas parciales para mantener transparencia.', 'link_text' => ''],
            ['icon' => '04', 'title' => 'Lanzamiento y Soporte', 'description' => 'Publicamos tu proyecto y te capacitamos. Soporte continuo para asegurar que todo funcione perfectamente.', 'link_text' => ''],
        ]],
    ],
    'html' => '<section class="wc-process-timeline-section">
  <div class="wc-process-timeline-container">
    <div class="wc-process-timeline-header">
      <h2 class="wc-process-timeline-title">{{title}}</h2>
      <p class="wc-process-timeline-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-process-timeline-steps">{{steps}}</div>
  </div>
</section>',
    'css' => '.wc-process-timeline-section {
  padding: clamp(3.5rem, 8vw, 6rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-process-timeline-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-process-timeline-header {
  text-align: center;
  margin-bottom: clamp(2rem, 4vw, 3.5rem);
}
.wc-process-timeline-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-process-timeline-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  color: rgba(30, 41, 59, 0.55);
  margin: 0;
}
.wc-process-timeline-steps {
  position: relative;
  display: flex;
  flex-direction: column;
  gap: 0;
}
.wc-process-timeline-steps::before {
  content: "";
  position: absolute;
  left: 24px;
  top: 24px;
  bottom: 24px;
  width: 2px;
  background: linear-gradient(to bottom, var(--color-primary, #6366F1), var(--color-accent, #F59E0B));
  opacity: 0.2;
}
.wc-process-timeline-card {
  display: flex;
  gap: 1.5rem;
  padding: 1.5rem 0;
  position: relative;
}
.wc-process-timeline-card-icon {
  width: 50px;
  height: 50px;
  min-width: 50px;
  border-radius: 50%;
  background: var(--color-primary, #6366F1);
  color: #FFFFFF;
  font-family: var(--font-heading, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  z-index: 1;
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}
.wc-process-timeline-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.4rem 0;
}
.wc-process-timeline-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.88rem;
  line-height: 1.7;
  color: rgba(30, 41, 59, 0.6);
  margin: 0;
}
.wc-process-timeline-card-link { display: none; }
@media (max-width: 768px) {
  .wc-process-timeline-steps::before { left: 20px; }
  .wc-process-timeline-card-icon { width: 42px; height: 42px; min-width: 42px; font-size: 0.75rem; }
}',
];
