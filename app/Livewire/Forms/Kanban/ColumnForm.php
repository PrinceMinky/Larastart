<?php

namespace App\Livewire\Forms\Kanban;

use Livewire\Form;

class ColumnForm extends Form
{
    public ?int $id = null;
    public int $board_id;
    public string $title = '';
    public int $position = 0;

    public function rules(): array
    {
        return [
            'title' => ['required', 'min:3']
        ];
    }

    public function loadData($column): void
    {
        $this->id = $column->id;
        $this->title = $column->title;
        $this->position = $column->position;
    }

    public function resetForm(): void
    {
        $this->id = null;
        $this->title = '';
        $this->position = 0;
    }
}
