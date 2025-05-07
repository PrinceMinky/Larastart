<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class UserFollowed extends Notification
{
    protected $follower;
    protected $status;

    public function __construct(User $follower, string $status)
    {
        $this->follower = $follower;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $this->follower->id,
            'icon' => 'user',
            'action' => $this->status === 'pending' 
                ? '{name} requested to follow you.' 
                : '{name} followed you.',
            'url' => $this->status === 'pending' 
                ? route('follow.requests') 
                : route('profile.show', ['username' => $this->follower->username]),
        ];
    }
}