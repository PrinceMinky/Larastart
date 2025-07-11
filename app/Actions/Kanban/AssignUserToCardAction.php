<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;

class AssignUserToCardAction
{
    public function handle(KanbanCard $card, int $userId): KanbanCard
    {
        $card->assigned_user_id = $userId;
        $card->save();

        return $card;
    }
}
