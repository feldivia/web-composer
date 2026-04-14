<?php

declare(strict_types=1);

/**
 * Hero Minimal — Clean, maximum whitespace, elegant simplicity.
 */
return [
    'id' => 'hero-minimal',
    'name' => 'Hero Minimalista',
    'category' => 'heroes',
    'description' => 'Diseño limpio y centrado con máximo espacio en blanco, la opción más elegante',
    'icon' => '🤍',
    'placeholders' => [
        'eyebrow' => ['type' => 'text', 'label' => 'Badge superior', 'default' => 'Innovación'],
        'title' => ['type' => 'text', 'label' => 'Titulo principal', 'default' => 'Simplicidad que inspira resultados'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'inspira'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Creemos que la mejor experiencia nace de lo esencial. Menos ruido, más impacto.'],
        'cta_primary' => ['type' => 'text', 'label' => 'Boton principal', 'default' => 'Explorar'],
    ],
    'html' => '<section class="wc-hero-minimal-section">
  <div class="wc-hero-minimal-container">
    <div class="wc-hero-minimal-label">
      <span class="wc-hero-minimal-line"></span>
      <span>{{eyebrow}}</span>
    </div>
    <h1 class="wc-hero-minimal-title">{{title}}</h1>
    <p class="wc-hero-minimal-subtitle">{{subtitle}}</p>
    <a href="#" class="wc-hero-minimal-btn">{{cta_primary}}</a>
  </div>
</section>',
    'css' => '.wc-hero-minimal-section {
  padding: clamp(6rem, 12vw, 11rem) 0;
  background: var(--color-background, #FFFFFF);
  text-align: center;
}
.wc-hero-minimal-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.wc-hero-minimal-label {
  display: inline-flex;
  align-items: center;
  gap: 0.6rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 2rem;
}
.wc-hero-minimal-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-hero-minimal-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2.6rem, 5.5vw, 4.2rem);
  font-weight: 700;
  line-height: 1.12;
  color: var(--color-text, #1E293B);
  margin: 0 0 1.5rem 0;
  max-width: 650px;
}
.wc-hero-minimal-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(1rem, 1.2vw, 1.1rem);
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0 0 2.5rem 0;
  max-width: 440px;
}
.wc-hero-minimal-btn {
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
.wc-hero-minimal-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
@media (max-width: 768px) {
  .wc-hero-minimal-section { padding: clamp(4rem, 8vw, 6rem) 0; }
}
@media (max-width: 480px) {
  .wc-hero-minimal-section { padding: clamp(3rem, 6vw, 4rem) 0; }
}',
];
