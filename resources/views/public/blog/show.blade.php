@extends('public.layout')

@section('title', $post->seo_title ?? $post->title)
@section('description', $post->seo_description ?? $post->excerpt ?? '')

@section('head')
{{-- Open Graph --}}
<meta property="og:title" content="{{ $post->seo_title ?? $post->title }}">
<meta property="og:description" content="{{ $post->seo_description ?? $post->excerpt ?? '' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="article">
@if($post->og_image ?? $post->featured_image)
<meta property="og:image" content="{{ url($post->og_image ?? $post->featured_image) }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->seo_title ?? $post->title }}">

{{-- Schema.org BlogPosting --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ e($post->title) }}",
    "description": "{{ e($post->seo_description ?? $post->excerpt ?? '') }}",
    "url": "{{ url()->current() }}",
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}",
    @if($post->featured_image)"image": "{{ url($post->featured_image) }}",@endif
    "author": {
        "@type": "Person",
        "name": "{{ e($post->user?->name ?? 'Admin') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ e($siteSettings['site_name'] ?? 'WebComposer') }}"
    }
}
</script>
@endsection

@section('content')
<x-breadcrumbs :items="[['label' => 'Blog', 'url' => route('blog.index')], ['label' => $post->title]]" />

{{-- Post Hero Image --}}
@if($post->featured_image)
<section class="post-hero">
    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="post-hero-image">
    <div class="post-hero-overlay"></div>
</section>
@endif

<article class="post-article">
    <div class="post-container">
        {{-- Back link --}}
        <a href="{{ route('blog.index') }}" class="post-back-link">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Volver al blog
        </a>

        {{-- Post Header --}}
        <header class="post-header">
            @if($post->categories->count())
            <div class="post-categories">
                @foreach($post->categories as $category)
                <span class="blog-category-badge">{{ $category->name }}</span>
                @endforeach
            </div>
            @endif

            <h1 class="post-title">{{ $post->title }}</h1>

            <div class="post-meta">
                <div class="post-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ $post->published_at?->format('d M Y') }}
                </div>
                <span class="post-meta-separator"></span>
                <div class="post-meta-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    {{ $post->user?->name ?? 'Admin' }}
                </div>
            </div>
        </header>

        {{-- Post Content --}}
        <div class="prose">
            {!! $sanitizedBody !!}
        </div>

        {{-- Tags --}}
        @if($post->tags->count())
        <div class="post-tags">
            <span class="post-tags-label">Etiquetas:</span>
            @foreach($post->tags as $tag)
            <span class="post-tag-pill">{{ $tag->name }}</span>
            @endforeach
        </div>
        @endif

        {{-- Divider + Back --}}
        <div class="post-footer-nav">
            <a href="{{ route('blog.index') }}" class="btn-secondary" style="padding: 12px 28px; font-size: 14px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Volver al blog
            </a>
        </div>
    </div>
</article>
@endsection
