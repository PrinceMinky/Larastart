<?php

namespace App\Actions\Kanban;

use App\Models\KanbanBoard;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteBoardAction
{
    /**
     * Delete one or many boards and return deleted instances.
     *
     * @param int|array $boardIds
     * @return KanbanBoard|Collection
     */
    public function handle(int|array $boardIds): KanbanBoard|Collection
    {
        if (is_array($boardIds)) {
            $boards = KanbanBoard::whereIn('id', $boardIds)->get();

            foreach ($boards as $board) {
                $board->delete();
            }

            return $boards;
        }

        $board = KanbanBoard::findOrFail($boardIds);
        $board->delete();

        return $board;
    }
}
