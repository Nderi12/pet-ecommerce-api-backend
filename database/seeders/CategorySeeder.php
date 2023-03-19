<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $categories = [
                'Technology',
                'Food',
                'Fashion',
                'Sports',
                'Travel',
                'Health',
                'Education',
                'Entertainment',
                'Art',
                'Science'
            ];
    
            foreach ($categories as $category) {
                Category::create([
                    'title' => $category,
                    'slug' => Str::slug($category)
                ]);
            }
        }
    }
}
