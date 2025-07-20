<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Samael Medina',
            'email' => 'samaelortiz2218@gmail.com',
            'password' => bcrypt('2832882812'),
        ]);

        Category::factory(5)->create();
        Recipe::factory(15)->create();
    }
}
