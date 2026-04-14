@extends('public.layout')

@section('title', 'Blog - ' . ($siteSettings['site_name'] ?? 'WebComposer'))

@section('content')
<x-breadcrumbs :items="[['label' => 'Blog']]" />

{{-- Blog Hero --}}
<section class="blog-hero">
    <div class="blog-hero-content">
        <span class="section-label">Blog</span>
        <h1 class="blog-hero-title">Nuestras Publicaciones</h1>
        <p class="blog-hero-subtitle">Descubre las novedades, consejos y tendencias que compartimos contigo.</p>
    </div>
</section>

{{-- Blog Posts Grid --}}
<section class="blog-section">
    <div class="container">
        @if($posts->count())
        <div class="blog-grid">
            @foreach($posts as $post)
            <article class="blog-card">
                @if($post->featured_image)
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-image-link">
                    <div class="blog-card-image">
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" loading="lazy">
                    </div>
                </a>
                @endif
                <div class="blog-card-body">
                    <div class="blog-card-meta">
                        @if($post->categories->count())
                        <div class="blog-card-categories">
                            @foreach($post->categories->take(2) as $category)
                            <span class="blog-category-badge">{{ $category->name }}</span>
                            @endforeach
                        </div>
                        @endif
                        <span class="blog-card-date">{{ $post->published_at?->format('d M Y') }}</span>
                    </div>
                    <h2 class="blog-card-title">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    @if($post->excerpt)
                    <p class="blog-card-excerpt">{{ Str::limit($post->excerpt, 140) }}</p>
                    @endif
                    <div class="blog-card-footer">
                        <span class="blog-card-author">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $post->user?->name ?? 'Admin' }}
                        </span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-read-more">
                            Leer m&aacute;s
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        @if($posts->hasPages())
        <div class="blog-pagination">
            @if($posts->onFirstPage())
                <span class="blog-pagination-link blog-pagination-disabled">&laquo; Anterior</span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="blog-pagination-link">&laquo; Anterior</a>
            @endif

            @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                @if($page == $posts->currentPage())
                    <span class="blog-pagination-link blog-pagination-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="blog-pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            @if($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="blog-pagination-link">Siguiente &raquo;</a>
            @else
                <span class="blog-pagination-link blog-pagination-disabled">Siguiente &raquo;</span>
            @endif
        </div>
        @endif

        @else
        <div class="blog-empty">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #94a3b8; margin-bottom: 20px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <h2>No hay publicaciones a&uacute;n</h2>
            <p>Pronto compartiremos contenido interesante. &iexcl;Vuelve pronto!</p>
        </div>
        @endif
    </div>
</section>
@endsection
