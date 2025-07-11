<?php

namespace App\Repositories\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ColumnRepository
{
    /**
     * Find a KanbanColumn by its ID.
     */
    public function find(int $id): KanbanColumn
    {
        return KanbanColumn::findOrFail($id);
    }

    /**
     * Find a KanbanColumn by ID with specified relations loaded.
     *
     * @param array<int,string> $relations
     */
    public function findWith(array $relations, int $id): KanbanColumn
    {
        return KanbanColumn::with($relations)->findOrFail($id);
    }

    /**
     * Get all columns for a specific board, ordered by position.
     *
     * @param int $boardId
     * @return \Illuminate\Database\Eloquent\Collection|KanbanColumn[]
     */
    public function allByBoard(int $boardId)
    {
        return KanbanColumn::where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Find a Kanban column by its board ID and column ID.
     *
     * @param int $boardId The ID of the Kanban board.
     * @param int $columnId The ID of the Kanban column.
     * @return KanbanColumn|null Returns the KanbanColumn model if found, otherwise null.
     */
    public function findByBoardIdAndColumnId(int $boardId, int $columnId)
    {
        return KanbanColumn::where('board_id', $boardId)
                ->where('id', $columnId)
                ->first();
    }

    /**
     * Get all Kanban columns for a specific board ordered by their position.
     *
     * @param int $boardId The ID of the Kanban board.
     * @return \Illuminate\Database\Eloquent\Collection|KanbanColumn[] Collection of KanbanColumn models ordered by position.
     */
    public function getByBoardIdOrdered(int $boardId)
    {
        return KanbanColumn::where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Get paginated KanbanColumns sorted by given field and direction.
     */
    public function paginated(string $sortBy = 'position', string $sortDirection = 'asc', int $perPage = 25): LengthAwarePaginator
    {
        return KanbanColumn::orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    /**
     * Get all columns for a given board ID ordered by position.
     *
     * @param int $boardId
     * @return Collection<int, KanbanColumn>
     */
    public function getByBoardId(int $boardId): Collection
    {
        return KanbanColumn::where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Create a new KanbanColumn with given data.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): KanbanColumn
    {
        return KanbanColumn::create($data);
    }

    /**
     * Update an existing KanbanColumn by ID with given data.
     *
     * @param int $id
     * @param array<string, mixed> $data
     */
    public function update(int $id, array $data): KanbanColumn
    {
        $column = $this->find($id);
        $column->update($data);

        return $column;
    }

    /**
     * Delete a KanbanColumn by ID.
     */
    public function delete(int $id): bool
    {
        $column = $this->find($id);

        return $column->delete();
    }
}
