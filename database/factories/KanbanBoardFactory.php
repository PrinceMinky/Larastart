<?php

namespace Database\Factories;

use App\Models\KanbanBoard;
use Illuminate\Database\Eloquent\Factories\Factory;

class KanbanBoardFactory extends Factory
{
    protected $model = KanbanBoard::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'owner_id' => \App\Models\User::factory(), // Assumes you have User factory
            'badges' => [], // empty badges by default, adjust if needed
        ];
    }
}
