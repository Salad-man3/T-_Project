<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::factory(20)->create()->each(function ($news) {
            $news->photos()->saveMany(
                Photo::factory(rand(1, 3))->make()
            );
        });
    }
}
