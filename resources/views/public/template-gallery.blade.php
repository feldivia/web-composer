@extends('public.layout')

@section('title', 'Templates — WebComposer')
@section('description', 'Galeria de templates profesionales para crear tu sitio web')

@section('content')
<section class="hero" style="min-height: auto; padding: 80px 24px 60px;">
    <div class="hero-content">
        <span class="hero-badge">Galeria de Templates</span>
        <h1>Elige tu <span>template</span> ideal</h1>
        <p class="hero-subtitle">Templates profesionales y modernos listos para personalizar. Elige uno y comienza a crear tu sitio web.</p>
    </div>
</section>

<section class="features-section" style="padding: 80px 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 32px; max-width: 1200px; margin: 0 auto;">
        @forelse($templates as $template)
        <div class="feature-card" style="padding: 0; overflow: hidden;">
            {{-- Template preview thumbnail --}}
            <div style="position: relative; height: 240px; background: linear-gradient(135deg, {{ $template->colors['primary'] ?? '#6366F1' }}15, {{ $template->colors['secondary'] ?? '#0EA5E9' }}15); overflow: hidden; display: flex; align-items: center; justify-content: center;">
                <div style="text-align: center; padding: 24px;">
                    <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, {{ $template->colors['primary'] ?? '#6366F1' }}, {{ $template->colors['secondary'] ?? '#0EA5E9' }}); margin: 0 auto 16px; display: flex; align-items: center; justify-content: center;">
                        <span style="font-size: 28px; color: #fff;">
                            @switch($template->category)
                                @case('tecnologia') &#128640; @break
                                @case('gastronomia') &#127860; @break
                                @case('creativo') &#127912; @break
                                @case('salud') &#9877; @break
                                @case('comercio') &#128722; @break
                                @case('inmobiliaria') &#127968; @break
                                @case('deporte') &#128170; @break
                                @case('educacion') &#127891; @break
                                @case('blog') &#128221; @break
                                @case('eventos') &#127915; @break
                                @default &#9998;
                            @endswitch
                        </span>
                    </div>
                    <div style="display: flex; gap: 6px; justify-content: center;">
                        @foreach(['primary', 'secondary', 'accent', 'background', 'text'] as $colorKey)
                        <div style="width: 20px; height: 20px; border-radius: 50%; background: {{ $template->colors[$colorKey] ?? '#ccc' }}; border: 2px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Template info --}}
            <div style="padding: 24px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                    <h3 style="margin: 0; font-size: 1.15rem;">{{ $template->name }}</h3>
                    <span class="section-label" style="margin: 0; font-size: 11px; padding: 3px 10px;">{{ ucfirst($template->category) }}</span>
                </div>
                <p style="color: #64748b; font-size: 0.9rem; line-height: 1.6; margin: 0 0 8px;">{{ $template->description }}</p>
                <p style="color: #94a3b8; font-size: 0.8rem; margin: 0 0 20px;">
                    Fuentes: {{ $template->fonts['heading'] ?? 'Inter' }} + {{ $template->fonts['body'] ?? 'Inter' }}
                </p>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ url('/templates/' . $template->slug . '/preview') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px; flex: 1; justify-content: center;">
                        Ver Preview
                    </a>
                    <a href="{{ url('/admin/pages/create') }}" class="btn-secondary" style="padding: 10px 20px; font-size: 14px; background: rgba(0,0,0,0.04); color: var(--color-text); border: 1px solid #e2e8f0;">
                        Usar
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px 24px;">
            <h2 style="margin: 0 0 8px;">No hay templates disponibles</h2>
            <p style="color: #64748b;">Los templates se cargaran pronto.</p>
        </div>
        @endforelse
    </div>
</section>
@endsection
