<?php

namespace App\Livewire;

use App\Models\Color;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Material;
use App\Enums\StockStatus;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ProductListPage extends Component
{
    use WithPagination;

    public $selectedCategories = [];
    public $selectedColors = [];
    public $selectedMaterials = [];
    public $selectedStockStatus = [];

    public $showAllCategories = false;
    public $showAllColors = false;
    public $showAllMaterials = false;
    public $showAllStockStatus = false;

    #[Url(as: 'categorie', except: '')]
    public string $queryStringCategory = '';

    #[Url(as: 'kleur', except: '')]
    public string $queryStringColor = '';

    #[Url(as: 'materiaal', except: '')]
    public string $queryStringMaterial = '';

    #[Url(as: 'voorraad', except: '')]
    public string $queryStringStockStatus = '';

    #[On('filter-updated')]
    public function handleFilters(array $filters)
    {
        match ($filters['type']) {
            'categories' => $this->handleCategories($filters['selected']),
            'colors' => $this->handleColors($filters['selected']),
            'materials' => $this->handleMaterials($filters['selected']),
            'stock_status' => $this->handleStockStatus($filters['selected']),
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

    private function handleStockStatus($selected)
    {
        $this->selectedStockStatus = $selected;
        $this->queryStringStockStatus = implode(',', $selected);
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
        $this->resetPage();
        $this->handleCategories($this->selectedCategories);
    }

    public function updatedSelectedColors()
    {
        $this->resetPage();
        $this->handleColors($this->selectedColors);
    }

    public function updatedSelectedMaterials()
    {
        $this->resetPage();
        $this->handleMaterials($this->selectedMaterials);
    }

    public function updatedSelectedStockStatus()
    {
        $this->resetPage();
        $this->handleStockStatus($this->selectedStockStatus);
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
            })
            ->when($this->selectedStockStatus, function ($query) {
                $query->whereIn('stock_status', $this->selectedStockStatus);
            });

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

            'stock_status' => collect(StockStatus::cases())
                ->map(function ($status) use ($productsQuery) {
                    return [
                        'id' => $status->value,
                        'name' => $status->label(),
                        'products_count' => Product::query()
                            ->when($this->selectedCategories, fn($q) => $q->whereIn('category_id', $this->selectedCategories))
                            ->when($this->selectedColors, fn($q) => $q->whereHas('colors', fn($q) => $q->whereIn('colors.id', $this->selectedColors)))
                            ->when($this->selectedMaterials, fn($q) => $q->whereHas('materials', fn($q) => $q->whereIn('materials.id', $this->selectedMaterials)))
                            ->where('stock_status', $status->value)
                            ->count()
                    ];
                })
        ];

        $products = $productsQuery->with(['category', 'colors', 'materials'])
            ->select(['id', 'product_number', 'name', 'slug', 'description', 'cover', 'price', 'discount', 'dimensions', 'weight', 'stock_status', 'category_id'])
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

        if (!in_array('stock_status', $exclude) && $this->selectedStockStatus) {
            $query->whereIn('stock_status', $this->selectedStockStatus);
        }
    }
}
