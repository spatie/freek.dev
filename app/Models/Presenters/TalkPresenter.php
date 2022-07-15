<?php

namespace App\Models\Presenters;

trait TalkPresenter
{
    public function getLinksAttribute(): string
    {
        return collect([
            'Slide deck' => $this->slides_link,
            'Joind.in' => $this->joindin_link,
            'Video' => $this->video_link,
        ])
            ->filter()
            ->map(fn ($url, $name) => '<a href="'.$url.'">'.$name.'</a>')
            ->implode(' | ');
    }
}
