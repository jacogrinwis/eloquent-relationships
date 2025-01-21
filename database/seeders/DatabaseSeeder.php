<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Material;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            CategorySeeder::class,
            ColorSeeder::class,
            MaterialSeeder::class,
            ProductSeeder::class,
        ]);

        Product::factory(20)
            ->create()
            ->each(function ($product) {
                // Attach random colors
                $product->colors()->attach(
                    Color::inRandomOrder()->take(rand(1, 3))->pluck('id')
                );

                // Attach random materials
                $product->materials()->attach(
                    Material::inRandomOrder()->take(rand(1, 2))->pluck('id')
                );

                // Assign a random category
                $product->category()->associate(
                    Category::inRandomOrder()->first()
                )->save();
            });
    }
}
