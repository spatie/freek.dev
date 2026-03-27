<?php

declare(strict_types=1);

namespace App\Services\CommonMark\Languages\Bash\Patterns;

use Tempest\Highlight\IsPattern;
use Tempest\Highlight\Pattern;
use Tempest\Highlight\Tokens\TokenTypeEnum;

final readonly class BashCommentPattern implements Pattern
{
    use IsPattern;

    public function getPattern(): string
    {
        return '(^|\s)(?<match>#.*)';
    }

    public function getTokenType(): TokenTypeEnum
    {
        return TokenTypeEnum::COMMENT;
    }
}
