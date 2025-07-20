<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'category_id' => Category::inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'ingredients' => $this->faker->paragraph(),
            'instructions' => $this->faker->paragraph(),
            'image_path' => $this->faker->imageUrl(),
        ];
    }
}
