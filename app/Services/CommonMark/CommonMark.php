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
    public static function convertToHtml(string $markdown): string
    {
        $languages = ['html', 'php', 'js', 'yaml', 'bash', 'blade', 'vue'];

        $environment = Environment::createCommonMarkEnvironment()
            ->addBlockRenderer(FencedCode::class, new FencedCodeRenderer($languages))
            ->addBlockRenderer(IndentedCode::class, new IndentedCodeRenderer($languages))
            ->addBlockRenderer(Heading::class, new HeadingRenderer());

        $commonMarkConverter = new CommonMarkConverter([], $environment);

        return $commonMarkConverter->convertToHtml($markdown);
    }
}
