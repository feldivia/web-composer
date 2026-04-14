<?php

declare(strict_types=1);

/**
 * Testimonials Featured — Single large testimonial centered with decorative quotes.
 */
return [
    'id' => 'testimonials-featured',
    'name' => 'Testimonio Destacado',
    'category' => 'testimonials',
    'description' => 'Un testimonio grande y centrado con comillas decorativas y datos del autor',
    'icon' => '💬',
    'placeholders' => [
        'quote' => ['type' => 'textarea', 'label' => 'Cita', 'default' => 'Trabajar con este equipo fue una experiencia transformadora. Su dedicación, profesionalismo y visión estratégica superaron con creces nuestras expectativas. No solo entregaron un resultado excepcional, sino que nos acompañaron en cada paso del camino.'],
        'name' => ['type' => 'text', 'label' => 'Nombre', 'default' => 'Roberto Sánchez'],
        'role' => ['type' => 'text', 'label' => 'Cargo', 'default' => 'Director General, Grupo Innovar'],
        'avatar' => ['type' => 'image', 'label' => 'Avatar', 'default' => 'https://picsum.photos/seed/featured/100/100'],
    ],
    'html' => '<section class="wc-testimonials-featured-section">
  <div class="wc-testimonials-featured-container">
    <div class="wc-testimonials-featured-quote-mark">&ldquo;</div>
    <blockquote class="wc-testimonials-featured-quote">{{quote}}</blockquote>
    <div class="wc-testimonials-featured-author">
      <img src="{{avatar}}" alt="{{name}}" class="wc-testimonials-featured-avatar">
      <div>
        <span class="wc-testimonials-featured-name">{{name}}</span>
        <span class="wc-testimonials-featured-role">{{role}}</span>
      </div>
    </div>
  </div>
</section>',
    'css' => '.wc-testimonials-featured-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
  text-align: center;
}
.wc-testimonials-featured-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.wc-testimonials-featured-quote-mark {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(4rem, 8vw, 6rem);
  line-height: 1;
  color: var(--color-accent, #F59E0B);
  opacity: 0.3;
  margin-bottom: -1rem;
}
.wc-testimonials-featured-quote {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.1rem, 2vw, 1.5rem);
  font-weight: 400;
  font-style: italic;
  line-height: 1.7;
  color: var(--color-text, #1E293B);
  margin: 0 0 2rem 0;
  max-width: 650px;
  border: none;
  padding: 0;
}
.wc-testimonials-featured-author {
  display: flex;
  align-items: center;
  gap: 1rem;
}
.wc-testimonials-featured-avatar {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid rgba(var(--color-accent-rgb, 245, 158, 11), 0.3);
}
.wc-testimonials-featured-name {
  display: block;
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 0.95rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
}
.wc-testimonials-featured-role {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.78rem;
  font-weight: 400;
  color: #999;
}
@media (max-width: 768px) {
  .wc-testimonials-featured-quote { font-size: clamp(1rem, 1.5vw, 1.2rem); }
}
@media (max-width: 480px) {
  .wc-testimonials-featured-section { padding: clamp(3rem, 6vw, 4rem) 0; }
  .wc-testimonials-featured-author { flex-direction: column; text-align: center; }
}',
];
