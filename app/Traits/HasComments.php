<?php

namespace App\Traits;

use App\Models\Comment;

trait HasComments
{
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_like')->withTimestamps();
    }
}
