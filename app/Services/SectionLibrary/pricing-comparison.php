<?php

declare(strict_types=1);

/**
 * Pricing Comparison — Table with feature rows, check/cross marks.
 */
return [
    'id' => 'pricing-comparison',
    'name' => 'Comparación de Planes',
    'category' => 'pricing',
    'description' => 'Tabla comparativa de planes con filas de features y marcas de check/cross',
    'icon' => '📋',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Comparar planes'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Encuentra el plan perfecto'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Compara las características de cada plan para tomar la mejor decisión.'],
        'plan_1_name' => ['type' => 'text', 'label' => 'Plan 1', 'default' => 'Básico'],
        'plan_2_name' => ['type' => 'text', 'label' => 'Plan 2', 'default' => 'Pro'],
        'plan_3_name' => ['type' => 'text', 'label' => 'Plan 3', 'default' => 'Enterprise'],
        'feature_1' => ['type' => 'text', 'label' => 'Feature 1', 'default' => 'Usuarios ilimitados'],
        'feature_2' => ['type' => 'text', 'label' => 'Feature 2', 'default' => 'Almacenamiento cloud'],
        'feature_3' => ['type' => 'text', 'label' => 'Feature 3', 'default' => 'Soporte prioritario'],
        'feature_4' => ['type' => 'text', 'label' => 'Feature 4', 'default' => 'API access'],
        'feature_5' => ['type' => 'text', 'label' => 'Feature 5', 'default' => 'Integraciones custom'],
        'feature_6' => ['type' => 'text', 'label' => 'Feature 6', 'default' => 'SLA garantizado'],
    ],
    'html' => '<section class="wc-pricing-comparison-section">
  <div class="wc-pricing-comparison-container">
    <div class="wc-pricing-comparison-header">
      <div class="wc-pricing-comparison-label">
        <span class="wc-pricing-comparison-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-pricing-comparison-title">{{title}}</h2>
      <p class="wc-pricing-comparison-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-pricing-comparison-table-wrap">
      <table class="wc-pricing-comparison-table">
        <thead>
          <tr>
            <th class="wc-pricing-comparison-th-feature">Característica</th>
            <th>{{plan_1_name}}</th>
            <th class="wc-pricing-comparison-th-highlight">{{plan_2_name}}</th>
            <th>{{plan_3_name}}</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{feature_1}}</td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
          <tr>
            <td>{{feature_2}}</td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
          <tr>
            <td>{{feature_3}}</td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
          <tr>
            <td>{{feature_4}}</td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
          <tr>
            <td>{{feature_5}}</td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
          <tr>
            <td>{{feature_6}}</td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-cross">&#10007;</span></td>
            <td><span class="wc-pricing-comparison-check">&#10003;</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>',
    'css' => '.wc-pricing-comparison-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-pricing-comparison-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-pricing-comparison-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-pricing-comparison-label {
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
.wc-pricing-comparison-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-pricing-comparison-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-pricing-comparison-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-pricing-comparison-table-wrap {
  overflow-x: auto;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
}
.wc-pricing-comparison-table {
  width: 100%;
  border-collapse: collapse;
  font-family: var(--font-body, "Inter", sans-serif);
}
.wc-pricing-comparison-table thead tr {
  background: linear-gradient(145deg, #0F172A, #1E293B);
}
.wc-pricing-comparison-table th {
  padding: 1.2rem 1.5rem;
  font-size: 0.82rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: rgba(255, 255, 255, 0.8);
  text-align: center;
}
.wc-pricing-comparison-th-feature {
  text-align: left !important;
  color: rgba(255, 255, 255, 0.5) !important;
}
.wc-pricing-comparison-th-highlight {
  background: rgba(var(--color-accent-rgb, 245, 158, 11), 0.15) !important;
  color: var(--color-accent, #F59E0B) !important;
}
.wc-pricing-comparison-table td {
  padding: 1rem 1.5rem;
  font-size: 0.88rem;
  font-weight: 300;
  color: #6B6B6B;
  text-align: center;
  border-bottom: 1px solid rgba(0, 0, 0, 0.04);
}
.wc-pricing-comparison-table td:first-child {
  text-align: left;
  font-weight: 400;
  color: var(--color-text, #1E293B);
}
.wc-pricing-comparison-table tbody tr:hover {
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.02);
}
.wc-pricing-comparison-check {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(34, 197, 94, 0.1);
  color: #22C55E;
  font-size: 0.75rem;
  font-weight: 700;
}
.wc-pricing-comparison-cross {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(203, 213, 225, 0.2);
  color: #CBD5E1;
  font-size: 0.75rem;
  font-weight: 700;
}
@media (max-width: 768px) {
  .wc-pricing-comparison-table th,
  .wc-pricing-comparison-table td { padding: 0.8rem 0.6rem; font-size: 0.78rem; }
}
@media (max-width: 480px) {
  .wc-pricing-comparison-table-wrap { margin: 0 -4%; }
}',
];
