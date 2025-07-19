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

    /**
     * Builds a hierarchical comment tree for the given model.
     *
     * @param Model $model
     * @param string $orderBy
     * @return SupportCollection<Comment>
     */
    public function buildCommentTree(Model $model, string $orderBy = 'newest'): SupportCollection
    {
        $comments = $this->commentRepository->getCommentsForModel($model, $orderBy);
        
        if ($comments->isEmpty()) {
            /** @var SupportCollection<Comment> */
            return collect();
        }

        $this->initializeChildrenCollections($comments);
        $rootComments = $this->buildTree($comments);
        
        // Remove this line - users are already attached via eager loading
        // $this->attachUsersToComments($rootComments, $comments);

        return $rootComments;
    }

    /**
     * Calculate the appropriate parent comment ID for a reply,
     * ensuring max indentation level is not exceeded.
     *
     * @param Comment $parentComment
     * @param int $maxIndentLevel Maximum allowed depth for comment nesting
     * @return int
     */
    public function calculateReplyParentId(Comment $parentComment, int $maxIndentLevel = 2): int
    {
        $currentParent = $parentComment;
        
        while ($currentParent->getLevel() >= $maxIndentLevel) {
            if (!$currentParent->parent) {
                break;
            }
            $currentParent = $currentParent->parent;
        }

        return $currentParent->id;
    }

    /**
     * Count all comments recursively including children.
     *
     * @param SupportCollection<Comment> $comments
     * @return int
     */
    public function countCommentsRecursively(SupportCollection $comments): int
    {
        $total = $comments->count();
        
        foreach ($comments as $comment) {
            $total += $this->countCommentsRecursively($comment->children);
        }

        return $total;
    }

    /**
     * Initialize empty children collections on all comments.
     *
     * @param Collection<Comment> $comments
     * @return void
     */
    private function initializeChildrenCollections(Collection $comments): void
    {
        $comments->each(fn(Comment $comment) => $comment->setRelation('children', collect()));
    }

    /**
     * Build a tree of comments by assigning children to their parents.
     *
     * @param Collection<Comment> $comments
     * @return SupportCollection<Comment>
     */
    private function buildTree(Collection $comments): SupportCollection
    {
        $commentsById = $comments->keyBy('id');
        $rootComments = collect();

        foreach ($comments as $comment) {
            if ($comment->parent_id !== null && $commentsById->has($comment->parent_id)) {
                $commentsById->get($comment->parent_id)->children->push($comment);
            } else {
                $rootComments->push($comment);
            }
        }

        return $rootComments;
    }

    /**
     * Attach user models to comments and recursively to children.
     * 
     * @deprecated This method is no longer needed since users are eager loaded
     * @param SupportCollection<Comment> $rootComments
     * @param Collection<Comment> $comments
     * @return void
     */
    private function attachUsersToComments(SupportCollection $rootComments, Collection $comments): void
    {
        // This method is no longer needed since we're eager loading users with roles
        // in the repository's getBaseQuery method
        return;
    }

    /**
     * Recursively assigns user models to comments and their children.
     * 
     * @deprecated This method is no longer needed since users are eager loaded
     * @param Comment $comment
     * @param SupportCollection<int, \App\Models\User> $users Keyed by user ID
     * @return void
     */
    private function assignUsersRecursively(Comment $comment, SupportCollection $users): void
    {
        // This method is no longer needed since we're eager loading users with roles
        // in the repository's getBaseQuery method
        return;
    }
}