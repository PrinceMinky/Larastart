<?php

namespace Database\Factories;

use App\Models\KanbanBoard;
use Illuminate\Support\Str;
use App\Models\KanbanColumn;
use Illuminate\Database\Eloquent\Factories\Factory;

class KanbanColumnFactory extends Factory
{
    protected $model = KanbanColumn::class;

    public function definition()
    {
        return [
            'board_id' => KanbanBoard::factory(),
            'title' => $this->faker->sentence(3),
            'slug' => Str::slug($this->faker->words(3, true)),
            'position' => $this->faker->numberBetween(1, 10),
        ];
    }
}
