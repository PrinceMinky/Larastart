<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LikeService
{
    public function toggle(Model $model, int $userId, string $relation = 'likedByUsers'): void
    {
        $relationQuery = $model->{$relation}();

        $relationQuery->where('user_id', $userId)->exists()
            ? $relationQuery->detach($userId)
            : $relationQuery->attach($userId);
    }

    public function hasUserLiked(Model $model, int $userId, string $relation = 'likedByUsers'): bool
    {
        return $model->{$relation}()->where('user_id', $userId)->exists();
    }

    public function getUserLikedIds(string $modelClass, int $userId, string $relation = 'likedByUsers'): array
    {
        $model = new $modelClass;
        $pivotTable = $model->{$relation}()->getTable();
        $foreignKey = $model->{$relation}()->getForeignPivotKeyName();

        return DB::table($pivotTable)
            ->where('user_id', $userId)
            ->pluck($foreignKey)
            ->toArray();
    }
}
