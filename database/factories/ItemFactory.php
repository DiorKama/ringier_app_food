<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\ItemCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
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
            'title' => $this->faker->word,
            'slug' => null,
            'active' => 1,
            'restaurant_id' => Restaurant::factory(),
            'item_category_id' => ItemCategorie::factory(),
            'item_thumb' => $this->faker->imageUrl(640, 480, 'food', true),
            'price' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
