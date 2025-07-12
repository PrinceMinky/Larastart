<?php

namespace App\Livewire\Admin\Kanban;

use Carbon\Carbon;
use App\Models\User;
use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Events\Kanban\CardCreated;
use App\Events\Kanban\CardDeleted;
use App\Events\Kanban\CardUpdated;
use App\Livewire\Traits\WithModal;
use App\Events\Kanban\ColumnCreated;
use App\Events\Kanban\ColumnDeleted;
use App\Events\Kanban\ColumnUpdated;
use App\Models\KanbanBoard as Board;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Forms\Kanban\CardForm;
use App\Actions\Kanban\CreateCardAction;
use App\Actions\Kanban\DeleteCardAction;
use App\Actions\Kanban\UpdateCardAction;
use Spatie\Permission\Models\Permission;
use App\Livewire\Forms\Kanban\ColumnForm;
use App\Actions\Kanban\CreateColumnAction;
use App\Actions\Kanban\DeleteColumnAction;
use App\Actions\Kanban\UpdateColumnAction;
use App\Repositories\Kanban\CardRepository;
use App\Repositories\Kanban\BoardRepository;
use App\Repositories\Kanban\ColumnRepository;
use App\Actions\Kanban\UpdateCardPositionAction;
use App\Actions\Kanban\UpdateColumnPositionAction;

#[Title('Kanban Board')]
#[Layout('components.layouts.admin')]
class Show extends BaseComponent
{
    use WithModal;

    public int $boardId;
    public string $slug;
    public ?Board $currentBoard = null;

    public CardForm $cardForm;
    public ColumnForm $columnForm;

    public array $badges = [];
    public array $selectedUserIds = [];
    public $eligibleUsers = [];

    protected ?array $columnOptionsCache = null;

    protected BoardRepository $boardRepository;
    protected ColumnRepository $columnRepository;
    protected CardRepository $cardRepository;

    protected CreateCardAction $createCardAction;
    protected UpdateCardAction $updateCardAction;
    protected DeleteCardAction $deleteCardAction;

    protected CreateColumnAction $createColumnAction;
    protected UpdateColumnAction $updateColumnAction;
    protected DeleteColumnAction $deleteColumnAction;

    protected UpdateCardPositionAction $updateCardPositionAction;
    protected UpdateColumnPositionAction $updateColumnPositionAction;
    
    public function boot(
        BoardRepository $boardRepository,
        ColumnRepository $columnRepository,
        CardRepository $cardRepository,
        CreateCardAction $createCardAction,
        UpdateCardAction $updateCardAction,
        DeleteCardAction $deleteCardAction,
        CreateColumnAction $createColumnAction,
        UpdateColumnAction $updateColumnAction,
        DeleteColumnAction $deleteColumnAction,
        UpdateCardPositionAction $updateCardPositionAction,
        UpdateColumnPositionAction $updateColumnPositionAction,
    ) {
        $this->boardRepository = $boardRepository;
        $this->columnRepository = $columnRepository;
        $this->cardRepository = $cardRepository;

        $this->createCardAction = $createCardAction;
        $this->updateCardAction = $updateCardAction;
        $this->deleteCardAction = $deleteCardAction;

        $this->createColumnAction = $createColumnAction;
        $this->updateColumnAction = $updateColumnAction;
        $this->deleteColumnAction = $deleteColumnAction;
        
        $this->updateCardPositionAction = $updateCardPositionAction;
        $this->updateColumnPositionAction = $updateColumnPositionAction;
    }

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->currentBoard = $this->boardRepository->findBySlugOrIdWithRelations($slug, 
            ['owner', 'users', 'columns.cards.column.board', 'columns.cards.user']
        );
        
        $this->boardId = $this->currentBoard->id;
        $this->authorizeView();

        $permission = Permission::where('name', 'view kanban boards')->first();

        if ($permission) {
            $rolesWithPermission = $permission->roles()->pluck('name')->toArray();

            $this->eligibleUsers = User::role($rolesWithPermission)
                ->where('id', '!=', $this->currentBoard->owner_id)
                ->orderBy('name', 'asc')
                ->get();
        }
    }

    protected function authorizeView(): void
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'You are not authorized to access this board.');
        }

        $isOwner = $this->currentBoard->owner_id === $user->id;
        $isSharedUser = $this->currentBoard->users->contains('id', $user->id);
        $isSuperAdmin = $user->hasRole('Super Admin');

        if (! $isOwner && ! $isSharedUser && ! $isSuperAdmin) {
            abort(403, 'You are not authorized to access this board.');
        }
    }

    #[Computed]
    public function boardBadges(): array
    {
        return $this->currentBoard->badges ?? [];
    }

    public function showColumnForm(?int $id = null): void
    {
        $this->columnForm->resetForm();
        
        if ($id) {
            $column = $this->columnRepository->findWith($id, ['cards']);
            if ($column) {
                $this->columnForm->loadData($column);
            }
        }

        $this->showModal('column-form');
    }

    public function showCreateCardForm(int $columnId): void
    {
        $this->cardForm->resetForm();
        $this->cardForm->column_id = $columnId;
        $this->showModal('card-form');
    }

    public function showEditCardForm(int $cardId): void
    {
        $card = $this->cardRepository->find($cardId);
        $this->cardForm->loadData($card);
        $this->showModal('card-form');
    }

    public function saveCard(): void
    {
        if ($this->cardForm->id) {
            $this->updateCard($this->cardForm->id);
        } else {
            $this->createCard();
        }
    }

    protected function createCard(): void
    {
        $data = $this->cardForm->validate();
        $dueAt = $this->cardForm->parseDueAt();

        if (! $this->cardForm->validateBadges($this->badges, $this->boardBadges)) {
            return;
        }

        $data['due_at'] = $dueAt;
        $data['badges'] = $this->badges;

        $card = $this->createCardAction->handle($this->cardForm);

        event(new CardCreated($card));

        $this->closeModal('card-form');
        $this->cardForm->resetForm();

        $this->toast([
            'heading' => 'Card created',
            'text' => 'Card created successfully.',
            'variant' => 'success',
        ]);
    }

    protected function updateCard(int $id): void
    {
        $data = $this->cardForm->validate();
        $dueAt = $this->cardForm->parseDueAt();

        if (! $this->cardForm->validateBadges($this->badges, $this->boardBadges)) {
            return;
        }

        $data['due_at'] = $dueAt;
        $data['badges'] = $this->badges;

        $card = $this->updateCardAction->handle($this->cardForm);

        event(new CardUpdated($card));

        $this->closeModal('card-form');
        $this->cardForm->resetForm();

        $this->toast([
            'heading' => 'Card updated',
            'text' => 'Card updated successfully.',
            'variant' => 'success',
        ]);
    }

    public function deleteCard(): void
    {
        $card = KanbanCard::findOrFail($this->cardForm->id);

        event(new CardDeleted($card));

        $this->deleteCardAction->handle($card);

        $this->closeModal('delete-card-form');
        $this->cardForm->resetForm();

        $this->toast([
            'heading' => 'Card Deleted',
            'text' => 'Card deleted successfully.',
            'variant' => 'danger',
        ]);
    }

    public function saveColumn(): void
    {
        if ($this->columnForm->id) {
            $this->updateColumn($this->columnForm->id);
        } else {
            $this->createColumn();
        }
    }

    protected function createColumn(): void
    {
        $this->columnForm->board_id = $this->boardId;
        $this->columnForm->validate();

        $column = $this->createColumnAction->handle($this->columnForm);

        event(new ColumnCreated($column));

        $this->closeModal('column-form');
        $this->columnForm->resetForm();

        $this->toast([
            'heading' => 'Column created',
            'text' => 'Column created successfully.',
            'variant' => 'success',
        ]);
    }

    protected function updateColumn(int $id): void
    {
        $this->columnForm->board_id = $this->boardId;
        $this->columnForm->validate();

        $column = $this->updateColumnAction->handle($this->columnForm);

        event(new ColumnUpdated($column));

        $this->closeModal('column-form');
        $this->columnForm->resetForm();

        $this->toast([
            'heading' => 'Column updated',
            'text' => 'Column updated successfully.',
            'variant' => 'success',
        ]);
    }

    public function deleteColumn(): void
    {
        $column = KanbanColumn::findOrFail($this->columnForm->id);

        event(new ColumnDeleted($column));
        
        $this->deleteColumnAction->handle($column);

        $this->closeModal('delete-column-form');
        $this->columnForm->resetForm();

        $this->toast([
            'heading' => 'Column deleted',
            'text' => 'Column deleted successfully.',
            'variant' => 'danger',
        ]);
    }

    #[Computed]
    public function columnOptions(): array
    {
        if ($this->columnOptionsCache === null) {
            $this->columnOptionsCache = $this->currentBoard->columns
                ->sortBy('position')
                ->map(fn($col) => ['id' => $col->id, 'title' => $col->title])
                ->toArray();
        }
        return $this->columnOptionsCache;
    }

    public function updateCardPosition(int $cardId, int $newPosition, int $newColumnId): void
    {
        $updatedCard = $this->updateCardPositionAction->handle($cardId, $newPosition, $newColumnId);

        if (!$updatedCard) {
            $this->addError('card', 'Card not found.');
            return;
        }

        event(new CardUpdated($updatedCard));
    }

    public function updateColumnPosition(int $columnId, int $newPosition): void
    {
        $updatedColumn = $this->updateColumnPositionAction->handle($this->boardId, $columnId, $newPosition);

        if (!$updatedColumn) {
            $this->addError('column', 'Column not found.');
            return;
        }

        event(new ColumnUpdated($updatedColumn));
    }

    public function showDeleteColumnForm($id = null)
    {
        $this->authorize('delete kanban columns');

        $column = $this->columnRepository->find($id);

        if ($column) {
            $this->columnForm->loadData($column);

            $this->showModal('delete-column-form');
        }
    }

    public function showDeleteCardForm($id = null)
    {
        $this->authorize('delete kanban cards');

        $card = $this->cardRepository->find($id);

        if ($card) {
            $this->cardForm->loadData($card);

            $this->showModal('delete-card-form');
        }
    }

    public function getColumnOptions()
    {
        if ($this->columnOptionsCache === null) {
            $this->columnOptionsCache = KanbanColumn::where('board_id', '=', $this->boardId)->orderBy('position')->pluck('title', 'id')->toArray();
        }

        return $this->columnOptionsCache;
    }

    public function showAssociateForm()
    {
        $this->authorize('manage kanban users');

        $this->selectedUserIds = $this->currentBoard->users->pluck('id')->toArray();

        $this->showModal('users-associate-form');
    }

    public function associateUsers()
    {
        $this->authorize('manage kanban users');

        // Get the current users assigned to the board before syncing
        $previousUserIds = $this->currentBoard->users()->pluck('users.id')->toArray();

        // Sync with the new selection
        $this->currentBoard->users()->sync($this->selectedUserIds);

        // Find users removed (in previous but not in selected)
        $removedUserIds = array_diff($previousUserIds, $this->selectedUserIds);

        if (!empty($removedUserIds)) {
            // Unassign these removed users from cards on this board
            $cardsToUpdate = KanbanCard::whereHas('column', function ($query) {
                $query->where('board_id', $this->currentBoard->id);
            })->whereIn('assigned_user_id', $removedUserIds)->get();

            foreach ($cardsToUpdate as $card) {
                $card->assigned_user_id = null;
                $card->save();
            }
        }

        $this->closeModal('users-associate-form');

        $this->toast([
            'heading' => 'Associated users',
            'text' => 'You have successfully associated users with this board.',
            'variant' => 'success',
        ]);
    }

    public function removeUser($id)
    {
        $this->authorize('manage kanban users'); 
        
        $this->currentBoard->users()->detach($id);

        KanbanCard::whereHas('column', function ($query) {
            $query->where('board_id', $this->currentBoard->id);
        })
        ->where('assigned_user_id', $id)
        ->update(['assigned_user_id' => null]);

        $this->toast([
            'heading' => 'Unassociated user',
            'text' => 'You have successfully unassociated user with this board.',
            'variant' => 'danger',
        ]);
    }

    public function addDays(int $days): void
    {
        $this->cardForm->dueAtDate = Carbon::parse($this->cardForm->dueAtDate ?? now())
            ->addDays($days)
            ->format('Y-m-d');
    }

    public function addMinutes(int $minutes): void
    {
        $this->cardForm->dueAtTime = Carbon::parse($this->cardForm->dueAtTime ?? now()->format('H:i'))
            ->addMinutes($minutes)
            ->format('H:i');
    }

    #[Computed]
    public function columns()
    {
        $columns = KanbanColumn::with([
            'cards' => function ($query) {
                $query->orderBy('position')->with([
                    'user',
                    'column.board', // ✅ this fixes the lazy loading error
                ]);
            }
        ])
        ->where('board_id', $this->boardId)
        ->orderBy('position')
        ->get();

        foreach ($columns as $column) {
            foreach ($column->cards as $card) {
                $card->badges = $card->badges ?? [];
            }
        }

        return $columns;
    }

    public function updatedCardFormBadgeTitle()
    {
        $this->cardForm->updateBadges($this->boardBadges);
    }

    public function removeBadge(int $index): void
    {
        $this->cardForm->removeBadge($index);
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.show', [
            'board' => $this->currentBoard,
            'columns' => $this->columns ?? collect(),
        ]);
    }
}
