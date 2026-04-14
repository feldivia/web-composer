{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ $siteName }} - Blog</title>
        <description>{{ $siteDescription }}</description>
        <link>{{ url('/blog') }}</link>
        <atom:link href="{{ url('/feed.xml') }}" rel="self" type="application/rss+xml"/>
        <language>es</language>
        <lastBuildDate>{{ $posts->first()?->published_at?->toRfc2822String() }}</lastBuildDate>
        @foreach($posts as $post)
        <item>
            <title>{{ htmlspecialchars($post->title) }}</title>
            <link>{{ url('/blog/' . $post->slug) }}</link>
            <guid isPermaLink="true">{{ url('/blog/' . $post->slug) }}</guid>
            <description>{{ htmlspecialchars($post->excerpt ?? Str::limit(strip_tags($post->body), 300)) }}</description>
            <pubDate>{{ $post->published_at->toRfc2822String() }}</pubDate>
            @foreach($post->categories as $category)
            <category>{{ $category->name }}</category>
            @endforeach
        </item>
        @endforeach
    </channel>
</rss>
