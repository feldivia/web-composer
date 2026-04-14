<?php

declare(strict_types=1);

/**
 * Video Embed — Sección con video de YouTube/Vimeo embebido con texto.
 */
return [
    'id' => 'video-embed',
    'name' => 'Video',
    'category' => 'gallery',
    'description' => 'Sección con video embebido de YouTube o Vimeo, título y descripción',
    'icon' => '🎬',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Conoce nuestra historia'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Descripción', 'default' => 'Descubre cómo trabajamos y por qué miles de clientes confían en nosotros para transformar sus ideas en realidad.'],
        'video_url' => ['type' => 'text', 'label' => 'URL de video (YouTube embed)', 'default' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'],
    ],
    'html' => '<section class="wc-video-embed-section">
  <div class="wc-video-embed-container">
    <div class="wc-video-embed-header">
      <h2 class="wc-video-embed-title">{{title}}</h2>
      <p class="wc-video-embed-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-video-embed-wrapper">
      <iframe src="{{video_url}}" class="wc-video-embed-iframe" frameborder="0" allowfullscreen loading="lazy"></iframe>
    </div>
  </div>
</section>',
    'css' => '.wc-video-embed-section {
  padding: clamp(3.5rem, 8vw, 6rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-video-embed-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-video-embed-header {
  text-align: center;
  margin-bottom: clamp(1.5rem, 3vw, 2.5rem);
}
.wc-video-embed-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-video-embed-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  line-height: 1.7;
  color: rgba(30, 41, 59, 0.55);
  margin: 0;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}
.wc-video-embed-wrapper {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}
.wc-video-embed-iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: none;
  border-radius: 16px;
}',
];
