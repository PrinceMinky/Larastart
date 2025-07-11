<?php

namespace App\Actions\Kanban;

use App\Models\KanbanBoard;
use App\Events\Kanban\BoardUpdated;
use App\Livewire\Forms\Kanban\BoardForm;

class UpdateBoardAction
{
    public function handle(BoardForm $form): KanbanBoard
    {
        $board = KanbanBoard::findOrFail($form->boardId);
        $board->update([
            'title' => $form->title,
            'badges' => $form->badges,
        ]);

        return $board;
    }
}
