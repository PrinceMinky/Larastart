<?php

namespace App\Traits;

use App\Models\Post;
use Illuminate\Foundation\Auth\User;

trait HasLikes
{
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    }

    public function hasLiked($post)
    {
        $postId = $post instanceof \Illuminate\Database\Eloquent\Model ? $post->id : $post;
        
        if ($post instanceof \Illuminate\Database\Eloquent\Model && $post->relationLoaded('likes')) {
            return $post->likes->contains('id', $this->id);
        }
        
        if (!isset($this->likedPostsCache)) {
            $this->likedPostsCache = $this->likedPosts()->pluck('post_id')->toArray();
        }
        
        return in_array($postId, $this->likedPostsCache);
    }
}
