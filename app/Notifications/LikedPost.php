<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Notifications\Notification;

class LikedPost extends Notification
{
    protected $user;
    protected $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,

            'icon' => 'hand-thumb-up',
            'action' => '{name} liked your post.',
            'url' => route('profile.show', ['username' => $this->user->username]),
        ];
    }
}