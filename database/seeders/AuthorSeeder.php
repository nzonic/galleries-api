<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /// Used to create a user with 10+ galleries to check author page pagination :)
        \App\Models\User::factory()->has(\App\Models\Gallery::factory()->count(15)->hasImages(3))->create();
    }
}
