<?php

namespace App\Livewire\Forms;

use App\Actions\CreateLinkAction;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Form;

class LinkForm extends Form
{
    #[Rule('required|max:255')]
    public string $title;

    #[Rule('required|url|unique:links,url')]
    public string $url;

    #[Rule('required')]
    public string $description;

    public function store()
    {
        app(CreateLinkAction::class)->execute($this->all(), auth()->user());
    }
}
