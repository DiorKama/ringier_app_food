<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'order_number' => Str::upper(Str::random(10)),
            'price' => $this->faker->numberBetween(1000, 5000),
            'payment_status' => config('orders.statuses.pending'),
        ];
    }
}

