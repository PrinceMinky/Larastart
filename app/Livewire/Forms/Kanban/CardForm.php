<?php

namespace App\Livewire\Forms\Kanban;

use Livewire\Form;
use App\Models\KanbanCard;
use Illuminate\Support\Carbon;

class CardForm extends Form
{
    public ?int $id = null;
    public string $title = '';
    public ?string $description = null;
    public ?int $assigned_user_id = null;
    public ?int $column_id = null;
    public ?Carbon $due_at = null;
    public array $badges = [];
    public ?string $badgeTitle = null;

    // For date/time input binding
    public ?string $dueAtDate = null;
    public ?string $dueAtTime = null;

    public function rules(): array
    {
        return [
            'title' => ['required', 'min:3'],
            'description' => ['nullable', 'min:3'],
            'column_id' => ['required', 'exists:kanban_columns,id'],
            'assigned_user_id' => ['nullable', 'exists:users,id'],
            'badges' => ['nullable', 'array'],
            'badges.*.title' => ['required_with:badges', 'string'],
            'badges.*.color' => ['required_with:badges', 'string'],
            'dueAtDate' => ['nullable', 'date'],
            'dueAtTime' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function updateBadges(array $boardBadges): void
    {
        if (!empty($this->badgeTitle)) {
            $isDuplicate = collect($this->badges)->contains(fn ($badge) => $badge['title'] === $this->badgeTitle);

            if ($isDuplicate) {
                $this->addError('badgeTitle', 'This badge has already been added.');
                return;
            }

            $this->resetErrorBag(['badgeTitle', 'badges']);

            $badge = collect($boardBadges)->firstWhere('title', $this->badgeTitle);

            if (!$badge) {
                $this->addError('badgeTitle', 'Selected badge is not valid for this board.');
                return;
            }

            $this->badges[] = [
                'title' => $badge['title'],
                'color' => $this->badgeColor ?? $badge['color'],
            ];

            $this->badgeTitle = null;
        }
    }

    public function updatedDueAtDate(): void
    {
        $this->updateDueAt();
    }

    public function updatedDueAtTime(): void
    {
        $this->updateDueAt();
    }

    public function parseDueAt(): ?Carbon
    {
        if ($this->dueAtDate && $this->dueAtTime) {
            return Carbon::parse("{$this->dueAtDate} {$this->dueAtTime}");
        } elseif ($this->dueAtDate) {
            return Carbon::parse($this->dueAtDate)->startOfDay();
        }

        return null;
    }

    protected function updateDueAt(): void
    {
        if ($this->dueAtDate && $this->dueAtTime) {
            $this->due_at = Carbon::parse("{$this->dueAtDate} {$this->dueAtTime}");
        } elseif ($this->dueAtDate) {
            $this->due_at = Carbon::parse($this->dueAtDate)->startOfDay();
        } else {
            $this->due_at = null;
        }
    }

    public function validateBadges(array $badges, array $boardBadges): bool
    {
        $validBadgeTitles = collect($boardBadges)->pluck('title')->toArray();

        foreach ($badges as $badge) {
            if (!in_array($badge['title'], $validBadgeTitles)) {
                $this->addError('badges', 'Invalid badge selected: ' . $badge['title']);
                return false;
            }
        }

        return true;
    }

    public function removeBadge(int $index): void
    {
        unset($this->badges[$index]);
        $this->badges = array_values($this->badges); 
    }

    public function loadData(KanbanCard $card): void
    {
        $this->id = $card->id;
        $this->title = $card->title;
        $this->description = $card->description;
        $this->assigned_user_id = $card->assigned_user_id;
        $this->column_id = $card->column_id;
        $this->badges = $card->badges ?? [];
        $this->due_at = $card->due_at;
        $this->dueAtDate = optional($card->due_at)?->format('Y-m-d');
        $this->dueAtTime = optional($card->due_at)?->format('H:i');
    }

    public function resetForm(): void
    {
        $this->id = null;
        $this->title = '';
        $this->description = null;
        $this->assigned_user_id = null;
        $this->column_id = null;
        $this->badges = [];
        $this->due_at = null;
        $this->dueAtDate = null;
        $this->dueAtTime = null;
    }
}