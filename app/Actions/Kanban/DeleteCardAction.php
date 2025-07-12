<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;
use Illuminate\Support\Facades\Gate;

class DeleteCardAction
{
    /**
     * Delete a KanbanCard by ID.
     *
     * @param KanbanCard $card
     * @return bool
     */
    public function handle(KanbanCard $card): bool
    {
        Gate::authorize('delete kanban cards');

        return $card->delete();
    }
}
