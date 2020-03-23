<?php

namespace App\Services\CommonMark;

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

        return $commonMarkConverter->convertToHtml($markdown);
    }
}
