<?php

namespace App\Actions\Kanban;

use App\Models\KanbanColumn;
use App\Traits\GeneratesUniqueSlug;
use Illuminate\Support\Facades\Gate;
use App\Livewire\Forms\Kanban\ColumnForm;

class UpdateColumnAction
{
    use GeneratesUniqueSlug;

    /**
     * Update an existing KanbanColumn found by form columnId.
     */
    public function handle(ColumnForm $form): KanbanColumn
    {
        Gate::authorize('update kanban columns');

        $column = KanbanColumn::findOrFail($form->id);

        // Determine if we need to regenerate the slug
        $slug = $form->slug;
        
        // If title has changed and no custom slug provided, or if slug is empty
        if (($column->title !== $form->title && empty($form->slug)) || empty($slug)) {
            $slug = $this->generateUniqueSlug(
                $form->title,
                new KanbanColumn(),
                'slug',
                ['board_id' => $column->board_id], // Scope to the same board
                $column->id // Exclude current column from uniqueness check
            );
        }

        $column->update([
            'title' => $form->title,
            'slug' => $slug,
        ]);

        return $column;
    }
}