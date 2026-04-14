<?php

declare(strict_types=1);

/**
 * Contact Split — 2 columns: contact details left, form right.
 */
return [
    'id' => 'contact-split',
    'name' => 'Contacto Dividido',
    'category' => 'contact',
    'description' => 'Datos de contacto a la izquierda con iconos, formulario estilizado a la derecha',
    'icon' => '📧',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'Contacto'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Hablemos de tu proyecto'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Estamos listos para ayudarte a dar el siguiente paso.'],
        'address' => ['type' => 'text', 'label' => 'Dirección', 'default' => 'Av. Principal 1234, Santiago, Chile'],
        'phone' => ['type' => 'text', 'label' => 'Teléfono', 'default' => '+56 9 1234 5678'],
        'email' => ['type' => 'text', 'label' => 'Email', 'default' => 'contacto@ejemplo.com'],
        'hours' => ['type' => 'text', 'label' => 'Horario', 'default' => 'Lun - Vie: 9:00 - 18:00'],
        'btn_text' => ['type' => 'text', 'label' => 'Texto botón', 'default' => 'Enviar mensaje'],
    ],
    'html' => '<section class="wc-contact-split-section">
  <div class="wc-contact-split-container">
    <div class="wc-contact-split-info">
      <div class="wc-contact-split-label">
        <span class="wc-contact-split-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-contact-split-title">{{title}}</h2>
      <p class="wc-contact-split-subtitle">{{subtitle}}</p>
      <div class="wc-contact-split-details">
        <div class="wc-contact-split-detail">
          <div class="wc-contact-split-detail-icon">&#9906;</div>
          <div>
            <span class="wc-contact-split-detail-label">Dirección</span>
            <span class="wc-contact-split-detail-value">{{address}}</span>
          </div>
        </div>
        <div class="wc-contact-split-detail">
          <div class="wc-contact-split-detail-icon">&#9742;</div>
          <div>
            <span class="wc-contact-split-detail-label">Teléfono</span>
            <span class="wc-contact-split-detail-value">{{phone}}</span>
          </div>
        </div>
        <div class="wc-contact-split-detail">
          <div class="wc-contact-split-detail-icon">&#9993;</div>
          <div>
            <span class="wc-contact-split-detail-label">Email</span>
            <span class="wc-contact-split-detail-value">{{email}}</span>
          </div>
        </div>
        <div class="wc-contact-split-detail">
          <div class="wc-contact-split-detail-icon">&#9200;</div>
          <div>
            <span class="wc-contact-split-detail-label">Horario</span>
            <span class="wc-contact-split-detail-value">{{hours}}</span>
          </div>
        </div>
      </div>
    </div>
    <div class="wc-contact-split-form-wrap">
      <form class="wc-contact-split-form">
        <div class="wc-contact-split-form-row">
          <div class="wc-contact-split-field">
            <label class="wc-contact-split-form-label">Nombre</label>
            <input type="text" class="wc-contact-split-input" placeholder="Tu nombre">
          </div>
          <div class="wc-contact-split-field">
            <label class="wc-contact-split-form-label">Email</label>
            <input type="email" class="wc-contact-split-input" placeholder="tu@email.com">
          </div>
        </div>
        <div class="wc-contact-split-field">
          <label class="wc-contact-split-form-label">Asunto</label>
          <input type="text" class="wc-contact-split-input" placeholder="¿En qué podemos ayudarte?">
        </div>
        <div class="wc-contact-split-field">
          <label class="wc-contact-split-form-label">Mensaje</label>
          <textarea class="wc-contact-split-textarea" rows="4" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
        </div>
        <button type="submit" class="wc-contact-split-btn">{{btn_text}}</button>
      </form>
    </div>
  </div>
</section>',
    'css' => '.wc-contact-split-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-contact-split-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 3.5rem;
  align-items: start;
}
.wc-contact-split-label {
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
.wc-contact-split-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-contact-split-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.6rem, 3vw, 2.2rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-contact-split-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.92rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0 0 2rem 0;
}
.wc-contact-split-details {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}
.wc-contact-split-detail {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  border-radius: 12px;
  border: 1px solid rgba(0, 0, 0, 0.04);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-contact-split-detail:hover {
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.03);
  border-color: rgba(var(--color-primary-rgb, 99, 102, 241), 0.1);
}
.wc-contact-split-detail-icon {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(var(--color-primary-rgb, 99, 102, 241), 0.08);
  font-size: 1.1rem;
  color: var(--color-primary, #6366F1);
}
.wc-contact-split-detail-label {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #999;
  margin-bottom: 0.1rem;
}
.wc-contact-split-detail-value {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.88rem;
  font-weight: 400;
  color: var(--color-text, #1E293B);
}
.wc-contact-split-form-wrap {
  background: #FFFFFF;
  border-radius: 16px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  padding: 2.2rem;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
}
.wc-contact-split-form { display: flex; flex-direction: column; gap: 1.2rem; }
.wc-contact-split-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
.wc-contact-split-form-label {
  display: block;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: #999;
  margin-bottom: 0.4rem;
}
.wc-contact-split-input,
.wc-contact-split-textarea {
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
.wc-contact-split-input:focus,
.wc-contact-split-textarea:focus {
  border-color: var(--color-primary, #6366F1);
  box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 99, 102, 241), 0.1);
}
.wc-contact-split-textarea { resize: vertical; min-height: 100px; }
.wc-contact-split-btn {
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
  align-self: flex-start;
}
.wc-contact-split-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(99, 102, 241, 0.35);
}
@media (max-width: 768px) {
  .wc-contact-split-container { grid-template-columns: 1fr; }
  .wc-contact-split-form-row { grid-template-columns: 1fr; }
}
@media (max-width: 480px) {
  .wc-contact-split-form-wrap { padding: 1.5rem; }
  .wc-contact-split-btn { width: 100%; }
}',
];
