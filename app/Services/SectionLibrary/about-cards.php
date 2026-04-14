<?php

declare(strict_types=1);

/**
 * About Cards — 3 overlapping cards with 3D perspective, stats, creative layout.
 */
return [
    'id' => 'about-cards',
    'name' => 'Acerca de - Tarjetas',
    'category' => 'about',
    'description' => '3 tarjetas superpuestas con perspectiva 3D, estadísticas e iconos',
    'icon' => '🃏',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Nuestra historia'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Construyendo el futuro desde la experiencia'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Tres pilares que definen nuestra forma de trabajar y nos distinguen en el mercado.'],
        'card_1_icon' => ['type' => 'text', 'label' => 'Icono tarjeta 1', 'default' => '🎯'],
        'card_1_title' => ['type' => 'text', 'label' => 'Titulo tarjeta 1', 'default' => 'Misión'],
        'card_1_desc' => ['type' => 'textarea', 'label' => 'Descripción tarjeta 1', 'default' => 'Transformar ideas en soluciones reales que generen impacto positivo y duradero.'],
        'card_1_stat' => ['type' => 'text', 'label' => 'Stat tarjeta 1', 'default' => '500+'],
        'card_1_stat_label' => ['type' => 'text', 'label' => 'Label stat 1', 'default' => 'Proyectos'],
        'card_2_icon' => ['type' => 'text', 'label' => 'Icono tarjeta 2', 'default' => '💡'],
        'card_2_title' => ['type' => 'text', 'label' => 'Titulo tarjeta 2', 'default' => 'Visión'],
        'card_2_desc' => ['type' => 'textarea', 'label' => 'Descripción tarjeta 2', 'default' => 'Ser referentes en innovación y calidad, liderando la transformación en nuestro sector.'],
        'card_2_stat' => ['type' => 'text', 'label' => 'Stat tarjeta 2', 'default' => '15'],
        'card_2_stat_label' => ['type' => 'text', 'label' => 'Label stat 2', 'default' => 'Años'],
        'card_3_icon' => ['type' => 'text', 'label' => 'Icono tarjeta 3', 'default' => '🤝'],
        'card_3_title' => ['type' => 'text', 'label' => 'Titulo tarjeta 3', 'default' => 'Valores'],
        'card_3_desc' => ['type' => 'textarea', 'label' => 'Descripción tarjeta 3', 'default' => 'Integridad, innovación y compromiso guían cada decisión que tomamos.'],
        'card_3_stat' => ['type' => 'text', 'label' => 'Stat tarjeta 3', 'default' => '98%'],
        'card_3_stat_label' => ['type' => 'text', 'label' => 'Label stat 3', 'default' => 'Satisfacción'],
    ],
    'html' => '<section class="wc-about-cards-section">
  <div class="wc-about-cards-container">
    <div class="wc-about-cards-header">
      <div class="wc-about-cards-label">
        <span class="wc-about-cards-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-about-cards-title">{{title}}</h2>
      <p class="wc-about-cards-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-about-cards-grid">
      <div class="wc-about-cards-card wc-about-cards-card--1">
        <span class="wc-about-cards-icon">{{card_1_icon}}</span>
        <h3 class="wc-about-cards-card-title">{{card_1_title}}</h3>
        <p class="wc-about-cards-card-desc">{{card_1_desc}}</p>
        <div class="wc-about-cards-card-stat">
          <span class="wc-about-cards-stat-num">{{card_1_stat}}</span>
          <span class="wc-about-cards-stat-label">{{card_1_stat_label}}</span>
        </div>
      </div>
      <div class="wc-about-cards-card wc-about-cards-card--2">
        <span class="wc-about-cards-icon">{{card_2_icon}}</span>
        <h3 class="wc-about-cards-card-title">{{card_2_title}}</h3>
        <p class="wc-about-cards-card-desc">{{card_2_desc}}</p>
        <div class="wc-about-cards-card-stat">
          <span class="wc-about-cards-stat-num">{{card_2_stat}}</span>
          <span class="wc-about-cards-stat-label">{{card_2_stat_label}}</span>
        </div>
      </div>
      <div class="wc-about-cards-card wc-about-cards-card--3">
        <span class="wc-about-cards-icon">{{card_3_icon}}</span>
        <h3 class="wc-about-cards-card-title">{{card_3_title}}</h3>
        <p class="wc-about-cards-card-desc">{{card_3_desc}}</p>
        <div class="wc-about-cards-card-stat">
          <span class="wc-about-cards-stat-num">{{card_3_stat}}</span>
          <span class="wc-about-cards-stat-label">{{card_3_stat_label}}</span>
        </div>
      </div>
    </div>
  </div>
</section>',
    'css' => '.wc-about-cards-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-about-cards-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-about-cards-header {
  text-align: center;
  margin-bottom: 3.5rem;
}
.wc-about-cards-label {
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
.wc-about-cards-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-about-cards-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-about-cards-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-about-cards-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.8rem;
  perspective: 1000px;
}
.wc-about-cards-card {
  border-radius: 16px;
  padding: 2rem;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
  display: flex;
  flex-direction: column;
}
.wc-about-cards-card--1 {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  transform: rotateY(2deg);
}
.wc-about-cards-card--2 {
  background: linear-gradient(145deg, #0F172A, #1E293B);
  color: #FFFFFF;
  transform: translateY(-10px) scale(1.03);
  z-index: 2;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
}
.wc-about-cards-card--3 {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  transform: rotateY(-2deg);
}
.wc-about-cards-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}
.wc-about-cards-card--2:hover {
  transform: translateY(-15px) scale(1.04);
}
.wc-about-cards-card::before {
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
.wc-about-cards-card:hover::before { transform: scaleX(1); }
.wc-about-cards-icon {
  font-size: 1.8rem;
  margin-bottom: 1rem;
}
.wc-about-cards-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.15rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-about-cards-card--2 .wc-about-cards-card-title { color: #FFFFFF; }
.wc-about-cards-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 300;
  line-height: 1.75;
  color: #6B6B6B;
  margin: 0 0 1.5rem 0;
  flex: 1;
}
.wc-about-cards-card--2 .wc-about-cards-card-desc { color: rgba(255, 255, 255, 0.6); }
.wc-about-cards-card-stat {
  display: flex;
  align-items: baseline;
  gap: 0.4rem;
  padding-top: 1rem;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.wc-about-cards-card--2 .wc-about-cards-card-stat { border-top-color: rgba(255, 255, 255, 0.1); }
.wc-about-cards-stat-num {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.8rem;
  font-weight: 700;
  color: var(--color-accent, #F59E0B);
}
.wc-about-cards-stat-label {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #999;
}
.wc-about-cards-card--2 .wc-about-cards-stat-label { color: rgba(255, 255, 255, 0.4); }
@media (max-width: 1024px) {
  .wc-about-cards-card--1, .wc-about-cards-card--3 { transform: none; }
  .wc-about-cards-card--2 { transform: translateY(-5px) scale(1.01); }
}
@media (max-width: 768px) {
  .wc-about-cards-grid { grid-template-columns: 1fr; max-width: 400px; margin: 0 auto; perspective: none; }
  .wc-about-cards-card--2 { transform: none; }
}
@media (max-width: 480px) {
  .wc-about-cards-card { padding: 1.5rem; }
}',
];
