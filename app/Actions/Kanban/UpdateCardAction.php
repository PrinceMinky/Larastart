<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;
use App\Livewire\Forms\Kanban\CardForm;
use Illuminate\Support\Facades\Gate;

class UpdateCardAction
{
    /**
     * Update an existing KanbanCard using data from the form.
     */
    public function handle(CardForm $form): KanbanCard
    {
        Gate::authorize('edit kanban cards');
        
        $card = KanbanCard::findOrFail($form->id);

        $card->update([
            'title' => $form->title,
            'description' => $form->description,
            'due_at' => $form->parseDueAt(),
            'column_id' => $form->column_id,
            'badges' => $form->badges,
            'assigned_user_id' => $form->assigned_user_id,
        ]);

        return $card;
    }
}