<?php

namespace App\Events;

use App\Models\Post;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostLiked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Post $post;
    public User $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->post->user_id);
    }
}
