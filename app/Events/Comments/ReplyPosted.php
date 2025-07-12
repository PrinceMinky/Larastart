<?php

namespace App\Events\Comments;

use App\Models\Comment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReplyPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Comment $model,
        public Comment $parentComment
    ) {}

    public function activityProperties(): array
    {
        return [
            'comment_id'  => $this->model->id,
            'parent_id'  => $this->model->parent_id,
            'user_id'  => $this->model->user_id,

            'original_body' => $this->parentComment->body,
        ];
    }
}