<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categories = Category::get()->pluck('uuid');

        foreach(range(1, 10) as $index) {
            Product::create([
                'title' => $faker->randomElement([
                    'Premium Dog Food with Real Chicken and Vegetables',
                    'Cozy Dog Bed with Soft Fleece Lining',
                    'Durable Dog Toys for Aggressive Chewers',
                    'Pet Grooming Kit with Clippers and Combs',
                    'Adjustable Dog Harness with Reflective Strips',
                    'Stylish Cat Tree with Multiple Levels and Scratching Posts',
                    'Comfortable Dog Collar with Padded Interior',
                    'Portable Dog Water Bottle and Bowl Combo',
                    'Natural Cat Litter Made from Corn and Wheat',
                    'Anti-Anxiety Dog Crate with Soundproofing and Calming Music'
                ]),
                'price' => $faker->randomFloat(2, 1, 100),
                'description' => $faker->paragraph,
                'category_uuid' => $faker->randomElement($categories),
                'metadata' => json_encode([
                    'brand' => $faker->sentence,
                    'image' => $faker->sentence,
                ]),
            ]);
        }
    }
}
