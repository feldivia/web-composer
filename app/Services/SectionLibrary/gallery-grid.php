<?php

declare(strict_types=1);

/**
 * Gallery Grid — 3-column grid, hover overlay sliding up.
 */
return [
    'id' => 'gallery-grid',
    'name' => 'Galería Grid',
    'category' => 'gallery',
    'description' => 'Grid de 6 imágenes con overlay al hover que sube con título y categoría',
    'icon' => '🖼️',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Portfolio'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Nuestros trabajos recientes'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Una selección de proyectos que demuestran nuestra experiencia y creatividad.'],
        'gallery' => ['type' => 'gallery', 'label' => 'Imágenes (6)', 'default' => [
            ['image' => 'https://picsum.photos/seed/gal1/600/600', 'title' => 'Proyecto Alpha', 'category' => 'Diseño'],
            ['image' => 'https://picsum.photos/seed/gal2/600/600', 'title' => 'Proyecto Beta', 'category' => 'Desarrollo'],
            ['image' => 'https://picsum.photos/seed/gal3/600/600', 'title' => 'Proyecto Gamma', 'category' => 'Branding'],
            ['image' => 'https://picsum.photos/seed/gal4/600/600', 'title' => 'Proyecto Delta', 'category' => 'Marketing'],
            ['image' => 'https://picsum.photos/seed/gal5/600/600', 'title' => 'Proyecto Epsilon', 'category' => 'Diseño'],
            ['image' => 'https://picsum.photos/seed/gal6/600/600', 'title' => 'Proyecto Zeta', 'category' => 'Desarrollo'],
        ]],
    ],
    'html' => '<section class="wc-gallery-grid-section">
  <div class="wc-gallery-grid-container">
    <div class="wc-gallery-grid-header">
      <div class="wc-gallery-grid-label">
        <span class="wc-gallery-grid-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-gallery-grid-title">{{title}}</h2>
      <p class="wc-gallery-grid-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-gallery-grid-items">
      {{gallery}}
    </div>
  </div>
</section>',
    'css' => '.wc-gallery-grid-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-gallery-grid-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-gallery-grid-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-gallery-grid-label {
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
.wc-gallery-grid-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-gallery-grid-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-gallery-grid-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-gallery-grid-items {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.2rem;
}
.wc-gallery-grid-item {
  position: relative;
  border-radius: 14px;
  overflow: hidden;
  aspect-ratio: 1;
  cursor: pointer;
}
.wc-gallery-grid-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-gallery-grid-item:hover .wc-gallery-grid-img {
  transform: scale(1.05);
}
.wc-gallery-grid-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1.5rem;
  background: linear-gradient(transparent, rgba(15, 23, 42, 0.85));
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  transform: translateY(100%);
  transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-gallery-grid-item:hover .wc-gallery-grid-overlay {
  transform: translateY(0);
}
.wc-gallery-grid-item-cat {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 0.3rem;
}
.wc-gallery-grid-item-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1rem;
  font-weight: 600;
  color: #FFFFFF;
}
@media (max-width: 768px) {
  .wc-gallery-grid-items { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .wc-gallery-grid-items { grid-template-columns: 1fr; max-width: 350px; margin: 0 auto; }
}',
];
