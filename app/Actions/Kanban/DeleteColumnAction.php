<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Support\Facades\Gate;

class DeleteColumnAction
{
    /**
     * Delete a KanbanColumn by ID.
     *
     * @param KanbanColumn
     * @return bool
     */
    public function handle(KanbanColumn $column): bool
    {
        Gate::authorize('delete kanban columns');

        return $column->delete();
    }
}
