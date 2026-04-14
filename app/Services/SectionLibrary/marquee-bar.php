<?php

declare(strict_types=1);

/**
 * Marquee Bar — Infinite horizontal scroll of text with dot separators.
 */
return [
    'id' => 'marquee-bar',
    'name' => 'Marquee Scroll',
    'category' => 'marquee',
    'description' => 'Barra con scroll infinito horizontal de textos con separadores de puntos',
    'icon' => '📜',
    'placeholders' => [
        'items' => ['type' => 'marquee', 'label' => 'Textos del marquee', 'default' => [
            'Innovación',
            'Calidad',
            'Compromiso',
            'Excelencia',
            'Profesionalismo',
            'Resultados',
            'Confianza',
            'Experiencia',
        ]],
    ],
    'html' => '<section class="wc-marquee-bar-section">
  <div class="wc-marquee-bar-track">
    <div class="wc-marquee-bar-content">
      {{items}}
    </div>
    <div class="wc-marquee-bar-content" aria-hidden="true">
      {{items}}
    </div>
  </div>
</section>',
    'css' => '.wc-marquee-bar-section {
  padding: 1.2rem 0;
  background: linear-gradient(145deg, #0F172A, #1E293B);
  overflow: hidden;
}
.wc-marquee-bar-track {
  display: flex;
  width: max-content;
  animation: wc-marquee-bar-scroll 30s linear infinite;
}
@keyframes wc-marquee-bar-scroll {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.wc-marquee-bar-content {
  display: flex;
  align-items: center;
  flex-shrink: 0;
}
.wc-marquee-bar-text {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(0.85rem, 1.2vw, 1rem);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: rgba(255, 255, 255, 0.6);
  white-space: nowrap;
  padding: 0 1rem;
}
.wc-marquee-bar-dot {
  color: var(--color-accent, #F59E0B);
  font-size: 0.4rem;
  padding: 0 0.5rem;
}
.wc-marquee-bar-section:hover .wc-marquee-bar-track {
  animation-play-state: paused;
}',
];
