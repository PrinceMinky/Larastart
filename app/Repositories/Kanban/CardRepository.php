<?php

namespace App\Repositories\Kanban;

use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use App\Models\KanbanColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CardRepository
{
    /**
     * Find a KanbanCard by its ID.
     */
    public function find(int $id): KanbanCard
    {
        return KanbanCard::findOrFail($id);
    }

    /**
     * Find a KanbanCard by its slug.
     */
    public function findBySlug(string $slug): KanbanCard
    {
        return KanbanCard::where('slug', $slug)->firstOrFail();
    }

    /**
     * Find a KanbanCard by slug or ID.
     */
    public function findBySlugOrId(string $identifier): KanbanCard
    {
        // Try to find by slug first
        $card = KanbanCard::where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$card && is_numeric($identifier)) {
            $card = KanbanCard::find((int) $identifier);
        }
        
        if (!$card) {
            abort(404, 'Card not found');
        }
        
        return $card;
    }

    public function getByColumnIdsWithRelations(array $columnIds, array $relations = [])
    {
        return KanbanCard::with($relations)
            ->whereIn('column_id', $columnIds)
            ->get();
    }

    /**
     * Find a KanbanCard by ID with optional eager loaded relations.
     *
     * @param array<int,string> $relations
     */
    public function findWith(array $relations, int $id): KanbanCard
    {
        return KanbanCard::with($relations)->findOrFail($id);
    }

    /**
     * Find a KanbanCard by slug with optional eager loaded relations.
     *
     * @param array<int,string> $relations
     */
    public function findBySlugWith(array $relations, string $slug): KanbanCard
    {
        return KanbanCard::with($relations)->where('slug', $slug)->firstOrFail();
    }

    /**
     * Find a KanbanCard by slug or ID with optional eager loaded relations.
     *
     * @param array<int,string> $relations
     */
    public function findBySlugOrIdWith(array $relations, string $identifier): KanbanCard
    {
        // Try to find by slug first
        $card = KanbanCard::with($relations)->where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$card && is_numeric($identifier)) {
            $card = KanbanCard::with($relations)->find((int) $identifier);
        }
        
        if (!$card) {
            abort(404, 'Card not found');
        }
        
        return $card;
    }

    /**
     * Find a KanbanCard by board slug, column slug, and card slug with validation.
     *
     * @param array<int,string> $relations
     */
    public function findByBoardColumnCardSlugs(string $boardSlug, string $columnSlug, string $cardSlug, array $relations = []): KanbanCard
    {
        // Find the board first
        $board = KanbanBoard::where('slug', $boardSlug)->first();
        if (!$board) {
            abort(404, 'Board not found');
        }

        // Find the column within the board
        $column = KanbanColumn::where('board_id', $board->id)
            ->where('slug', $columnSlug)
            ->first();
        if (!$column) {
            abort(404, 'Column not found');
        }

        // Find the card within the column
        $card = KanbanCard::with($relations)
            ->where('column_id', $column->id)
            ->where('slug', $cardSlug)
            ->first();
        if (!$card) {
            abort(404, 'Card not found');
        }

        return $card;
    }

    /**
     * Find a KanbanCard by board slug/ID, column slug/ID, and card slug/ID with validation.
     *
     * @param array<int,string> $relations
     */
    public function findByBoardColumnCardIdentifiers(string $boardIdentifier, string $columnIdentifier, string $cardIdentifier, array $relations = []): KanbanCard
    {
        // Find the board first (slug or ID)
        $board = KanbanBoard::where('slug', $boardIdentifier)->first();
        if (!$board && is_numeric($boardIdentifier)) {
            $board = KanbanBoard::find((int) $boardIdentifier);
        }
        if (!$board) {
            abort(404, 'Board not found');
        }

        // Find the column within the board (slug or ID)
        $column = KanbanColumn::where('board_id', $board->id)
            ->where('slug', $columnIdentifier)
            ->first();
        if (!$column && is_numeric($columnIdentifier)) {
            $column = KanbanColumn::where('board_id', $board->id)
                ->where('id', (int) $columnIdentifier)
                ->first();
        }
        if (!$column) {
            abort(404, 'Column not found');
        }

        // Find the card within the column by ID only (since cards don't have slugs)
        $card = KanbanCard::with($relations)
            ->where('column_id', $column->id)
            ->where('id', (int) $cardIdentifier)
            ->first();
        
        if (!$card) {
            abort(404, 'Card not found');
        }

        return $card;
    }

    /**
     * Find a KanbanCard by ID.
     */
    public function findById(int $id): KanbanCard
    {
        return KanbanCard::findOrFail($id);
    }

    /**
     * Refresh the KanbanCard instance from the database with optional relations.
     *
     * @param array<int,string> $relations
     */
    public function refresh(KanbanCard $card, array $relations = []): KanbanCard
    {
        $card->loadMissing($relations);
        return $card;
    }

    /**
     * Save the KanbanCard instance.
     */
    public function save(KanbanCard $card): KanbanCard
    {
        $card->save();
        return $card;
    }

    /**
     * Create a new KanbanCard with given data.
     *
     * @param array<string,mixed> $data
     */
    public function create(array $data): KanbanCard
    {
        return KanbanCard::create($data);
    }

    /**
     * Update a KanbanCard by ID with given data.
     *
     * @param int $id
     * @param array<string,mixed> $data
     */
    public function update(int $id, array $data): KanbanCard
    {
        $card = $this->findById($id);
        $card->update($data);
        return $card;
    }

    /**
     * Delete a KanbanCard by ID.
     */
    public function delete(int $id): bool
    {
        $card = $this->findById($id);
        return $card->delete();
    }

    /**
     * Get paginated KanbanCards for a given column ID, sorted by position.
     *
     * @param int $columnId
     * @param int $perPage
     * @return LengthAwarePaginator<KanbanCard>
     */
    public function getByColumnIdPaginated(int $columnId, int $perPage = 25): LengthAwarePaginator
    {
        return KanbanCard::where('column_id', $columnId)
            ->orderBy('position')
            ->paginate($perPage);
    }

    /**
     * Get all cards for a given column ID ordered by position.
     *
     * @param int $columnId
     * @return Collection<int, KanbanCard>
     */
    public function getByColumnId(int $columnId): Collection
    {
        return KanbanCard::where('column_id', $columnId)
            ->orderBy('position')
            ->get();
    }

    /**
     * Get all cards for a given column slug ordered by position.
     *
     * @param string $columnSlug
     * @param int $boardId
     * @return Collection<int, KanbanCard>
     */
    public function getByColumnSlug(string $columnSlug, int $boardId): Collection
    {
        return KanbanCard::whereHas('column', function ($query) use ($columnSlug, $boardId) {
            $query->where('slug', $columnSlug)->where('board_id', $boardId);
        })
        ->orderBy('position')
        ->get();
    }
}