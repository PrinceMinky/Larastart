<?php

namespace App\Livewire\Admin\Kanban;

use App\Models\KanbanCard;
use App\Models\KanbanColumn;
use App\Models\KanbanBoard;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use App\Repositories\Kanban\CardRepository;
use App\Repositories\Kanban\BoardRepository;
use App\Actions\Kanban\AssignUserToCardAction;
use App\Actions\Kanban\RemoveUserFromCardAction;

#[Title('Kanban Board - View Card')]
#[Layout('components.layouts.admin')]
class Card extends BaseComponent
{
    public int $boardId;
    public int $columnId;
    public int $cardId;

    public KanbanCard $card;
    public KanbanColumn $column;
    public KanbanBoard $board;

    public Collection $boardUsers;

    protected BoardRepository $boardRepository;
    protected CardRepository $cardRepository;
    protected AssignUserToCardAction $assignUserToCardAction;
    protected RemoveUserFromCardAction $removeUserFromCardAction;

    public function boot(
        BoardRepository $boardRepository,
        CardRepository $cardRepository,
        AssignUserToCardAction $assignUserToCardAction,
        RemoveUserFromCardAction $removeUserFromCardAction,
    ): void {
        $this->boardRepository = $boardRepository;
        $this->cardRepository = $cardRepository;
        $this->assignUserToCardAction = $assignUserToCardAction;
        $this->removeUserFromCardAction = $removeUserFromCardAction;
    }

    public function mount(int $boardId, int $columnId, int $cardId): void
    {
        $this->boardId = $boardId;
        $this->columnId = $columnId;
        $this->cardId = $cardId;

        // Load card with user and relations except owner separately
        $relations = [
            'user',
            'column',
            'column.board',
            'column.board.users',
        ];

        $this->card = $this->cardRepository->findWith($relations, $cardId);
        $this->column = $this->card->column;
        $this->board = $this->column->board;

        // Load combined users + owner once and cache on board
        $this->board = $this->boardRepository->loadUsersWithOwner($this->board);

        $this->prepareBoardUsers();
    }

    protected function prepareBoardUsers(): void
    {
        // Use the cached combined users + owner collection
        $this->boardUsers = $this->board->getRelation('usersWithOwner') ?? collect();
    }

    public function assignUser(int $userId): void
    {
        $this->assignUserToCardAction->handle($this->card, $userId);

        $relations = [
            'user',
            'column',
            'column.board',
            'column.board.users',
        ];

        $this->card = $this->cardRepository->refresh($this->card, $relations);
        $this->column = $this->card->column;
        $this->board = $this->column->board;

        // Reload combined users + owner collection without re-querying owner twice
        $this->board = $this->boardRepository->loadUsersWithOwner($this->board);

        $this->prepareBoardUsers();

        $this->toast([
            'heading' => 'User assigned',
            'text' => 'User has been assigned to this card.',
            'variant' => 'success',
        ]);
    }

    public function removeAssignedUser(): void
    {
        $this->removeUserFromCardAction->handle($this->card);

        $relations = [
            'user',
            'column',
            'column.board',
            'column.board.users',
        ];

        $this->card = $this->cardRepository->refresh($this->card, $relations);
        $this->column = $this->card->column;
        $this->board = $this->column->board;

        // Reload combined users + owner collection without re-querying owner twice
        $this->board = $this->boardRepository->loadUsersWithOwner($this->board);

        $this->prepareBoardUsers();

        $this->toast([
            'heading' => 'User unassigned',
            'text' => 'User has been unassigned from this card.',
            'variant' => 'danger',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.kanban-boards.card');
    }
}
