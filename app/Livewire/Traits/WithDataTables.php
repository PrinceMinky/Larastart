<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait WithDataTables 
{
    use Filterable, Sortable, Searchable, WithPagination, WithModal, WithBulkActions;
}