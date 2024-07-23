<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'address' => $this->faker->address,
            'slug' => null,
            'about' => null,
            'logo' => null,
            'active' => 1,
            'phone_number' => $this->faker->optional()->phoneNumber,
            'website_url' => $this->faker->optional()->url,
            'facebook_url' => $this->faker->optional()->url,
            'instagram_url' => $this->faker->optional()->url,
            'linkedin_url' => $this->faker->optional()->url,
            'created_at' => now(),
            'updated_at' => now(),    
        ];
    }
}
