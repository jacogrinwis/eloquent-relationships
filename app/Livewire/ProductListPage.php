<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Material;

class ProductListPage extends Component
{
    public function render()
    {
        $filters = [
            'categories' => Category::select('id', 'name', 'slug')->withCount('products')->get(),
            'colors' => Color::select('id', 'name', 'slug')->withCount('products')->get(),
            'materials' => Material::select('id', 'name', 'slug')->withCount('products')->get(),
        ];

        $products = Product::with(['category', 'colors', 'materials'])
            ->select(['id', 'name', 'slug', 'description', 'price', 'cover', 'category_id'])
            ->paginate(12);

        return view('livewire.product-list-page', [
            'filters' => $filters,
            'products' => $products
        ]);
    }
}
