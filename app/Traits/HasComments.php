<?php

namespace App\Traits;

trait HasComments
{
    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_like')->withTimestamps();
    }
}
