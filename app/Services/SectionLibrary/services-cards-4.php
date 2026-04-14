<?php

declare(strict_types=1);

/**
 * Services Cards 4 — 4-column grid, more compact cards.
 */
return [
    'id' => 'services-cards-4',
    'name' => 'Servicios 4 Columnas',
    'category' => 'services',
    'description' => 'Grid de 4 tarjetas compactas con icono, titulo y descripción',
    'icon' => '🔲',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta de sección', 'default' => 'Servicios'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Soluciones completas para tu negocio'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Cubrimos todas las áreas clave para impulsar tu crecimiento.'],
        'features' => ['type' => 'features', 'label' => 'Servicios (4)', 'default' => [
            ['icon' => '⚡', 'title' => 'Rendimiento', 'description' => 'Optimización avanzada para máxima velocidad y eficiencia.', 'link_text' => 'Ver más'],
            ['icon' => '🛡️', 'title' => 'Seguridad', 'description' => 'Protección integral de datos y sistemas críticos.', 'link_text' => 'Ver más'],
            ['icon' => '📱', 'title' => 'Mobile', 'description' => 'Experiencias adaptadas a todos los dispositivos.', 'link_text' => 'Ver más'],
            ['icon' => '🔗', 'title' => 'Integración', 'description' => 'Conexión fluida con tus herramientas existentes.', 'link_text' => 'Ver más'],
        ]],
    ],
    'html' => '<section class="wc-services-cards-4-section">
  <div class="wc-services-cards-4-container">
    <div class="wc-services-cards-4-header">
      <div class="wc-services-cards-4-label">
        <span class="wc-services-cards-4-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-services-cards-4-title">{{title}}</h2>
      <p class="wc-services-cards-4-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-services-cards-4-grid">
      {{features}}
    </div>
  </div>
</section>',
    'css' => '.wc-services-cards-4-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-services-cards-4-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-services-cards-4-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-services-cards-4-label {
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
.wc-services-cards-4-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-services-cards-4-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  line-height: 1.2;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-services-cards-4-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-services-cards-4-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.4rem;
}
.wc-services-cards-4-card {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 14px;
  padding: 1.6rem;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-services-cards-4-card::before {
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
.wc-services-cards-4-card:hover::before { transform: scaleX(1); }
.wc-services-cards-4-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
}
.wc-services-cards-4-card-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 46px;
  height: 46px;
  border-radius: 12px;
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.08);
  font-size: 1.2rem;
  margin-bottom: 1rem;
}
.wc-services-cards-4-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.02rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.5rem 0;
}
.wc-services-cards-4-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  font-weight: 300;
  line-height: 1.7;
  color: #6B6B6B;
  margin: 0 0 1rem 0;
}
.wc-services-cards-4-card-link {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.78rem;
  font-weight: 500;
  color: var(--color-primary, #6366F1);
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  transition: gap 0.3s ease;
}
.wc-services-cards-4-card-link:hover { gap: 0.6rem; }
@media (max-width: 1024px) {
  .wc-services-cards-4-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .wc-services-cards-4-grid { grid-template-columns: 1fr; max-width: 380px; margin: 0 auto; }
}
@media (max-width: 480px) {
  .wc-services-cards-4-card { padding: 1.3rem; }
}',
];
