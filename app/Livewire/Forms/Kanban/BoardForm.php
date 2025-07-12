<?php

namespace App\Livewire\Forms\Kanban;

use Livewire\Form;
use App\Models\KanbanBoard;
use App\Enums\KanbanTemplates;
use Illuminate\Validation\Rule;

class BoardForm extends Form
{
    public ?int $boardId = null;
    public string $title = '';
    public string $slug = '';
    public ?string $selectedTemplate = null;
    public array $badges = [];
    public ?string $badgeTitle = null;
    public ?string $badgeColor = null;

    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'badges' => 'array',
            'badges.*.title' => 'required|string|min:1',
            'badges.*.color' => 'required|string|min:1',
        ];
    }

    public function resetForm(): void
    {
        $this->reset(['boardId', 'title', 'slug', 'selectedTemplate', 'badges', 'badgeTitle', 'badgeColor']);
    }

    public function load(int $id): void
    {
        $board = KanbanBoard::findOrFail($id);

        $this->boardId = $board->id;
        $this->title = $board->title;
        $this->slug = $board->slug;
        $this->badges = $board->badges ?? [];
    }

    public function getTemplateColumns(): array
    {
        if ($this->selectedTemplate && KanbanTemplates::tryFrom($this->selectedTemplate)) {
            return KanbanTemplates::from($this->selectedTemplate)->columns();
        }

        return [];
    }

    public function addBadge(): void
    {
        if (empty($this->badgeTitle)) {
            return;
        }

        $isDuplicate = collect($this->badges)->contains(fn ($badge) =>
            strtolower($badge['title']) === strtolower($this->badgeTitle)
        );

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

    public function removeBadge(int $index): void
    {
        unset($this->badges[$index]);
        $this->badges = array_values($this->badges);
    }
}
