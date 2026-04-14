<?php

declare(strict_types=1);

/**
 * Navbar Modern — Barra de navegación responsive con sticky, glassmorphism y hamburger animado.
 */
return [
    'id' => 'navbar-modern',
    'name' => 'Navbar Moderno',
    'category' => 'navbar',
    'description' => 'Barra de navegación fija con efecto glass al hacer scroll, menú hamburguesa animado y botón CTA',
    'icon' => '🧭',
    'placeholders' => [
        'brand_name' => ['type' => 'text', 'label' => 'Nombre de marca', 'default' => 'MiSitio'],
        'nav_links' => ['type' => 'links', 'label' => 'Links de navegación', 'default' => [
            ['text' => 'Inicio', 'url' => '#'],
            ['text' => 'Servicios', 'url' => '#servicios'],
            ['text' => 'Nosotros', 'url' => '#nosotros'],
            ['text' => 'Portafolio', 'url' => '#portafolio'],
            ['text' => 'Blog', 'url' => '/blog'],
        ]],
        'cta_text' => ['type' => 'text', 'label' => 'Texto del botón CTA', 'default' => 'Contáctanos'],
        'cta_url' => ['type' => 'text', 'label' => 'URL del botón CTA', 'default' => '#contacto'],
    ],
    'html' => '<nav class="wc-navbar-modern" data-sticky data-sticky-class="wc-navbar-modern--scrolled">
  <div class="wc-navbar-modern-container">
    <!-- Logo / Brand -->
    <a href="/" class="wc-navbar-modern-brand">
      <span class="wc-navbar-modern-brand-icon">
        <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
          <rect width="28" height="28" rx="8" fill="var(--color-primary, #6366F1)"/>
          <path d="M8 14l4 4 8-8" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
      <span class="wc-navbar-modern-brand-text">{{brand_name}}</span>
    </a>

    <!-- Desktop Nav -->
    <ul class="wc-navbar-modern-nav">{{nav_links}}</ul>

    <!-- CTA Button -->
    <a href="{{cta_url}}" class="wc-navbar-modern-cta">{{cta_text}}</a>

    <!-- Hamburger -->
    <button class="wc-navbar-modern-hamburger" data-menu-toggle aria-label="Abrir menú" aria-expanded="false">
      <span class="wc-navbar-modern-hamburger-line"></span>
      <span class="wc-navbar-modern-hamburger-line"></span>
      <span class="wc-navbar-modern-hamburger-line"></span>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div class="wc-navbar-modern-mobile hidden" data-mobile-menu>
    <ul class="wc-navbar-modern-mobile-nav">{{nav_links}}</ul>
    <a href="{{cta_url}}" class="wc-navbar-modern-mobile-cta">{{cta_text}}</a>
  </div>
</nav>',
    'css' => '/* === Navbar Modern === */
.wc-navbar-modern {
  position: relative;
  width: 100%;
  z-index: 1000;
  padding: 0;
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  background: var(--color-background, #FFFFFF);
}

/* Sticky / Scrolled state */
.wc-navbar-modern.wc-navbar-modern--scrolled {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.88);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 4px 24px rgba(0, 0, 0, 0.06);
}

.wc-navbar-modern-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 6%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 72px;
  gap: 2rem;
}

/* Brand */
.wc-navbar-modern-brand {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  text-decoration: none;
  flex-shrink: 0;
}
.wc-navbar-modern-brand-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s ease;
}
.wc-navbar-modern-brand:hover .wc-navbar-modern-brand-icon {
  transform: scale(1.08);
}
.wc-navbar-modern-brand-text {
  font-family: var(--font-heading, "Inter", sans-serif);
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--color-text, #1E293B);
  letter-spacing: -0.02em;
}

/* Desktop Nav Links */
.wc-navbar-modern-nav {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  list-style: none;
  padding: 0;
  margin: 0;
}
.wc-navbar-modern-nav li {
  padding: 0;
  margin: 0;
}
.wc-navbar-modern-nav .wc-navbar-modern-link {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 0.9rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.875rem;
  font-weight: 500;
  color: var(--color-text, #1E293B);
  text-decoration: none;
  border-radius: 8px;
  transition: color 0.25s ease, background-color 0.25s ease;
  position: relative;
}
.wc-navbar-modern-nav .wc-navbar-modern-link:hover {
  color: var(--color-primary, #6366F1);
  background: rgba(99, 102, 241, 0.06);
}
.wc-navbar-modern-nav .wc-navbar-modern-link::after {
  content: "";
  position: absolute;
  bottom: 4px;
  left: 50%;
  width: 0;
  height: 2px;
  background: var(--color-primary, #6366F1);
  transition: width 0.3s ease, left 0.3s ease;
  border-radius: 1px;
}
.wc-navbar-modern-nav .wc-navbar-modern-link:hover::after {
  width: 40%;
  left: 30%;
}

/* CTA Button */
.wc-navbar-modern-cta {
  display: inline-flex;
  align-items: center;
  padding: 0.6rem 1.4rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 2px 8px rgba(99, 102, 241, 0.25);
  flex-shrink: 0;
}
.wc-navbar-modern-cta:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
  filter: brightness(1.08);
}
.wc-navbar-modern-cta:active {
  transform: translateY(0);
}

/* Hamburger */
.wc-navbar-modern-hamburger {
  display: none;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 44px;
  height: 44px;
  padding: 0;
  border: none;
  background: transparent;
  cursor: pointer;
  gap: 5px;
  border-radius: 10px;
  transition: background-color 0.25s ease;
  flex-shrink: 0;
}
.wc-navbar-modern-hamburger:hover {
  background: rgba(0, 0, 0, 0.04);
}
.wc-navbar-modern-hamburger-line {
  display: block;
  width: 22px;
  height: 2px;
  background: var(--color-text, #1E293B);
  border-radius: 2px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  transform-origin: center;
}
/* Hamburger animated to X when open */
.wc-navbar-modern-hamburger[aria-expanded="true"] .wc-navbar-modern-hamburger-line:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
.wc-navbar-modern-hamburger[aria-expanded="true"] .wc-navbar-modern-hamburger-line:nth-child(2) {
  opacity: 0;
  transform: scaleX(0);
}
.wc-navbar-modern-hamburger[aria-expanded="true"] .wc-navbar-modern-hamburger-line:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}

/* Mobile Menu */
.wc-navbar-modern-mobile {
  overflow: hidden;
  max-height: 0;
  opacity: 0;
  transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, padding 0.3s ease;
  padding: 0 6%;
  background: var(--color-background, #FFFFFF);
  border-top: 1px solid rgba(0, 0, 0, 0.04);
}
.wc-navbar-modern-mobile:not(.hidden) {
  max-height: 500px;
  opacity: 1;
  padding: 1.2rem 6% 1.5rem;
}
.wc-navbar-modern--scrolled .wc-navbar-modern-mobile {
  background: rgba(255, 255, 255, 0.96);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
}
.wc-navbar-modern-mobile-nav {
  list-style: none;
  padding: 0;
  margin: 0 0 1rem 0;
  display: flex;
  flex-direction: column;
  gap: 0.15rem;
}
.wc-navbar-modern-mobile-nav li {
  padding: 0;
  margin: 0;
}
.wc-navbar-modern-mobile-nav .wc-navbar-modern-link {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 500;
  color: var(--color-text, #1E293B);
  text-decoration: none;
  border-radius: 10px;
  transition: color 0.25s ease, background-color 0.25s ease;
}
.wc-navbar-modern-mobile-nav .wc-navbar-modern-link:hover {
  color: var(--color-primary, #6366F1);
  background: rgba(99, 102, 241, 0.06);
}
.wc-navbar-modern-mobile-cta {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 0.85rem 1.5rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 600;
  color: #FFFFFF;
  background: var(--color-primary, #6366F1);
  border-radius: 12px;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(99, 102, 241, 0.25);
}
.wc-navbar-modern-mobile-cta:hover {
  box-shadow: 0 4px 20px rgba(99, 102, 241, 0.35);
  filter: brightness(1.08);
}

/* Responsive */
@media (max-width: 768px) {
  .wc-navbar-modern-container {
    height: 64px;
  }
  .wc-navbar-modern-nav,
  .wc-navbar-modern-cta {
    display: none;
  }
  .wc-navbar-modern-hamburger {
    display: flex;
  }
}
@media (min-width: 769px) {
  .wc-navbar-modern-mobile {
    display: none !important;
  }
}',
];
