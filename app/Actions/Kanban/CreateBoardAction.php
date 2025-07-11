<?php

namespace App\Actions\Kanban;

use App\Livewire\Forms\Kanban\BoardForm;
use App\Models\KanbanBoard;
use App\Enums\KanbanTemplates;

class CreateBoardAction
{
    public function handle(BoardForm $form): KanbanBoard
    {
        $board = KanbanBoard::create([
            'title' => $form->title,
            'badges' => $form->badges,
        ]);

        if ($form->selectedTemplate && KanbanTemplates::tryFrom($form->selectedTemplate)) {
            $template = KanbanTemplates::from($form->selectedTemplate);

            foreach ($template->columns() as $index => $columnTitle) {
                $board->columns()->create([
                    'title' => $columnTitle,
                    'position' => $index,
                ]);
            }
        }

        return $board;
    }
}
