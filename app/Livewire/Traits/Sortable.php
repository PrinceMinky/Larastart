<?php

namespace App\Livewire\Traits;

/**
 * Trait Sortable
 *
 * Provides reusable sorting logic for Livewire components using dynamic column selection.
 * Automatically toggles sort direction on repeated clicks and applies `orderBy` constraints to queries.
 *
 * Usage:
 * - Include `use Sortable` in your Livewire component.
 * - Default sort column is `'id'` in ascending order.
 * - Call `sort('column')` from table headers or buttons.
 * - Apply sorting in render method with `applySorting($query)`.
 */
trait Sortable
{
    /**
     * The current column used for sorting.
     *
     * @var string
     */
    public $sortBy = 'id';

    /**
     * The current sorting direction (`asc` or `desc`).
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * Sets the column to sort by, toggling direction if the same column is clicked again.
     * Note: will be deprecated once I have refactored all.
     *
     * @param string $column The column name to sort by.
     * @return void
     */
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
     * Applies sorting to an Eloquent query builder instance using the current sort state.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder to modify.
     * @return \Illuminate\Database\Eloquent\Builder The updated query builder with sorting applied.
     */
    public function applySorting($query)
    {
        if ($this->sortBy) {
            return $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query;
    }
}