<x-main-layout>
    <x-slot name="title">Manage Timepieces — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Manage Products</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Boutique Inventory Catalog</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <nav class="flex space-x-6 text-xs tracking-wider uppercase font-medium mr-4">
                    <a href="{{ url('/admin/dashboard') }}" class="text-zinc-400 hover:text-white transition">Dashboard</a>
                    <a href="{{ url('/admin/categories') }}" class="text-zinc-400 hover:text-white transition">Categories</a>
                    <a href="{{ url('/admin/products') }}" class="text-luxury-gold font-bold">Products</a>
                    <a href="{{ url('/admin/orders') }}" class="text-zinc-400 hover:text-white transition">Orders</a>
                </nav>
                <a href="{{ route('products.create') }}" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-[10px] tracking-widest uppercase px-4 py-2 rounded transition">
                    <i class="fa-solid fa-plus mr-1"></i> List Timepiece
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-6">
                
                <!-- Search & Filters -->
                <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <form action="{{ url('/admin/products') }}" method="GET" class="relative max-w-md w-full">
                        <input type="text" name="search" placeholder="Search by name or reference number..." 
                               value="{{ request('search') }}"
                               class="w-full bg-zinc-900 border border-white/10 rounded-md py-2 pl-4 pr-10 text-xs text-zinc-300 placeholder-zinc-550 focus:outline-none focus:border-luxury-gold focus:ring-0 transition">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-luxury-gold transition">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                    
                    @if (request()->filled('search'))
                        <a href="{{ url('/admin/products') }}" class="text-zinc-500 hover:text-white text-xs transition">
                            Clear Search Filters
                        </a>
                    @endif
                </div>

                <!-- Products Table -->
                @if ($products->isEmpty())
                    <div class="text-center py-16 text-zinc-500 text-xs">
                        No exclusive timepieces found matching the filters.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-zinc-400">
                            <thead>
                                <tr class="text-zinc-500 uppercase tracking-wider border-b border-white/5 pb-4">
                                    <th class="py-3 font-semibold pb-4">Timepiece</th>
                                    <th class="py-3 font-semibold pb-4">Model Ref</th>
                                    <th class="py-3 font-semibold pb-4">Category</th>
                                    <th class="py-3 font-semibold pb-4">Price</th>
                                    <th class="py-3 font-semibold pb-4 text-center">Stock</th>
                                    <th class="py-3 font-semibold pb-4 text-center">Featured</th>
                                    <th class="py-3 font-semibold pb-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($products as $product)
                                    <tr>
                                        <!-- Timepiece name and image -->
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="bg-white rounded p-1 w-10 h-10 flex items-center justify-center shrink-0">
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-8 w-auto object-contain">
                                                </div>
                                                <div>
                                                    <a href="{{ url('/products/' . $product->slug) }}" class="text-white hover:text-luxury-gold font-semibold transition">
                                                        {{ $product->name }}
                                                    </a>
                                                    <p class="text-[9px] text-zinc-500 uppercase tracking-widest mt-0.5">{{ $product->case_diameter }} — Condition: {{ $product->condition }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Ref Num -->
                                        <td class="py-4 font-mono font-medium text-white">{{ $product->reference_number }}</td>
                                        
                                        <!-- Category -->
                                        <td class="py-4 text-zinc-300">{{ $product->category->name }}</td>
                                        
                                        <!-- Price -->
                                        <td class="py-4 font-semibold text-white">IDR {{ number_format($product->price, 0, ',', '.') }}</td>
                                        
                                        <!-- Stock status -->
                                        <td class="py-4 text-center">
                                            @if ($product->stock > 0)
                                                <span class="text-emerald-400 font-semibold">{{ $product->stock }} units</span>
                                            @else
                                                <span class="text-red-500 bg-red-500/10 px-2 py-0.5 border border-red-500/20 text-[9px] rounded font-bold uppercase tracking-wider">Out of Stock</span>
                                            @endif
                                        </td>

                                        <!-- Featured status -->
                                        <td class="py-4 text-center">
                                            @if ($product->featured)
                                                <span class="text-luxury-gold" title="Featured timepiece"><i class="fa-solid fa-star text-sm"></i></span>
                                            @else
                                                <span class="text-zinc-650" title="Regular list"><i class="fa-regular fa-star text-xs"></i></span>
                                            @endif
                                        </td>

                                        <!-- Actions crud -->
                                        <td class="py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('products.edit', $product->id) }}" class="text-luxury-gold hover:text-white transition" title="Modify item details">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                                                      onsubmit="return confirm('Attention: Deleting timepiece \'{{ $product->name }}\' is destructive. Proceed?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-zinc-600 hover:text-red-400 transition" title="Remove timepiece from boutique">
                                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6 border-t border-white/5">
                        {{ $products->links('partials.pagination') }}
                    </div>
                @endif

            </div>
        </div>
    </section>

</x-main-layout>
