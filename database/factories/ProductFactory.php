<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'picture' => $this->faker->imageUrl(640, 480, 'animals', true),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'availability' => $this->faker->boolean,
            'quantity' => $this->faker->numberBetween(1, 100),
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Product $product) {
            $category = Category::factory()->create();
            $product->category()->associate($category);
        });
    }
}
