<?php

declare(strict_types=1);

/**
 * Testimonials Grid — 3-column grid with stars, quotes, author info.
 */
return [
    'id' => 'testimonials-grid',
    'name' => 'Testimonios Grid',
    'category' => 'testimonials',
    'description' => 'Grid de 3 tarjetas de testimonios con estrellas, citas y datos del autor',
    'icon' => '⭐',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Testimonios'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Lo que dicen nuestros clientes'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'La satisfacción de nuestros clientes es nuestra mayor recompensa.'],
        'testimonials' => ['type' => 'testimonials', 'label' => 'Testimonios (3)', 'default' => [
            ['quote' => 'El servicio superó todas mis expectativas. Profesionalismo y dedicación en cada paso del proceso.', 'name' => 'Ana García', 'role' => 'CEO, TechStart', 'avatar' => 'https://picsum.photos/seed/avatar1/80/80', 'stars' => 5],
            ['quote' => 'Increíble atención al detalle y resultados que hablan por sí solos. Los recomiendo ampliamente.', 'name' => 'Carlos Mendoza', 'role' => 'Director, Innova Corp', 'avatar' => 'https://picsum.photos/seed/avatar2/80/80', 'stars' => 5],
            ['quote' => 'Transformaron nuestra visión en realidad. Un equipo comprometido que realmente entiende las necesidades del cliente.', 'name' => 'María López', 'role' => 'Fundadora, EcoVerde', 'avatar' => 'https://picsum.photos/seed/avatar3/80/80', 'stars' => 5],
        ]],
    ],
    'html' => '<section class="wc-testimonials-grid-section">
  <div class="wc-testimonials-grid-container">
    <div class="wc-testimonials-grid-header">
      <div class="wc-testimonials-grid-label">
        <span class="wc-testimonials-grid-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-testimonials-grid-title">{{title}}</h2>
      <p class="wc-testimonials-grid-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-testimonials-grid-cards">
      {{testimonials}}
    </div>
  </div>
</section>',
    'css' => '.wc-testimonials-grid-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-testimonials-grid-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-testimonials-grid-header {
  text-align: center;
  margin-bottom: 3.5rem;
}
.wc-testimonials-grid-label {
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
.wc-testimonials-grid-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-testimonials-grid-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-testimonials-grid-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-testimonials-grid-cards {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.8rem;
}
.wc-testimonials-grid-card {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 16px;
  padding: 2rem;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
  display: flex;
  flex-direction: column;
}
.wc-testimonials-grid-card::before {
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
.wc-testimonials-grid-card:hover::before { transform: scaleX(1); }
.wc-testimonials-grid-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
}
.wc-testimonials-grid-stars {
  display: flex;
  gap: 0.15rem;
  margin-bottom: 1rem;
}
.wc-testimonials-grid-star {
  color: var(--color-accent, #F59E0B);
  font-size: 0.9rem;
}
.wc-testimonials-grid-quote {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.9rem;
  font-weight: 300;
  line-height: 1.8;
  color: #6B6B6B;
  margin: 0 0 1.5rem 0;
  position: relative;
  padding-left: 1.2rem;
  border-left: 2px solid rgba(var(--color-primary-rgb, 99, 102, 241), 0.15);
  flex: 1;
}
.wc-testimonials-grid-author {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  padding-top: 1.2rem;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.wc-testimonials-grid-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  object-fit: cover;
}
.wc-testimonials-grid-name {
  display: block;
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 0.88rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
}
.wc-testimonials-grid-role {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.72rem;
  font-weight: 400;
  color: #999;
}
@media (max-width: 1024px) {
  .wc-testimonials-grid-cards { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .wc-testimonials-grid-cards { grid-template-columns: 1fr; max-width: 420px; margin: 0 auto; }
}
@media (max-width: 480px) {
  .wc-testimonials-grid-card { padding: 1.5rem; }
}',
];
