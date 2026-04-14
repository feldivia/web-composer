<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview: {{ $template->name }} — WebComposer</title>

    @php
        $colors = $template->colors ?? [];
        $fonts = $template->fonts ?? [];
        $headingFont = $fonts['heading'] ?? 'Inter';
        $bodyFont = $fonts['body'] ?? 'Inter';
        $allFonts = collect([$headingFont, $bodyFont])->unique()->map(fn($f) => str_replace(' ', '+', $f))->implode('&family=');
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $allFonts }}:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --font-heading: '{{ $headingFont }}', sans-serif;
            --font-body: '{{ $bodyFont }}', sans-serif;
            --color-primary: {{ $colors['primary'] ?? '#6366F1' }};
            --color-secondary: {{ $colors['secondary'] ?? '#0EA5E9' }};
            --color-accent: {{ $colors['accent'] ?? '#F59E0B' }};
            --color-background: {{ $colors['background'] ?? '#FFFFFF' }};
            --color-text: {{ $colors['text'] ?? '#1E293B' }};
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            font-family: var(--font-body);
            color: var(--color-text);
            background-color: var(--color-background);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-heading); }
        img { max-width: 100%; height: auto; }
        a { transition: color 0.2s, background-color 0.2s; }

        /* Preview banner */
        .preview-banner {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: linear-gradient(135deg, #6366F1, #0EA5E9);
            color: #fff;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        }
        .preview-banner-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .preview-banner-badge {
            background: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .preview-banner-actions {
            display: flex;
            gap: 10px;
        }
        .preview-banner-actions a {
            padding: 6px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }
        .preview-btn-back {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.25);
        }
        .preview-btn-back:hover { background: rgba(255,255,255,0.25); }
        .preview-btn-use {
            background: #fff;
            color: #6366F1;
        }
        .preview-btn-use:hover { background: #f0f0ff; }
        .preview-spacer { height: 48px; }
    </style>

    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body>
    <div class="preview-banner">
        <div class="preview-banner-info">
            <span class="preview-banner-badge">Preview</span>
            <span><strong>{{ $template->name }}</strong> — {{ $template->description }}</span>
        </div>
        <div class="preview-banner-actions">
            <a href="{{ url('/templates') }}" class="preview-btn-back">&larr; Galeria</a>
            <a href="{{ url('/admin/pages/create') }}" class="preview-btn-use">Usar Template</a>
        </div>
    </div>
    <div class="preview-spacer"></div>

    <div class="page-content">
        @if($sanitizedCss)
        <style>{!! $sanitizedCss !!}</style>
        @endif
        {!! $sanitizedHtml !!}
    </div>
</body>
</html>
