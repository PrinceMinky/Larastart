<?php

namespace App\Events\Kanban;

use App\Models\KanbanBoard;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BoardUpdated
{
    public function __construct(
        public KanbanBoard $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'board_id'  => $this->model->id
        ];
    }
}
