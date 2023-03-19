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
            'metadata' => [
                'color' => $this->faker->safeColorName(),
                'size' => $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL']),
                'material' => $this->faker->word(),
                'weight' => $this->faker->randomFloat(2, 0.1, 10),
            ],
        ];
    }
}
