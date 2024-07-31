<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition()
    {
        $now = Carbon::now();
        $startAt = $now->copy()->setTime(10, 0, 0);
        $endAt = $now->copy()->addHours(2);

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'validated_date' => $startAt,
            'closing_date' => $endAt,
            'active' => 1,
        ];
    }
}

