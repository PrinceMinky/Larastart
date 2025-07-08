<?php

namespace App\Livewire\Admin\KanbanBoards;

use App\Models\User;
use App\Livewire\Traits\WithModal;
use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\KanbanBoard as Board;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

#[Title('Kanban Board')]
#[Layout('components.layouts.admin')]
class Show extends BaseComponent
{
    use WithModal;

    protected $columnOptionsCache = null;

    public int $kanbanBoardId;
    public $currentBoard;

    public $columns;
    public $columnId = null;
    public $columnTitle;
    public $columnPosition;

    public $cardId;
    public $cardTitle;
    public $cardDescription;
    public $cardUser = 0;
    public ?string $dueAtDate = null;
    public ?string $dueAtTime = null;
    public ?Carbon $dueAt = null;

    public $badgeTitle;
    public $badgeColor;
    public $badges = [];

    public $selectedUserIds = [];
    public $eligibleUsers = [];

    public function mount($id)
    {
        $this->kanbanBoardId = (int) $id;
        $this->currentBoard = Board::findOrFail($this->kanbanBoardId);
        $this->currentBoard->load('owner','users');

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

    public function authorizeView()
    {
        if (! Auth::check()) {
            abort(403, 'You are not authorized to access this board.');
        }

        $user = Auth::user();

        $isOwner = $this->currentBoard->owner_id === $user->id;
        $isSharedUser = $this->currentBoard->users()->where('user_id', $user->id)->exists();
        $isSuperAdmin = $user->hasRole('Super Admin');

        if (! $isOwner && ! $isSharedUser && ! $isSuperAdmin) {
            abort(403, 'You are not authorized to access this board.');
        }
    }

    #[Computed]
    public function boardBadges()
    {
        return $this->currentBoard->badges ?? [];
    }

    public function showColumnForm($id = null)
    {
        $this->reset(['columnTitle']);

        if ($id) {
            $this->loadData($id);
        }

        $this->showModal('column-form');
    }

    public function showCardForm($id = null) 
    {
        $this->reset(['cardTitle', 'cardDescription', 'cardUser', 'columnId', 'cardId', 'badges','dueAtDate','dueAtTime','dueAt']);

        if ($id) {
            $this->loadData($id);
        }

        $this->showModal('card-form');
    }

    public function showDeleteColumnForm($id = null)
    {
        $this->authorize('delete kanban columns');

        if ($id) {
            $this->loadData($id);

            $this->showModal('delete-column-form');
        }
    }

    public function showDeleteCardForm($id = null)
    {
        $this->authorize('delete kanban cards');

        if ($id) {
            $this->loadData($id);

            $this->showModal('delete-card-form');
        }
    }

    public function loadData($id)
    {
        if ($column = KanbanColumn::find($id)) {
            $this->columnId = $column->id;
            $this->columnTitle = $column->title;
            $this->badges = [];
            return;
        }

        if ($card = KanbanCard::find($id)) {
            $this->cardId = $card->id;
            $this->cardTitle = $card->title;
            $this->cardDescription = $card->description;
            $this->cardUser = $card->assigned_user_id;
            $this->dueAt = $card->due_at;
            $this->dueAtDate = optional($card->due_at)?->format('Y-m-d');
            $this->dueAtTime = optional($card->due_at)?->format('H:i');
            $this->columnId = $card->column_id;
            $this->badges = $card->badges;

            return;
        }
    }

    public function saveCard()
    {
        $this->cardId ? $this->updateCard($this->cardId) : $this->createCard();
    }

    public function createCard()
    {
        $this->authorize('create kanban cards');

        $this->validate([
            'cardTitle' => ['required', 'min:3'],
            'cardDescription' => ['nullable', 'min:3'],
            'columnId' => ['required', 'exists:kanban_columns,id'],
            'badges' => ['nullable', 'array'],
            'badges.*.title' => ['required_with:badges', 'string'],
            'badges.*.color' => ['required_with:badges', 'string'],
        ], [
            'badges.required' => 'At least one badge must be selected.',
            'badges.min' => 'At least one badge must be selected.',
        ]);

        if ($this->dueAtDate && $this->dueAtTime) {
            $this->dueAt = Carbon::parse("{$this->dueAtDate} {$this->dueAtTime}");
        } elseif ($this->dueAtDate) {
            $this->dueAt = Carbon::parse($this->dueAtDate)->startOfDay();
        } else {
            $this->dueAt = null;
        }

        $validBadges = collect($this->currentBoard->badges ?? [])
            ->pluck('title')
            ->toArray();

        foreach ($this->badges as $badge) {
            if (!in_array($badge['title'], $validBadges)) {
                $this->addError('badges', 'Invalid badge selected: ' . $badge['title']);
                return;
            }
        }

        $maxPosition = KanbanCard::where('column_id', $this->columnId)->max('position') ?? -1;

        KanbanCard::create([
            'title' => $this->cardTitle,
            'description' => $this->cardDescription,
            'due_at' => $this->dueAt,
            'column_id' => $this->columnId,
            'position' => $maxPosition + 1,
            'badges' => $this->badges,
            'assigned_user_id' => $this->cardUser ?? null
        ]);

        $this->reset(['cardTitle', 'cardDescription', 'columnId', 'cardId', 'badges', 'dueAt', 'dueAtDate', 'dueAtTime']);
        $this->closeModal('card-form');

        $this->toast([
            'heading' => 'Card created',
            'text' => 'Card inserted successfully.',
            'variant' => 'success',
        ]);
    }

    public function updateCard($id)
    {
        $this->authorize('edit kanban cards');

        $this->validate([
            'cardTitle' => ['required', 'min:3'],
            'cardDescription' => ['nullable', 'min:3'],
            'columnId' => ['required', 'exists:kanban_columns,id'],
            'badges' => ['nullable', 'array'],
            'badges.*.title' => ['required_with:badges', 'string'],
            'badges.*.color' => ['required_with:badges', 'string'],
        ], [
            'badges.required' => 'At least one badge must be selected.',
            'badges.min' => 'At least one badge must be selected.',
        ]);

        $card = KanbanCard::findOrFail($id);

        if ($this->dueAtDate && $this->dueAtTime) {
            $this->dueAt = Carbon::parse("{$this->dueAtDate} {$this->dueAtTime}");
        } elseif ($this->dueAtDate) {
            $this->dueAt = Carbon::parse($this->dueAtDate)->startOfDay();
        } else {
            $this->dueAt = null;
        }

        $card->update([
            'title' => $this->cardTitle,
            'description' => $this->cardDescription,
            'due_at' => $this->dueAt,
            'column_id' => $this->columnId,
            'badges' => $this->badges,
            'assigned_user_id' => $this->cardUser ?? null
        ]);

        $this->reset(['cardTitle', 'cardDescription', 'cardUser', 'columnId', 'cardId', 'dueAt', 'dueAtDate', 'dueAtTime']);
        $this->closeModal('card-form');

        $this->toast([
            'heading' => 'Card updated',
            'text' => 'Card has been successfully updated.',
            'variant' => 'success',
        ]);
    }

    public function updatedBadgeTitle()
    {
        if (!empty($this->badgeTitle)) {
            $isDuplicate = collect($this->badges)->contains(function ($badge) {
                return $badge['title'] === $this->badgeTitle;
            });

            if ($isDuplicate) {
                $this->addError('badgeTitle', 'This badge has already been added.');
                return;
            }

            $this->resetErrorBag(['badgeTitle','badges']);

            $badge = collect($this->boardBadges)->firstWhere('title', $this->badgeTitle);

            if (!$badge) {
                $this->addError('badgeTitle', 'Selected badge is not valid for this board.');
                return;
            }

            $this->badges[] = [
                'title' => $badge['title'],
                'color' => $this->badgeColor ?? $badge['color'],
            ];

            $this->reset(['badgeTitle', 'badgeColor']);
        }
    }

    public function removeBadge($index)
    {
        unset($this->badges[$index]);
        $this->badges = array_values($this->badges);
    }

    public function deleteCard()
    {
        $this->authorize('delete kanban cards');

        KanbanCard::findOrFail($this->cardId)->delete();

        $this->normalizeColumnPositions();

        $this->closeModal('delete-card-form');

        $this->toast([
            'heading' => 'Card deleted',
            'text' => 'Card has been successfully deleted.',
            'variant' => 'danger',
        ]);
    }

    public function saveColumn()
    {
        $this->columnId ? $this->updateColumn($this->columnId) : $this->createColumn();
    }

    public function getColumnOptions()
    {
        if ($this->columnOptionsCache === null) {
            $this->columnOptionsCache = KanbanColumn::where('board_id', '=', $this->kanbanBoardId)->orderBy('position')->pluck('title', 'id')->toArray();
        }

        return $this->columnOptionsCache;
    }

    public function createColumn()
    {
        $this->authorize('create kanban columns');

        $this->validate(['columnTitle' => ['required', 'min:3']]);

        $newPos = KanbanColumn::where('board_id', $this->kanbanBoardId)->max('position') + 1;

        KanbanColumn::create([
            'board_id' => $this->kanbanBoardId,
            'title' => $this->columnTitle,
            'position' => $newPos,
        ]);

        $this->reset(['columnTitle']);
        $this->closeModal('column-form');

        $this->toast([
            'heading' => 'Column created',
            'text' => 'Column added to the end.',
            'variant' => 'success',
        ]);
    }

    public function updateColumn()
    {
        $this->authorize('edit kanban columns');

        $column = KanbanColumn::findOrFail($this->columnId);

        $column->update([
            'board_id' => $this->kanbanBoardId,
            'title' => $this->columnTitle,
        ]);

        $this->normalizeColumnPositions();

        $this->closeModal('column-form');

        $this->toast([
            'heading' => 'Column updated',
            'text' => 'Column has been successfully updated.',
            'variant' => 'success',
        ]);
    }

    public function deleteColumn()
    {
        $this->authorize('delete kanban columns');

        KanbanColumn::findOrFail($this->columnId)->delete();

        $this->normalizeColumnPositions();

        $this->closeModal('delete-column-form');

        $this->toast([
            'heading' => 'Column deleted',
            'text' => 'Column has been successfully deleted.',
            'variant' => 'danger',
        ]);
    }

    public function normalizeColumnPositions()
    {
        $columns = KanbanColumn::where('board_id','=', $this->kanbanBoardId)->orderBy('position')->get();

        foreach ($columns as $index => $column) {
            $column->update(['position' => $index]);
        }
    }

    public function updateColumnPosition($columnId, $newPosition)
    {
        $this->authorize('edit kanban columns');

        $column = KanbanColumn::find($columnId);

        if (!$column) {
            return;
        }

        $oldPosition = $column->position;
        
        if ($newPosition == $oldPosition) {
            return; // no change needed
        }

        if ($newPosition > $oldPosition) {
            KanbanColumn::where('board_id', '=', $this->kanbanBoardId)
                ->where('position', '>', $oldPosition)
                ->where('position', '<=', $newPosition)
                ->decrement('position');
        } else {
            KanbanColumn::where('board_id', '=', $this->kanbanBoardId)
                ->where('position', '>=', $newPosition)
                ->where('position', '<', $oldPosition)
                ->increment('position');
        }

        $column->position = $newPosition;
        $column->save();
    }

    public function updateCardPosition($cardId, $newPosition, $newColumnId)
    {
        $this->authorize('edit kanban cards');

        $card = KanbanCard::find($cardId);
        if (!$card) return;

        $oldColumnId = $card->column_id;
        $oldPosition = $card->position;

        // Moving within the same column
        if ($oldColumnId == $newColumnId) {
            if ($newPosition == $oldPosition) return;

            if ($newPosition > $oldPosition) {
                KanbanCard::where('column_id', $newColumnId)
                    ->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->decrement('position');
            } else {
                KanbanCard::where('column_id', $newColumnId)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $oldPosition)
                    ->increment('position');
            }

            $card->position = $newPosition;
            $card->save();

            $this->normalizeCardPositions($newColumnId);
            return;
        }

        // Moving to a different column
        // Step 1: Shift down positions in new column
        KanbanCard::where('column_id', $newColumnId)
            ->where('position', '>=', $newPosition)
            ->increment('position');

        // Step 2: Shift up positions in old column
        KanbanCard::where('column_id', $oldColumnId)
            ->where('position', '>', $oldPosition)
            ->decrement('position');

        // Step 3: Move card
        $card->column_id = $newColumnId;
        $card->position = $newPosition;
        $card->save();
    }

    protected function normalizeCardPositions($columnId)
    {
        $cards = KanbanCard::where('column_id', $columnId)->orderBy('position')->get();

        foreach ($cards as $index => $card) {
            if ($card->position !== $index) {
                $card->position = $index;
                $card->save();
            }
        }
    }

    #[Computed]
    public function columns()
    {
        $columns = KanbanColumn::with([
            'cards' => function ($query) {
                $query->orderBy('position')->with(['user','column']); // eager load user
            }
        ])
        ->where('board_id', $this->kanbanBoardId)
        ->orderBy('position')
        ->get();

        foreach ($columns as $column) {
            foreach ($column->cards as $card) {
                $card->badges = $card->badges ?? [];
            }
        }

        return $columns;
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
        $this->dueAtDate = Carbon::parse($this->dueAtDate ?? now())
            ->addDays($days)
            ->format('Y-m-d');
    }


    public function addMinutes(int $minutes): void
    {
        $this->dueAtTime = Carbon::parse($this->dueAtTime ?? now()->format('H:i'))
            ->addMinutes($minutes)
            ->format('H:i');
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.show');
    }
}