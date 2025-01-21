<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ProductListPage extends Component
{
    use WithPagination;

    public $selectedCategories = [];
    public $selectedColors = [];
    public $selectedMaterials = [];

    public $showAllCategories = false;
    public $showAllColors = false;
    public $showAllMaterials = false;




    #[Url(as: 'categorie', except: '')]
    public string $queryStringCategory = '';

    #[Url(as: 'kleur', except: '')]
    public string $queryStringColor = '';

    #[Url(as: 'materiaal', except: '')]
    public string $queryStringMaterial = '';

    #[On('filter-updated')]
    public function handleFilters(array $filters)
    {
        dd($filters);

        match ($filters['type']) {
            'categories' => $this->handleCategories($filters['selected']),
            'colors' => $this->handleColors($filters['selected']),
            'materials' => $this->handleMaterials($filters['selected']),
        };
    }

    private function handleCategories($selected)
    {
        if (empty($selected)) {
            $this->queryStringCategory = '';
        } else {
            $this->selectedCategories = $selected;
            $this->queryStringCategory = $this->buildQueryString(Category::class, $selected, 'categories');
        }
    }

    private function handleColors($selected)
    {
        $this->selectedColors = $selected;
        $this->queryStringColor = $this->buildQueryString(Color::class, $selected, 'colors');
    }

    private function handleMaterials($selected)
    {
        $this->selectedMaterials = $selected;
        $this->queryStringMaterial = $this->buildQueryString(Material::class, $selected, 'materials');
    }

    private function buildQueryString($model, $ids, $type)
    {
        $slugs = match ($type) {
            'categories' => Category::whereIn('id', $ids)->pluck('slug')->toArray(),
            'colors' => Color::whereIn('id', $ids)->pluck('slug')->toArray(),
            'materials' => Material::whereIn('id', $ids)->pluck('slug')->toArray(),
        };

        return implode(',', $slugs);
    }



    #[On('filters-updated')]
    public function updateFilters()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategories()
    {
        $this->handleCategories($this->selectedCategories);
    }

    public function updatedSelectedColors()
    {
        $this->handleColors($this->selectedColors);
    }

    public function updatedSelectedMaterials()
    {
        $this->handleMaterials($this->selectedMaterials);
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
        // ->orderBy('name');

        $filters = [
            'categories' => Category::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['categories']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['categories']);
                })
                ->orderBy('name')
                ->get(),

            'colors' => Color::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['colors']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['colors']);
                })
                ->orderBy('name')
                ->get(),

            'materials' => Material::withCount(['products' => function ($query) {
                $this->applyCurrentFilters($query, ['materials']);
            }])
                ->whereHas('products', function ($query) {
                    $this->applyCurrentFilters($query, ['materials']);
                })
                ->orderBy('name')
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
