<?php

declare(strict_types=1);

/**
 * FAQ Accordion — Collapsible questions with rotating arrow, max-height animation.
 */
return [
    'id' => 'faq-accordion',
    'name' => 'Preguntas Frecuentes',
    'category' => 'faq',
    'description' => 'Acordeón de preguntas frecuentes con animación de apertura y flecha rotativa',
    'icon' => '❓',
    'placeholders' => [
        'label' => ['type' => 'text', 'label' => 'Etiqueta', 'default' => 'FAQ'],
        'title' => ['type' => 'text', 'label' => 'Titulo', 'default' => 'Preguntas frecuentes'],
        'subtitle' => ['type' => 'textarea', 'label' => 'Subtitulo', 'default' => 'Resolvemos las dudas más comunes de nuestros clientes.'],
        'faq' => ['type' => 'faq', 'label' => 'Preguntas (5)', 'default' => [
            ['question' => '¿Cuáles son los tiempos de entrega?', 'answer' => 'Los tiempos varían según el proyecto, pero generalmente entregamos en 2-4 semanas para proyectos estándar y 6-12 semanas para proyectos complejos.'],
            ['question' => '¿Ofrecen garantía en sus servicios?', 'answer' => 'Sí, todos nuestros servicios incluyen garantía de satisfacción. Si no estás conforme con el resultado, trabajamos hasta que lo estés sin costo adicional.'],
            ['question' => '¿Cómo es el proceso de trabajo?', 'answer' => 'Comenzamos con una consulta gratuita para entender tus necesidades. Luego presentamos una propuesta detallada, y una vez aprobada, trabajamos en sprints con entregas parciales y feedback continuo.'],
            ['question' => '¿Puedo cancelar en cualquier momento?', 'answer' => 'Sí, no tenemos contratos de permanencia. Puedes cancelar cuando quieras con un aviso de 30 días.'],
            ['question' => '¿Ofrecen soporte post-entrega?', 'answer' => 'Absolutamente. Incluimos 3 meses de soporte gratuito post-entrega y ofrecemos planes de mantenimiento a largo plazo.'],
        ]],
    ],
    'html' => '<section class="wc-faq-accordion-section">
  <div class="wc-faq-accordion-container">
    <div class="wc-faq-accordion-header">
      <div class="wc-faq-accordion-label">
        <span class="wc-faq-accordion-line"></span>
        <span>{{label}}</span>
      </div>
      <h2 class="wc-faq-accordion-title">{{title}}</h2>
      <p class="wc-faq-accordion-subtitle">{{subtitle}}</p>
    </div>
    <div class="wc-faq-accordion-items">
      {{faq}}
    </div>
  </div>
</section>',
    'css' => '.wc-faq-accordion-section {
  padding: clamp(4rem, 8vw, 7rem) 0;
  background: var(--color-background, #FFFFFF);
}
.wc-faq-accordion-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 8%;
}
.wc-faq-accordion-header {
  text-align: center;
  margin-bottom: 3rem;
}
.wc-faq-accordion-label {
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
.wc-faq-accordion-line {
  display: block;
  width: 30px;
  height: 2px;
  background: var(--color-accent, #F59E0B);
}
.wc-faq-accordion-title {
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: clamp(1.8rem, 3.5vw, 2.6rem);
  font-weight: 700;
  color: var(--color-text, #1E293B);
  margin: 0 0 0.8rem 0;
}
.wc-faq-accordion-subtitle {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  max-width: 500px;
  margin: 0 auto;
}
.wc-faq-accordion-items {
  max-width: 750px;
  margin: 0 auto;
}
.wc-faq-accordion-item {
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}
.wc-faq-accordion-question {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  padding: 1.3rem 0;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  font-family: var(--font-heading, "Playfair Display", serif);
  font-size: 1rem;
  font-weight: 600;
  color: var(--color-text, #1E293B);
  transition: color 0.3s ease;
  gap: 1rem;
}
.wc-faq-accordion-question:hover {
  color: var(--color-primary, #6366F1);
}
.wc-faq-accordion-arrow {
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  border: 1.5px solid rgba(0, 0, 0, 0.1);
  transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-faq-accordion-arrow::before {
  content: "";
  display: block;
  width: 7px;
  height: 7px;
  border-right: 1.5px solid var(--color-text, #1E293B);
  border-bottom: 1.5px solid var(--color-text, #1E293B);
  transform: rotate(45deg);
  margin-top: -2px;
  transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-faq-accordion-item--open .wc-faq-accordion-arrow {
  background: var(--color-primary, #6366F1);
  border-color: var(--color-primary, #6366F1);
}
.wc-faq-accordion-item--open .wc-faq-accordion-arrow::before {
  border-color: #FFFFFF;
  transform: rotate(-135deg);
  margin-top: 2px;
}
.wc-faq-accordion-answer {
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.4s cubic-bezier(0.22, 1, 0.36, 1), padding 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}
.wc-faq-accordion-item--open .wc-faq-accordion-answer {
  max-height: 300px;
  padding-bottom: 1.3rem;
}
.wc-faq-accordion-answer p {
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.9rem;
  font-weight: 300;
  line-height: 1.85;
  color: #6B6B6B;
  margin: 0;
}
@media (max-width: 768px) {
  .wc-faq-accordion-items { max-width: 100%; }
}
@media (max-width: 480px) {
  .wc-faq-accordion-question { font-size: 0.92rem; padding: 1rem 0; }
}',
];
