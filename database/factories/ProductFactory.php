<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            'name' => $this->faker->productName(),
            'desc' => $this->faker->paragraph(),
            'sku' => strtoupper($this->faker->bothify('??##??##')),
            'qty' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(80),
            'image_url' => $this->faker->imageUrl(),
            'attrs' => json_encode(['color' => $this->faker->colorName()]),
        ];
    }
}
