<?php

namespace App\Repositories\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ColumnRepository
{
    /**
     * FIXED: Optimized default relations to prevent N+1 queries
     * Removed redundant 'cards.column' since we're loading columns directly
     */
    protected array $defaultRelations = ['cards.user'];

    /**
     * Find a KanbanColumn by its ID with cards eager loaded.
     */
    public function find(int $id): KanbanColumn
    {
        return KanbanColumn::with($this->defaultRelations)->findOrFail($id);
    }

    /**
     * Find a KanbanColumn by ID with specified relations loaded, always including cards.
     *
     * @param int $id
     * @param array<int,string> $relations
     */
    public function findWith(int $id, array $relations): KanbanColumn
    {
        // Ensure default relations are always loaded
        $relations = array_unique(array_merge($relations, $this->defaultRelations));
        return KanbanColumn::with($relations)->findOrFail($id);
    }

    /**
     * Get all columns for a specific board, ordered by position, with cards eager loaded.
     *
     * @param int $boardId
     * @return Collection<int, KanbanColumn>
     */
    public function allByBoard(int $boardId): Collection
    {
        return KanbanColumn::with($this->defaultRelations)
            ->where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Find a Kanban column by its board ID and column ID, with cards eager loaded.
     *
     * @param int $boardId
     * @param int $columnId
     * @return KanbanColumn|null
     */
    public function findByBoardIdAndColumnId(int $boardId, int $columnId): ?KanbanColumn
    {
        return KanbanColumn::with($this->defaultRelations)
            ->where('board_id', $boardId)
            ->where('id', $columnId)
            ->first();
    }

    /**
     * Get all Kanban columns for a specific board ordered by their position with cards eager loaded.
     *
     * @param int $boardId
     * @return Collection<int, KanbanColumn>
     */
    public function getByBoardIdOrdered(int $boardId): Collection
    {
        return KanbanColumn::with($this->defaultRelations)
            ->where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Get all Kanban columns for a board ordered by position without eager loading.
     */
    public function getByBoardIdOrderedPlain(int $boardId): Collection
    {
        return KanbanColumn::where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Paginate KanbanColumns sorted by given field and direction, with cards eager loaded.
     *
     * @param string $sortBy
     * @param string $sortDirection
     * @param int $perPage
     * @return LengthAwarePaginator<int, KanbanColumn>
     */
    public function paginated(string $sortBy = 'position', string $sortDirection = 'asc', int $perPage = 25): LengthAwarePaginator
    {
        return KanbanColumn::with($this->defaultRelations)
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Get all columns for a given board ID ordered by position with cards eager loaded.
     *
     * @param int $boardId
     * @return Collection<int, KanbanColumn>
     */
    public function getByBoardId(int $boardId): Collection
    {
        return KanbanColumn::with($this->defaultRelations)
            ->where('board_id', $boardId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Create a new KanbanColumn with given data.
     * After creation, load with default relations to prevent lazy loading issues.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): KanbanColumn
    {
        $column = KanbanColumn::create($data);
        
        // Force reload with relations to prevent lazy loading issues
        // Use fresh() to get a completely new instance with relations
        return $column->fresh($this->defaultRelations);
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

        // Reload relations after update to ensure fresh data
        return $column->fresh($this->defaultRelations);
    }

    /**
     * Delete a KanbanColumn by ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $column = $this->find($id);

        return $column->delete();
    }
}