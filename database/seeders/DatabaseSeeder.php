<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ItemSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\MenuItemSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\ItemCategorieSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([UserSeeder::class,]);
        $this->call([RestaurantSeeder::class,]);
        $this->call([ItemCategorieSeeder::class,]);
        $this->call([ItemSeeder::class,]);
        $this->call([MenuSeeder::class,]);
        $this->call([MenuItemSeeder::class,]);
        $this->call([OrderSeeder::class,]);
        $this->call([OrderItemSeeder::class,]);
        $this->call([PaymentSeeder::class,]);
    }
}
