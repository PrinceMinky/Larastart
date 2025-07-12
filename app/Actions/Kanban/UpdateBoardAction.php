<?php

namespace App\Actions\Kanban;

use App\Models\KanbanBoard;
use App\Livewire\Forms\Kanban\BoardForm;
use App\Traits\GeneratesUniqueSlug;

class UpdateBoardAction
{
    use GeneratesUniqueSlug;

    public function handle(BoardForm $form): KanbanBoard
    {
        $board = KanbanBoard::findOrFail($form->boardId);
        
        // Determine if we need to regenerate the slug
        $slug = $form->slug;
        
        // If title has changed and no custom slug provided, or if slug is empty
        if (($board->title !== $form->title && empty($form->slug)) || empty($slug)) {
            $slug = $this->generateUniqueSlug(
                $form->title,
                new KanbanBoard(),
                'slug',
                [],
                $board->id // Exclude current board from uniqueness check
            );
        }
        
        $board->update([
            'title' => $form->title,
            'slug' => $slug,
            'badges' => $form->badges,
        ]);

        return $board;
    }
}