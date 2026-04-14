<?php

declare(strict_types=1);

/**
 * Hero Dark — Full dark background, white text, dot pattern CSS.
 */
return [
    'id' => 'hero-dark',
    'name' => 'Hero Oscuro',
    'category' => 'heroes',
    'description' => 'Fondo oscuro con gradiente, texto blanco y patrón decorativo sutil',
    'icon' => '🌑',
    'placeholders' => [
        'eyebrow' => ['type' => 'text', 'label' => 'Badge superior', 'default' => 'Premium'],
        'title' => ['type' => 'text', 'label' => 'Titulo principal', 'default' => 'La excelencia no es un acto, es un hábito'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'excelencia'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Llevamos más de una década creando experiencias excepcionales que marcan la diferencia.'],
        'cta_primary' => ['type' => 'text', 'label' => 'Boton primario', 'default' => 'Descubrir'],
        'cta_secondary' => ['type' => 'text', 'label' => 'Boton secundario', 'default' => 'Contactar'],
    ],
    'html' => '<section class="wc-hero-dark-section">
  <div class="wc-hero-dark-pattern"></div>
  <div class="wc-hero-dark-container">
    <div class="wc-hero-dark-eyebrow">
      <span class="wc-hero-dark-line"></span>
      <span>{{eyebrow}}</span>
      <span class="wc-hero-dark-line"></span>
    </div>
    <h1 class="wc-hero-dark-title">La <em>{{highlight}}</em> no es un acto, es un hábito</h1>
    <p class="wc-hero-dark-subtitle">{{subtitle}}</p>
    <div class="wc-hero-dark-buttons">
      <a href="#" class="wc-hero-dark-btn-primary">{{cta_primary}}</a>
      <a href="#" class="wc-hero-dark-btn-ghost">{{cta_secondary}}</a>
    </div>
  </div>
</section>',
    'css' => '.wc-hero-dark-section {
  padding: clamp(5rem, 10vw, 9rem) 0;
  background: linear-gradient(145deg, #0F172A 0%, #1E293B 50%, #0F172A 100%);
  position: relative;
  overflow: hidden;
  text-align: center;
}
.wc-hero-dark-pattern {
  position: absolute;
  inset: 0;
  background-image: radial-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px);
  background-size: 24px 24px;
  pointer-events: none;
}
.wc-hero-dark-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.wc-hero-dark-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 1.5rem;
}
.wc-hero-dark-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-hero-dark-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2.4rem, 5vw, 4rem);
  font-weight: 700;
  line-height: 1.15;
  color: #FFFFFF;
  margin: 0 0 1.2rem 0;
  max-width: 700px;
}
.wc-hero-dark-title em {
  font-style: italic;
  color: var(--color-accent, #F59E0B);
}
.wc-hero-dark-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(0.95rem, 1.2vw, 1.05rem);
  font-weight: 300;
  line-height: 1.85;
  color: rgba(255, 255, 255, 0.55);
  margin: 0 0 2.5rem 0;
  max-width: 500px;
}
.wc-hero-dark-buttons {
  display: flex;
  gap: 1rem;
}
.wc-hero-dark-btn-primary {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #0F172A;
  background: #FFFFFF;
  border: none;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-dark-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
}
.wc-hero-dark-btn-ghost {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #FFFFFF;
  background: transparent;
  border: 1.5px solid rgba(255, 255, 255, 0.2);
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-dark-btn-ghost:hover {
  border-color: var(--color-accent, #F59E0B);
  transform: translateY(-2px);
}
@media (max-width: 768px) {
  .wc-hero-dark-buttons { flex-direction: column; align-items: center; }
}
@media (max-width: 480px) {
  .wc-hero-dark-section { padding: clamp(3rem, 8vw, 5rem) 0; }
}',
];
