<?php

namespace Database\Seeders;

use App\Models\ItemCategorie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemCategorie::factory()->count(5)->create();
    }
}
