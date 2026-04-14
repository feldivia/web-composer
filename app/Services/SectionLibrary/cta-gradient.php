<?php

declare(strict_types=1);

/**
 * CTA Gradient — Full width dark gradient, centered white text, CTA button.
 */
return [
    'id' => 'cta-gradient',
    'name' => 'CTA Gradiente',
    'category' => 'cta',
    'description' => 'Sección de llamada a la acción con fondo gradiente oscuro y texto blanco centrado',
    'icon' => '🚀',
    'placeholders' => [
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => '¿Listo para dar el siguiente paso?'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Únete a cientos de empresas que ya confían en nosotros para impulsar su crecimiento.'],
        'cta_text' => ['type' => 'text', 'label' => 'Texto del botón', 'default' => 'Comenzar ahora'],
    ],
    'html' => '<section class="wc-cta-gradient-section">
  <div class="wc-cta-gradient-container">
    <h2 class="wc-cta-gradient-title">{{title}}</h2>
    <p class="wc-cta-gradient-subtitle">{{subtitle}}</p>
    <a href="#" class="wc-cta-gradient-btn">{{cta_text}}</a>
  </div>
</section>',
    'css' => '.wc-cta-gradient-section {
  padding: clamp(4rem, 8vw, 6rem) 0;
  background: linear-gradient(145deg, var(--color-primary, #6366F1), #312E81);
  text-align: center;
  position: relative;
  overflow: hidden;
}
.wc-cta-gradient-section::before {
  content: "";
  position: absolute;
  top: -50%;
  right: -20%;
  width: 500px;
  height: 500px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.03);
  pointer-events: none;
}
.wc-cta-gradient-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  position: relative;
  z-index: 1;
}
.wc-cta-gradient-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.8rem);
  font-weight: 700;
  color: #FFFFFF;
  margin: 0 0 1rem 0;
}
.wc-cta-gradient-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: clamp(0.95rem, 1.2vw, 1.05rem);
  font-weight: 300;
  line-height: 1.85;
  color: rgba(255, 255, 255, 0.6);
  max-width: 500px;
  margin: 0 auto 2rem;
}
.wc-cta-gradient-btn {
  display: inline-flex;
  align-items: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  text-decoration: none;
  color: var(--color-primary, #6366F1);
  background: #FFFFFF;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-cta-gradient-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}
@media (max-width: 480px) {
  .wc-cta-gradient-section { padding: clamp(3rem, 6vw, 4rem) 0; }
}',
];
