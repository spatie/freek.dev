<?php

namespace App\Services\CommonMark;

use DOMDocument;
use DOMXPath;
use League\CommonMark\Block\Element\FencedCode;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;

class CommonMark
{
    public static function convertToHtml(string $markdown, $highlightCode = true): string
    {
        $languages = ['html', 'php', 'js', 'yaml', 'bash'];

        $environment = Environment::createCommonMarkEnvironment()
            ->addBlockRenderer(Heading::class, new HeadingRenderer());

        if ($highlightCode) {
            $environment
                ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($languages))
                ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($languages));
        }

        $commonMarkConverter = new CommonMarkConverter([], $environment);

        $htmlString = $commonMarkConverter->convertToHtml($markdown);

        return self::lazyLoadImages($htmlString);
    }

    public static function lazyLoadImages($htmlString) {
        $dom = new DOMDocument;
        $dom->loadHTML($htmlString, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        foreach ($xpath->query("//img") as $node) {
            $currentLoadingAttribute = $node->getAttribute('loading');

            $node->setAttribute('loading', !empty($currentLoadingAttribute) ? $currentLoadingAttribute : 'lazy');
        }

        return $dom->saveHTML();
    }
}
