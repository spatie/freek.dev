@props(['post' => null, 'breadcrumbs' => null])

@if($post && $post->isOriginal())
@php
echo '<script type="application/ld+json">' . json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'datePublished' => $post->publish_date?->toIso8601String(),
    'dateModified' => $post->updated_at->toIso8601String(),
    'author' => [
        '@type' => 'Person',
        'name' => 'Freek Van der Herten',
        'url' => 'https://freek.dev/about',
        'sameAs' => [
            'https://x.com/freekmurze',
            'https://github.com/freekmurze',
        ],
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'freek.dev',
        'url' => 'https://freek.dev',
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => $post->url,
    ],
    'keywords' => $post->tags->pluck('name')->implode(', '),
    'wordCount' => str_word_count(strip_tags($post->html ?? $post->text)),
    'articleSection' => $post->tags->first()?->name ?? 'Technology',
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
@endphp
@endif

@if($breadcrumbs)
@php
echo '<script type="application/ld+json">' . json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($breadcrumbs)->map(fn ($item, $index) => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item['name'],
        'item' => $item['url'],
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
@endphp
@endif
