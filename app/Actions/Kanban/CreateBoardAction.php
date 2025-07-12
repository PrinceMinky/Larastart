<?php

namespace App\Actions\Kanban;

use App\Models\KanbanBoard;
use App\Models\KanbanColumn;
use Illuminate\Support\Str;
use App\Enums\KanbanTemplates;
use App\Livewire\Forms\Kanban\BoardForm;
use App\Traits\GeneratesUniqueSlug;

class CreateBoardAction
{
    use GeneratesUniqueSlug;

    public function handle(BoardForm $form): KanbanBoard
    {
        $slug = $form->slug ?: $this->generateUniqueSlug($form->title, new KanbanBoard());

        $board = KanbanBoard::create([
            'title' => $form->title,
            'slug' => $slug,
            'badges' => $form->badges,
        ]);

        if ($form->selectedTemplate && KanbanTemplates::tryFrom($form->selectedTemplate)) {
            $template = KanbanTemplates::from($form->selectedTemplate);

            foreach ($template->columns() as $index => $columnTitle) {
                $columnSlug = $this->generateUniqueSlug(
                    $columnTitle,
                    new KanbanColumn(),
                    'slug',
                    ['board_id' => $board->id]
                );

                $board->columns()->create([
                    'title' => $columnTitle,
                    'slug' => $columnSlug,
                    'position' => $index,
                ]);
            }
        }

        return $board;
    }
}