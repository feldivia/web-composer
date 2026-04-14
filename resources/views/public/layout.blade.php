<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $siteSettings['site_name'] ?? 'WebComposer')</title>
    <meta name="description" content="@yield('description', $siteSettings['site_description'] ?? '')">
    @if(isset($siteSettings['site_favicon']))
    <link rel="icon" href="{{ $siteSettings['site_favicon'] }}">
    @endif

    {{-- Google Fonts - only the 2 selected --}}
    @php
        $headingFont = $siteSettings['font_heading'] ?? 'Inter';
        $bodyFont = $siteSettings['font_body'] ?? 'Inter';
        $fonts = collect([$headingFont, $bodyFont])->unique()->map(fn($f) => str_replace(' ', '+', $f))->implode('&family=');
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $fonts }}&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="https://fonts.googleapis.com/css2?family={{ $fonts }}&display=swap" rel="stylesheet"></noscript>

    <style>
        :root {
            --font-heading: '{{ preg_replace('/[^a-zA-Z0-9 ]/', '', $headingFont) }}', sans-serif;
            --font-body: '{{ preg_replace('/[^a-zA-Z0-9 ]/', '', $bodyFont) }}', sans-serif;
            --color-primary: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_primary'] ?? '') ? $siteSettings['color_primary'] : '#6366F1' }};
            --color-secondary: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_secondary'] ?? '') ? $siteSettings['color_secondary'] : '#0EA5E9' }};
            --color-accent: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_accent'] ?? '') ? $siteSettings['color_accent'] : '#F59E0B' }};
            --color-background: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_background'] ?? '') ? $siteSettings['color_background'] : '#FFFFFF' }};
            --color-text: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_text'] ?? '') ? $siteSettings['color_text'] : '#1E293B' }};
        }

        [data-theme="dark"] {
            --color-background: #0f172a;
            --color-text: #e2e8f0;
            --color-primary: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_primary'] ?? '') ? $siteSettings['color_primary'] : '#6366F1' }};
            --color-secondary: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_secondary'] ?? '') ? $siteSettings['color_secondary'] : '#0EA5E9' }};
            --color-accent: {{ preg_match('/^#[0-9a-fA-F]{3,8}$/', $siteSettings['color_accent'] ?? '') ? $siteSettings['color_accent'] : '#F59E0B' }};
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) {
                --color-background: #0f172a;
                --color-text: #e2e8f0;
            }
        }

        body {
            font-family: var(--font-body);
            color: var(--color-text);
            background-color: var(--color-background);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
        }
    </style>

    {{-- Tailwind CSS Play CDN — DEVELOPMENT ONLY. Replace with compiled Tailwind CSS in production (npm run build). --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        corePlugins: {
            preflight: false,
        },
        theme: {
            extend: {
                fontFamily: {
                    heading: 'var(--font-heading)',
                    body: 'var(--font-body)',
                },
                colors: {
                    primary: 'var(--color-primary)',
                    secondary: 'var(--color-secondary)',
                    accent: 'var(--color-accent)',
                }
            }
        }
    }
    </script>

    {{-- Base CSS --}}
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">

    <link rel="alternate" type="application/rss+xml" title="Blog Feed" href="{{ url('/feed.xml') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    @yield('head')

    {{-- Analytics: only load if cookie consent is accepted --}}
    <script>
        (function() {
            if (localStorage.getItem('wc_cookie_consent') !== 'accepted') return;

            @if(!empty($siteSettings['analytics_id']) && preg_match('/^[A-Z0-9-]+$/', $siteSettings['analytics_id']))
            var gaScript = document.createElement('script');
            gaScript.async = true;
            gaScript.src = 'https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['analytics_id'] }}';
            document.head.appendChild(gaScript);
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            window.gtag = gtag;
            gtag('js', new Date());
            gtag('config', @json($siteSettings['analytics_id']));
            @endif

            @if(!empty($siteSettings['meta_pixel_id']) && preg_match('/^[0-9]+$/', $siteSettings['meta_pixel_id']))
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', @json($siteSettings['meta_pixel_id']));
            fbq('track', 'PageView');
            @endif
        })();
    </script>
</head>
<body class="min-h-screen">
    @yield('content')

    <footer class="site-footer">
        <div class="footer-links">
            @if(!empty($siteSettings['social_facebook']))
            <a href="{{ $siteSettings['social_facebook'] }}" target="_blank">Facebook</a>
            @endif
            @if(!empty($siteSettings['social_instagram']))
            <a href="{{ $siteSettings['social_instagram'] }}" target="_blank">Instagram</a>
            @endif
            @if(!empty($siteSettings['social_twitter']))
            <a href="{{ $siteSettings['social_twitter'] }}" target="_blank">Twitter</a>
            @endif
            @if(!empty($siteSettings['social_linkedin']))
            <a href="{{ $siteSettings['social_linkedin'] }}" target="_blank">LinkedIn</a>
            @endif
            @if(!empty($siteSettings['social_youtube']))
            <a href="{{ $siteSettings['social_youtube'] }}" target="_blank">YouTube</a>
            @endif
            <a href="/blog">Blog</a>
            <a href="/admin">Admin</a>
        </div>
        <p style="margin:0;">{{ $siteSettings['footer_text'] ?? '© ' . date('Y') . ' WebComposer' }}</p>
    </footer>

    {{-- Site JS --}}
    <script src="{{ asset('js/site.js') }}" defer></script>

    @yield('scripts')

    {{-- Dark Mode Toggle Button --}}
    <button id="wc-dark-mode-toggle" class="wc-dark-toggle" aria-label="Cambiar tema" title="Cambiar tema">
        <svg class="wc-dark-toggle-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <svg class="wc-dark-toggle-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
    </button>

    {{-- Cookie Consent Banner --}}
    <div id="wc-cookie-banner" class="wc-cookie-banner" style="display:none;">
        <div class="wc-cookie-banner-inner">
            <p class="wc-cookie-banner-text">
                Usamos cookies para mejorar tu experiencia. Al continuar navegando, aceptas nuestra pol&iacute;tica de cookies.
                <a href="#" class="wc-cookie-banner-link">M&aacute;s informaci&oacute;n</a>
            </p>
            <div class="wc-cookie-banner-actions">
                <button id="wc-cookie-reject" class="wc-cookie-btn wc-cookie-btn-reject">Rechazar</button>
                <button id="wc-cookie-accept" class="wc-cookie-btn wc-cookie-btn-accept">Aceptar</button>
            </div>
        </div>
    </div>

    @if(!empty($siteSettings['whatsapp_number']))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['whatsapp_number']) }}?text={{ urlencode($siteSettings['whatsapp_message'] ?? 'Hola') }}"
       target="_blank"
       style="position:fixed; bottom:24px; right:24px; width:60px; height:60px; background:#25d366; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(37,211,102,0.4); z-index:999; text-decoration:none; transition:transform 0.2s;"
       onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"
       title="Chatea por WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>
    @endif
</body>
</html>
