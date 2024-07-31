<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Créez 10 menus avec la factory
        Menu::factory()->count(10)->create();
    }
}

