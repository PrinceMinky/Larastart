<?php

namespace App\Livewire\Traits;

trait Searchable
{
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function applySearch($query, array $searchableFields = ['name'])
    {
        if ($this->search) {
            $query->where(function ($q) use ($searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$this->search}%");
                }
            });
        }
    }
}
