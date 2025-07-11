<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Forms\Kanban\ColumnForm;

class UpdateColumnAction
{
    /**
     * Update an existing KanbanColumn found by form columnId.
     */
    public function handle(ColumnForm $form): KanbanColumn
    {
        Gate::authorize('update kanban columns');

        $column = KanbanColumn::findOrFail($form->id);

        $column->update([
            'title' => $form->title
        ]);

        return $column;
    }
}
