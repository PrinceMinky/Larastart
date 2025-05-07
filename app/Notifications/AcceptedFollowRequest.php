<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class AcceptedFollowRequest extends Notification
{
    protected $following;

    public function __construct(User $following)
    {
        $this->following = $following;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'user_id' => $this->following->id,
            'icon' => 'user',
            'action' => '{name} has accepted your follow request.',
            'url' => route('profile.show', ['username' => $this->following->username]),
        ];
    }
}