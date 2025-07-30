<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Blade;

trait WithDataTables 
{
    use Filterable, Sortable, Searchable, WithPagination, WithModal, WithBulkActions;

    public $perPage = 25;
    public $pagesList = [10, 25, 50, 100, 250, 500];

    public function perPageForm()
    {
        return Blade::render(
            '<x-filters.perPage />'
        );
    }

    public function getPerPage(): int
    {
        return (int) $this->perPage;
    }

    public function UpdatedPerPage()
    {
        return $this->resetPage();
    }
}