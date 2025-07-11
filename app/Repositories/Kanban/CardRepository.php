<?php

namespace App\Repositories\Kanban;

use App\Models\KanbanCard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CardRepository
{
    /**
     * Find a KanbanColumn by its ID.
     */
    public function find(int $id): KanbanCard
    {
        return KanbanCard::findOrFail($id);
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
}
