<?php

declare(strict_types=1);

/**
 * Navbar Transparent — Navbar transparente que se vuelve sólido al scrollear. Ideal sobre heros con imagen.
 */
return [
    'id' => 'navbar-transparent',
    'name' => 'Navbar Transparente',
    'category' => 'navbar',
    'description' => 'Navbar transparente sobre hero que se vuelve sólido con glass al hacer scroll. Ideal para landing pages',
    'icon' => '🌐',
    'placeholders' => [
        'brand_name' => ['type' => 'text', 'label' => 'Nombre de marca', 'default' => 'MiSitio'],
        'brand_logo' => ['type' => 'image', 'label' => 'Logo de la empresa', 'default' => ''],
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
    'html' => '<nav class="wc-navbar-transparent" data-sticky data-sticky-class="wc-navbar-transparent--scrolled">
  <div class="wc-navbar-transparent-container">
    <!-- Logo / Brand -->
    <a href="/" class="wc-navbar-transparent-brand">
      {{brand_logo}}
      <span class="wc-navbar-transparent-brand-text">{{brand_name}}</span>
    </a>

    <!-- Desktop Nav -->
    <ul class="wc-navbar-transparent-nav">{{nav_links}}</ul>

    <!-- CTA Button -->
    <a href="{{cta_url}}" class="wc-navbar-transparent-cta">{{cta_text}}</a>

    <!-- Hamburger -->
    <button class="wc-navbar-transparent-hamburger" data-menu-toggle aria-label="Abrir menú" aria-expanded="false">
      <span class="wc-navbar-transparent-hamburger-line"></span>
      <span class="wc-navbar-transparent-hamburger-line"></span>
      <span class="wc-navbar-transparent-hamburger-line"></span>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div class="wc-navbar-transparent-mobile hidden" data-mobile-menu>
    <ul class="wc-navbar-transparent-mobile-nav">{{nav_links}}</ul>
    <a href="{{cta_url}}" class="wc-navbar-transparent-mobile-cta">{{cta_text}}</a>
  </div>
</nav>',
    'css' => '/* === Navbar Transparent === */
.wc-navbar-transparent {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  z-index: 1000;
  padding: 0;
  background: transparent;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Scrolled: solid glass effect */
.wc-navbar-transparent.wc-navbar-transparent--scrolled {
  position: fixed;
  background: rgba(15, 23, 42, 0.92);
  backdrop-filter: blur(20px) saturate(180%);
  -webkit-backdrop-filter: blur(20px) saturate(180%);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 8px 32px rgba(0, 0, 0, 0.12);
}

.wc-navbar-transparent-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 6%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 76px;
  gap: 2rem;
}
.wc-navbar-transparent--scrolled .wc-navbar-transparent-container {
  height: 64px;
}

/* Brand */
.wc-navbar-transparent-brand {
  display: flex;
  align-items: center;
  gap: 0.65rem;
  text-decoration: none;
  flex-shrink: 0;
}
.wc-navbar-transparent-brand-logo {
  height: 36px;
  width: auto;
  max-width: 140px;
  object-fit: contain;
  transition: transform 0.3s ease;
}
.wc-navbar-transparent-brand:hover .wc-navbar-transparent-brand-logo {
  transform: scale(1.04);
}
.wc-navbar-transparent-brand-icon {
  display: flex;
  align-items: center;
  transition: transform 0.3s ease;
}
.wc-navbar-transparent-brand:hover .wc-navbar-transparent-brand-icon {
  transform: scale(1.08);
}
.wc-navbar-transparent-brand-text {
  font-family: var(--font-heading, "Inter", sans-serif);
  font-size: 1.2rem;
  font-weight: 700;
  color: #FFFFFF;
  letter-spacing: -0.02em;
}

/* Desktop Nav */
.wc-navbar-transparent-nav {
  display: flex;
  align-items: center;
  gap: 0.15rem;
  list-style: none;
  padding: 0;
  margin: 0;
}
.wc-navbar-transparent-nav li {
  padding: 0;
  margin: 0;
}
.wc-navbar-transparent-nav .wc-navbar-transparent-link {
  display: inline-flex;
  align-items: center;
  padding: 0.5rem 0.9rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.875rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  border-radius: 8px;
  transition: color 0.25s ease, background-color 0.25s ease;
  position: relative;
}
.wc-navbar-transparent-nav .wc-navbar-transparent-link:hover {
  color: #FFFFFF;
  background: rgba(255, 255, 255, 0.1);
}
.wc-navbar-transparent-nav .wc-navbar-transparent-link::after {
  content: "";
  position: absolute;
  bottom: 4px;
  left: 50%;
  width: 0;
  height: 2px;
  background: var(--color-accent, #F59E0B);
  transition: width 0.3s ease, left 0.3s ease;
  border-radius: 1px;
}
.wc-navbar-transparent-nav .wc-navbar-transparent-link:hover::after {
  width: 40%;
  left: 30%;
}

/* CTA */
.wc-navbar-transparent-cta {
  display: inline-flex;
  align-items: center;
  padding: 0.55rem 1.4rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.85rem;
  font-weight: 600;
  color: #FFFFFF;
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  flex-shrink: 0;
}
.wc-navbar-transparent-cta:hover {
  background: var(--color-primary, #6366F1);
  border-color: var(--color-primary, #6366F1);
  box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
  transform: translateY(-1px);
}
.wc-navbar-transparent--scrolled .wc-navbar-transparent-cta {
  background: var(--color-primary, #6366F1);
  border-color: var(--color-primary, #6366F1);
  box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
}

/* Hamburger */
.wc-navbar-transparent-hamburger {
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
.wc-navbar-transparent-hamburger:hover {
  background: rgba(255, 255, 255, 0.1);
}
.wc-navbar-transparent-hamburger-line {
  display: block;
  width: 22px;
  height: 2px;
  background: #FFFFFF;
  border-radius: 2px;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  transform-origin: center;
}
.wc-navbar-transparent-hamburger[aria-expanded="true"] .wc-navbar-transparent-hamburger-line:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}
.wc-navbar-transparent-hamburger[aria-expanded="true"] .wc-navbar-transparent-hamburger-line:nth-child(2) {
  opacity: 0;
  transform: scaleX(0);
}
.wc-navbar-transparent-hamburger[aria-expanded="true"] .wc-navbar-transparent-hamburger-line:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}

/* Mobile Menu */
.wc-navbar-transparent-mobile {
  overflow: hidden;
  max-height: 0;
  opacity: 0;
  transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, padding 0.3s ease;
  padding: 0 6%;
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
}
.wc-navbar-transparent-mobile:not(.hidden) {
  max-height: 500px;
  opacity: 1;
  padding: 1rem 6% 1.5rem;
}
.wc-navbar-transparent-mobile-nav {
  list-style: none;
  padding: 0;
  margin: 0 0 1rem 0;
  display: flex;
  flex-direction: column;
  gap: 0.15rem;
}
.wc-navbar-transparent-mobile-nav li {
  padding: 0;
  margin: 0;
}
.wc-navbar-transparent-mobile-nav .wc-navbar-transparent-link {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  font-family: var(--font-body, "Inter", sans-serif);
  font-size: 0.95rem;
  font-weight: 500;
  color: rgba(255, 255, 255, 0.85);
  text-decoration: none;
  border-radius: 10px;
  transition: color 0.25s ease, background-color 0.25s ease;
}
.wc-navbar-transparent-mobile-nav .wc-navbar-transparent-link:hover {
  color: #FFFFFF;
  background: rgba(255, 255, 255, 0.08);
}
.wc-navbar-transparent-mobile-cta {
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
  box-shadow: 0 2px 10px rgba(99, 102, 241, 0.3);
}
.wc-navbar-transparent-mobile-cta:hover {
  box-shadow: 0 4px 20px rgba(99, 102, 241, 0.4);
  filter: brightness(1.08);
}

/* Responsive */
@media (max-width: 768px) {
  .wc-navbar-transparent-container {
    height: 64px;
  }
  .wc-navbar-transparent--scrolled .wc-navbar-transparent-container {
    height: 60px;
  }
  .wc-navbar-transparent-nav,
  .wc-navbar-transparent-cta {
    display: none;
  }
  .wc-navbar-transparent-hamburger {
    display: flex;
  }
}
@media (min-width: 769px) {
  .wc-navbar-transparent-mobile {
    display: none !important;
  }
}',
];
