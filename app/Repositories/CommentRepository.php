<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

class CommentRepository
{
    public function getCommentsForModel(Model $model, string $orderBy = 'newest'): Collection
    {
        $query = $this->getBaseQuery($model);
        
        return $this->applyOrdering($query, $orderBy)->get();
    }

    public function findById(int $id): ?Comment
    {
        return Comment::with(['likedByUsers', 'user'])->find($id);
    }

    public function findModelById(string $modelClass, int|string $id): ?Model
    {
        return $modelClass::find($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(Comment $comment, array $data): bool
    {
        return $comment->update($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function getUsersForComments(Collection $comments): SupportCollection
    {
        $allUserIds = $this->getAllUserIds($comments);
        
        if (empty($allUserIds)) {
            return collect();
        }

        return User::whereIn('id', $allUserIds)->get()->keyBy('id');
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
}