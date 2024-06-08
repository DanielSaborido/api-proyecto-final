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
        User::factory()->admin()->create(['name' => 'TestAdmin', 'email' => 'admin@test.com', 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        Customer::factory()->count(20)->customer()->create();
        Customer::factory()->customer()->create(['name' => 'TestCustomer', 'email' => 'customer@test.com', 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);

        $seasonCategory = Category::factory()->create(['name' => 'Temporada', 'description' => 'Productos de temporada.']);
        Category::factory()->count(5)->create();

        $allCategories = Category::all();

        Product::factory()->count(30)->create()->each(function ($product) use ($allCategories, $seasonCategory) {
            $product->category_id = $allCategories->random()->id;
            if (rand(0, 1)) {
                $product->category_id = $seasonCategory->id;
            }
            $product->save();
        });
    }
}
