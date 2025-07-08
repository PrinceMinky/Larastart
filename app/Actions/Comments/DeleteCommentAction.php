<?php

namespace App\Actions\Comments;

use App\Events\Comments\CommentDeleted;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\Gate;

class DeleteCommentAction
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function execute(Comment $comment): bool
    {
        Gate::authorize('delete', $comment);

        // Fire event before deletion since we need the comment data
        event(new CommentDeleted($comment));

        return $this->commentRepository->delete($comment);
    }
}