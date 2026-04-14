<?php

declare(strict_types=1);

/**
 * Blog Preview — Grid de últimos posts del blog.
 */
return [
    'id' => 'blog-preview',
    'name' => 'Blog / Artículos',
    'category' => 'cta',
    'description' => 'Preview de últimos artículos del blog con imagen, categoría, título y extracto',
    'icon' => '📰',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Últimas Publicaciones'],
        'subtitle' => ['type' => 'text', 'label' => 'Subtítulo', 'default' => 'Artículos, noticias y consejos para tu negocio'],
        'posts' => ['type' => 'features', 'label' => 'Artículos', 'default' => [
            ['icon' => 'Marketing', 'title' => '10 estrategias de marketing digital para 2026', 'description' => 'Descubre las tendencias que están transformando el marketing digital y cómo aplicarlas en tu negocio.', 'link_text' => 'Leer más'],
            ['icon' => 'Diseño', 'title' => 'Claves del diseño web minimalista', 'description' => 'El minimalismo no es solo una tendencia, es una filosofía que mejora la experiencia del usuario.', 'link_text' => 'Leer más'],
            ['icon' => 'Negocios', 'title' => 'Cómo aumentar conversiones en tu web', 'description' => 'Optimizaciones simples que pueden incrementar tus conversiones hasta un 150% sin cambiar tu producto.', 'link_text' => 'Leer más'],
        ]],
    ],
    'html' => '<section class="wc-blog-preview-section">
  <div class="wc-blog-preview-container">
    <div class="wc-blog-preview-header">
      <div>
        <h2 class="wc-blog-preview-title">{{title}}</h2>
        <p class="wc-blog-preview-subtitle">{{subtitle}}</p>
      </div>
      <a href="/blog" class="wc-blog-preview-viewall">Ver todos &rarr;</a>
    </div>
    <div class="wc-blog-preview-grid">{{posts}}</div>
  </div>
</section>',
    'css' => '.wc-blog-preview-section {
  padding: clamp(3.5rem, 8vw, 6rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-blog-preview-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-blog-preview-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: clamp(2rem, 4vw, 3rem);
  gap: 1rem;
}
.wc-blog-preview-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.3rem 0;
}
.wc-blog-preview-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.9rem;
  color: rgba(30, 41, 59, 0.55);
  margin: 0;
}
.wc-blog-preview-viewall {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--color-primary, #6366F1);
  text-decoration: none;
  white-space: nowrap;
  transition: opacity 0.2s;
}
.wc-blog-preview-viewall:hover { opacity: 0.7; }
.wc-blog-preview-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}
.wc-blog-preview-card {
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  border: 1px solid rgba(0,0,0,0.06);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.wc-blog-preview-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.wc-blog-preview-card-icon {
  display: inline-block;
  padding: 6px 12px;
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--color-primary, #6366F1);
  background: rgba(99, 102, 241, 0.08);
  border-radius: 6px;
  margin-bottom: 0.6rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.wc-blog-preview-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.5rem 0;
  line-height: 1.4;
}
.wc-blog-preview-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.82rem;
  line-height: 1.6;
  color: rgba(30, 41, 59, 0.6);
  margin: 0 0 0.8rem 0;
}
.wc-blog-preview-card-link {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--color-primary, #6366F1);
  text-decoration: none;
}
.wc-blog-preview-card-link span { transition: margin-left 0.2s; }
.wc-blog-preview-card:hover .wc-blog-preview-card-link span { margin-left: 4px; }
/* Cards have padding since no image */
.wc-blog-preview-card { padding: 1.5rem; }
@media (max-width: 768px) {
  .wc-blog-preview-grid { grid-template-columns: 1fr; }
  .wc-blog-preview-header { flex-direction: column; align-items: flex-start; }
}',
];
