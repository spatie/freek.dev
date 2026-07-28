<?php

namespace App\Services\Utm;

use Illuminate\Support\Arr;

/**
 * Adds UTM parameters to links pointing at one of the domains in `config/utm.php`.
 *
 * When a regex fails, `preg_replace_callback` returns null. In that case the taggers
 * hand back the original content: links without UTM parameters are a lot better
 * than a blank blog post.
 */
class UtmTagger
{
    public static function tagUrl(string $url, UtmParameters $utmParameters): string
    {
        if (! static::shouldBeTagged($url)) {
            return $url;
        }

        [$url, $fragment] = array_pad(explode('#', $url, 2), 2, null);

        $separator = str_contains($url, '?') ? '&' : '?';

        $url .= $separator.http_build_query($utmParameters->toArray());

        return $fragment === null
            ? $url
            : "{$url}#{$fragment}";
    }

    public static function tagHtml(string $html, UtmParameters $utmParameters): string
    {
        return preg_replace_callback(
            '/href=(["\'])(.*?)\1/i',
            function (array $matches) use ($utmParameters): string {
                $url = html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5);

                $taggedUrl = static::tagUrl($url, $utmParameters);

                if ($taggedUrl === $url) {
                    return $matches[0];
                }

                return 'href='.$matches[1].htmlspecialchars($taggedUrl, ENT_QUOTES | ENT_HTML5).$matches[1];
            },
            $html
        ) ?? $html;
    }

    public static function tagMarkdown(string $markdown, UtmParameters $utmParameters): string
    {
        return preg_replace_callback(
            '/\]\(([^)\s]+)((?:\s+[^)]*)?)\)/',
            fn (array $matches): string => ']('
                .static::tagUrl($matches[1], $utmParameters)
                .$matches[2]
                .')',
            $markdown
        ) ?? $markdown;
    }

    protected static function shouldBeTagged(string $url): bool
    {
        $urlParts = parse_url($url);

        if (! is_string($urlParts['host'] ?? null)) {
            return false;
        }

        parse_str($urlParts['query'] ?? '', $queryParameters);

        if (isset($queryParameters['utm_source'])) {
            return false;
        }

        return static::isTrackedHost($urlParts['host']);
    }

    protected static function isTrackedHost(string $host): bool
    {
        $host = strtolower($host);

        return Arr::first(
            config('utm.tracked_domains'),
            fn (string $trackedDomain) => $host === $trackedDomain || str_ends_with($host, ".{$trackedDomain}"),
        ) !== null;
    }
}
