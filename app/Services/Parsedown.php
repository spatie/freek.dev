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

        $elementName = $block['element']['name'];

        $block['element']['text'] .= " <a class='{$this->getFragmentLinkClass($elementName)}' href='#{$slug}'>#</a>";

        return $block;
    }

    protected function getFragmentLinkClass($elementName)
    {
        if ($elementName === 'h1') {
            return 'text-grey';
        }

        if ($elementName === 'h2') {
            return 'text-grey';
        }

        return 'text-grey-light';
    }
}
