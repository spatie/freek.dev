<?php

namespace App\Models\Presenters;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait PostPresenter
{
    public function getExcerptAttribute(): string
    {
        if (! $this->original_content) {
            return $this->formatted_text;
        }

        $excerpt = trim($this->formatted_text);

        $excerpt = Str::before($excerpt, '<blockquote>');

        //remove html
        $excerpt = strip_tags($excerpt);

        //replace multiple spaces
        $excerpt = preg_replace("/\s+/", ' ', $excerpt);

        if (strlen($excerpt) == 0) {
            return '';
        }

        if (strlen($excerpt) <= 300) {
            return $excerpt;
        }

        $ww = wordwrap($excerpt, 300, "\n");

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
