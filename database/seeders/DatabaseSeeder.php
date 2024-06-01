<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\CustomerFactory;
use Database\Factories\ProductFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->user()->create();

        User::factory(5)->admin()->create();

        Customer::factory(20)->customer()->create();

        $seasonCategory = Category::factory()->create(['name' => 'Temporada', 'description' => 'Productos de temporada.']);
        $categories = Category::factory(5)->create();

        Product::factory(50)->create()->each(function ($product) use ($categories, $seasonCategory) {
            $product->category_id = $categories->random()->id;
            if (rand(0, 1)) {
                $product->category_id = $seasonCategory->id;
            }
            $product->save();
        });
    }
}
