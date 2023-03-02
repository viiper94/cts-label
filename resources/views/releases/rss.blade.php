<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>CTS, Creative Technologies Studio, electronic music</title>
        <link>{{ route('home') }}</link>
        <description>CTS - Creative Technologies Studio - one of the first independent record labels based in Ukraine working in electronic dance music sphere.</description>
        <language>en-us</language>
        <pubDate>{{ $releases[0]->updated_at->toRssString() }}</pubDate>
        <lastBuildDate>{{ $releases[0]->updated_at->toRssString() }}</lastBuildDate>
        <atom:link href="{{ route('rss') }}" rel="self" type="application/rss+xml" />

        @foreach($releases as $release)
            <item>
                <title>{{ $release->title }}</title>
                <link>{{ route('release', $release->id) }}</link>
                <description>{!! htmlentities(strip_tags($release->getUsefulText($release->description_en)), ENT_XML1 | ENT_COMPAT, 'UTF-8', false) !!}</description>
                <pubDate>{{ $release->created_at->toRssString() }}</pubDate>
                <guid>{{ route('release', $release->id) }}</guid>
            </item>
        @endforeach

    </channel>
</rss>
