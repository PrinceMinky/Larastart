<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Support\Facades\Gate;

class DeleteColumnAction
{
    /**
     * Delete a KanbanColumn by ID.
     *
     * @param int $columnId
     * @return KanbanColumn
     */
    public function handle(int $columnId): bool
    {
        Gate::authorize('delete kanban columns');

        $column = KanbanColumn::findOrFail($columnId);
        return $column->delete();
    }
}
