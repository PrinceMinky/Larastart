<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Cache;

class CommentRepository
{
    // Static cache to prevent duplicate queries within request
    protected static $commentCache = [];
    protected static $userCache = [];

    public function getCommentsForModel(Model $model, string $orderBy = 'newest'): Collection
    {
        $cacheKey = "comments_for_model_" . get_class($model) . "_{$model->id}_{$orderBy}";
        
        if (isset(static::$commentCache[$cacheKey])) {
            return static::$commentCache[$cacheKey];
        }

        $query = $this->getBaseQuery($model);
        $comments = $this->applyOrdering($query, $orderBy)->get();
        
        // Preload users for all comments to prevent N+1 queries
        $this->preloadUsersForComments($comments);
        
        static::$commentCache[$cacheKey] = $comments;
        return $comments;
    }

    public function findById(int $id): ?Comment
    {
        $cacheKey = "comment_by_id_{$id}";
        
        if (isset(static::$commentCache[$cacheKey])) {
            return static::$commentCache[$cacheKey];
        }

        $comment = Comment::with(['likedByUsers', 'user'])->find($id);
        
        if ($comment) {
            static::$commentCache[$cacheKey] = $comment;
        }
        
        return $comment;
    }

    public function findModelById(string $modelClass, int|string $id): ?Model
    {
        return $modelClass::find($id);
    }

    public function create(array $data): Comment
    {
        $comment = Comment::create($data);
        
        // Clear related caches
        $this->clearCommentsCache($comment);
        
        return $comment;
    }

    public function update(Comment $comment, array $data): bool
    {
        $result = $comment->update($data);
        
        // Clear related caches
        $this->clearCommentsCache($comment);
        
        return $result;
    }

    public function delete(Comment $comment): bool
    {
        $result = $comment->delete();
        
        // Clear related caches
        $this->clearCommentsCache($comment);
        
        return $result;
    }

    /**
     * Optimized method to get users for comments, preventing duplicate role queries.
     */
    public function getUsersForComments(Collection $comments): Collection
    {
        $userIds = $comments
            ->pluck('user_id')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        return $this->getUsersWithRolesByIds($userIds);
    }

    /**
     * Preload users for comments to prevent N+1 queries.
     */
    protected function preloadUsersForComments(Collection $comments): void
    {
        $userIds = $this->getAllUserIds($comments);
        
        if (empty($userIds)) {
            return;
        }

        $users = $this->getUsersWithRolesByIds($userIds);
        
        // Set the user relation on each comment
        foreach ($comments as $comment) {
            if ($comment->user_id && $users->has($comment->user_id)) {
                $comment->setRelation('user', $users->get($comment->user_id));
            }
        }
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

    private function getBaseQuery(Model $model): Builder
    {
        return Comment::with(['likedByUsers'])
            ->where('model_class', get_class($model))
            ->where('model_id', $model->id);
    }

    private function applyOrdering(Builder $query, string $orderBy): Builder
    {
        return $orderBy === 'top' 
            ? $query->withCount('likedByUsers')
                    ->orderBy('liked_by_users_count', 'desc')
                    ->orderBy('created_at', 'desc')
            : $query->orderBy('created_at', 'desc');
    }

    private function getAllUserIds(Collection $comments): array
    {
        $userIds = $comments->pluck('user_id')->filter()->unique()->toArray();
        
        $likedUserIds = $comments
            ->flatMap(fn($c) => $c->likedByUsers->pluck('id'))
            ->filter()
            ->unique()
            ->toArray();

        return array_unique(array_merge($userIds, $likedUserIds));
    }

    /**
     * Clear comment-related caches when comment is modified.
     */
    protected function clearCommentsCache(Comment $comment): void
    {
        // Clear specific comment cache
        unset(static::$commentCache["comment_by_id_{$comment->id}"]);
        
        // Clear model comments cache
        $modelClass = $comment->model_class;
        $modelId = $comment->model_id;
        
        $keysToRemove = array_filter(
            array_keys(static::$commentCache),
            fn($key) => str_contains($key, "comments_for_model_{$modelClass}_{$modelId}")
        );
        
        foreach ($keysToRemove as $key) {
            unset(static::$commentCache[$key]);
        }
    }

    /**
     * Clear all caches.
     */
    public function clearCaches(): void
    {
        static::$commentCache = [];
        static::$userCache = [];
    }

    /**
     * Bulk load comments with optimized queries for multiple models.
     */
    public function getCommentsForModels(array $models, string $orderBy = 'newest'): Collection
    {
        if (empty($models)) {
            return collect();
        }

        $allComments = collect();
        $groupedModels = collect($models)->groupBy(fn($model) => get_class($model));

        foreach ($groupedModels as $modelClass => $modelGroup) {
            $modelIds = $modelGroup->pluck('id')->toArray();
            
            $comments = Comment::with(['likedByUsers'])
                ->where('model_class', $modelClass)
                ->whereIn('model_id', $modelIds)
                ->when($orderBy === 'top', function ($query) {
                    return $query->withCount('likedByUsers')
                                ->orderBy('liked_by_users_count', 'desc')
                                ->orderBy('created_at', 'desc');
                }, function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->get();

            $allComments = $allComments->merge($comments);
        }

        // Preload users for all comments at once
        $this->preloadUsersForComments($allComments);

        return $allComments;
    }
}