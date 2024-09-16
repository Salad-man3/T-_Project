<?php

namespace Database\Factories;

use App\Models\Decision;
use Illuminate\Database\Eloquent\Factories\Factory;

class DecisionFactory extends Factory
{
    protected $model = Decision::class;

    public function definition()
    {
        return [
            'decision_id' => $this->faker->unique()->numberBetween(1000, 9999),
            'decision_date' => $this->faker->date(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
