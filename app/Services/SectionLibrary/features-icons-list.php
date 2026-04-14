<?php

declare(strict_types=1);

/**
 * Features Icons List — Vertical list of features with icon + text.
 */
return [
    'id' => 'features-icons-list',
    'name' => 'Features Lista Vertical',
    'category' => 'services',
    'description' => 'Lista vertical de 5 features con icono circular, titulo y descripción',
    'icon' => '📋',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Ventajas'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Por qué elegirnos'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Cada detalle importa cuando se trata de calidad.'],
        'features' => ['type' => 'features', 'label' => 'Features (5)', 'default' => [
            ['icon' => '✓', 'title' => 'Atención personalizada', 'description' => 'Cada proyecto recibe dedicación individual y seguimiento constante.'],
            ['icon' => '✓', 'title' => 'Equipo experto', 'description' => 'Profesionales certificados con años de experiencia en su campo.'],
            ['icon' => '✓', 'title' => 'Resultados medibles', 'description' => 'Entregamos métricas claras para que veas el impacto real.'],
            ['icon' => '✓', 'title' => 'Soporte continuo', 'description' => 'Acompañamiento post-proyecto para asegurar el éxito a largo plazo.'],
            ['icon' => '✓', 'title' => 'Precios transparentes', 'description' => 'Sin costos ocultos ni sorpresas. Presupuestos claros desde el inicio.'],
        ]],
    ],
    'html' => '<section class="wc-features-icons-list-section">
  <div class="wc-features-icons-list-container">
    <div class="wc-features-icons-list-header">
      <div class="wc-features-icons-list-label">
        <span class="wc-features-icons-list-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-features-icons-list-title">{{title}}</h2>
      <p class="wc-features-icons-list-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-features-icons-list-items">
      {{features}}
    </div>
  </div>
</section>',
    'css' => '.wc-features-icons-list-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-features-icons-list-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-features-icons-list-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-features-icons-list-label {
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
.wc-features-icons-list-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-features-icons-list-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-features-icons-list-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 480px;
  margin: 0 auto;
}
.wc-features-icons-list-items {
  max-width: 650px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}
.wc-features-icons-list-card {
  display: flex;
  align-items: flex-start;
  gap: 1.2rem;
  padding: 1.4rem;
  border-radius: 14px;
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-features-icons-list-card:hover {
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.03);
  border-color: rgba(var(--color-primary-rgb, 99, 102, 241), 0.1);
  transform: translateX(5px);
}
.wc-features-icons-list-card-icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.08);
  font-size: 1rem;
  color: var(--color-primary, #6366F1);
  font-weight: 700;
}
.wc-features-icons-list-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.02rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.3rem 0;
}
.wc-features-icons-list-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 300;
  line-height: 1.7;
  color: #6B6B6B;
  margin: 0;
}
.wc-features-icons-list-card-link {
  display: none;
}
@media (max-width: 768px) {
  .wc-features-icons-list-items { max-width: 100%; }
}
@media (max-width: 480px) {
  .wc-features-icons-list-card { flex-direction: column; text-align: center; align-items: center; }
}',
];
