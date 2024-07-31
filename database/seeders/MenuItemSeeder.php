<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        // Créez 50 éléments de menu avec la factory
        MenuItem::factory()->count(20)->create();
    }
}

