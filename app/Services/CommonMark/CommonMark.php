<?php

namespace App\Services\CommonMark;

use DOMDocument;
use DOMXPath;
use League\CommonMark\Block\Element\Heading;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Throwable;

class CommonMark
{
    public static function convertToHtml(string $markdown, $highlightCode = false): string
    {
        /** @var MarkdownRenderer $markdownRenderer */
        $markdownRenderer = app(MarkdownRenderer::class);

        $markdownRenderer
            ->addBlockRenderer(Heading::class, new HeadingRenderer());

        if (! $highlightCode) {
            $markdownRenderer->disableHighlighting();
        }

        $htmlString = $markdownRenderer->toHtml($markdown);

        return self::lazyLoadImages($htmlString);
    }

    public static function lazyLoadImages($htmlString): string
    {
        try {
            $dom = new DOMDocument;
            $dom->loadHTML($htmlString ?? '', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new DOMXPath($dom);

            foreach ($xpath->query("//img") as $node) {
                $currentLoadingAttribute = $node->getAttribute('loading');
                $node->setAttribute('loading', ! empty($currentLoadingAttribute) ? $currentLoadingAttribute : 'lazy');
            }

            return $dom->saveHTML();
        } catch (Throwable) {
            return $htmlString;
        }
    }
}
