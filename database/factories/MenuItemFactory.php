<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Menu;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'menu_id' => Menu::factory(),
            'item_id' => Item::factory(),
            'price' => $this->faker->randomNumber(4),
        ];
    }
}

