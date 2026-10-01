<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'code' => fake()->unique()->bothify('BRG-####'),
            'name' => fake()->words(3, true),
            'unit' => fake()->randomElement(['pcs', 'box', 'pak']),
            'stock' => 0,
            'min_stock' => 5,
            'description' => fake()->optional()->sentence(),
        ];
    }
}
