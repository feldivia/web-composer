<?php

declare(strict_types=1);

/**
 * Team Grid — Equipo con fotos, nombres y roles en grid responsive.
 */
return [
    'id' => 'team-grid',
    'name' => 'Equipo',
    'category' => 'about',
    'description' => 'Grid de miembros del equipo con foto, nombre, cargo y redes sociales',
    'icon' => '👥',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Título', 'default' => 'Nuestro Equipo'],
        'subtitle' => ['type' => 'text', 'label' => 'Subtítulo', 'default' => 'Profesionales apasionados por crear soluciones excepcionales'],
        'members' => ['type' => 'features', 'label' => 'Miembros del equipo', 'default' => [
            ['icon' => '', 'title' => 'Carolina Pérez', 'description' => 'CEO & Fundadora', 'link_text' => 'https://picsum.photos/seed/team1/400/400'],
            ['icon' => '', 'title' => 'Andrés Morales', 'description' => 'Director de Tecnología', 'link_text' => 'https://picsum.photos/seed/team2/400/400'],
            ['icon' => '', 'title' => 'Valentina Rojas', 'description' => 'Diseñadora UX/UI', 'link_text' => 'https://picsum.photos/seed/team3/400/400'],
            ['icon' => '', 'title' => 'Diego Fuentes', 'description' => 'Desarrollador Senior', 'link_text' => 'https://picsum.photos/seed/team4/400/400'],
        ]],
    ],
    'html' => '<section class="wc-team-grid-section">
  <div class="wc-team-grid-container">
    <div class="wc-team-grid-header">
      <h2 class="wc-team-grid-title">{{title}}</h2>
      <p class="wc-team-grid-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-team-grid-grid">{{members}}</div>
  </div>
</section>',
    'css' => '.wc-team-grid-section {
  padding: clamp(3.5rem, 8vw, 6rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-team-grid-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-team-grid-header {
  text-align: center;
  margin-bottom: clamp(2rem, 4vw, 3.5rem);
}
.wc-team-grid-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.6rem 0;
}
.wc-team-grid-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  color: rgba(30, 41, 59, 0.55);
  margin: 0;
}
.wc-team-grid-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 2rem;
}
.wc-team-grid-card {
  text-align: center;
}
.wc-team-grid-card-icon {
  display: none;
}
.wc-team-grid-card-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  margin: 0.8rem 0 0.2rem 0;
}
.wc-team-grid-card-desc {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.8rem;
  color: rgba(30, 41, 59, 0.5);
  margin: 0;
}
.wc-team-grid-card-link {
  display: none;
}
/* Team member photo: use link_text as image URL */
.wc-team-grid-card::before {
  content: "";
  display: block;
  width: 100%;
  padding-bottom: 100%;
  background: #f1f5f9;
  border-radius: 16px;
  background-size: cover;
  background-position: center;
}
@media (max-width: 1024px) {
  .wc-team-grid-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .wc-team-grid-grid { grid-template-columns: 1fr; max-width: 280px; margin: 0 auto; }
}',
];
