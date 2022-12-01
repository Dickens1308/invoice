<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'brand' => fake()->domainName(),
            'quantity' => rand(10, 50),
            'description' => fake()->sentence(6),
            'price' => rand(100000, 1000000),
            'category_id' => rand(1, 10),
            'barcode' => fake()->uuid(),
        ];
    }
}
