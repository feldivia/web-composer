@extends('public.layout')

@section('title', $page->seo_title ?? $page->title)
@section('description', $page->seo_description ?? '')

@section('head')
{{-- Open Graph --}}
<meta property="og:title" content="{{ $page->seo_title ?? $page->title }}">
<meta property="og:description" content="{{ $page->seo_description ?? '' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'WebComposer' }}">
@if($page->og_image)
<meta property="og:image" content="{{ url($page->og_image) }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $page->seo_title ?? $page->title }}">
<meta name="twitter:description" content="{{ $page->seo_description ?? '' }}">

{{-- Schema.org --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "{{ e($page->seo_title ?? $page->title) }}",
    "description": "{{ e($page->seo_description ?? '') }}",
    "url": "{{ url()->current() }}",
    "publisher": {
        "@type": "Organization",
        "name": "{{ e($siteSettings['site_name'] ?? 'WebComposer') }}"
    }
}
</script>

@if(!empty($isPreview))
<style>
    .wc-preview-bar {
        position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
        background: #1e293b;
        color: #f1f5f9; padding: 0 24px;
        display: flex; align-items: center; justify-content: space-between;
        font-family: 'Inter', system-ui, sans-serif; font-size: 13px;
        height: 44px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        backdrop-filter: blur(8px);
    }
    .wc-preview-bar-left {
        display: flex; align-items: center; gap: 10px;
    }
    .wc-preview-badge {
        background: #f59e0b; color: #1e293b; padding: 3px 10px;
        border-radius: 50px; font-weight: 700; font-size: 10px;
        letter-spacing: 1px; text-transform: uppercase;
    }
    .wc-preview-status {
        color: #94a3b8; font-size: 12px;
    }
    .wc-preview-bar-right {
        display: flex; align-items: center; gap: 6px;
    }
    .wc-preview-btn {
        padding: 5px 14px; border-radius: 6px; font-size: 12px;
        font-weight: 500; text-decoration: none; color: #e2e8f0;
        background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.2s; font-family: inherit;
    }
    .wc-preview-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }
    .wc-preview-btn-primary {
        background: #6366f1; border-color: #6366f1; color: #fff;
    }
    .wc-preview-btn-primary:hover { background: #4f46e5; }
    .wc-preview-spacer { height: 44px; }
</style>
@endif
@endsection

@section('content')
@if(!empty($isPreview))
<div class="wc-preview-bar">
    <div class="wc-preview-bar-left">
        <span class="wc-preview-badge">Preview</span>
        <strong>{{ $page->title }}</strong>
        <span class="wc-preview-status">{{ ucfirst($page->status) }}</span>
    </div>
    <div class="wc-preview-bar-right">
        <a href="{{ route('filament.admin.resources.pages.index') }}" class="wc-preview-btn">
            Panel
        </a>
        <a href="{{ route('filament.admin.resources.pages.edit', $page) }}" class="wc-preview-btn">
            Configurar
        </a>
        @php
            $hasContent = is_array($page->content) && !empty($page->content['html']);
            $editorRoute = $hasContent && !empty($page->content['sections'])
                ? route('builder.sections', $page)
                : route('builder.wizard', $page);
        @endphp
        <a href="{{ $editorRoute }}" class="wc-preview-btn wc-preview-btn-primary">
            Diseñar
        </a>
    </div>
</div>
<div class="wc-preview-spacer"></div>
@endif

<div class="page-content">
    @if($sanitizedCss)
    <style>{!! $sanitizedCss !!}</style>
    @endif
    {!! $sanitizedHtml !!}
</div>
@endsection
