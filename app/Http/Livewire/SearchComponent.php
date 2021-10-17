<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SiteSearch\SearchIndexQuery;

class SearchComponent extends Component
{
    public string $query = '';

    public function render()
    {

        ray($this->query);
        return view('livewire.search', [
            'hits' => ray()->pass($this->getResults()),
        ]);
    }

    public function getResults(): Collection
    {
        if ($this->query === '') {
            return collect();
        }

        return SearchIndexQuery::onIndex('freek')
            ->limit(40)
            ->search($this->query)
            ->get()
            ->hits;
    }
}
