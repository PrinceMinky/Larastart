<?php

namespace App\Repositories\Kanban;

use App\Models\User;
use App\Models\KanbanBoard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class BoardRepository
{
    // Static cache to prevent duplicate queries within request
    protected static $boardCache = [];
    protected static $userCache = [];

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
     * Find a KanbanBoard by slug or ID with caching.
     */
    public function findBySlugOrId(string $identifier): KanbanBoard
    {
        $cacheKey = "board_slug_or_id_{$identifier}";
        
        if (isset(static::$boardCache[$cacheKey])) {
            return static::$boardCache[$cacheKey];
        }

        // Try to find by slug first
        $board = KanbanBoard::where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$board && is_numeric($identifier)) {
            $board = KanbanBoard::find((int) $identifier);
        }
        
        if (!$board) {
            abort(404, 'Board not found');
        }
        
        static::$boardCache[$cacheKey] = $board;
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
     * Optimized find by slug or ID with relations.
     *
     * @param array<int,string> $relations
     */
    public function findBySlugOrIdWith(array $relations, string $identifier): KanbanBoard
    {
        $cacheKey = "board_with_relations_{$identifier}_" . md5(implode(',', $relations));
        
        if (isset(static::$boardCache[$cacheKey])) {
            return static::$boardCache[$cacheKey];
        }

        // Try to find by slug first
        $board = KanbanBoard::with($relations)->where('slug', $identifier)->first();
        
        // If not found and identifier is numeric, try by ID
        if (!$board && is_numeric($identifier)) {
            $board = KanbanBoard::with($relations)->find((int) $identifier);
        }
        
        if (!$board) {
            abort(404, 'Board not found');
        }
        
        static::$boardCache[$cacheKey] = $board;
        return $board;
    }

    /**
     * Alias methods for backward compatibility
     */
    public function findOrFailWithRelations(int $id, array $relations): KanbanBoard
    {
        return $this->findWith($relations, $id);
    }

    public function findBySlugWithRelations(string $slug, array $relations): KanbanBoard
    {
        return $this->findBySlugWith($relations, $slug);
    }

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
     * Get a collection of KanbanBoards by an array of IDs with caching.
     *
     * @param int[] $ids
     */
    public function getManyByIds(array $ids): Collection
    {
        $cacheKey = 'boards_by_ids_' . md5(implode(',', $ids));
        
        if (isset(static::$boardCache[$cacheKey])) {
            return static::$boardCache[$cacheKey];
        }

        static::$boardCache[$cacheKey] = KanbanBoard::whereIn('id', $ids)->get();
        return static::$boardCache[$cacheKey];
    }

    /**
     * Optimized method to load users with owner, preventing duplicate role queries.
     */
    public function loadUsersWithOwner(KanbanBoard $board): KanbanBoard
    {
        $cacheKey = "board_users_with_owner_{$board->id}";
        
        if (isset(static::$boardCache[$cacheKey])) {
            $board->setRelation('usersWithOwner', static::$boardCache[$cacheKey]);
            return $board;
        }

        // Get all user IDs that need to be loaded
        $userIds = $board->users()->pluck('users.id')->toArray();
        
        // Add owner if not already included
        if ($board->owner_id && !in_array($board->owner_id, $userIds)) {
            $userIds[] = $board->owner_id;
        }

        // Single query to get all users with roles
        $users = $this->getUsersWithRolesByIds($userIds);
        
        $orderedUsers = $this->orderUsers($users);
        
        static::$boardCache[$cacheKey] = $orderedUsers;
        $board->setRelation('usersWithOwner', $orderedUsers);

        return $board;
    }

    /**
     * Get users with roles by IDs with caching to prevent duplicate queries.
     */
    protected function getUsersWithRolesByIds(array $userIds): Collection
    {
        if (empty($userIds)) {
            return collect();
        }

        $cacheKey = 'users_with_roles_' . md5(implode(',', $userIds));
        
        if (isset(static::$userCache[$cacheKey])) {
            return static::$userCache[$cacheKey];
        }

        // Single optimized query with eager loading
        static::$userCache[$cacheKey] = User::with('roles')
            ->whereIn('id', $userIds)
            ->get()
            ->keyBy('id');

        return static::$userCache[$cacheKey];
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

    /**
     * Clear caches when needed
     */
    public function clearCaches(): void
    {
        static::$boardCache = [];
        static::$userCache = [];
    }
}