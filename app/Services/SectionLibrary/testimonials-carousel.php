<?php

declare(strict_types=1);

/**
 * Testimonials Carousel — Carrusel de testimonios con autoplay, dots y flechas.
 */
return [
    'id' => 'testimonials-carousel',
    'name' => 'Testimonios Carrusel',
    'category' => 'testimonials',
    'description' => 'Carrusel rotativo de testimonios con navegación, autoplay y transición suave',
    'icon' => '🔄',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Lo que dicen nuestros clientes'],
        'subtitle' => ['type' => 'text', 'label' => 'Subtítulo', 'default' => 'Historias reales de quienes confían en nosotros'],
        'testimonials' => ['type' => 'testimonials', 'label' => 'Testimonios', 'default' => [
            ['quote' => 'Transformaron completamente nuestra presencia digital. El resultado superó todas nuestras expectativas y los plazos se cumplieron al pie de la letra.', 'name' => 'Carolina Mendez', 'role' => 'Directora de Marketing, TechCorp', 'avatar' => 'https://picsum.photos/seed/t1/80/80', 'stars' => 5],
            ['quote' => 'Profesionalismo excepcional. Entendieron nuestra visión desde el primer día y la ejecutaron con una calidad impresionante.', 'name' => 'Roberto Fuentes', 'role' => 'CEO, InnovaGroup', 'avatar' => 'https://picsum.photos/seed/t2/80/80', 'stars' => 5],
            ['quote' => 'El mejor equipo con el que hemos trabajado. Comunicación fluida, entregas puntuales y un producto final que habla por sí solo.', 'name' => 'Andrea Villanueva', 'role' => 'Fundadora, DesignStudio', 'avatar' => 'https://picsum.photos/seed/t3/80/80', 'stars' => 5],
            ['quote' => 'Incrementamos nuestras conversiones en un 180% gracias al rediseño. La inversión se pagó sola en el primer trimestre.', 'name' => 'Miguel Contreras', 'role' => 'Gerente Comercial, SalesForce Chile', 'avatar' => 'https://picsum.photos/seed/t4/80/80', 'stars' => 5],
            ['quote' => 'Atención personalizada y resultados medibles. Recomiendo sus servicios sin dudarlo.', 'name' => 'Valentina Rojas', 'role' => 'Directora, Clínica Bienestar', 'avatar' => 'https://picsum.photos/seed/t5/80/80', 'stars' => 5],
        ]],
    ],
    'html' => '<section class="wc-testimonials-carousel-section">
  <div class="wc-testimonials-carousel-container">
    <div class="wc-testimonials-carousel-header">
      <h2 class="wc-testimonials-carousel-title">{{title}}</h2>
      <p class="wc-testimonials-carousel-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-testimonials-carousel-slider" data-carousel data-carousel-autoplay="5000" data-carousel-dots="true" data-carousel-arrows="true">
      {{testimonials}}
    </div>
  </div>
</section>',
    'css' => '.wc-testimonials-carousel-section {
  padding: clamp(3.5rem, 8vw, 6rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-testimonials-carousel-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-testimonials-carousel-header {
  text-align: center;
  margin-bottom: clamp(2rem, 4vw, 3rem);
}
.wc-testimonials-carousel-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-testimonials-carousel-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  color: rgba(30, 41, 59, 0.55);
  margin: 0;
}
.wc-testimonials-carousel-slider {
  position: relative;
}
.wc-testimonials-carousel-card {
  text-align: center;
  padding: 2rem 1.5rem;
}
.wc-testimonials-carousel-stars {
  display: flex;
  justify-content: center;
  gap: 3px;
  margin-bottom: 1.2rem;
}
.wc-testimonials-carousel-star {
  color: #F59E0B;
  font-size: 1rem;
}
.wc-testimonials-carousel-quote {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 1.05rem;
  font-weight: 400;
  line-height: 1.8;
  color: var(--color-text, #1E293B);
  font-style: italic;
  margin: 0 0 1.5rem 0;
  position: relative;
}
.wc-testimonials-carousel-quote::before {
  content: "\201C";
  font-size: 3rem;
  color: var(--color-primary, #6366F1);
  opacity: 0.2;
  position: absolute;
  top: -1rem;
  left: -0.5rem;
  font-family: Georgia, serif;
}
.wc-testimonials-carousel-author {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.8rem;
}
.wc-testimonials-carousel-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid rgba(99, 102, 241, 0.15);
}
.wc-testimonials-carousel-name {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  display: block;
}
.wc-testimonials-carousel-role {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.75rem;
  color: rgba(30, 41, 59, 0.5);
  display: block;
}
@media (max-width: 768px) {
  .wc-testimonials-carousel-card { padding: 1rem 0.5rem; }
}',
];
