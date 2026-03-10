<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => 'T-'.$this->faker->unique()->numberBetween(1, 30),
            'capacity' => $this->faker->randomElement([2, 4, 6, 8]),
            'status' => 'available',
        ];
    }
}
