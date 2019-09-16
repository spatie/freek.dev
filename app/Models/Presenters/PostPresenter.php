<?php

namespace App\Models\Presenters;

use App\Models\Post;
use App\Services\CommonMark\CommonMark;
use Illuminate\Support\Str;

trait PostPresenter
{
    public function getExcerptAttribute(): string
    {
        $excerpt = $this->getManualExcerpt() ?? $this->getAutomaticExcerpt();

        $excerpt = str_replace(
            '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>',
            '<div data-lazy="twitter"></div>',
            $excerpt,
        );

        $excerpt = CommonMark::convertToHtml($excerpt);

        return trim($excerpt);
    }

    public function getNewsletterExcerptAttribute(): string
    {
        $excerpt = $this->getAutomaticExcerpt();
        $excerpt = Str::replaceLast('</p>', '', $excerpt);
        $excerpt = Str::replaceFirst('<p>', '', $excerpt);
        $excerpt = Str::before($excerpt, '<blockquote>');

        $excerpt = strip_tags($excerpt);

        return trim($excerpt);
    }

    protected function getManualExcerpt(): ?string
    {
        if (!Str::contains($this->text, '<!--more-->')) {
            return null;
        }

        return trim(Str::before($this->text, '<!--more-->'));
    }

    protected function getAutomaticExcerpt(): string
    {
        if (!$this->original_content) {
            return $this->formatted_text;
        }

        $excerpt = $this->formatted_text;

        $excerpt = Str::before($excerpt, '<blockquote>');

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

    public function getEmojiAttribute(): string
    {
        if ($this->isLink()) {
            return '🔗';
        }

        if ($this->isTweet()) {
            return '🐦';
        }

        if ($this->isOriginal()) {
            return '🌟';
        }

        return '';
    }

    public function getFormattedTypeAttribute(): string
    {
        if ($this->isOriginal()) {
            return 'Original';
        }

        return ucfirst($this->getType());
    }

    public function getThemeAttribute(): string
    {
        $tagNames = $this->tags->pluck('name');

        if ($tagNames->contains('laravel')) {
            return '#f16563';
        }

        if ($tagNames->contains('php')) {
            return '#7578ab';
        }

        if ($tagNames->contains('javascript')) {
            return '#f7df1e';
        }

        return '#cbd5e0';
    }

    public function getReadingTimeAttribute(): int
    {
        return (int)ceil(str_word_count(strip_tags($this->text)) / 200);
    }

    public function getIsOriginalAttribute(): bool
    {
        return $this->type === Post::TYPE_ORIGINAL;
    }

    public function getExternalUrlHostAttribute(): string
    {
        return parse_url($this->external_url)['host'] ?? '';
    }
}
