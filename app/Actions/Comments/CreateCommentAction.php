<?php

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateCommentAction
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function execute(Model $model, string $body): Comment
    {
        $comment = $this->commentRepository->create([
            'model_class' => get_class($model),
            'model_id' => $model->id,
            'user_id' => Auth::id(),
            'body' => $body,
        ]);

        return $comment;
    }
}