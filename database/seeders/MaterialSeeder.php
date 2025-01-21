<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            'Katoen',
            'Polyester',
            'Wol',
            'Zijde',
            'Linnen',
            'Leer',
            'Denim',
            'Fleece',
            'Nylon',
            'Spandex',
        ];

        foreach ($materials as $material) {
            Material::create([
                'name' => $material,
                'slug' => Str::slug($material),
            ]);
        }
    }
}
