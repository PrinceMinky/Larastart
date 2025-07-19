<?php

namespace App\Actions\Kanban;

use Illuminate\Support\Facades\Gate;
use App\Repositories\Kanban\ColumnRepository;

class UpdateColumnPositionAction
{
    protected ColumnRepository $columnRepository;

    public function __construct(ColumnRepository $columnRepository)
    {
        $this->columnRepository = $columnRepository;
    }

    /**
     * Update column position scoped to a board.
     *
     * @param int $boardId
     * @param int $columnId
     * @param int $newPosition
     * @return \App\Models\KanbanColumn|null
     */
    public function handle(int $boardId, int $columnId, int $newPosition)
    {
        Gate::authorize('edit kanban columns');

        $column = $this->columnRepository->findByBoardIdAndColumnId($boardId, $columnId);
        if (!$column) {
            return null;
        }

        // Get all columns of the board ordered by position
        $columns = $this->columnRepository->getByBoardIdOrderedPlain($boardId);

        // Remove the column we're moving from the list
        $columns = $columns->filter(fn($col) => $col->id !== $columnId)->values();

        // Insert the moving column back at the new position
        $columns->splice($newPosition, 0, [$column]);

        // Re-assign positions based on the new order
        foreach ($columns as $index => $col) {
            $col->position = $index;
            $col->save();
        }

        // Return the moved column refreshed
        return $column->fresh();
    }
}
