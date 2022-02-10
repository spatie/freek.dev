<?php

namespace App\Services\CommonMark;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class CommonMark
{
    public static function convertToHtml(string $markdown, bool $highlightCode = false): string
    {
        $renderer = app(MarkdownRenderer::class);

        if (!$highlightCode) {
            $renderer->disableHighlighting();
        }

        return $renderer->toHtml($markdown);
    }
}
