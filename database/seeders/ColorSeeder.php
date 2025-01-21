<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            ['name' => 'Leisteen', 'slug' => 'leisteen', 'tailwind_color' => 'slate'],
            ['name' => 'Grijs', 'slug' => 'grijs', 'tailwind_color' => 'gray'],
            ['name' => 'Zink', 'slug' => 'zink', 'tailwind_color' => 'zinc'],
            ['name' => 'Neutraal', 'slug' => 'neutraal', 'tailwind_color' => 'neutral'],
            ['name' => 'Steen', 'slug' => 'steen', 'tailwind_color' => 'stone'],
            ['name' => 'Rood', 'slug' => 'rood', 'tailwind_color' => 'red'],
            ['name' => 'Oranje', 'slug' => 'oranje', 'tailwind_color' => 'orange'],
            ['name' => 'Amber', 'slug' => 'amber', 'tailwind_color' => 'amber'],
            ['name' => 'Geel', 'slug' => 'geel', 'tailwind_color' => 'yellow'],
            ['name' => 'Limoen', 'slug' => 'limoen', 'tailwind_color' => 'lime'],
            ['name' => 'Groen', 'slug' => 'groen', 'tailwind_color' => 'green'],
            ['name' => 'Smaragd', 'slug' => 'smaragd', 'tailwind_color' => 'emerald'],
            ['name' => 'Groenblauw', 'slug' => 'groenblauw', 'tailwind_color' => 'teal'],
            ['name' => 'Cyaan', 'slug' => 'cyaan', 'tailwind_color' => 'cyan'],
            ['name' => 'Hemel', 'slug' => 'hemel', 'tailwind_color' => 'sky'],
            ['name' => 'Blauw', 'slug' => 'blauw', 'tailwind_color' => 'blue'],
            ['name' => 'Indigo', 'slug' => 'indigo', 'tailwind_color' => 'indigo'],
            ['name' => 'Violet', 'slug' => 'violet', 'tailwind_color' => 'violet'],
            ['name' => 'Paars', 'slug' => 'paars', 'tailwind_color' => 'purple'],
            ['name' => 'Fuchsia', 'slug' => 'fuchsia', 'tailwind_color' => 'fuchsia'],
            ['name' => 'Roze', 'slug' => 'roze', 'tailwind_color' => 'pink'],
            ['name' => 'Roos', 'slug' => 'roos', 'tailwind_color' => 'rose'],
            ['name' => 'Wit', 'slug' => 'wit', 'tailwind_color' => 'white'],
            ['name' => 'Zwart', 'slug' => 'zwart', 'tailwind_color' => 'black']
        ];

        foreach ($colors as $color) {
            Color::create([
                'name' => $color['name'],
                'slug' => $color['slug'],
                'tailwind_color' => $color['tailwind_color']
            ]);
        }
    }
}
