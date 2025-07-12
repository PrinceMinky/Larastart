<?php

namespace App\Events\Kanban;

use App\Models\KanbanColumn;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ColumnCreated
{
    public function __construct(
        public KanbanColumn $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'column_id'  => $this->model->id
        ];
    }
}
