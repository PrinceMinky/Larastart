<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Livewire\BaseComponent;
use App\Livewire\Traits\HasLikes;
use Illuminate\Support\Collection;
use App\Events\Comments\ReplyPosted;
use App\Services\CommentTreeService;
use Illuminate\Support\Facades\Config;
use App\Events\Comments\CommentCreated;
use App\Events\Comments\CommentDeleted;
use App\Events\Comments\CommentUpdated;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;
use App\Actions\Comments\CreateReplyAction;
use App\Actions\Comments\CreateCommentAction;
use App\Actions\Comments\DeleteCommentAction;
use App\Actions\Comments\UpdateCommentAction;
use App\Livewire\Forms\Comments\StoreReplyForm;
use App\Livewire\Forms\Comments\StoreCommentForm;
use App\Livewire\Forms\Comments\UpdateCommentForm;
use App\Livewire\Traits\ManagesCommentPermissions;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Livewire component to manage comments and replies for any Eloquent model.
 *
 * Handles listing, posting, editing, deleting comments, and liking functionality.
 *
 * @property Collection $comments Cached collection of comments for the current model.
 *
 * @property string $modelClass The fully qualified class name of the parent model.
 * @property int|string|null $modelId The ID of the parent model instance.
 * @property int|string|null $ownerId Optional owner user ID.
 * @property bool $indentReplies Whether to indent reply comments (from config).
 * @property bool $useFullName Whether to show full names for commenters (from config).
 * @property int $maxChildren Maximum depth/number of reply levels allowed.
 * @property int|null $editingId The ID of the comment currently being edited.
 * @property array<int, string> $replyBodies Reply contents keyed by parent comment ID.
 * @property array<int, bool> $replyingTo Flags to track which comments are being replied to.
 * @property string $orderBy Current ordering of comments: 'newest' or 'top'.
 *
 */
class Comments extends BaseComponent
{
    use HasLikes, ManagesCommentPermissions;

    protected string $likeModelClass = Comment::class;

    private ?Collection $commentsCache = null;

    public $modelInstance;

    /**
     * The class name of the model to which comments belong.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    public string $modelClass;

    /**
     * The ID of the model instance.
     *
     * @var int|string|null
     */
    public int|string|null $modelId;

    /**
     * The ID of the owner user (optional).
     *
     * @var int|string|null
     */
    public int|string|null $ownerId;

    /**
     * Whether to indent replies.
     *
     * @var bool
     */
    public bool $indentReplies;

    /**
     * Whether to use full names for commenters.
     *
     * @var bool
     */
    public bool $useFullName;

    /**
     * Max Number of children for comments
     *
     * @var int
     */
    public int $maxChildren = 2;

    /**
     * The comment ID currently being edited.
     *
     * @var int|null
     */
    public int|null $editingId = null;

    /**
     * Reply bodies keyed by parent comment ID.
     *
     * @var array<int, string>
     */
    public array $replyBodies = [];

    /**
     * Flags indicating whether user is replying to a comment.
     *
     * @var array<int, bool>
     */
    public array $replyingTo = [];
    
    public const ORDER_NEWEST = 'newest';
    public const ORDER_TOP = 'top';

    public string $orderBy = self::ORDER_NEWEST;

    public StoreCommentForm $storeCommentForm;
    public StoreReplyForm $storeReplyForm;
    public UpdateCommentForm $updateCommentForm;

    protected CommentTreeService $commentTreeService;
    protected CommentRepository $commentRepository;
    protected CreateCommentAction $createCommentAction;
    protected CreateReplyAction $createReplyAction;
    protected UpdateCommentAction $updateCommentAction;
    protected DeleteCommentAction $deleteCommentAction;

    public function booted(): void
    {
        $this->commentTreeService = app(CommentTreeService::class);
        $this->commentRepository = app(CommentRepository::class);
        $this->createCommentAction = app(CreateCommentAction::class);
        $this->createReplyAction = app(CreateReplyAction::class);
        $this->updateCommentAction = app(UpdateCommentAction::class);
        $this->deleteCommentAction = app(DeleteCommentAction::class);
    }

    public function mount(Model $model, $ownerId = null): void
    {
        $this->modelInstance = $model;
        $this->modelClass = get_class($model);
        $this->modelId = $model->id;
        $this->ownerId = $ownerId;
        $this->indentReplies = Config::get('comments.indentations', false);
        $this->useFullName = Config::get('comments.full_name', false);
        $this->maxChildren = Config::get('comments.max_indent_level', 2);
    }

    public function getCommentsProperty(): Collection
    {
        if ($this->commentsCache !== null) {
            return $this->commentsCache;
        }

        $model = $this->getModelInstance();

        return $this->commentsCache = $this->commentTreeService->buildCommentTree($model, $this->orderBy);
    }

    public function postComment(): void
    {
        $this->storeCommentForm->validate();

        $model = $this->getModelInstance();

        $comment = $this->createCommentAction->execute($model, $this->storeCommentForm->body);

        $this->storeCommentForm->reset();
        $this->invalidateCache();

        event(new CommentCreated($comment));

        $this->toast([
            'variant' => 'success',
            'heading' => 'Comment Posted',
            'text' => 'Your comment has been posted successfully.'
        ]);
    }

    /**
     * Post a reply to a parent comment.
     */
    public function postReply(int $parentId): void
    {
        $this->storeReplyForm->validate();

        $body = $this->storeReplyForm->body[$parentId] ?? null;

        $parentComment = $this->commentRepository->findById($parentId);
        if (!$parentComment) {
            $this->addError("storeReplyForm.body.$parentId", 'Parent comment not found.');
            return;
        }

        $model = $this->getModelInstance();

        $reply = $this->createReplyAction->execute($model, $parentComment, $body, $this->maxChildren);

        unset($this->storeReplyForm->body[$parentId]);

        $this->invalidateCache();
        $this->dispatch('reply-posted', commentId: $parentId);

        event(new ReplyPosted($reply, $parentComment));

        $this->toast([
            'variant' => 'success',
            'heading' => 'Reply Posted',
            'text' => 'You have successfully posted a reply.'
        ]);
    }

    /**
     * Prepare editing state for a specific comment.
     */
    public function startEditing(int $commentId): void
    {
        $comment = $this->commentRepository->findById($commentId);

        if (!$comment || !$this->canEdit($comment)) {
            return;
        }

        $this->editingId = $commentId;
        $this->updateCommentForm->body = $comment->body;

        $this->dispatch('focus-edit-textarea');
    }

    public function cancelEditing(): void
    {
        $this->reset(['editingId']);
        $this->updateCommentForm->reset();
    }

    /**
     * Save the updated comment after editing.
     */
    public function saveEdit(): void
    {
        $this->updateCommentForm->validate();

        $comment = $this->commentRepository->findById($this->editingId);
        if (!$comment) {
            return;
        }

        $comment = $this->updateCommentAction->execute($comment, $this->updateCommentForm->body);

        $this->reset(['editingId']);
        $this->updateCommentForm->reset();
        $this->invalidateCache();

        event(new CommentUpdated($comment, $comment->body));

        $this->toast([
            'variant' => 'success',
            'heading' => 'Comment Updated',
            'text' => 'You have successfully updated your comment.'
        ]);
    }

    public function deleteComment($id): void
    {
        $comment = $this->commentRepository->findById($id);
        if (!$comment) {
            return;
        }

        // Fire event before deletion
        event(new CommentDeleted($comment));

        $this->deleteCommentAction->execute($comment);

        $this->invalidateCache();

        $this->toast([
            'variant' => 'danger',
            'heading' => 'Comment Deleted',
            'text' => 'You have successfully deleted your comment.'
        ]);
    }

    /**
     * Returns the total number of comments including all replies.
     */
    public function getTotalCommentsCount(): int
    {
        return $this->commentTreeService->countCommentsRecursively($this->comments);
    }

    public function countDescendants(Comment $comment): int
    {
        $total = $comment->children->count();

        foreach ($comment->children as $child) {
            $total += $this->countDescendants($child);
        }

        return $total;
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->comments,
        ]);
    }

    private function resetReplyBody(int $parentId): void
    {
        $this->replyBodies[$parentId] = '';
    }

    private function invalidateCache(): void
    {
        $this->commentsCache = null;
    }

    private function getModelInstance(): Model
    {
        return $this->modelInstance;
    }
}
