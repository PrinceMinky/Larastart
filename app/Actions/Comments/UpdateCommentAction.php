<?php

namespace App\Actions\Comments;

use App\Events\Comments\CommentUpdated;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Gate;

class UpdateCommentAction
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function execute(Comment $comment, string $body): Comment
    {
        Gate::authorize('update', $comment);

        $originalBody = $comment->body;

        tap($comment)->update(['body' => $body]);

        event(new CommentUpdated($comment, $originalBody));

        return $comment;
    }
}