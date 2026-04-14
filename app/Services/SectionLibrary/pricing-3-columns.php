<?php

declare(strict_types=1);

/**
 * Pricing 3 Columns — 3 pricing cards, middle highlighted as "Popular".
 */
return [
    'id' => 'pricing-3-columns',
    'name' => 'Precios 3 Columnas',
    'category' => 'pricing',
    'description' => '3 tarjetas de precios con plan destacado, features con check/cross y CTA',
    'icon' => '💰',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Precios'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Planes para cada necesidad'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Elige el plan que mejor se adapte a tu negocio. Sin compromisos.'],
        'plans' => ['type' => 'pricing', 'label' => 'Planes (3)', 'default' => [
            [
                'name' => 'Básico',
                'price' => '$29',
                'period' => '/mes',
                'popular' => false,
                'cta' => 'Comenzar',
                'features' => [
                    ['text' => '5 proyectos', 'included' => true],
                    ['text' => '10 GB almacenamiento', 'included' => true],
                    ['text' => 'Soporte email', 'included' => true],
                    ['text' => 'Análisis básico', 'included' => true],
                    ['text' => 'API access', 'included' => false],
                    ['text' => 'Soporte prioritario', 'included' => false],
                ],
            ],
            [
                'name' => 'Profesional',
                'price' => '$79',
                'period' => '/mes',
                'popular' => true,
                'cta' => 'Elegir plan',
                'features' => [
                    ['text' => 'Proyectos ilimitados', 'included' => true],
                    ['text' => '100 GB almacenamiento', 'included' => true],
                    ['text' => 'Soporte prioritario', 'included' => true],
                    ['text' => 'Análisis avanzado', 'included' => true],
                    ['text' => 'API access', 'included' => true],
                    ['text' => 'Integraciones', 'included' => false],
                ],
            ],
            [
                'name' => 'Enterprise',
                'price' => '$199',
                'period' => '/mes',
                'popular' => false,
                'cta' => 'Contactar',
                'features' => [
                    ['text' => 'Todo ilimitado', 'included' => true],
                    ['text' => '1 TB almacenamiento', 'included' => true],
                    ['text' => 'Soporte 24/7 dedicado', 'included' => true],
                    ['text' => 'Análisis premium', 'included' => true],
                    ['text' => 'API access completo', 'included' => true],
                    ['text' => 'Integraciones custom', 'included' => true],
                ],
            ],
        ]],
    ],
    'html' => '<section class="wc-pricing-3-columns-section">
  <div class="wc-pricing-3-columns-container">
    <div class="wc-pricing-3-columns-header">
      <div class="wc-pricing-3-columns-label">
        <span class="wc-pricing-3-columns-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-pricing-3-columns-title">{{title}}</h2>
      <p class="wc-pricing-3-columns-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-pricing-3-columns-grid">
      {{plans}}
    </div>
  </div>
</section>',
    'css' => '.wc-pricing-3-columns-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-pricing-3-columns-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-pricing-3-columns-header {
  text-align: center;
  margin-bottom: 3.5rem;
}
.wc-pricing-3-columns-label {
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
.wc-pricing-3-columns-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-pricing-3-columns-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-pricing-3-columns-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-pricing-3-columns-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.8rem;
  align-items: stretch;
}
.wc-pricing-3-columns-card {
  background: #FFFFFF;
  border: 1px solid rgba(0, 0, 0, 0.06);
  border-radius: 16px;
  padding: 2.2rem;
  position: relative;
  overflow: hidden;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
  display: flex;
  flex-direction: column;
}
.wc-pricing-3-columns-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
}
.wc-pricing-3-columns-card--popular {
  border: 2px solid var(--color-accent, #F59E0B);
  transform: scale(1.04);
  z-index: 2;
  box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
}
.wc-pricing-3-columns-card--popular:hover {
  transform: scale(1.04) translateY(-5px);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}
.wc-pricing-3-columns-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: var(--color-accent, #F59E0B);
  color: #FFFFFF;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 0.3rem 0.8rem;
  border-radius: 50px;
}
.wc-pricing-3-columns-plan-name {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #999;
  margin: 0 0 0.8rem 0;
}
.wc-pricing-3-columns-price {
  display: flex;
  align-items: baseline;
  gap: 0.2rem;
  margin-bottom: 1.8rem;
}
.wc-pricing-3-columns-price-amount {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2rem, 3.5vw, 2.8rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
}
.wc-pricing-3-columns-price-period {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 400;
  color: #999;
}
.wc-pricing-3-columns-features {
  list-style: none;
  padding: 0;
  margin: 0 0 2rem 0;
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
}
.wc-pricing-3-columns-feature {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 300;
  color: #6B6B6B;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.wc-pricing-3-columns-check {
  color: #22C55E;
  font-weight: 700;
  font-size: 0.85rem;
}
.wc-pricing-3-columns-cross {
  color: #CBD5E1;
  font-weight: 700;
  font-size: 0.85rem;
}
.wc-pricing-3-columns-btn-primary {
  display: block;
  text-align: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-pricing-3-columns-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
.wc-pricing-3-columns-btn-ghost {
  display: block;
  text-align: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: var(--color-text, #1E293B);
  background: transparent;
  border: 1.5px solid rgba(0, 0, 0, 0.15);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-pricing-3-columns-btn-ghost:hover {
  border-color: var(--color-accent, #F59E0B);
  transform: translateY(-2px);
}
@media (max-width: 1024px) {
  .wc-pricing-3-columns-card--popular { transform: scale(1.02); }
  .wc-pricing-3-columns-card--popular:hover { transform: scale(1.02) translateY(-5px); }
}
@media (max-width: 768px) {
  .wc-pricing-3-columns-grid { grid-template-columns: 1fr; max-width: 380px; margin: 0 auto; }
  .wc-pricing-3-columns-card--popular { transform: none; }
  .wc-pricing-3-columns-card--popular:hover { transform: translateY(-5px); }
}
@media (max-width: 480px) {
  .wc-pricing-3-columns-card { padding: 1.5rem; }
}',
];
