<div class="container mx-auto my-6 max-w-7xl">
    <div class="grid grid-cols-4 gap-8">
        <aside class="col-span-1 space-y-4 text-sm">
            <section class="rounded p-4 shadow">
                <h3 class="mb-2 text-lg font-semibold">Categorieën ({{ $filters['categories']->count() }})</h3>
                @foreach ($filters['categories'] as $category)
                    <label class="mb-2 flex items-center gap-2">
                        <input
                            type="checkbox"
                            value="{{ $category->id }}"
                            class="h-4 w-4 rounded border-gray-300"
                        >
                        {{ $category->name }} ({{ $category->products_count }})
                    </label>
                @endforeach
            </section>
            <section class="rounded p-4 shadow">
                <h3 class="mb-2 text-lg font-semibold">Kleuren ({{ $filters['colors']->count() }})</h3>
                @foreach ($filters['colors'] as $color)
                    <label class="mb-2 flex items-center gap-2">
                        <input
                            type="checkbox"
                            value="{{ $color->id }}"
                            class="h-4 w-4 rounded border-gray-300"
                        >
                        <span
                            class="bg-{{ $color->slug }}{{ !in_array($color->slug, ['white', 'black']) ? '-500' : '' }} {{ $color->slug == 'white' ? 'border border-gray-300' : '' }} size-3 rounded-full"
                        ></span>
                        {{ $color->name }} ({{ $color->products_count }})
                    </label>
                @endforeach
            </section>
            <section class="rounded p-4 shadow">
                <h3 class="mb-2 text-lg font-semibold">Materialen ({{ $filters['materials']->count() }})</h3>
                @foreach ($filters['materials'] as $material)
                    <label class="mb-2 flex items-center gap-2">
                        <input
                            type="checkbox"
                            value="{{ $material->id }}"
                            class="h-4 w-4 rounded border-gray-300"
                        >
                        {{ $material->name }} ({{ $material->products_count }})
                    </label>
                @endforeach
            </section>
        </aside>
        <main class="col-span-3">
            <div class="mb-6 grid grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <section class="rounded p-4 shadow">
                        <img
                            src="{{ asset($product->cover) }}"
                            alt="{{ $product->name }}"
                            class="aspect-square w-full rounded object-cover"
                        >
                        <h2 class="mb-2 truncate text-lg font-semibold">{{ $product->name }}</h2>
                        <p>€{{ $product->price }}</p>
                        <p>Category: {{ $product->category->name }}</p>
                        <div>
                            Colors:
                            @foreach ($product->colors as $color)
                                <span>{{ $color->name }}</span>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
            {{ $products->links() }}
        </main>
    </div>
</div>
