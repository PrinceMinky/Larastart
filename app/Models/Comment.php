<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getLevel(): int
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_class', 'model_id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'comment_like')->withTimestamps();
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likedByUsers()->where('user_id', $user->id)->exists();
    }

    public function likedByCurrentUser()
    {
        return $this->belongsToMany(User::class, 'comment_like')
            ->where('user_id', Auth::user()->id);
    }

    public function getIsLikedByCurrentUserAttribute(): bool
    {
        if (!Auth::check() || !$this->relationLoaded('likedByUsers')) {
            return false;
        }

        return $this->likedByUsers->contains(Auth::user()->id);
    }

    public function getUserAttribute(): ?User
    {
        return $this->relationLoaded('user') ? $this->getRelation('user') : null;
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
}