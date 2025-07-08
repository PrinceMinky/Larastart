<?php

namespace App\Livewire\Admin\KanbanBoards;

use App\Livewire\Traits\Sortable;
use App\Livewire\Traits\WithModal;
use App\Models\KanbanBoard;
use Livewire\WithPagination;
use App\Enums\KanbanTemplates;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

#[Title('Kanban Boards')]
#[Layout('components.layouts.admin')]
class Index extends BaseComponent
{
    use Sortable, WithModal, WithPagination;

    public $boardId;
    public $title;
    public $selectedTemplate = null;
    public $columnsPreview = [];
    public $selectedUserIds = [];

    public $badges = [];
    public $badgeTitle = null;
    public $badgeColor = null;

    #[Computed]
    public function boards()
    {
        $query = KanbanBoard::with(['owner', 'users'])
            ->withCount('users');

        if ($this->sortBy === 'owner') {
            $query->join('users as owners', 'kanban_boards.owner_id', '=', 'owners.id')
                ->orderBy('owners.name', $this->sortDirection)
                ->select('kanban_boards.*');
        } elseif ($this->sortBy === 'members') {
            $query->orderBy('users_count', $this->sortDirection);
        } elseif ($this->sortBy === 'badges') {
            $query->orderByRaw('JSON_LENGTH(badges) ' . $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate(25);
    }

    public function showForm($id = null)
    {
        $this->reset(['boardId', 'title', 'selectedTemplate', 'columnsPreview', 'badges','badgeTitle','badgeColor']);

        if ($id) {
            $this->loadData($id);
        } 

        $this->ShowModal('board-form');
    }

    public function showDeleteForm($id = null)
    {
        $this->authorize('delete kanban boards');

        if ($id) {
            $this->loadData($id);
            $this->ShowModal('delete-form');
        }
    }

    public function loadData($id)
    {
        if ($board = KanbanBoard::find($id)) {
            $this->boardId = $board->id;
            $this->title = $board->title;
            $this->badges = $board->badges ?? [];
        }
    }

    public function save()
    {
        $this->boardId ? $this->update($this->boardId) : $this->create();
    }

    public function create()
    {
        $this->authorize('create kanban boards');

        $this->validate([
            'title' => 'required|min:3',
            'badges' => 'array',
            'badges.*.title' => 'required|string|min:1',
            'badges.*.color' => 'required|string|min:1',
        ]);

        $board = KanbanBoard::create([
            'title' => $this->title,
            'badges' => $this->badges,
        ]);

        if ($this->selectedTemplate && KanbanTemplates::tryFrom($this->selectedTemplate)) {
            $template = KanbanTemplates::from($this->selectedTemplate);
            foreach ($template->columns() as $index => $columnTitle) {
                $board->columns()->create([
                    'title' => $columnTitle,
                    'position' => $index,
                ]);
            }
        }

        $this->reset(['title', 'selectedTemplate', 'columnsPreview', 'badges','badgeTitle','badgeColor']);
        $this->closeModal('board-form');

        $this->toast([
            'heading' => 'Kanban Board created',
            'text' => 'Board created successfully.',
            'variant' => 'success',
        ]);
    }

    public function update($id)
    {
        $this->authorize('edit kanban boards');

        $this->validate([
            'title' => 'required|min:3',
            'badges' => 'array',
            'badges.*.title' => 'required|string|min:1',
            'badges.*.color' => 'required|string|min:1',
        ]);

        $board = KanbanBoard::find($id);

        if (!$board) {
            $this->toast([
                'heading' => 'Error',
                'text' => 'Board not found.',
                'variant' => 'danger',
            ]);
            return;
        }

        $board->update([
            'title' => $this->title,
            'badges' => $this->badges,
        ]);

        $this->reset(['title', 'selectedTemplate', 'columnsPreview', 'badges','badgeTitle','badgeColor']);
        $this->closeModal('board-form');

        $this->toast([
            'heading' => 'Kanban Board updated',
            'text' => 'Board updated successfully.',
            'variant' => 'success',
        ]);
    }

    public function delete()
    {
        $this->authorize('delete kanban boards');

        $board = KanbanBoard::find($this->boardId);

        if (!$board) {
            $this->toast([
                'heading' => 'Error',
                'text' => 'Board not found.',
                'variant' => 'danger',
            ]);
            return;
        }

        $board->delete();

        $this->reset(['boardId', 'title']);
        $this->closeModal('delete-form');

        $this->toast([
            'heading' => 'Kanban Board deleted',
            'text' => 'Board deleted successfully.',
            'variant' => 'danger',
        ]);
    }

    public function deleteSelected(): void
    {
        $this->authorize('delete kanban boards');

        KanbanBoard::whereIn('id', $this->selectedUserIds)->delete();

        $this->toast([
            'heading' => 'Kanban Boards deleted',
            'text' => 'Kanban Boards have successfully been deleted.',
            'variant' => 'danger',
        ]);

        $this->reset('selectedUserIds');
        $this->closeModal();
    }

    public function updatedSelectedTemplate($value)
    {
        if ($value && KanbanTemplates::tryFrom($value)) {
            $template = KanbanTemplates::from($value);
            $this->columnsPreview = $template->columns();
        } else {
            $this->columnsPreview = [];
        }
    }

    public function addBadge()
    {
        if (!empty($this->badgeTitle)) {
            $isDuplicate = collect($this->badges)->contains(function ($badge) {
                return strtolower($badge['title']) === strtolower($this->badgeTitle);
            });

            if ($isDuplicate) {
                $this->addError('badgeTitle', 'This badge has already been added.');
                return;
            }

            $this->resetErrorBag(['badgeTitle', 'badges']);

            $this->badges[] = [
                'title' => $this->badgeTitle,
                'color' => $this->badgeColor ?? 'gray',
            ];

            $this->reset(['badgeTitle', 'badgeColor']);
        }
    }

    public function removeBadge($index)
    {
        unset($this->badges[$index]);
        $this->badges = array_values($this->badges);
    }

    public function canViewBoard($board): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        if ($board->owner_id === $user->id) {
            return true;
        }

        return $board->users->contains('id', $user->id);
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.index');
    }
}
