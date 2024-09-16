<?php

namespace Database\Factories;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->unique()->numerify('COMP-####'),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['unresolved', 'in progress', 'resolved']),
        ];
    }
}
