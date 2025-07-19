<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Repository for managing comments and related user data with optimized caching.
 */
class CommentRepository
{
    /**
     * @var array<int, User> Single cache per user ID
     */
    protected static array $userByIdCache = [];
    
    /**
     * Static cache to prevent duplicate queries within a request.
     *
     * @var array<string, EloquentCollection|Comment|null>
     */
    protected static array $commentCache = [];

    /**
     * Static cache for users keyed by hashed user ID list.
     *
     * @var array<string, Collection<int, User>>
     */
    protected static array $userCache = [];

    /**
     * Get comments for a given model, ordered by newest or top (most liked).
     *
     * @param Model $model
     * @param string $orderBy 'newest'|'top'
     * @return EloquentCollection<Comment>
     */
    public function getCommentsForModel(Model $model, string $orderBy = 'newest'): EloquentCollection
    {
        $cacheKey = $this->generateCommentsCacheKey($model, $orderBy);

        if (isset(static::$commentCache[$cacheKey])) {
            return static::$commentCache[$cacheKey];
        }

        $query = $this->getBaseQuery($model);
        $comments = $this->applyOrdering($query, $orderBy)->get();

        // Since we're eager loading users with roles in getBaseQuery, 
        // we don't need to call preloadUsersForComments anymore
        // $this->preloadUsersForComments($comments);

        static::$commentCache[$cacheKey] = $comments;

        return $comments;
    }

    /**
     * Find a comment by its ID with related user and likes.
     *
     * @param int $id
     * @return Comment|null
     */
    public function findById(int $id): ?Comment
    {
        $cacheKey = "comment_by_id_{$id}";

        if (isset(static::$commentCache[$cacheKey])) {
            return static::$commentCache[$cacheKey];
        }

        // Explicitly load the user relationship with roles to prevent lazy loading
        $comment = Comment::with(['likedByUsers', 'user.roles'])->find($id);

        if ($comment !== null) {
            static::$commentCache[$cacheKey] = $comment;
        }

        return $comment;
    }

    /**
     * Find a model instance by its class and ID.
     *
     * @param class-string<Model> $modelClass
     * @param int|string $id
     * @return Model|null
     */
    public function findModelById(string $modelClass, int|string $id): ?Model
    {
        return $modelClass::find($id);
    }

    /**
     * Create a new comment and clear related caches.
     *
     * @param array<string, mixed> $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        $comment = Comment::create($data);

        $this->clearCommentsCache($comment);

        return $comment;
    }

    /**
     * Update an existing comment and clear related caches.
     *
     * @param Comment $comment
     * @param array<string, mixed> $data
     * @return bool
     */
    public function update(Comment $comment, array $data): bool
    {
        $result = $comment->update($data);

        if ($result) {
            $this->clearCommentsCache($comment);
        }

        return $result;
    }

    /**
     * Delete a comment and clear related caches.
     *
     * @param Comment $comment
     * @return bool
     */
    public function delete(Comment $comment): bool
    {
        $result = $comment->delete();

        if ($result) {
            $this->clearCommentsCache($comment);
        }

        return $result;
    }

    /**
     * Get users associated with the given comments, including their roles.
     * 
     * @deprecated This method should not be needed if we're properly eager loading
     * @param EloquentCollection<Comment> $comments
     * @return Collection<int, User>
     */
    public function getUsersForComments(EloquentCollection $comments): Collection
    {
        // Since we're eager loading users with roles in our base queries,
        // this method should rarely be called. If it is, we'll extract
        // users from the already loaded relationships
        
        $users = collect();
        
        foreach ($comments as $comment) {
            if ($comment->relationLoaded('user') && $comment->user !== null) {
                $users->put($comment->user->id, $comment->user);
            }
        }
        
        return $users;
    }

    /**
     * Preload users and assign them to comments to prevent N+1 queries.
     * 
     * @deprecated This method should not be needed if we're properly eager loading
     * @param EloquentCollection<Comment> $comments
     * @return void
     */
    protected function preloadUsersForComments(EloquentCollection $comments): void
    {
        // Since we're eager loading users with roles in getBaseQuery,
        // this method should not be necessary anymore
        return;
    }

    /**
     * Get users by IDs with roles eagerly loaded, with stable cache keys.
     *
     * @param int[] $userIds
     * @return Collection<int, User>
     */
    public function getUsersWithRolesByIds(array $userIds): Collection
    {
        $userIds = array_unique($userIds);
        $cachedUsers = [];
        $missingUserIds = [];

        // Check cache first - only consider users that have roles loaded
        foreach ($userIds as $userId) {
            if (isset(static::$userByIdCache[$userId])) {
                $user = static::$userByIdCache[$userId];
                // Only use cached user if roles are already loaded
                if ($user->relationLoaded('roles')) {
                    $cachedUsers[$userId] = $user;
                } else {
                    // User exists in cache but roles not loaded, need to fetch
                    $missingUserIds[] = $userId;
                }
            } else {
                $missingUserIds[] = $userId;
            }
        }

        // Only query for users that aren't properly cached
        if (!empty($missingUserIds)) {
            $freshUsers = User::with(['roles'])->whereIn('id', $missingUserIds)->get();

            foreach ($freshUsers as $user) {
                static::$userByIdCache[$user->id] = $user;
                $cachedUsers[$user->id] = $user;
            }
        }

        // Return users in the same order as $userIds
        return collect($userIds)
            ->filter(fn($id) => isset($cachedUsers[$id]))
            ->map(fn($id) => $cachedUsers[$id]);
    }

    /**
     * Build base query for fetching comments for a model.
     * Always eager load the user relationship with roles to prevent lazy loading.
     *
     * @param Model $model
     * @return Builder<Comment>
     */
    private function getBaseQuery(Model $model): Builder
    {
        return Comment::with(['likedByUsers', 'user.roles'])
            ->where('model_class', get_class($model))
            ->where('model_id', $model->getKey());
    }

    /**
     * Apply ordering to the comment query.
     *
     * @param Builder<Comment> $query
     * @param string $orderBy 'top'|'newest'
     * @return Builder<Comment>
     */
    private function applyOrdering(Builder $query, string $orderBy): Builder
    {
        return $orderBy === 'top'
            ? $query->withCount('likedByUsers')
                ->orderBy('liked_by_users_count', 'desc')
                ->orderBy('created_at', 'desc')
            : $query->orderBy('created_at', 'desc');
    }

    /**
     * Extract all unique user IDs from comments and their likes.
     *
     * @param EloquentCollection<Comment> $comments
     * @return int[]
     */
    private function getAllUserIds(EloquentCollection $comments): array
    {
        $commentUserIds = $comments->pluck('user_id')->filter()->unique()->toArray();

        $likedUserIds = $comments
            ->flatMap(fn(Comment $comment) => $comment->likedByUsers->pluck('id'))
            ->filter()
            ->unique()
            ->toArray();

        return array_unique(array_merge($commentUserIds, $likedUserIds));
    }

    /**
     * Clear caches related to a specific comment.
     *
     * @param Comment $comment
     * @return void
     */
    protected function clearCommentsCache(Comment $comment): void
    {
        // Clear cache for this comment ID
        unset(static::$commentCache["comment_by_id_{$comment->getKey()}"]);

        // Clear cache for all comments on the related model
        $modelClass = $comment->model_class;
        $modelId = $comment->model_id;

        $modelCachePrefix = "comments_for_model_{$modelClass}_{$modelId}";

        foreach (array_keys(static::$commentCache) as $key) {
            if (Str::startsWith($key, $modelCachePrefix)) {
                unset(static::$commentCache[$key]);
            }
        }
    }

    /**
     * Clear all cached comments and users.
     *
     * @return void
     */
    public function clearCaches(): void
    {
        static::$commentCache = [];
        static::$userCache = [];
        static::$userByIdCache = [];
    }

    /**
     * Bulk load comments for multiple models with optimized queries.
     *
     * @param Model[] $models
     * @param string $orderBy 'newest'|'top'
     * @return EloquentCollection<Comment>
     */
    public function getCommentsForModels(array $models, string $orderBy = 'newest'): EloquentCollection
    {
        if (empty($models)) {
            return collect();
        }

        $allComments = collect();
        $groupedModels = collect($models)->groupBy(fn(Model $model) => get_class($model));

        foreach ($groupedModels as $modelClass => $modelGroup) {
            $modelIds = $modelGroup->pluck('id')->toArray();

            // Always eager load user relationship with roles to prevent lazy loading
            $query = Comment::with(['likedByUsers', 'user.roles'])
                ->where('model_class', $modelClass)
                ->whereIn('model_id', $modelIds);

            if ($orderBy === 'top') {
                $query->withCount('likedByUsers')
                    ->orderBy('liked_by_users_count', 'desc')
                    ->orderBy('created_at', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $comments = $query->get();
            $allComments = $allComments->merge($comments);
        }

        // No need to preload users since they're already eager loaded
        return $allComments;
    }

    /**
     * Generate a stable cache key for comments of a model and ordering.
     *
     * @param Model $model
     * @param string $orderBy
     * @return string
     */
    private function generateCommentsCacheKey(Model $model, string $orderBy): string
    {
        return "comments_for_model_" . get_class($model) . "_{$model->getKey()}_{$orderBy}";
    }
}