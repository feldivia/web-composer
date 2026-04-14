<?php

declare(strict_types=1);

/**
 * Hero Split — Titulo + CTAs a la izquierda, imagen a la derecha.
 * Patrón: 2 columnas (1.1fr 1fr), eyebrow badge animado, stats row.
 */
return [
    'id' => 'hero-split',
    'name' => 'Hero con Imagen',
    'category' => 'heroes',
    'description' => 'Titulo grande + subtitulo + CTAs a la izquierda, imagen a la derecha',
    'icon' => '🎯',
    'placeholders' => [
        'eyebrow' => ['type' => 'text', 'label' => 'Badge superior', 'default' => 'Bienvenido'],
        'title' => ['type' => 'text', 'label' => 'Titulo principal', 'default' => 'Soluciones que transforman tu negocio'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'transforman'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Ofrecemos servicios profesionales de alta calidad diseñados para impulsar el crecimiento y la innovación de tu empresa.'],
        'cta_primary' => ['type' => 'text', 'label' => 'Boton primario', 'default' => 'Comenzar ahora'],
        'cta_secondary' => ['type' => 'text', 'label' => 'Boton secundario', 'default' => 'Saber más'],
        'image_1' => ['type' => 'image', 'label' => 'Imagen principal', 'default' => 'https://picsum.photos/seed/herosplit/800/700'],
        'stats' => ['type' => 'stats', 'label' => 'Estadisticas', 'default' => [
            ['number' => '500+', 'label' => 'Clientes'],
            ['number' => '15', 'label' => 'Años'],
            ['number' => '98%', 'label' => 'Satisfacción'],
        ]],
    ],
    'html' => '<section class="wc-hero-split-section">
  <div class="wc-hero-split-container">
    <div class="wc-hero-split-content">
      <div class="wc-hero-split-eyebrow">
        <span class="wc-hero-split-dot"></span>
        <span>{{eyebrow}}</span>
      </div>
      <h1 class="wc-hero-split-title">{{title}}</h1>
      <p class="wc-hero-split-subtitle">{{subtitle}}</p>
      <div class="wc-hero-split-buttons">
        <a href="#" class="wc-hero-split-btn-primary">{{cta_primary}}</a>
        <a href="#" class="wc-hero-split-btn-ghost">{{cta_secondary}}</a>
      </div>
      <div class="wc-hero-split-stats">
        {{stats}}
      </div>
    </div>
    <div class="wc-hero-split-visual">
      <img src="{{image_1}}" alt="Hero" class="wc-hero-split-image" loading="eager">
    </div>
  </div>
</section>',
    'css' => '.wc-hero-split-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
  overflow: hidden;
  position: relative;
}
.wc-hero-split-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: grid;
  grid-template-columns: 1.1fr 1fr;
  gap: 3rem;
  align-items: center;
}
.wc-hero-split-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: rgba(var(--color-accent-rgb, 245, 158, 11), 0.12);
  padding: 0.45rem 1.1rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 1.2rem;
}
.wc-hero-split-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--color-accent, #F59E0B);
  animation: wc-hero-split-pulse 2s ease-in-out infinite;
}
@keyframes wc-hero-split-pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.5; transform: scale(1.4); }
}
.wc-hero-split-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2.2rem, 4.5vw, 3.6rem);
  font-weight: 700;
  line-height: 1.15;
  color: var(--color-text, #1E293B);
  margin: 0 0 1.2rem 0;
}
.wc-hero-split-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(0.95rem, 1.2vw, 1.05rem);
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0 0 2rem 0;
  max-width: 480px;
}
.wc-hero-split-buttons {
  display: flex;
  gap: 1rem;
  margin-bottom: 2.5rem;
}
.wc-hero-split-btn-primary {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  border: none;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-split-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
.wc-hero-split-btn-ghost {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: var(--color-text, #1E293B);
  background: transparent;
  border: 1.5px solid rgba(0, 0, 0, 0.15);
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-split-btn-ghost:hover {
  border-color: var(--color-accent, #F59E0B);
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}
.wc-hero-split-stats {
  display: flex;
  gap: 2rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(0, 0, 0, 0.08);
}
.wc-hero-split-stat-item {
  display: flex;
  flex-direction: column;
}
.wc-hero-split-stat-number {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1.6rem;
  font-weight: 700;
  color: var(--color-primary, #6366F1);
}
.wc-hero-split-stat-label {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.7rem;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #999;
  margin-top: 0.2rem;
}
.wc-hero-split-visual {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}
.wc-hero-split-visual::before {
  content: "";
  position: absolute;
  top: -20px;
  right: -20px;
  width: 70%;
  height: 70%;
  background: linear-gradient(135deg, var(--color-primary, #6366F1), var(--color-secondary, #0EA5E9));
  border-radius: 20px;
  opacity: 0.08;
  z-index: 0;
}
.wc-hero-split-image {
  width: 100%;
  height: auto;
  max-height: 550px;
  object-fit: cover;
  border-radius: 16px;
  position: relative;
  z-index: 1;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}
@media (max-width: 1024px) {
  .wc-hero-split-container {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
  .wc-hero-split-title { font-size: clamp(1.8rem, 3.5vw, 2.6rem); }
}
@media (max-width: 768px) {
  .wc-hero-split-container {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .wc-hero-split-subtitle { max-width: 100%; }
  .wc-hero-split-buttons { justify-content: center; }
  .wc-hero-split-stats { justify-content: center; }
  .wc-hero-split-visual { order: -1; }
  .wc-hero-split-eyebrow { margin-left: auto; margin-right: auto; }
}
@media (max-width: 480px) {
  .wc-hero-split-section { padding: clamp(2.5rem, 6vw, 4rem) 0; }
  .wc-hero-split-buttons { flex-direction: column; }
  .wc-hero-split-stats { flex-direction: column; gap: 1rem; align-items: center; }
}',
];
