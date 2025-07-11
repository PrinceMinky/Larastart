<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;
use Illuminate\Support\Facades\Gate;

class DeleteCardAction
{
    /**
     * Delete a KanbanCard by ID.
     *
     * @param int $cardId
     * @return void
     */
    public function handle(int $cardId): bool
    {
        Gate::authorize('delete kanban cards');

        $card = KanbanCard::findOrFail($cardId);
        return $card->delete();
    }
}
