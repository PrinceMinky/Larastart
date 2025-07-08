<?php

namespace App\Livewire\Admin\KanbanBoards;

use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use App\Models\KanbanColumn;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;

#[Title('Kanban Board - View Card')]
#[Layout('components.layouts.admin')]
class Card extends BaseComponent
{
    public $boardId;
    public $columnId;
    public $cardId;

    public KanbanCard $card;
    public KanbanColumn $column;
    public KanbanBoard $board;
    public $boardUsers;

    public function mount($board_id, $column_id, $card_id)
    {
        $this->boardId = $board_id;
        $this->columnId = $column_id;
        $this->cardId = $card_id;

        $this->card = KanbanCard::with('user', 'column')->findOrFail($card_id);
        $this->column = KanbanColumn::with('board')->findOrFail($this->card->column_id);

        // Eager load owner + users
        $this->board = $this->column->board()->with('users', 'owner')->first();

        // Start with team members (users)
        $users = $this->board->users ?? collect();

        // Add owner if not already in users
        if ($this->board->owner && !$users->contains('id', $this->board->owner->id)) {
            $users->push($this->board->owner);
        }

        // Remove duplicates by ID (safe if owner added)
        $users = $users->unique('id');

        // Sort users alphabetically by name except owner goes first
        $this->boardUsers = $users->unique('id')->sort(function ($a, $b) {
            // Owner first
            if ($a->id === $this->board->owner->id) {
                return -1; // $a is owner, comes first
            }
            if ($b->id === $this->board->owner->id) {
                return 1; // $b is owner, so $a after $b
            }

            // Neither is owner, so sort alphabetically by name
            return strcmp($a->name, $b->name);
        })->values();
    }

    public function assignUser($userId)
    {
        $this->card->assigned_user_id = $userId;
        $this->card->save();

        $this->toast([
            'heading' => 'User assigned',
            'text' => 'User has been assigned to this card.',
            'variant' => 'success',
        ]);
    }

    public function removeAssignedUser()
    {
        $this->card->assigned_user_id = null;
        $this->card->save();

        $this->toast([
            'heading' => 'User unassigned',
            'text' => 'User has been unassigned to this card.',
            'variant' => 'danger',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.card');
    }
}
