<?php

namespace App\Services\CommonMark;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\HeadingRenderer as BaseHeadingRenderer;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class HeadingRenderer extends BaseHeadingRenderer
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        $element = parent::render($block, $htmlRenderer, $inTightList);

        $id = str_slug($element->getContents());

        $element->setAttribute('id', $id);
        $element->setContents(
            $element->getContents() .
            new HtmlElement('a', ['href' => "#{$id}", 'class' => $this->getFragmentLinkClass($element->getTagName())], ' #')
        );

        return $element;
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
