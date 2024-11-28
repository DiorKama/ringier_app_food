<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->numberBetween(1000, 10000),
            'payment_period' => $this->faker->numberBetween(1, 12), // Par exemple, de 1 à 12 mois
        ];
    }
}
