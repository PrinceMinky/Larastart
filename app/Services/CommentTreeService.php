<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

class CommentTreeService
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function buildCommentTree(Model $model, string $orderBy = 'newest'): SupportCollection
    {
        $comments = $this->commentRepository->getCommentsForModel($model, $orderBy);
        
        if ($comments->isEmpty()) {
            return collect();
        }

        $this->initializeChildrenCollections($comments);
        $rootComments = $this->buildTree($comments);
        $this->attachUsersToComments($rootComments, $comments);

        return $rootComments;
    }

    public function calculateReplyParentId(Comment $parentComment, int $maxChildren = 2): int
    {
        $currentParent = $parentComment;
        
        while ($currentParent->getLevel() >= $maxChildren) {
            if (!$currentParent->parent) {
                break;
            }
            $currentParent = $currentParent->parent;
        }

        return $currentParent->id;
    }

    public function countCommentsRecursively(SupportCollection $comments): int
    {
        $total = $comments->count();
        
        foreach ($comments as $comment) {
            $total += $this->countCommentsRecursively($comment->children);
        }

        return $total;
    }

    private function initializeChildrenCollections(Collection $comments): void
    {
        $comments->each(fn($comment) => $comment->setRelation('children', collect()));
    }

    private function buildTree(Collection $comments): SupportCollection
    {
        $commentsById = $comments->keyBy('id');
        $rootComments = collect();

        foreach ($comments as $comment) {
            if ($comment->parent_id && isset($commentsById[$comment->parent_id])) {
                $commentsById[$comment->parent_id]->children->push($comment);
            } else {
                $rootComments->push($comment);
            }
        }

        return $rootComments;
    }

    private function attachUsersToComments(SupportCollection $rootComments, Collection $comments): void
    {
        $users = $this->commentRepository->getUsersForComments($comments);
        
        if ($users->isEmpty()) {
            return;
        }

        $rootComments->each(fn($comment) => $this->assignUsersRecursively($comment, $users));
    }

    private function assignUsersRecursively(Comment $comment, SupportCollection $users): void
    {
        if ($comment->user_id && isset($users[$comment->user_id])) {
            $comment->setRelation('user', $users[$comment->user_id]);
        }

        if ($comment->relationLoaded('likedByUsers')) {
            $likedUsers = $comment->likedByUsers->map(fn($user) => $users[$user->id] ?? $user);
            $comment->setRelation('likedByUsers', $likedUsers);
        }

        if ($comment->relationLoaded('children')) {
            $comment->children->each(fn($child) => $this->assignUsersRecursively($child, $users));
        }
    }
}