<?php

declare(strict_types=1);

namespace App\Services\CommonMark\Languages\Bash;

use App\Services\CommonMark\Languages\Bash\Patterns\BashCommentPattern;
use App\Services\CommonMark\Languages\Bash\Patterns\BashKeywordPattern;
use App\Services\CommonMark\Languages\Bash\Patterns\BashVariablePattern;
use Override;
use Tempest\Highlight\Languages\Base\BaseLanguage;
use Tempest\Highlight\Languages\Php\Patterns\DoubleQuoteValuePattern;
use Tempest\Highlight\Languages\Php\Patterns\SingleQuoteValuePattern;

class BashLanguage extends BaseLanguage
{
    public function getName(): string
    {
        return 'bash';
    }

    #[Override]
    public function getAliases(): array
    {
        return ['sh', 'shell', 'zsh'];
    }

    #[Override]
    public function getPatterns(): array
    {
        return [
            ...parent::getPatterns(),
            new BashKeywordPattern(),
            new BashCommentPattern(),
            new BashVariablePattern(),
            new SingleQuoteValuePattern(),
            new DoubleQuoteValuePattern(),
        ];
    }
}
