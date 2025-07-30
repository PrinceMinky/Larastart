<?php

namespace App\Livewire\Traits;

trait WithBulkActions 
{
    public array $selectedItems = [];

    /**
     * Reset to first page if current page has no results.
     */
    protected function resetPageIfEmpty($collection): void
    {
        if ($collection->isEmpty() && $this->paginators['page'] > 1) {
            $this->resetPage();
        }
    }

    /**
     * Clear selected items and optionally reset page.
     */
    protected function clearSelection(): void
    {
        $this->reset('selectedItems');
    }
}