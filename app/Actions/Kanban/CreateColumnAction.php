<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use App\Livewire\Forms\Kanban\ColumnForm;
use Illuminate\Support\Facades\Gate;

class CreateColumnAction
{
    /**
     * Create a new KanbanColumn using data from form.
     */
    public function handle(ColumnForm $form): KanbanColumn
    {
        Gate::authorize('create kanban columns');

        $nextPosition = KanbanColumn::where('board_id', $form->board_id)->max('position') + 1;

        return KanbanColumn::create([
            'board_id' => $form->board_id,
            'title' => $form->title,
            'position' => $nextPosition,
        ]);
    }
}
