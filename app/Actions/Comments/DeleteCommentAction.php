<?php

namespace App\Actions\Comments;

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
        Gate::authorize('delete comments', $comment);

        return $this->commentRepository->delete($comment);
    }
}