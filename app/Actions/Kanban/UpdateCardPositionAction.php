<?php

namespace App\Actions\Kanban;

use App\Models\KanbanCard;
use Illuminate\Support\Facades\Gate;

class UpdateCardPositionAction
{
    public function handle(int $cardId, int $newPosition, int $newColumnId): ?KanbanCard
    {
        Gate::authorize('edit kanban cards');

        $card = KanbanCard::find($cardId);

        if (!$card) {
            return null;
        }

        // Optionally, you can add authorization here if not done elsewhere
        // throw_if(!auth()->user()->can('edit kanban cards'), AuthorizationException::class);

        $oldColumnId = $card->column_id;
        $oldPosition = $card->position;

        // If no change in column or position, just return card
        if ($oldColumnId === $newColumnId && $oldPosition === $newPosition) {
            return $card;
        }

        // Moving within the same column
        if ($oldColumnId === $newColumnId) {
            if ($newPosition > $oldPosition) {
                KanbanCard::where('column_id', $newColumnId)
                    ->where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->decrement('position');
            } else {
                KanbanCard::where('column_id', $newColumnId)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $oldPosition)
                    ->increment('position');
            }

            $card->position = $newPosition;
            $card->save();

            $this->normalizeCardPositions($newColumnId);

            return $card;
        }

        // Moving to a different column
        // Step 1: Increment positions at or after newPosition in new column
        KanbanCard::where('column_id', $newColumnId)
            ->where('position', '>=', $newPosition)
            ->increment('position');

        // Step 2: Decrement positions after oldPosition in old column
        KanbanCard::where('column_id', $oldColumnId)
            ->where('position', '>', $oldPosition)
            ->decrement('position');

        // Step 3: Update card's column and position
        $card->column_id = $newColumnId;
        $card->position = $newPosition;
        $card->save();

        // Normalize positions in both columns
        $this->normalizeCardPositions($oldColumnId);
        $this->normalizeCardPositions($newColumnId);

        return $card;
    }

    protected function normalizeCardPositions(int $columnId): void
    {
        $cards = KanbanCard::where('column_id', $columnId)
            ->orderBy('position')
            ->get();

        foreach ($cards as $index => $card) {
            if ($card->position !== $index) {
                $card->position = $index;
                $card->save();
            }
        }
    }
}