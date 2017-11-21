<?php

namespace App\Models\Presenters;

trait PostPresenter
{
    public function getExcerptAttribute(): string
    {
        if ($this->concernsTweet()) {
            return '';
        }

        $excerpt = trim($this->text);

        $excerpt = str_before($excerpt, '<blockquote>');

        //remove html
        $excerpt = strip_tags($excerpt);

        //replace multiple spaces
        $excerpt = preg_replace("/\s+/", ' ', $excerpt);

        if (strlen($excerpt) == 0) {
            return '';
        }

        if (strlen($excerpt) <= 150) {
            return $excerpt;
        }

        $ww = wordwrap($excerpt, 150, "\n");

        $excerpt = substr($ww, 0, strpos($ww, "\n")) . '…';

        return $excerpt;
    }

    public function getTagsTextAttribute(): string
    {
        return $this
            ->tags
            ->pluck('name')
            ->implode(', ');
    }

    public function getFormattedTitleAttribute(): string
    {
        $prefix = $this->original_content
            ? '★ '
            : '';

        return $prefix . $this->title;
    }
}
