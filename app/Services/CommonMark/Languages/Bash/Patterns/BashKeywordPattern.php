<?php

declare(strict_types=1);

namespace App\Services\CommonMark\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class BashKeywordPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        $keywords = implode('|', [
            'if', 'then', 'else', 'elif', 'fi',
            'case', 'esac', 'for', 'while', 'until', 'do', 'done',
            'in', 'function', 'select',
            'return', 'exit', 'break', 'continue',
            'alias', 'export', 'local', 'readonly', 'declare',
            'source', 'eval', 'exec', 'set', 'unset', 'shift',
            'command',
        ]);

        return "/\b(?<match>{$keywords})\b/";
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::KEYWORD;
    }
}
