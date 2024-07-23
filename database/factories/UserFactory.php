<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'title' => fake()->randomElement(array_keys(config('employees.titles'))),
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'position' => $this->faker->jobTitle,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // password
            'phone_number' => $this->faker->phoneNumber,
            'disable' => false,
            'desactivate_date' => null,
            'is_superadmin' => false,
            'role' => 'user',
            'remember_token' => Str::random(10),
        ];
    }

    // public function admin()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'role' => 'admin',
    //             'is_superadmin' => true,
    //             'email' => 'admin@example.com',
    //             'firstName' => 'Admin',
    //             'lastName' => 'User',
    //         ];
    //     });
    // }
}
