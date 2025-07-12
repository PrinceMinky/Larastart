<?php

namespace App\Events\Kanban;

use App\Models\KanbanCard;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserUnassigned
{
    public function __construct(
        public KanbanCard $model,
    ) {}

    public function activityProperties(): array
    {
        return [
            'card_id'  => $this->model->id,
        ];
    }
}
