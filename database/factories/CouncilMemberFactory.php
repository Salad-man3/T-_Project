<?php

namespace Database\Factories;

use App\Models\CouncilMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouncilMemberFactory extends Factory
{
    protected $model = CouncilMember::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'photo_id' => null, // Assuming you want to set this later
        ];
    }
}
