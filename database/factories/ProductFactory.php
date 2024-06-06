<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $timestamp = Carbon::now()->timestamp;
        $filename = "foto_" . $this->faker->word . "_$timestamp.jpg";
        $imageContent = $this->faker->image(storage_path('app/public/tmp'), 640, 480, 'animals', false);
        Storage::disk('imgProduct')->put($filename, file_get_contents(storage_path('app/public/tmp/' . $imageContent)));
        unlink(storage_path('app/public/tmp/' . $imageContent));

        return [
            'picture' => $filename,
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
            $product->category_id = Category::query()->inRandomOrder()->first()->id;
        });
    }
}
