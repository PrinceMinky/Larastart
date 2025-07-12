<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    public function __construct(
        public User $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'user_id'  => $this->model->id,
        ];
    }
}
