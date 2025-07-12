<?php

namespace App\Livewire\Admin\Kanban;

use App\Models\KanbanCard;
use Livewire\Attributes\Title;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use App\Events\Kanban\UserAssigned;
use App\Events\Kanban\UserUnassigned;
use App\Repositories\Kanban\CardRepository;
use App\Repositories\Kanban\BoardRepository;
use App\Actions\Kanban\AssignUserToCardAction;
use App\Actions\Kanban\RemoveUserFromCardAction;

#[Title('Kanban Board - View Card')]
#[Layout('components.layouts.admin')]
class Card extends BaseComponent
{
    public string $boardSlug;
    public string $columnSlug;
    public string $cardSlug;

    public int $boardId;
    public int $columnId;
    public int $cardId;

    public KanbanCard $card;
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

    public function mount(string $boardSlug, string $columnSlug, string $cardId): void
    {
        $this->boardSlug = $boardSlug;
        $this->columnSlug = $columnSlug;

        // Load card with all necessary relations
        $relations = [
            'user',
            'column',
            'board',
            'board.users',
        ];

        // Find card by board slug, column slug, and card slug with validation
        $this->card = $this->cardRepository->findByBoardColumnCardIdentifiers(
            $boardSlug,
            $columnSlug, 
            $cardId,
            $relations
        );

        // Set the IDs for backward compatibility
        $this->cardId = $this->card->id;
        $this->columnId = $this->card->column->id;
        $this->boardId = $this->card->board->id;

        // Load combined users + owner once and cache on board
        $board = $this->boardRepository->loadUsersWithOwner($this->card->board);
        $this->card->setRelation('board', $board);

        $this->prepareBoardUsers();
    }

    protected function prepareBoardUsers(): void
    {
        // Use the cached combined users + owner collection
        $this->boardUsers = $this->card->board->getRelation('usersWithOwner') ?? collect();
    }

    public function assignUser(int $userId): void
    {
        $this->assignUserToCardAction->handle($this->card, $userId);

        $relations = [
            'user',
            'column',
            'board',
            'board.users',
        ];

        $this->card = $this->cardRepository->refresh($this->card, $relations);

        // Reload combined users + owner collection without re-querying owner twice
        $board = $this->boardRepository->loadUsersWithOwner($this->card->board);
        $this->card->setRelation('board', $board);

        event(new UserAssigned($this->card));

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
            'board',
            'board.users',
        ];

        $this->card = $this->cardRepository->refresh($this->card, $relations);

        event(new UserUnassigned($this->card));

        $board = $this->boardRepository->loadUsersWithOwner($this->card->board);
        $this->card->setRelation('board', $board);

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