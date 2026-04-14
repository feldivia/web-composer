<?php

declare(strict_types=1);

/**
 * About Split — Image left with decorative border, text + credentials right.
 */
return [
    'id' => 'about-split',
    'name' => 'Acerca de - Dividido',
    'category' => 'about',
    'description' => 'Imagen con borde decorativo a la izquierda, texto con credenciales a la derecha',
    'icon' => '👤',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Sobre nosotros'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Una historia de compromiso y excelencia'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'compromiso'],
        'paragraph_1' => ['type' => 'textarea', 'label' => 'Párrafo 1', 'default' => 'Desde nuestros inicios, nos hemos dedicado a ofrecer soluciones que realmente transforman la vida de nuestros clientes. Cada proyecto es una oportunidad para demostrar nuestro compromiso con la calidad.'],
        'paragraph_2' => ['type' => 'textarea', 'label' => 'Párrafo 2', 'default' => 'Nuestro equipo está formado por profesionales apasionados que combinan experiencia técnica con un profundo entendimiento de las necesidades del mercado.'],
        'image_1' => ['type' => 'image', 'label' => 'Imagen', 'default' => 'https://picsum.photos/seed/about/500/600'],
        'credentials' => ['type' => 'features', 'label' => 'Credenciales', 'default' => [
            ['icon' => '🎓', 'title' => 'Certificación internacional', 'description' => 'Avalados por instituciones de prestigio global.'],
            ['icon' => '🏆', 'title' => '+15 años de experiencia', 'description' => 'Trayectoria sólida en el mercado local e internacional.'],
            ['icon' => '⭐', 'title' => 'Premio a la excelencia 2025', 'description' => 'Reconocidos por nuestra calidad de servicio.'],
        ]],
    ],
    'html' => '<section class="wc-about-split-section">
  <div class="wc-about-split-container">
    <div class="wc-about-split-image-wrap">
      <img src="{{image_1}}" alt="Sobre nosotros" class="wc-about-split-image" loading="lazy">
    </div>
    <div class="wc-about-split-content">
      <div class="wc-about-split-label">
        <span class="wc-about-split-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-about-split-title">Una historia de <em>{{highlight}}</em> y excelencia</h2>
      <p class="wc-about-split-text">{{paragraph_1}}</p>
      <p class="wc-about-split-text">{{paragraph_2}}</p>
      <div class="wc-about-split-credentials">
        {{credentials}}
      </div>
    </div>
  </div>
</section>',
    'css' => '.wc-about-split-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-about-split-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: grid;
  grid-template-columns: 0.8fr 1.2fr;
  gap: 3.5rem;
  align-items: center;
}
.wc-about-split-image-wrap {
  position: relative;
}
.wc-about-split-image-wrap::after {
  content: "";
  position: absolute;
  inset: 15px;
  border: 2px solid var(--color-accent, #F59E0B);
  border-radius: 16px;
  pointer-events: none;
  z-index: 1;
}
.wc-about-split-image {
  width: 100%;
  height: auto;
  border-radius: 16px;
  display: block;
  position: relative;
  z-index: 2;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
}
.wc-about-split-content {
  display: flex;
  flex-direction: column;
}
.wc-about-split-label {
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
.wc-about-split-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-about-split-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  line-height: 1.2;
  color: var(--color-text, #1E293B);
  margin: 0 0 1.2rem 0;
}
.wc-about-split-title em {
  font-style: italic;
  color: var(--color-accent, #F59E0B);
}
.wc-about-split-text {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.92rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0 0 1rem 0;
}
.wc-about-split-credentials {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.wc-about-split-card {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.wc-about-split-card-icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.08);
  font-size: 1rem;
}
.wc-about-split-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.15rem 0;
}
.wc-about-split-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.78rem;
  font-weight: 300;
  color: #6B6B6B;
  margin: 0;
}
.wc-about-split-card-link { display: none; }
@media (max-width: 1024px) {
  .wc-about-split-container { grid-template-columns: 1fr 1fr; gap: 2.5rem; }
}
@media (max-width: 768px) {
  .wc-about-split-container { grid-template-columns: 1fr; }
  .wc-about-split-image-wrap { max-width: 400px; margin: 0 auto; }
}
@media (max-width: 480px) {
  .wc-about-split-image-wrap::after { inset: 8px; }
}',
];
