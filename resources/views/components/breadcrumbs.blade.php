@props(['items' => []])
<nav aria-label="Breadcrumb" class="wc-breadcrumbs">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="/"><span itemprop="name">Inicio</span></a>
            <meta itemprop="position" content="1">
        </li>
        @foreach($items as $index => $item)
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            @if($item['url'] ?? false)
                <a itemprop="item" href="{{ $item['url'] }}"><span itemprop="name">{{ $item['label'] }}</span></a>
            @else
                <span itemprop="name">{{ $item['label'] }}</span>
            @endif
            <meta itemprop="position" content="{{ $index + 2 }}">
        </li>
        @endforeach
    </ol>
</nav>
