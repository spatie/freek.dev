<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Component;

class Search extends Component
{
    public string $query = '';

    public function render()
    {
        return view('livewire.search', [
            'results' => $this->getResults(),
        ]);
    }

    public function getResults(): Collection
    {
        if ($this->query === '') {
            return collect();
        }

        return Post::search($this->query)->take(30)->get();
    }
}
