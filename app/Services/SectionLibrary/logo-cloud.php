<?php

declare(strict_types=1);

/**
 * Logo Cloud — Logos de clientes o partners en fila con efecto grayscale hover.
 */
return [
    'id' => 'logo-cloud',
    'name' => 'Logos de Clientes',
    'category' => 'trust',
    'description' => 'Fila de logos de clientes o partners con efecto grayscale y hover a color',
    'icon' => '🏢',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Empresas que confían en nosotros'],
        'logos' => ['type' => 'gallery', 'label' => 'Logos (6-8 recomendado)', 'default' => [
            ['image' => 'https://picsum.photos/seed/logo1/200/80', 'title' => 'Empresa 1', 'category' => ''],
            ['image' => 'https://picsum.photos/seed/logo2/200/80', 'title' => 'Empresa 2', 'category' => ''],
            ['image' => 'https://picsum.photos/seed/logo3/200/80', 'title' => 'Empresa 3', 'category' => ''],
            ['image' => 'https://picsum.photos/seed/logo4/200/80', 'title' => 'Empresa 4', 'category' => ''],
            ['image' => 'https://picsum.photos/seed/logo5/200/80', 'title' => 'Empresa 5', 'category' => ''],
            ['image' => 'https://picsum.photos/seed/logo6/200/80', 'title' => 'Empresa 6', 'category' => ''],
        ]],
    ],
    'html' => '<section class="wc-logo-cloud-section">
  <div class="wc-logo-cloud-container">
    <p class="wc-logo-cloud-title">{{title}}</p>
    <div class="wc-logo-cloud-grid">{{logos}}</div>
  </div>
</section>',
    'css' => '.wc-logo-cloud-section {
  padding: clamp(2.5rem, 5vw, 4rem) 0;
  background: var(--color-background, #FFFFFF);
  border-top: 1px solid rgba(0,0,0,0.04);
  border-bottom: 1px solid rgba(0,0,0,0.04);
}
.wc-logo-cloud-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  text-align: center;
}
.wc-logo-cloud-title {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: rgba(30, 41, 59, 0.4);
  margin: 0 0 2rem 0;
}
.wc-logo-cloud-grid {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;
  gap: clamp(1.5rem, 4vw, 3rem);
}
.wc-logo-cloud-item {
  position: relative;
}
.wc-logo-cloud-img {
  height: 36px;
  width: auto;
  max-width: 140px;
  object-fit: contain;
  filter: grayscale(100%) opacity(0.4);
  transition: all 0.4s ease;
}
.wc-logo-cloud-img:hover {
  filter: grayscale(0%) opacity(1);
  transform: scale(1.05);
}
@media (max-width: 768px) {
  .wc-logo-cloud-grid { gap: 1.5rem; }
  .wc-logo-cloud-img { height: 28px; max-width: 100px; }
}',
];
