<?php

namespace App\Repositories\Kanban;

use App\Models\User;
use App\Models\KanbanBoard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BoardRepository
{
    /**
     * Find a KanbanBoard by its ID.
     */
    public function find(int $id): KanbanBoard
    {
        return KanbanBoard::findOrFail($id);
    }

    /**
     * Find a KanbanBoard by its slug.
     */
    public function findBySlug(string $slug): KanbanBoard
    {
        return KanbanBoard::where('slug', $slug)->firstOrFail();
    }

    /**
     * Find a KanbanBoard by slug or ID.
     */
    public function findBySlugOrId(string $identifier): KanbanBoard
    {
        // Try to find by slug first
        $board = KanbanBoard::where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$board && is_numeric($identifier)) {
            $board = KanbanBoard::find((int) $identifier);
        }
        
        if (!$board) {
            abort(404, 'Board not found');
        }
        
        return $board;
    }

    /**
     * Find a KanbanBoard by ID with specified relations loaded.
     *
     * @param array<int,string> $relations
     */
    public function findWith(array $relations, int $id): KanbanBoard
    {
        return KanbanBoard::with($relations)->findOrFail($id);
    }

    /**
     * Find a KanbanBoard by slug with specified relations loaded.
     *
     * @param array<int,string> $relations
     */
    public function findBySlugWith(array $relations, string $slug): KanbanBoard
    {
        return KanbanBoard::with($relations)->where('slug', $slug)->firstOrFail();
    }

    /**
     * Find a KanbanBoard by slug or ID with specified relations loaded.
     *
     * @param array<int,string> $relations
     */
    public function findBySlugOrIdWith(array $relations, string $identifier): KanbanBoard
    {
        // Try to find by slug first
        $board = KanbanBoard::with($relations)->where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$board && is_numeric($identifier)) {
            $board = KanbanBoard::with($relations)->find((int) $identifier);
        }
        
        if (!$board) {
            abort(404, 'Board not found');
        }
        
        return $board;
    }

    /**
     * Find a KanbanBoard by ID with specified relations loaded.
     *
     * @param int $id
     * @param array<int,string> $relations
     * @return KanbanBoard
     */
    public function findOrFailWithRelations(int $id, array $relations): KanbanBoard
    {
        return $this->findWith($relations, $id);
    }

    /**
     * Find a KanbanBoard by slug with specified relations loaded.
     *
     * @param string $slug
     * @param array<int,string> $relations
     * @return KanbanBoard
     */
    public function findBySlugWithRelations(string $slug, array $relations): KanbanBoard
    {
        return $this->findBySlugWith($relations, $slug);
    }

    /**
     * Find a KanbanBoard by slug or ID with specified relations loaded.
     *
     * @param string $identifier
     * @param array<int,string> $relations
     * @return KanbanBoard
     */
    public function findBySlugOrIdWithRelations(string $identifier, array $relations): KanbanBoard
    {
        return $this->findBySlugOrIdWith($relations, $identifier);
    }

    /**
     * Get paginated KanbanBoards sorted by given field and direction.
     */
    public function paginated(string $sortBy, string $sortDirection, int $perPage = 25): LengthAwarePaginator
    {
        $query = KanbanBoard::with(['owner', 'users'])->withCount('users');

        match ($sortBy) {
            'owner' => $query->join('users as owners', 'kanban_boards.owner_id', '=', 'owners.id')
                             ->orderBy('owners.name', $sortDirection)
                             ->select('kanban_boards.*'),
            'members' => $query->orderBy('users_count', $sortDirection),
            'badges' => $query->orderByRaw('JSON_LENGTH(badges) ' . $sortDirection),
            default => $query->orderBy($sortBy, $sortDirection),
        };

        return $query->paginate($perPage);
    }

    /**
     * Get a collection of KanbanBoards by an array of IDs.
     *
     * @param int[] $ids
     */
    public function getManyByIds(array $ids): Collection
    {
        return KanbanBoard::whereIn('id', $ids)->get();
    }

    /**
     * Load all users of the board including the owner,
     * eager load roles, and set a custom relation usersWithOwner
     * which includes the owner if missing, sorted by role and name.
     */
    public function loadUsersWithOwner(KanbanBoard $board): KanbanBoard
    {
        $users = $board->users()->with('roles')->get();

        if ($board->owner_id && !$users->contains('id', $board->owner_id)) {
            $owner = User::find($board->owner_id);
            if ($owner) {
                $users->push($owner);
            }
        }

        $orderedUsers = $this->orderUsers($users->unique('id'));

        $board->setRelation('usersWithOwner', $orderedUsers);

        return $board;
    }

    /**
     * Order users by role (Super Admins first) then alphabetically by name.
     *
     * @param Collection<int, User> $users
     */
    public function orderUsers(Collection $users): Collection
    {
        return $users->sortBy(function (User $user) {
            $isSuperAdmin = $user->roles->contains('name', 'Super Admin') ? 0 : 1;

            return sprintf('%d_%s', $isSuperAdmin, strtolower($user->name));
        })->values();
    }
}