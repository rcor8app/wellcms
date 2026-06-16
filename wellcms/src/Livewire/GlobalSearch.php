<?php

namespace WellCMS\Livewire;

use WellCMS\Facades\WellCMS;
use WellCMS\GlobalSearch\GlobalSearchResults;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class GlobalSearch extends Component
{
    public ?string $search = '';

    public function getResults(): ?GlobalSearchResults
    {
        $search = trim($this->search);

        if (blank($search)) {
            return null;
        }

        $results = WellCMS::getGlobalSearchProvider()->getResults($this->search);

        if ($results === null) {
            return $results;
        }

        $this->dispatch('open-global-search-results');

        return $results;
    }

    public function render(): View
    {
        return view('wellcms-panels::components.global-search.index', [
            'results' => $this->getResults(),
        ]);
    }
}
