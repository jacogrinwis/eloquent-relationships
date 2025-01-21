<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProductListPage extends Component
{
    use WithPagination;

    public $selectedCategories = [];
    public $selectedColors = [];
    public $selectedMaterials = [];

    #[On('filters-updated')]
    public function updateFilters()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->dispatch('filters-updated');
    }

    public function updatedSelectedColors()
    {
        $this->dispatch('filters-updated');
    }

    public function updatedSelectedMaterials()
    {
        $this->dispatch('filters-updated');
    }

    public function render()
    {
        $productsQuery = Product::query()
            ->when($this->selectedCategories, function ($query) {
                $query->whereIn('category_id', $this->selectedCategories);
            })
            ->when($this->selectedColors, function ($query) {
                $query->whereHas('colors', fn($q) => $q->whereIn('colors.id', $this->selectedColors));
            })
            ->when($this->selectedMaterials, function ($query) {
                $query->whereHas('materials', fn($q) => $q->whereIn('materials.id', $this->selectedMaterials));
            });

        $filters = [
            'categories' => Category::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['categories']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['categories']);
                })
                ->get(),

            'colors' => Color::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['colors']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['colors']);
                })
                ->get(),

            'materials' => Material::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['materials']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['materials']);
                })
                ->get(),
        ];

        $products = $productsQuery->with(['category', 'colors', 'materials'])
            ->select(['id', 'name', 'slug', 'description', 'price', 'cover', 'category_id'])
            ->paginate(12);

        return view('livewire.product-list-page', [
            'filters' => $filters,
            'products' => $products
        ]);
    }

    private function applyCurrentFilters($query, $exclude = [])
    {
        if (!in_array('categories', $exclude) && $this->selectedCategories) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!in_array('colors', $exclude) && $this->selectedColors) {
            $query->whereHas('colors', fn($q) => $q->whereIn('colors.id', $this->selectedColors));
        }

        if (!in_array('materials', $exclude) && $this->selectedMaterials) {
            $query->whereHas('materials', fn($q) => $q->whereIn('materials.id', $this->selectedMaterials));
        }
    }
}
