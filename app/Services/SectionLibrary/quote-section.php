<?php

declare(strict_types=1);

/**
 * Quote Section — Dark bg, centered blockquote with radial gradient ornament.
 */
return [
    'id' => 'quote-section',
    'name' => 'Cita / Filosofía',
    'category' => 'quote',
    'description' => 'Sección oscura con cita grande centrada, nombre del autor y ornamento decorativo',
    'icon' => '💎',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Nuestra filosofía'],
        'quote' => ['type' => 'textarea', 'label' => 'Cita', 'default' => 'La verdadera innovación no consiste en hacer las cosas diferentes, sino en hacer las cosas que realmente importan de una manera extraordinaria.'],
        'author' => ['type' => 'text', 'label' => 'Autor', 'default' => 'Equipo fundador'],
    ],
    'html' => '<section class="wc-quote-section-section">
  <div class="wc-quote-section-ornament"></div>
  <div class="wc-quote-section-container">
    <div class="wc-quote-section-label">
      <span class="wc-quote-section-line"></span>
      <span>{{label}}</span>
      <span class="wc-quote-section-line"></span>
    </div>
    <blockquote class="wc-quote-section-quote">{{quote}}</blockquote>
    <cite class="wc-quote-section-author">— {{author}}</cite>
  </div>
</section>',
    'css' => '.wc-quote-section-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: linear-gradient(145deg, #0F172A, #1E293B);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.wc-quote-section-ornament {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 500px;
  height: 500px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(var(--color-accent-rgb, 245, 158, 11), 0.06) 0%, transparent 70%);
  pointer-events: none;
}
.wc-quote-section-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.wc-quote-section-label {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 2rem;
}
.wc-quote-section-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-quote-section-quote {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.2rem, 2.5vw, 1.8rem);
  font-weight: 400;
  font-style: italic;
  line-height: 1.7;
  color: rgba(255, 255, 255, 0.85);
  margin: 0 0 1.5rem 0;
  max-width: 700px;
  border: none;
  padding: 0;
}
.wc-quote-section-author {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  font-weight: 500;
  font-style: normal;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent, #F59E0B);
}
@media (max-width: 768px) {
  .wc-quote-section-ornament { width: 300px; height: 300px; }
}
@media (max-width: 480px) {
  .wc-quote-section-section { padding: clamp(3rem, 6vw, 4rem) 0; }
}',
];
