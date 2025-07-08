<?php

namespace App\Actions\Comments;

use App\Events\Comments\ReplyPosted;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Services\CommentTreeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateReplyAction
{
    public function __construct(
        private CommentRepository $commentRepository,
        private CommentTreeService $commentTreeService
    ) {}

    public function execute(Model $model, Comment $parentComment, string $body, int $maxChildren = 2): Comment
    {
        $parentId = $this->commentTreeService->calculateReplyParentId($parentComment, $maxChildren);
        
        $reply = $this->commentRepository->create([
            'model_class' => get_class($model),
            'model_id' => $model->id,
            'user_id' => Auth::id(),
            'body' => $body,
            'parent_id' => $parentId,
        ]);

        event(new ReplyPosted($reply, $parentComment));

        return $reply;
    }
}