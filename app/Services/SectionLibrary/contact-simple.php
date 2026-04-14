<?php

declare(strict_types=1);

/**
 * Contact Simple — Centered minimal form.
 */
return [
    'id' => 'contact-simple',
    'name' => 'Contacto Simple',
    'category' => 'contact',
    'description' => 'Formulario de contacto centrado y minimalista con nombre, email y mensaje',
    'icon' => '✉️',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Contacto'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Envíanos un mensaje'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Completa el formulario y te responderemos a la brevedad.'],
        'btn_text' => ['type' => 'text', 'label' => 'Texto botón', 'default' => 'Enviar'],
    ],
    'html' => '<section class="wc-contact-simple-section">
  <div class="wc-contact-simple-container">
    <div class="wc-contact-simple-header">
      <div class="wc-contact-simple-label">
        <span class="wc-contact-simple-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-contact-simple-title">{{title}}</h2>
      <p class="wc-contact-simple-subtitle">{{subtitle}}</p>
    </div>
    <form class="wc-contact-simple-form" data-contact-form>
      <div class="wc-contact-simple-field">
        <label class="wc-contact-simple-form-label" for="cf-name">Nombre</label>
        <input type="text" name="name" id="cf-name" class="wc-contact-simple-input" placeholder="Tu nombre completo" required>
      </div>
      <div class="wc-contact-simple-field">
        <label class="wc-contact-simple-form-label" for="cf-email">Email</label>
        <input type="email" name="email" id="cf-email" class="wc-contact-simple-input" placeholder="tu@email.com" required>
      </div>
      <div class="wc-contact-simple-field">
        <label class="wc-contact-simple-form-label" for="cf-message">Mensaje</label>
        <textarea name="message" id="cf-message" class="wc-contact-simple-textarea" rows="5" placeholder="¿En qué podemos ayudarte?" required></textarea>
      </div>
      <button type="submit" class="wc-contact-simple-btn">{{btn_text}}</button>
    </form>
  </div>
</section>',
    'css' => '.wc-contact-simple-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-contact-simple-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-contact-simple-header {
  text-align: center;
  margin-bottom: 2.5rem;
}
.wc-contact-simple-label {
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
.wc-contact-simple-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-contact-simple-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-contact-simple-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 450px;
  margin: 0 auto;
}
.wc-contact-simple-form {
  max-width: 600px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}
.wc-contact-simple-form-label {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #999;
  margin-bottom: 0.4rem;
}
.wc-contact-simple-input,
.wc-contact-simple-textarea {
  width: 100%;
  padding: 0.85rem 1rem;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 10px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.88rem;
  font-weight: 300;
  color: var(--color-text, #1E293B);
  background: var(--color-background, #FFFFFF);
  transition: all 0.3s ease;
  outline: none;
  box-sizing: border-box;
}
.wc-contact-simple-input:focus,
.wc-contact-simple-textarea:focus {
  border-color: var(--color-primary, #6366F1);
  box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 99, 102, 241), 0.1);
}
.wc-contact-simple-textarea { resize: vertical; min-height: 120px; }
.wc-contact-simple-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.9rem 2.4rem;
  border-radius: 50px;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 500;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  border: none;
  cursor: pointer;
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
  align-self: center;
}
.wc-contact-simple-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
@media (max-width: 480px) {
  .wc-contact-simple-btn { width: 100%; }
}',
];
