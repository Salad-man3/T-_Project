<?php

namespace Database\Seeders;

use App\Models\Decision;
use Illuminate\Database\Seeder;

class DecisionSeeder extends Seeder
{
    public function run(): void
    {
        Decision::factory(30)->create();
    }
}
