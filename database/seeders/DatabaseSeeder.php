<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->count(10)->user()->create();
        User::factory()->count(5)->admin()->create();
        Customer::factory()->count(20)->customer()->create();

        $seasonCategory = Category::factory()->create(['name' => 'Temporada', 'description' => 'Productos de temporada.']);
        Category::factory()->count(5)->create();

        $allCategories = Category::all();

        Product::factory()->count(50)->create()->each(function ($product) use ($allCategories, $seasonCategory) {
            $product->category_id = $allCategories->random()->id;
            if (rand(0, 1)) {
                $product->category_id = $seasonCategory->id;
            }
            $product->save();
        });
    }
}
