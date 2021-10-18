<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\SiteSearch\Search;
use Spatie\SiteSearch\SearchIndexQuery;

class SearchComponent extends Component
{
    public string $query = '';

    public function render()
    {
        info($this->query);
        info(count($this->getResults()) . ' hits');
        return view('livewire.search', [
            'hits' => $this->getResults(),
        ]);
    }

    public function getResults(): Collection
    {
        if ($this->query === '') {
            return collect();
        }

        return Search::onIndex('freek')
            ->limit(40)
            ->query($this->query)
            ->get()
            ->hits;
    }
}
