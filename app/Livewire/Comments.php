<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use App\Livewire\Traits\HasLikes;
use Illuminate\Support\Collection;
use App\Services\CommentTreeService;
use App\Livewire\Forms\StoreReplyForm;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;
use App\Livewire\Forms\StoreCommentForm;
use App\Livewire\Forms\UpdateCommentForm;
use App\Livewire\Traits\ManagesCommentPermissions;
use App\Actions\Comments\CreateReplyAction;
use App\Actions\Comments\CreateCommentAction;
use App\Actions\Comments\DeleteCommentAction;
use App\Actions\Comments\UpdateCommentAction;

class Comments extends Component
{
    use HasLikes, ManagesCommentPermissions;

    protected string $likeModelClass = Comment::class;

    private ?Collection $commentsCache = null;

    public $modelClass;
    public $modelId;
    public $ownerId;
    public $indentReplies;
    public $useFullName;

    public $editingId;

    public array $replyBodies = [];
    public array $replyingTo = [];

    public int $maxChildren = 2;
    public string $orderBy = 'newest';

    public StoreCommentForm $storeCommentForm;
    public StoreReplyForm $storeReplyForm;
    public UpdateCommentForm $updateCommentForm;

    protected CommentTreeService $commentTreeService;
    protected CommentRepository $commentRepository;
    protected CreateCommentAction $createCommentAction;
    protected CreateReplyAction $createReplyAction;
    protected UpdateCommentAction $updateCommentAction;
    protected DeleteCommentAction $deleteCommentAction;

    public function boot(): void
    {
        $this->commentTreeService = app(CommentTreeService::class);
        $this->commentRepository = app(CommentRepository::class);
        $this->createCommentAction = app(CreateCommentAction::class);
        $this->createReplyAction = app(CreateReplyAction::class);
        $this->updateCommentAction = app(UpdateCommentAction::class);
        $this->deleteCommentAction = app(DeleteCommentAction::class);
    }

    public function mount(Model $model, bool $indentReplies = true, $ownerId = null, bool $useFullName = false): void
    {
        $this->modelClass = get_class($model);
        $this->modelId = $model->id;
        $this->ownerId = $ownerId;
        $this->indentReplies = $indentReplies;
        $this->useFullName = $useFullName;
    }

    public function getCommentsProperty(): Collection
    {
        if ($this->commentsCache !== null) {
            return $this->commentsCache;
        }

        $model = new $this->modelClass();
        $model->id = $this->modelId;

        return $this->commentsCache = $this->commentTreeService->buildCommentTree($model, $this->orderBy);
    }

    public function postComment(): void
    {
        $this->storeCommentForm->validate();

        $model = new $this->modelClass();
        $model->id = $this->modelId;

        $this->createCommentAction->execute($model, $this->storeCommentForm->body);

        $this->storeCommentForm->reset();
        $this->invalidateCache();
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

        $model = new $this->modelClass();
        $model->id = $this->modelId;

        $this->createReplyAction->execute($model, $parentComment, $body, $this->maxChildren);

        unset($this->storeReplyForm->body[$parentId]);

        $this->invalidateCache();
        $this->dispatch('reply-posted', commentId: $parentId);
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

        $this->updateCommentAction->execute($comment, $this->updateCommentForm->body);

        $this->reset(['editingId']);
        $this->updateCommentForm->reset();
        $this->invalidateCache();
    }

    public function deleteComment($id): void
    {
        $comment = $this->commentRepository->findById($id);
        if (!$comment) {
            return;
        }

        $this->deleteCommentAction->execute($comment);

        $this->invalidateCache();
    }

    /**
     * Returns the total number of comments including all replies.
     */
    public function getTotalCommentsCount(): int
    {
        return $this->commentTreeService->countCommentsRecursively($this->comments);
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
}
