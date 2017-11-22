<?php

namespace App\Services;

use Parsedown as BaseParseDown;

class ParseDown extends BaseParseDown
{
    public function blockHeader($line)
    {
        $block = parent::blockHeader($line);

        $slug = str_slug($block['element']['text']);

        $block['element']['attributes']['id'] = $slug;

        $block['element']['text'] .= " <a class='text-grey' href='#{$slug}'>#</a>";

        return $block;
    }
}
