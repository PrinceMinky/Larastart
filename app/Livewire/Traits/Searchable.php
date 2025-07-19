<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Schema;

/**
 * Trait Searchable
 *
 * Adds reusable search functionality to Livewire components.
 * Handles keyword filtering across multiple database columns and validates column existence.
 *
 * Usage:
 * - Add `use Searchable` to your Livewire component.
 * - Define `public $search` and call `applySearch($query, ['field1', 'field2'])` within your render method.
 * - Optionally call `validateSearchableFields()` in mount() to catch misconfigurations early.
 */
trait Searchable
{
    /**
     * The current search keyword entered by the user.
     *
     * @var string
     */
    public $search = '';

    /**
     * Automatically resets pagination when the search query changes.
     *
     * This ensures the user starts from the first page after updating their search term.
     *
     * @return void
     */
    public function updatedSearch()
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * Applies the search filter to a query using the provided searchable fields.
     *
     * This method will perform a case-insensitive partial match (`LIKE`) across all fields.
     * Fields are validated prior to query manipulation.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance to apply filters to.
     * @param array $searchableFields The list of column names to search in. Defaults to ['name'].
     * @return void
     *
     * @throws \InvalidArgumentException If any provided field does not exist in the database table.
     */
    public function applySearch($query, array $searchableFields = ['name'])
    {
        $this->validateSearchableFields($query, $searchableFields);

        if ($this->search) {
            $query->where(function ($q) use ($searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'LIKE', "%{$this->search}%");
                }
            });
        }
    }

    /**
     * Validates that all searchable fields exist in the associated database table.
     *
     * Helps prevent runtime query errors by catching misconfigured field names during development.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder with access to the model and table.
     * @param array $searchableFields List of field names to validate.
     * @return void
     *
     * @throws \InvalidArgumentException If a field is not present in the table's schema.
     */
    protected function validateSearchableFields($query, array $searchableFields): void
    {
        $model = $query->getModel();
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);

        foreach ($searchableFields as $field) {
            if (!in_array($field, $columns)) {
                throw new \InvalidArgumentException("Searchable field '{$field}' does not exist on '{$table}' table.");
            }
        }
    }
}