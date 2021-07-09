<?php

namespace App\Services\CommonMark;

use DOMDocument;
use DOMXPath;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;
use Throwable;

class CommonMark
{
    public static function convertToHtml(string $markdown, $highlightCode = true): string
    {
        $environment = Environment::createCommonMarkEnvironment()
            ->addBlockRenderer(Heading::class, new HeadingRenderer());

        /*
        if ($highlightCode) {
            $environment
               ->addExtension(new HighlightCodeExtension('material-lighter'));
        }
        */


        $commonMarkConverter = new CommonMarkConverter([], $environment);

        $htmlString = $commonMarkConverter->convertToHtml($markdown);

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
