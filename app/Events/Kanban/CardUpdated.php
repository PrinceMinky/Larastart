<?php

namespace App\Events\Kanban;

use App\Models\KanbanCard;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardUpdated
{
    public function __construct(
        public KanbanCard $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'card_id'  => $this->model->id
        ];
    }
}
