<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        // IDs from picsum.photos that look like food/drinks/dining
        $foodImageIds = [102, 163, 192, 225, 292, 312, 429, 431, 488, 493, 517, 674, 755, 766, 824, 835, 999];
        $randomId = $this->faker->randomElement($foodImageIds);

        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(10000, 150000),
            'is_available' => true,
            'is_featured' => $this->faker->boolean(20),
            'preparation_time' => $this->faker->numberBetween(10, 30),
            'image_url' => "https://picsum.photos/id/{$randomId}/400/300",
        ];
    }
}
