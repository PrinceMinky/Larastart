<?php

namespace App\Actions\Comments;

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
        Gate::authorize('update comments', $comment);

        tap($comment)->update(['body' => $body]);

        return $comment;
    }
}