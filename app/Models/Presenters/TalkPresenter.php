<?php

namespace App\Models\Presenters;

trait TalkPresenter
{
    public function getLinksAttribute(): string
    {
        return collect([
            'Video' => $this->video_link,
            'Slide deck' => $this->slides_link,
            'Joind.in' => $this->joindin_link
        ])
            ->filter()
            ->map(function ($url, $name) {
                return '<a href="' . $url . '">' . $name . '</a>';
            })

            ->implode(' | ');
    }
}
