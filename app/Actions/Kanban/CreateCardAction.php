<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;
use App\Livewire\Forms\Kanban\CardForm;
use Illuminate\Support\Facades\Gate;

class CreateCardAction
{
    /**
     * Create a new KanbanCard using data from the form.
     */
    public function handle(CardForm $form): KanbanCard
    {
        Gate::authorize('create kanban cards');

        $nextPosition = KanbanCard::where('column_id', $form->column_id)->max('position') + 1;

        return KanbanCard::create([
            'column_id' => $form->column_id,
            'title' => $form->title,
            'description' => $form->description,
            'position' => $nextPosition,
            'assigned_user_id' => $form->assigned_user_id,
            'badges' => $form->badges,
            'due_at' => $form->parseDueAt(),
        ]);
    }
}
