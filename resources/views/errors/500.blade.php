@extends('public.layout')

@section('title', 'Error del servidor - ' . ($siteSettings['site_name'] ?? 'WebComposer'))

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
        background: radial-gradient(circle at 30% 50%, rgba(239,68,68,0.12) 0%, transparent 50%),
                    radial-gradient(circle at 70% 30%, rgba(99,102,241,0.1) 0%, transparent 50%),
                    radial-gradient(circle at 50% 80%, rgba(245,158,11,0.06) 0%, transparent 50%);
        animation: heroFloat 20s ease-in-out infinite;
    }

    @keyframes heroFloat {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(2%, -2%) rotate(1deg); }
        66% { transform: translate(-1%, 1%) rotate(-1deg); }
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
        background: linear-gradient(135deg, #f87171, #ef4444, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 4px 24px rgba(239,68,68,0.3));
        animation: errorPulse 4s ease-in-out infinite;
    }

    @keyframes errorPulse {
        0%, 100% { opacity: 1; filter: drop-shadow(0 4px 24px rgba(239,68,68,0.3)); }
        50% { opacity: 0.85; filter: drop-shadow(0 4px 32px rgba(239,68,68,0.5)); }
    }

    .error-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
    }

    .error-icon svg {
        color: rgba(248,113,113,0.6);
        animation: iconShake 3s ease-in-out infinite;
    }

    @keyframes iconShake {
        0%, 100% { transform: rotate(0deg); }
        10% { transform: rotate(-3deg); }
        20% { transform: rotate(3deg); }
        30% { transform: rotate(-2deg); }
        40% { transform: rotate(0deg); }
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

    /* Hide footer on error pages */
    .site-footer { display: none; }
</style>
@endsection

@section('content')
<section class="error-page">
    <div class="error-content">
        {{-- Large gradient 500 --}}
        <h1 class="error-code" style="font-family: var(--font-heading);">500</h1>

        {{-- Warning icon --}}
        <div class="error-icon">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>

        <h2 class="error-title" style="font-family: var(--font-heading);">Error del servidor</h2>
        <p class="error-subtitle">Algo salio mal. Estamos trabajando para solucionarlo. Intenta nuevamente en unos minutos.</p>

        {{-- Action button --}}
        <div class="error-buttons">
            <a href="{{ url('/') }}" class="btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Volver al inicio
            </a>
        </div>
    </div>
</section>
@endsection
