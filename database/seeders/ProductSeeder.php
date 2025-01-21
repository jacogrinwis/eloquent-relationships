<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(50)
            ->create()
            ->each(function ($product) {
                $product->colors()->attach(
                    Color::inRandomOrder()->take(rand(1, 3))->pluck('id')
                );
                $product->materials()->attach(
                    Material::inRandomOrder()->take(rand(1, 2))->pluck('id')
                );
                $product->category()->associate(
                    Category::inRandomOrder()->first()
                )->save();
            });
    }
}
