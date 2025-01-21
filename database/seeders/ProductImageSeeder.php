<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $faker = \Faker\Factory::create();

        foreach ($products as $product) {
            $imageCount = rand(2, 10);
            for ($i = 1; $i <= $imageCount; $i++) {
                $imageNumber = rand(1, 30);
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => "storage/products/images/{$imageNumber}.jpg",
                    'alt_text' => $faker->slug(1),
                ]);
            }
        }
    }
}
