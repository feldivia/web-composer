<?php

declare(strict_types=1);

/**
 * Services Cards — 3-column grid with hover effects, gradient ::before bar.
 */
return [
    'id' => 'services-cards',
    'name' => 'Servicios 3 Columnas',
    'category' => 'services',
    'description' => 'Header centrado + grid de 3 tarjetas con icono, titulo, descripción y link hover',
    'icon' => '🔧',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta de sección', 'default' => 'Nuestros servicios'],
        'title' => ['type' => 'text', 'label' => 'Titulo de sección', 'default' => 'Lo que podemos hacer por ti'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'hacer'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Ofrecemos soluciones integrales adaptadas a las necesidades de cada cliente.'],
        'features' => ['type' => 'features', 'label' => 'Servicios (3)', 'default' => [
            ['icon' => '💎', 'title' => 'Consultoría estratégica', 'description' => 'Analizamos tu situación actual y diseñamos un plan de acción personalizado para alcanzar tus objetivos.', 'link_text' => 'Consultar'],
            ['icon' => '🚀', 'title' => 'Desarrollo a medida', 'description' => 'Creamos soluciones tecnológicas adaptadas a los procesos únicos de tu empresa.', 'link_text' => 'Consultar'],
            ['icon' => '📊', 'title' => 'Optimización continua', 'description' => 'Monitoreamos y mejoramos constantemente el rendimiento de tus sistemas y procesos.', 'link_text' => 'Consultar'],
        ]],
    ],
    'html' => '<section class="wc-services-cards-section">
  <div class="wc-services-cards-container">
    <div class="wc-services-cards-header">
      <div class="wc-services-cards-label">
        <span class="wc-services-cards-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-services-cards-title">{{title}}</h2>
      <p class="wc-services-cards-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-services-cards-grid">
      {{features}}
    </div>
  </div>
</section>',
    'css' => '.wc-services-cards-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-services-cards-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-services-cards-header {
  text-align: center;
  margin-bottom: 3.5rem;
}
.wc-services-cards-label {
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
.wc-services-cards-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-services-cards-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  line-height: 1.2;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-services-cards-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-services-cards-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.8rem;
}
.wc-services-cards-card {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 16px;
  padding: 2rem;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-services-cards-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--color-primary, #6366F1), var(--color-accent, #F59E0B));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-services-cards-card:hover::before {
  transform: scaleX(1);
}
.wc-services-cards-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
}
.wc-services-cards-card-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.08);
  font-size: 1.4rem;
  margin-bottom: 1.2rem;
}
.wc-services-cards-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.15rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-services-cards-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.88rem;
  font-weight: 300;
  line-height: 1.75;
  color: #6B6B6B;
  margin: 0 0 1.2rem 0;
}
.wc-services-cards-card-link {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  font-weight: 500;
  color: var(--color-primary, #6366F1);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  transition: gap 0.3s ease;
}
.wc-services-cards-card-link:hover {
  gap: 0.6rem;
}
@media (max-width: 1024px) {
  .wc-services-cards-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .wc-services-cards-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; }
}
@media (max-width: 480px) {
  .wc-services-cards-card { padding: 1.5rem; }
}',
];
