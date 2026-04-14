<?php

declare(strict_types=1);

/**
 * Hero Centered — Texto centrado con ornamentos decorativos.
 * Patrón: Full width, radial-gradient circles, credential card flotante.
 */
return [
    'id' => 'hero-centered',
    'name' => 'Hero Centrado',
    'category' => 'heroes',
    'description' => 'Texto centrado con ornamentos decorativos y credential card flotante',
    'icon' => '✨',
    'placeholders' => [
        'eyebrow' => ['type' => 'text', 'label' => 'Badge superior', 'default' => 'Experiencia y confianza'],
        'title' => ['type' => 'text', 'label' => 'Titulo principal', 'default' => 'Excelencia en cada detalle'],
        'highlight' => ['type' => 'text', 'label' => 'Palabra destacada', 'default' => 'Excelencia'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Brindamos soluciones personalizadas con los más altos estándares de calidad y profesionalismo.'],
        'cta_primary' => ['type' => 'text', 'label' => 'Boton primario', 'default' => 'Agendar cita'],
        'cta_secondary' => ['type' => 'text', 'label' => 'Boton secundario', 'default' => 'Conocer más'],
        'credential_name' => ['type' => 'text', 'label' => 'Nombre credencial', 'default' => 'Dr. María González'],
        'credential_title' => ['type' => 'text', 'label' => 'Titulo credencial', 'default' => 'Especialista certificada'],
    ],
    'html' => '<section class="wc-hero-centered-section">
  <div class="wc-hero-centered-ornament wc-hero-centered-ornament--1"></div>
  <div class="wc-hero-centered-ornament wc-hero-centered-ornament--2"></div>
  <div class="wc-hero-centered-container">
    <div class="wc-hero-centered-eyebrow">
      <span class="wc-hero-centered-line"></span>
      <span>{{eyebrow}}</span>
      <span class="wc-hero-centered-line"></span>
    </div>
    <h1 class="wc-hero-centered-title"><em>{{highlight}}</em> {{title}}</h1>
    <p class="wc-hero-centered-subtitle">{{subtitle}}</p>
    <div class="wc-hero-centered-buttons">
      <a href="#" class="wc-hero-centered-btn-primary">{{cta_primary}}</a>
      <a href="#" class="wc-hero-centered-btn-ghost">{{cta_secondary}}</a>
    </div>
    <div class="wc-hero-centered-credential">
      <div class="wc-hero-centered-credential-dot"></div>
      <div>
        <span class="wc-hero-centered-credential-name">{{credential_name}}</span>
        <span class="wc-hero-centered-credential-title">{{credential_title}}</span>
      </div>
    </div>
  </div>
</section>',
    'css' => '.wc-hero-centered-section {
  padding: clamp(5rem, 10vw, 9rem) 0;
  background: var(--color-background, #FFFFFF);
  position: relative;
  overflow: hidden;
  text-align: center;
}
.wc-hero-centered-ornament {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}
.wc-hero-centered-ornament--1 {
  width: 400px;
  height: 400px;
  top: -150px;
  right: -100px;
  background: radial-gradient(circle, rgba(var(--color-primary-rgb, 99, 102, 241), 0.06) 0%, transparent 70%);
}
.wc-hero-centered-ornament--2 {
  width: 300px;
  height: 300px;
  bottom: -80px;
  left: -60px;
  background: radial-gradient(circle, rgba(var(--color-accent-rgb, 245, 158, 11), 0.06) 0%, transparent 70%);
}
.wc-hero-centered-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.wc-hero-centered-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.65rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 3px;
  color: var(--color-accent, #F59E0B);
  margin-bottom: 1.5rem;
}
.wc-hero-centered-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-hero-centered-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(2.4rem, 5vw, 4rem);
  font-weight: 700;
  line-height: 1.15;
  color: var(--color-text, #1E293B);
  margin: 0 0 1.2rem 0;
  max-width: 700px;
}
.wc-hero-centered-title em {
  font-style: italic;
  color: var(--color-accent, #F59E0B);
}
.wc-hero-centered-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(0.95rem, 1.2vw, 1.05rem);
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0 0 2.2rem 0;
  max-width: 500px;
}
.wc-hero-centered-buttons {
  display: flex;
  gap: 1rem;
  margin-bottom: 3rem;
}
.wc-hero-centered-btn-primary {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  border: none;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-centered-btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
.wc-hero-centered-btn-ghost {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: var(--color-text, #1E293B);
  background: transparent;
  border: 1.5px solid rgba(0, 0, 0, 0.15);
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-hero-centered-btn-ghost:hover {
  border-color: var(--color-accent, #F59E0B);
  transform: translateY(-2px);
}
.wc-hero-centered-credential {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  background: #FFFFFF;
  padding: 0.8rem 1.5rem;
  border-radius: 14px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
}
.wc-hero-centered-credential-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #22C55E;
  animation: wc-hero-centered-pulse 2s ease-in-out infinite;
}
@keyframes wc-hero-centered-pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}
.wc-hero-centered-credential-name {
  display: block;
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
}
.wc-hero-centered-credential-title {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.7rem;
  color: #999;
}
@media (max-width: 768px) {
  .wc-hero-centered-buttons { flex-direction: column; align-items: center; }
  .wc-hero-centered-ornament--1 { width: 250px; height: 250px; }
  .wc-hero-centered-ornament--2 { width: 200px; height: 200px; }
}
@media (max-width: 480px) {
  .wc-hero-centered-section { padding: clamp(3rem, 8vw, 5rem) 0; }
  .wc-hero-centered-credential { flex-direction: column; text-align: center; }
}',
];
