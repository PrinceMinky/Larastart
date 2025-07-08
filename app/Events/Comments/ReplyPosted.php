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
        public Comment $reply,
        public Comment $parentComment
    ) {}
}