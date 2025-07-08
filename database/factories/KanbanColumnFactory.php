<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\KanbanColumn;
use App\Models\KanbanBoard;

class KanbanColumnFactory extends Factory
{
    protected $model = KanbanColumn::class;

    public function definition()
    {
        return [
            'board_id' => KanbanBoard::factory(),
            'title' => $this->faker->sentence(3),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}
