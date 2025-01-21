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
            'slate',
            'gray',
            'zinc',
            'neutral',
            'stone',
            'red',
            'orange',
            'amber',
            'yellow',
            'lime',
            'green',
            'emerald',
            'teal',
            'cyan',
            'sky',
            'blue',
            'indigo',
            'violet',
            'purple',
            'fuchsia',
            'pink',
            'rose',
            'white',
            'black',
        ];

        foreach ($colors as $color) {
            Color::create([
                'name' => ucfirst($color),
                'slug' => Str::slug($color)
            ]);
        }
    }
}
