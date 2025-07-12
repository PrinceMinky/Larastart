<?php

namespace App\Events\Kanban;

use App\Models\User;
use App\Models\KanbanCard;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserAssigned
{
    public function __construct(
        public KanbanCard $model,
    ) {}

    public function activityProperties(): array
    {
        return [
            'card_id'  => $this->model->id,
            'assigned_user' => $this->model->user->id,
            'assigned_user_name' => $this->model->user->name,
        ];
    }
}
