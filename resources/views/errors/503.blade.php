<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio en mantenimiento</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Space+Grotesk:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            color: #e2e8f0;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(99,102,241,0.12) 0%, transparent 50%),
                        radial-gradient(circle at 70% 30%, rgba(14,165,233,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 50% 80%, rgba(245,158,11,0.06) 0%, transparent 50%);
            animation: bgFloat 20s ease-in-out infinite;
            z-index: 0;
        }

        @keyframes bgFloat {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(2%, -2%) rotate(1deg); }
            66% { transform: translate(-1%, 1%) rotate(-1deg); }
        }

        .maintenance {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 560px;
            padding: 40px 24px;
        }

        /* Gear animation */
        .maintenance-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
        }

        .gear-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
        }

        .gear {
            position: absolute;
            color: rgba(129,140,248,0.5);
        }

        .gear-large {
            top: 0;
            left: 0;
            width: 56px;
            height: 56px;
            animation: gearSpin 6s linear infinite;
        }

        .gear-small {
            bottom: 4px;
            right: 0;
            width: 40px;
            height: 40px;
            animation: gearSpinReverse 4s linear infinite;
            color: rgba(6,182,212,0.5);
        }

        @keyframes gearSpin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes gearSpinReverse {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        .maintenance-title {
            font-family: 'Space Grotesk', 'Inter', sans-serif;
            font-size: clamp(2rem, 5vw, 2.75rem);
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 16px;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .maintenance-subtitle {
            font-size: clamp(1rem, 2.5vw, 1.15rem);
            color: #94a3b8;
            line-height: 1.7;
            margin: 0 0 48px;
        }

        /* Progress bar */
        .progress-wrapper {
            max-width: 320px;
            margin: 0 auto;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(255,255,255,0.08);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            width: 65%;
            background: linear-gradient(90deg, #818cf8, #06b6d4);
            border-radius: 6px;
            position: relative;
            animation: progressShimmer 2.5s ease-in-out infinite;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes progressShimmer {
            0%, 100% { width: 55%; }
            50% { width: 75%; }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Floating dots decoration */
        .dots {
            position: fixed;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .dot {
            position: absolute;
            border-radius: 50%;
            background: rgba(129,140,248,0.2);
            animation: dotFloat linear infinite;
        }

        .dot:nth-child(1) { width: 4px; height: 4px; left: 12%; animation-duration: 14s; animation-delay: -2s; }
        .dot:nth-child(2) { width: 6px; height: 6px; left: 30%; animation-duration: 18s; animation-delay: -5s; background: rgba(6,182,212,0.2); }
        .dot:nth-child(3) { width: 3px; height: 3px; left: 55%; animation-duration: 12s; animation-delay: -8s; }
        .dot:nth-child(4) { width: 5px; height: 5px; left: 75%; animation-duration: 16s; animation-delay: -3s; background: rgba(245,158,11,0.15); }
        .dot:nth-child(5) { width: 4px; height: 4px; left: 88%; animation-duration: 20s; animation-delay: -11s; }

        @keyframes dotFloat {
            0% { bottom: -10px; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { bottom: 110vh; opacity: 0; }
        }

        @media (max-width: 480px) {
            .maintenance {
                padding: 32px 20px;
            }

            .gear-wrapper {
                width: 64px;
                height: 64px;
            }

            .gear-large {
                width: 44px;
                height: 44px;
            }

            .gear-small {
                width: 32px;
                height: 32px;
            }
        }
    </style>
</head>
<body>
    {{-- Floating dots --}}
    <div class="dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>

    <main class="maintenance">
        {{-- Animated gears --}}
        <div class="maintenance-icon">
            <div class="gear-wrapper">
                <svg class="gear gear-large" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97s-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1s.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.58 1.69-.98l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64L19.43 12.97Z"/>
                </svg>
                <svg class="gear gear-small" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97s-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1s.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.58 1.69-.98l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64L19.43 12.97Z"/>
                </svg>
            </div>
        </div>

        <h1 class="maintenance-title">Sitio en mantenimiento</h1>
        <p class="maintenance-subtitle">Estamos realizando mejoras. Volvemos pronto.</p>

        {{-- Animated progress bar --}}
        <div class="progress-wrapper">
            <div class="progress-label">
                <span>Progreso</span>
                <span>Volvemos pronto</span>
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </main>
</body>
</html>
