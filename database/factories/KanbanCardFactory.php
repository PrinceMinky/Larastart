<?php

namespace Database\Factories;

use App\Models\KanbanCard;
use App\Models\KanbanBoard;
use App\Models\KanbanColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

class KanbanCardFactory extends Factory
{
    protected $model = KanbanCard::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'position' => 1,
            'badges' => [],
            'column_id' => KanbanColumn::factory(),
            'due_at' => null,
        ];
    }
}
