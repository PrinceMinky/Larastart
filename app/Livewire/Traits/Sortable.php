<?php

namespace App\Livewire\Traits;

trait Sortable
{
    public $sortBy = 'id';
    public $sortDirection = 'asc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Apply sorting to the given query if sortBy is set.
     */
    public function applySorting($query)
    {
        if ($this->sortBy) {
            return $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query;
    }
}
