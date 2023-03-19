<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph(),
            'category_uuid' => $this->faker->uuid(),
            'metadata' => ['key' => 'value'],
        ];
    }
}
