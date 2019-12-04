<?php

namespace App\Services\CommonMark;

use Illuminate\Support\Str;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class HeadingRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {
        $element = $this->createElement($block, $htmlRenderer);

        $id = Str::slug($element->getContents());

        $element->setAttribute('id', $id);
        $element->setContents(
            $element->getContents() . ' ' .
            new HtmlElement('a', ['href' => "#{$id}", 'class' => 'permalink'], '#')
        );

        return $element;
    }

    protected function createElement(AbstractBlock $block, ElementRendererInterface $htmlRenderer): HtmlElement
    {
        $tag = 'h' . $block->getLevel();

        $attrs = $block->getData('attributes', []);

        return new HtmlElement($tag, $attrs, $htmlRenderer->renderInlines($block->children()));
    }
}
