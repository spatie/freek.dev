<?php

namespace App\Livewire\Forms;

use App\Actions\CreateTestimonialAction;
use Livewire\Attributes\Rule;
use Livewire\Form;

class TestimonialForm extends Form
{
    #[Rule('required|max:500')]
    public string $text = '';

    #[Rule('required|max:255')]
    public string $author_name = '';

    #[Rule('nullable|max:255')]
    public string $author_title = '';

    #[Rule('nullable|url|max:255')]
    public string $author_url = '';

    #[Rule('nullable|image|max:1024')]
    public $avatar = null;

    public function store(): void
    {
        app(CreateTestimonialAction::class)->execute(
            attributes: $this->except(['avatar']),
            avatar: $this->avatar,
        );
    }
}
