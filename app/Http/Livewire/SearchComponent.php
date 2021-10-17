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
    use WithPagination;

    public string $query = '';

    public function render()
    {
        return view('livewire.search', [
            'hits' => $this->getResults(),
        ]);
    }

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function getResults(): ?Paginator
    {
        if ($this->query === '') {
            return null;
        }

        return SearchIndexQuery::onIndex('freek')
            ->search($this->query)
            ->paginate();
    }
}
