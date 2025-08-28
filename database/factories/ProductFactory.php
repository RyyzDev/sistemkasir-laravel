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
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10000, 500000), // 10rb - 500rb
            'stock' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(80), // 80% true
        ];
    }

    // State methods
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    public function outOfStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock' => 0,
            ];
        });
    }

    public function expensive()
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => $this->faker->randomFloat(2, 1000000, 5000000),
            ];
        });
    }
}