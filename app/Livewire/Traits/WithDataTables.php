<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait WithDataTables 
{
    use WithModal, Sortable, Searchable, WithPagination, WithBulkActions;
}