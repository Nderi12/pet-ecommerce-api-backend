<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'slug' => $this->faker->slug(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->sentence(),
            'metadata' => ['key' => 'value'],
        ];
    }
}
