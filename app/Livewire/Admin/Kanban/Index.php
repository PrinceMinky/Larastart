<?php

namespace App\Livewire\Admin\Kanban;

use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\Sortable;
use Livewire\Attributes\Computed;
use App\Livewire\Traits\WithModal;
use Illuminate\Support\Facades\DB;
use App\Events\Kanban\BoardCreated;
use App\Events\Kanban\BoardDeleted;
use App\Events\Kanban\BoardUpdated;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Kanban\BoardForm;
use App\Actions\Kanban\CreateBoardAction;
use App\Actions\Kanban\DeleteBoardAction;
use App\Actions\Kanban\UpdateBoardAction;
use App\Repositories\Kanban\BoardRepository;

#[Title('Kanban Boards')]
#[Layout('components.layouts.admin')]
class Index extends BaseComponent
{
    use Sortable, WithModal, WithPagination;

    public BoardForm $form;

    public array $columnsPreview = [];
    public array $selectedBoardIds = [];

    protected BoardRepository $boardRepository;
    protected CreateBoardAction $createBoard;
    protected UpdateBoardAction $updateBoard;
    protected DeleteBoardAction $deleteBoard;

    public function boot(
        BoardRepository $boardRepository,
        CreateBoardAction $createBoard,
        UpdateBoardAction $updateBoard,
        DeleteBoardAction $deleteBoard,
    ): void {
        $this->boardRepository = $boardRepository;
        $this->createBoard = $createBoard;
        $this->updateBoard = $updateBoard;
        $this->deleteBoard = $deleteBoard;
    }

    #[Computed]
    public function boards(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->boardRepository->paginated(
            sortBy: $this->sortBy,
            sortDirection: $this->sortDirection,
            perPage: 25
        );
    }

    /**
     * Show the create/edit form modal
     */
    public function showForm(?int $id = null): void
    {
        $this->form->resetForm();

        if ($id) {
            $this->form->load($id);
        }

        $this->showModal('board-form');
    }

    /**
     * Show the delete confirmation modal
     */
    public function showDeleteForm(?int $id = null): void
    {
        $this->authorize('delete kanban boards');

        if ($id) {
            $this->form->load($id);
            $this->showModal('delete-form');
        }
    }

    /**
     * Save the board using the appropriate action
     */
    public function save(): void
    {
        $this->form->validate();
        
        $board = $this->form->boardId
            ? $this->updateBoard->handle($this->form)
            : $this->createBoard->handle($this->form);

        $this->reset(['columnsPreview']);
        $this->closeModal('board-form');

        $this->form->boardId 
            ? event(new BoardUpdated($board))
            : event(new BoardCreated($board));

        $this->toast([
            'heading' => 'Board Saved',
            'text' => 'Board was saved successfully.',
            'variant' => 'success',
        ]);
    }

    /**
     * Delete the selected board.
     */
    public function delete(): void
    {
        $this->authorize('delete kanban boards');

        $deletedKanbanBoard = $this->deleteBoard->handle($this->form->boardId);

        event(new BoardDeleted($deletedKanbanBoard));

        $this->form->resetForm();
        $this->closeModal('delete-form');

        $this->toast([
            'heading' => 'Board deleted',
            'text' => 'Board deleted successfully.',
            'variant' => 'danger',
        ]);
    }

    /**
     * Bulk delete selected boards.
     */
    public function deleteSelected(): void
    {
        $this->authorize('delete kanban boards');

        $deletedBoards = $this->deleteBoard->handle($this->selectedBoardIds);

        DB::transaction(function () use ($deletedBoards) {
            foreach ($deletedBoards as $board) {
                event(new BoardDeleted($board));
            }
        });

        $this->toast([
            'heading' => 'Boards deleted',
            'text' => 'Selected boards were deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedBoardIds');
        $this->closeModal();
    }

    /**
     * Preview columns based on template selection
     */
    public function updatedFormSelectedTemplate($value): void
    {
        $this->columnsPreview = $this->form->getTemplateColumns();
    }

    /**
     * Add a badge to the form
     */
    public function addBadge(): void
    {
        $this->form->addBadge();
    }

    /**
     * Remove a badge by index
     */
    public function removeBadge(int $index): void
    {
        $this->form->removeBadge($index);
    }

    /**
     * Check if the current user can view the given board
     */
    public function canViewBoard($board): bool
    {
        $user = Auth::user();

        return $user &&
            ($user->hasRole('Super Admin') ||
            $board->owner_id === $user->id ||
            $board->users->contains('id', $user->id));
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.index');
    }
}