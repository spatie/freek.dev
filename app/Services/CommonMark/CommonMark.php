<?php

namespace App\Services\CommonMark;

use App\Services\CommonMark\Languages\Bash\BashLanguage;
use Spatie\LaravelMarkdown\MarkdownRenderer;
use Tempest\Highlight\CommonMark\HighlightExtension;
use Tempest\Highlight\Highlighter;

class CommonMark
{
    public static function convertToHtml(string $markdown, bool $highlightCode = false): string
    {
        $renderer = app(MarkdownRenderer::class);

        $renderer->disableHighlighting();

        if ($highlightCode) {
            $highlighter = new Highlighter;
            $highlighter->addLanguage(new BashLanguage());
            $renderer->addExtension(new HighlightExtension($highlighter));
        }

        return $renderer->toHtml($markdown);
    }
}
