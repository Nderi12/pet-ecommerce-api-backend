<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\OrderStatus;
use BlogSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Call various seeders
         */
        
         $this->call(CategorySeeder::class);
         $this->call(ProductSeeder::class);
         $this->call(OrderStatusSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(BlogSeeder::class);
    }
}
