<?php

namespace App\Events\Badwords;

use App\Models\Badword;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadwordUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Badword $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'badword_id' => $this->model->id
        ];
    }
}