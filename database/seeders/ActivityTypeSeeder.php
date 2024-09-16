<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Workshop',
            'Conference',
            'Seminar',
            'Meeting',
            'Training',
        ];

        foreach ($types as $type) {
            ActivityType::create(['name' => $type]);
        }
    }
}
