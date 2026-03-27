<?php

use App\Services\CommonMark\CommonMark;

it('highlights bash code blocks', function () {
    $markdown = <<<'MD'
```bash
alias a="php artisan"
```
MD;

    $html = CommonMark::convertToHtml($markdown, highlightCode: true);

    expect($html)
        ->toContain('data-lang="bash"')
        ->toContain('hl-keyword')
        ->toContain('hl-value');
});

it('highlights bash keywords and strings in functions', function () {
    $markdown = <<<'MD'
```bash
function p() {
   if [ -f vendor/bin/pest ]; then
      vendor/bin/pest "$@"
   fi
}
```
MD;

    $html = CommonMark::convertToHtml($markdown, highlightCode: true);

    expect($html)
        ->toContain('<span class="hl-keyword">function</span>')
        ->toContain('<span class="hl-keyword">if</span>')
        ->toContain('<span class="hl-keyword">then</span>')
        ->toContain('<span class="hl-keyword">fi</span>');
});

it('supports sh and shell as aliases for bash', function () {
    $markdown = <<<'MD'
```sh
alias ls="eza"
```
MD;

    $html = CommonMark::convertToHtml($markdown, highlightCode: true);

    expect($html)
        ->toContain('data-lang="bash"')
        ->toContain('hl-keyword');
});
