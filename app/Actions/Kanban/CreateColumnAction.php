<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use App\Livewire\Forms\Kanban\ColumnForm;
use App\Traits\GeneratesUniqueSlug;
use Illuminate\Support\Facades\Gate;

class CreateColumnAction
{
    use GeneratesUniqueSlug;

    /**
     * Create a new KanbanColumn using data from form.
     */
    public function handle(ColumnForm $form): KanbanColumn
    {
        Gate::authorize('create kanban columns');

        $nextPosition = KanbanColumn::where('board_id', $form->board_id)->max('position') + 1;

        // Generate unique slug for column within the board scope
        $slug = $form->slug ?: $this->generateUniqueSlug(
            $form->title,
            new KanbanColumn(),
            'slug',
            ['board_id' => $form->board_id]
        );

        return KanbanColumn::create([
            'board_id' => $form->board_id,
            'title' => $form->title,
            'slug' => $slug,
            'position' => $nextPosition,
        ]);
    }
}