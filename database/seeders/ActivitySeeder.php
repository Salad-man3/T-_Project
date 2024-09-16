<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityType;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $types = ActivityType::all();

        foreach ($types as $type) {
            Activity::factory(5)->create([
                'activity_type_id' => $type->id,
            ])->each(function ($activity) {
                $activity->photos()->saveMany(
                    Photo::factory(rand(1, 5))->make()
                );
            });
        }
    }
}