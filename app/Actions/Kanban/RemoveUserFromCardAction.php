<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;

class RemoveUserFromCardAction
{
    public function handle(KanbanCard $card): KanbanCard
    {
        $card->assigned_user_id = null;
        $card->save();

        return $card;
    }
}
