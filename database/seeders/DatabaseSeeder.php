<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(25)->create();
        \App\Models\Gallery::factory(25)->hasImages(5)->create();
    }
}
