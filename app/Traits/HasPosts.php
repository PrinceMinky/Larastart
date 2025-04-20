<?php

namespace App\Traits;

use App\Models\Post;

trait HasPosts
{
    public function posts()
    {
        return $this->HasMany(Post::class);
    }
}
