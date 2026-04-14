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
@endsection

@section('head')
@if(!empty($isPreview))
<style>
    .preview-banner {
        position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
        background: linear-gradient(135deg, #f59e0b, #ef4444);
        color: #fff; padding: 10px 24px;
        display: flex; align-items: center; justify-content: space-between;
        font-family: var(--font-body); font-size: 14px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .preview-banner-badge {
        background: rgba(255,255,255,0.2); padding: 4px 12px;
        border-radius: 50px; font-weight: 600; font-size: 12px;
        letter-spacing: 0.5px; text-transform: uppercase; margin-right: 12px;
    }
    .preview-banner a {
        padding: 6px 16px; border-radius: 8px; font-size: 13px;
        font-weight: 600; text-decoration: none; color: #fff;
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        margin-left: 8px;
    }
    .preview-banner a:hover { background: rgba(255,255,255,0.25); }
    .preview-spacer { height: 48px; }
</style>
@endif
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
@endsection

@section('content')
@if(!empty($isPreview))
<div class="preview-banner">
    <div>
        <span class="preview-banner-badge">Preview</span>
        <strong>{{ $page->title }}</strong> — Estado: {{ ucfirst($page->status) }}
    </div>
    <div>
        <a href="{{ url('/admin/pages/' . $page->id . '/edit') }}">Editar</a>
        <a href="{{ url('/builder/' . $page->id) }}">Abrir Editor</a>
    </div>
</div>
<div class="preview-spacer"></div>
@endif

<div class="page-content">
    @if($sanitizedCss)
    <style>{!! $sanitizedCss !!}</style>
    @endif
    {!! $sanitizedHtml !!}
</div>
@endsection
