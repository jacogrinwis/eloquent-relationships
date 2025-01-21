<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        static $number = 1;
        $name = $this->faker->words(3, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'price' => $this->faker->numberBetween(100, 9999),
            'discount' => function () {
                if (mt_rand(1, 100) <= 75) {
                    return null; // 75% kans op null
                } else {
                    return Arr::random([10, 15, 30, 50]); // 25% kans op een van deze waarden
                }
            },
            'dimensions' => $this->faker->numberBetween(10, 100) . ' x ' . $this->faker->numberBetween(10, 100) . ' x ' . $this->faker->numberBetween(10, 100) . ' cm',
            'weight' => $this->faker->randomFloat(2, 0.1, 50),
            'cover' => 'storage/products/covers/' . $this->faker->numberBetween(1, 30) . '.jpg',
            'stock_status' => function () {
                $rand = mt_rand(1, 100);
                if ($rand <= 65) {
                    return 1; // 65% kans
                } elseif ($rand <= 90) {
                    return 2; // 25% kans (90 - 65)
                } else {
                    return 3; // 10% kans (100 - 90)
                }
            },
            'product_number' => sprintf('#%08d', $number++),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
