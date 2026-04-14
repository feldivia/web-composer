@extends('public.layout')

@section('title', 'Pagina no encontrada - ' . ($siteSettings['site_name'] ?? 'WebComposer'))

@section('head')
<style>
    .error-page {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
    }

    .error-page::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 50%, rgba(99,102,241,0.15) 0%, transparent 50%),
                    radial-gradient(circle at 70% 30%, rgba(14,165,233,0.12) 0%, transparent 50%),
                    radial-gradient(circle at 50% 80%, rgba(245,158,11,0.08) 0%, transparent 50%);
        animation: heroFloat 20s ease-in-out infinite;
    }

    .error-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 680px;
        padding: 40px 24px;
    }

    .error-code {
        font-size: clamp(8rem, 20vw, 14rem);
        font-weight: 900;
        line-height: 1;
        margin: 0 0 8px;
        letter-spacing: -0.04em;
        background: linear-gradient(135deg, #818cf8, #06b6d4, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 4px 24px rgba(99,102,241,0.3));
        animation: errorPulse 4s ease-in-out infinite;
    }

    @keyframes errorPulse {
        0%, 100% { opacity: 1; filter: drop-shadow(0 4px 24px rgba(99,102,241,0.3)); }
        50% { opacity: 0.85; filter: drop-shadow(0 4px 32px rgba(99,102,241,0.5)); }
    }

    .error-decoration {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 32px;
    }

    .error-line {
        width: 60px;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(129,140,248,0.5), transparent);
        border-radius: 2px;
    }

    .error-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(129,140,248,0.6);
        animation: dotPulse 2s ease-in-out infinite;
    }

    @keyframes dotPulse {
        0%, 100% { transform: scale(1); opacity: 0.6; }
        50% { transform: scale(1.4); opacity: 1; }
    }

    .error-title {
        font-size: clamp(1.5rem, 4vw, 2.25rem);
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 16px;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .error-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        color: #94a3b8;
        margin: 0 0 40px;
        line-height: 1.7;
    }

    .error-buttons {
        display: flex;
        gap: 16px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Floating particles decoration */
    .error-particles {
        position: absolute;
        inset: 0;
        z-index: 1;
        overflow: hidden;
        pointer-events: none;
    }

    .error-particle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: rgba(129,140,248,0.3);
        border-radius: 50%;
        animation: particleFloat linear infinite;
    }

    .error-particle:nth-child(1) { left: 10%; top: 20%; animation-duration: 12s; animation-delay: 0s; width: 3px; height: 3px; }
    .error-particle:nth-child(2) { left: 25%; top: 60%; animation-duration: 15s; animation-delay: -3s; width: 5px; height: 5px; background: rgba(6,182,212,0.25); }
    .error-particle:nth-child(3) { left: 45%; top: 10%; animation-duration: 18s; animation-delay: -6s; }
    .error-particle:nth-child(4) { left: 65%; top: 75%; animation-duration: 14s; animation-delay: -2s; width: 6px; height: 6px; background: rgba(245,158,11,0.2); }
    .error-particle:nth-child(5) { left: 80%; top: 35%; animation-duration: 16s; animation-delay: -8s; width: 3px; height: 3px; }
    .error-particle:nth-child(6) { left: 90%; top: 80%; animation-duration: 13s; animation-delay: -4s; background: rgba(6,182,212,0.2); }
    .error-particle:nth-child(7) { left: 15%; top: 85%; animation-duration: 17s; animation-delay: -10s; width: 5px; height: 5px; }
    .error-particle:nth-child(8) { left: 55%; top: 45%; animation-duration: 19s; animation-delay: -7s; background: rgba(245,158,11,0.15); }

    @keyframes particleFloat {
        0% { transform: translateY(0) translateX(0); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateY(-100vh) translateX(30px); opacity: 0; }
    }

    /* Hide footer on error pages for cleaner look */
    .site-footer { display: none; }
</style>
@endsection

@section('content')
<section class="error-page">
    {{-- Floating particles --}}
    <div class="error-particles">
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
        <div class="error-particle"></div>
    </div>

    <div class="error-content">
        {{-- Large gradient 404 --}}
        <h1 class="error-code" style="font-family: var(--font-heading);">404</h1>

        {{-- Decorative divider --}}
        <div class="error-decoration">
            <span class="error-line"></span>
            <span class="error-dot"></span>
            <span class="error-line"></span>
        </div>

        <h2 class="error-title" style="font-family: var(--font-heading);">Pagina no encontrada</h2>
        <p class="error-subtitle">La pagina que buscas no existe o fue movida a otra ubicacion. Verifica la URL o vuelve al inicio.</p>

        {{-- Action buttons --}}
        <div class="error-buttons">
            <a href="{{ url('/') }}" class="btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Volver al inicio
            </a>
            <a href="{{ url('/blog') }}" class="btn-secondary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Ir al blog
            </a>
        </div>
    </div>
</section>
@endsection
