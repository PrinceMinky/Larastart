<?php

namespace App\Events\Comments;

use App\Models\Comment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Comment $model
    ) {}

    public function activityProperties(): array
    {
        return [
            'comment_id'  => $this->model->id,
            'user_id'  => $this->model->user_id,
        ];
    }
}