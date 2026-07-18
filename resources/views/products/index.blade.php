<x-main-layout>
    <x-slot name="title">Collections — ChronosLuxury Boutique</x-slot>

    <style>
        .watch-profile-tilt {
            transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            transform-style: preserve-3d;
            perspective: 800px;
        }
        .group:hover .watch-profile-tilt {
            transform: scale(1.06) rotateY(-25deg) rotateX(12deg) translateY(-6px);
        }
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-bg {
            background: linear-gradient(90deg, #161618 25%, #232326 50%, #161618 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite linear;
        }
    </style>

    <!-- Header Page (Luxury dark theme minimalis) -->
    <section class="bg-luxury-bg py-12 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl md:text-4xl text-white font-bold tracking-wide">The Chronos Collection</h1>
                <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">Authenticated masterpieces of horology</p>
            </div>
            
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs tracking-wider uppercase text-zinc-500 mt-4 md:mt-0 font-medium">
                <a href="{{ url('/') }}" class="hover:text-luxury-gold transition">Home</a>
                <span class="text-zinc-700">/</span>
                <span class="text-luxury-gold">Shop</span>
            </div>
        </div>
    </section>

    <!-- Main Catalog Area -->
    <section class="py-16 bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- FILTER SIDEBAR (Kiri - col-span-1) -->
                <aside class="space-y-8 lg:col-span-1 bg-zinc-950 p-6 rounded-lg border border-white/5 h-fit">
                    <form action="{{ url('/products') }}" method="GET" class="space-y-6">
                        <!-- Keep search word if any -->
                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <!-- Filter Header -->
                        <div class="flex justify-between items-center pb-4 border-b border-white/5">
                            <span class="font-serif text-md text-white font-bold tracking-wider">Filters</span>
                            <a href="{{ url('/products') }}" class="text-[10px] text-zinc-500 hover:text-luxury-gold uppercase tracking-widest transition">Clear All</a>
                        </div>

                        <!-- Category Filter -->
                        <div class="space-y-3">
                            <h3 class="text-xs uppercase tracking-widest font-semibold text-luxury-gold mb-2">Category</h3>
                            <div class="flex flex-col gap-2">
                                <label class="flex items-center gap-3 text-xs text-zinc-300 hover:text-luxury-gold cursor-pointer transition">
                                    <input type="radio" name="category" value="" 
                                           {{ !request('category') ? 'checked' : '' }}
                                           class="accent-luxury-gold border-white/10 bg-zinc-900 rounded focus:ring-0">
                                    <span class="flex-grow">All Timepieces</span>
                                </label>
                                @foreach ($categories as $cat)
                                    <label class="flex items-center gap-3 text-xs text-zinc-300 hover:text-luxury-gold cursor-pointer transition">
                                        <input type="radio" name="category" value="{{ $cat->slug }}" 
                                               {{ request('category') === $cat->slug ? 'checked' : '' }}
                                               class="accent-luxury-gold border-white/10 bg-zinc-900 rounded focus:ring-0">
                                        <span class="flex-grow">{{ $cat->name }}</span>
                                        <span class="text-[10px] text-zinc-500 bg-zinc-900 px-2 py-0.5 rounded font-mono">{{ $cat->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="space-y-3">
                            <h3 class="text-xs uppercase tracking-widest font-semibold text-luxury-gold mb-2">Price Range (IDR)</h3>
                            <div class="space-y-2">
                                <input type="number" name="min_price" placeholder="Min Price" 
                                       value="{{ request('min_price') }}"
                                       class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 placeholder-zinc-650 focus:outline-none focus:border-luxury-gold">
                                <input type="number" name="max_price" placeholder="Max Price" 
                                       value="{{ request('max_price') }}"
                                       class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 placeholder-zinc-650 focus:outline-none focus:border-luxury-gold">
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="space-y-2">
                            <h3 class="text-xs uppercase tracking-widest font-semibold text-luxury-gold mb-2">Availability</h3>
                            <label class="flex items-center gap-3 text-xs text-zinc-300 hover:text-luxury-gold cursor-pointer transition">
                                <input type="checkbox" name="stock" value="instock"
                                       {{ request('stock') === 'instock' ? 'checked' : '' }}
                                       class="accent-luxury-gold border-white/10 bg-zinc-900 rounded focus:ring-0">
                                <span>In Stock Only</span>
                            </label>
                        </div>

                        <!-- Sort By Dropdown -->
                        <div class="space-y-2">
                            <h3 class="text-xs uppercase tracking-widest font-semibold text-luxury-gold mb-2">Sort By</h3>
                            <select name="sort" class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold cursor-pointer">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest Releases</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>
                        </div>

                        <!-- Submit Buttons -->
                        <button type="submit" class="w-full bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3 rounded transition duration-300 shadow">
                            Apply Filters
                        </button>
                    </form>
                </aside>

                <!-- PRODUCTS GRID AREA (Kanan - col-span-3) -->
                <main class="lg:col-span-3 space-y-8">
                    <!-- Quick Filter Chips -->
                    <div class="flex flex-wrap items-center gap-2 pb-1">
                        <span class="text-[9px] uppercase tracking-widest text-zinc-500 font-semibold mr-1.5">Quick filters:</span>
                        <a href="{{ url('/products?max_price=300000000') }}" data-filter-chip
                           class="text-[9px] uppercase tracking-widest px-3 py-1.5 rounded-full border border-white/10 text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold transition duration-205 bg-zinc-950">
                            Under 300jt
                        </a>
                        <a href="{{ url('/products?max_price=1000000000') }}" data-filter-chip
                           class="text-[9px] uppercase tracking-widest px-3 py-1.5 rounded-full border border-white/10 text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold transition duration-205 bg-zinc-950">
                            Under 1M
                        </a>
                        <a href="{{ url('/products?search=unworn') }}" data-filter-chip
                           class="text-[9px] uppercase tracking-widest px-3 py-1.5 rounded-full border border-white/10 text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold transition duration-205 bg-zinc-950">
                            Unworn List
                        </a>
                        <a href="{{ url('/products?sort=newest') }}" data-filter-chip
                           class="text-[9px] uppercase tracking-widest px-3 py-1.5 rounded-full border border-white/10 text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold transition duration-205 bg-zinc-950">
                            New Arrival
                        </a>
                    </div>

                    <!-- Status / Summary Info Bar -->
                    <div class="flex items-center justify-between text-xs text-zinc-500 pb-4 border-b border-white/5">
                        <p>Showing <span class="text-white font-medium">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</span> of <span class="text-white font-medium">{{ $products->total() }}</span> results</p>
                        
                        <!-- Mini search result indicator -->
                        @if (request('search'))
                            <p class="italic text-zinc-400">Search results for: "{{ request('search') }}"</p>
                        @endif
                    </div>

                    <!-- Products Grid (Clean White Card layout - Inspired by Screenshot 1) -->
                    @if ($products->isEmpty())
                        <div class="text-center py-20 bg-zinc-950 rounded-lg border border-white/5">
                            <i class="fa-solid fa-hourglass-empty text-3xl text-luxury-gold mb-4"></i>
                            <h3 class="font-serif text-lg text-white font-semibold">No Timepieces Found</h3>
                            <p class="text-zinc-500 text-xs mt-2 max-w-xs mx-auto">We couldn't find any watches matching your criteria. Try adjustments to your filters or search keywords.</p>
                            <a href="{{ url('/products') }}" class="inline-block mt-6 text-xs uppercase tracking-widest text-luxury-gold hover:text-white transition duration-300">View All</a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach ($products as $product)
                                <div class="bg-white rounded-md p-6 sm:p-8 flex items-center justify-between border border-zinc-100 shadow-md hover:shadow-xl transition-all duration-300 relative group overflow-hidden">
                                    
                                    <!-- Left Side Info -->
                                    <div class="flex flex-col justify-between h-full z-10 max-w-[60%]">
                                        <div>
                                            <!-- Favorite Heart Icon -->
                                            <button class="text-emerald-700 hover:text-emerald-500 transition mb-4 block" title="Add to Wishlist">
                                                <i class="fa-regular fa-heart text-xl"></i>
                                            </button>
                                            
                                            <!-- Title Link to detail page -->
                                            <a href="{{ url('/products/' . $product->slug) }}" class="block">
                                                <h3 class="font-sans text-xl sm:text-2xl text-zinc-900 font-bold tracking-tight mb-2 hover:text-luxury-gold transition duration-300">
                                                    {{ $product->name }}
                                                </h3>
                                            </a>
                                            
                                            <p class="text-zinc-500 text-xs sm:text-sm font-light leading-relaxed mb-6">
                                                {{ $product->reference_number ? 'Ref: ' . $product->reference_number . ' — ' : '' }}{{ $product->case_material }}, {{ $product->case_diameter }}
                                            </p>
                                        </div>

                                        <div>
                                            <div class="flex items-center gap-2 text-zinc-950 font-semibold text-md sm:text-lg">
                                                <span>IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <button class="text-zinc-400 hover:text-zinc-900 transition" title="Price Information">
                                                    <i class="fa-solid fa-circle-info text-xs"></i>
                                                </button>
                                            </div>
                                            
                                            <div class="flex items-center gap-2 mt-3">
                                                <span class="text-[9px] uppercase tracking-wider text-luxury-goldDark bg-amber-50 px-2 py-1 rounded font-semibold">
                                                    {{ $product->category->name }}
                                                </span>
                                                @if ($product->stock > 0)
                                                    <span class="text-[9px] uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2 py-1 rounded font-semibold">
                                                        In Stock ({{ $product->stock }})
                                                    </span>
                                                @else
                                                    <span class="text-[9px] uppercase tracking-wider text-red-900 bg-red-50 px-2 py-1 rounded font-semibold">
                                                        Sold Out
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Side Product Image with Floating look and soft shadowing -->
                                    <a href="{{ url('/products/' . $product->slug) }}" class="relative w-[130px] sm:w-[160px] h-[180px] flex items-center justify-center select-none z-10 shrink-0 overflow-visible">
                                        <!-- Soft drop shadow underneath watch -->
                                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-4/5 h-4 bg-black/15 blur-md rounded-full transition-transform duration-500 group-hover:scale-x-110"></div>
                                        
                                        <!-- Watch Image floats slightly up on hover with 3D profile tilt -->
                                        <div class="watch-profile-tilt">
                                            <img src="{{ asset($product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="h-[155px] w-auto object-contain z-10 drop-shadow-[0_10px_20px_rgba(0,0,0,0.12)]">
                                        </div>
                                    </a>

                                    <!-- Hover golden accent line at the bottom -->
                                    <div class="absolute bottom-0 left-0 w-full h-[3px] bg-luxury-gold transform scale-x-0 group-hover:scale-x-100 origin-left transition duration-300"></div>

                                    <!-- Quick add-to-cart overlay/action button on hover -->
                                    @if ($product->stock > 0)
                                        <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition duration-300">
                                            <form action="{{ url('/cart') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="bg-zinc-900 hover:bg-luxury-gold text-white hover:text-black h-8 w-8 rounded-full flex items-center justify-center shadow transition duration-300" title="Add to Cart">
                                                    <i class="fa-solid fa-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination section (Luxury style) -->
                        <div class="pt-8 border-t border-white/5">
                            {{ $products->links('partials.pagination') }}
                        </div>
                    @endif
                </main>

            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterForm = document.querySelector('aside form');
            const mainContainer = document.querySelector('main');

            if (filterForm && mainContainer) {
                const handleFilterLoad = async (url) => {
                    // Show Shimmer Skeletons
                    displaySkeletonShimmer();

                    try {
                        const response = await fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        if (!response.ok) throw new Error('Query error');

                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Keep shimmer rendering visible for a natural 450ms duration transition
                        setTimeout(() => {
                            const newMain = doc.querySelector('main');
                            if (newMain) {
                                mainContainer.innerHTML = newMain.innerHTML;
                                window.history.pushState({}, '', url);
                                // Scroll gracefully back slightly if down
                                if (window.scrollY > 300) {
                                    window.scrollTo({ top: 300, behavior: 'smooth' });
                                }
                            }
                        }, 450);

                    } catch (error) {
                        console.error('Filter request failed, reloading fallback:', error);
                        window.location.href = url;
                    }
                };

                // Intercept filter sidebar submit
                filterForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const url = filterForm.action + '?' + params.toString();
                    handleFilterLoad(url);
                });

                // Intercept chip and pagination clicks dynamically in document
                document.addEventListener('click', (e) => {
                    const pagLink = e.target.closest('.pagination a, [data-filter-chip]');
                    if (pagLink) {
                        e.preventDefault();
                        handleFilterLoad(pagLink.href);
                    }
                });
            }

            function displaySkeletonShimmer() {
                const grid = document.querySelector('main .grid');
                if (grid) {
                    grid.innerHTML = `
                        ${Array(4).fill(0).map(() => `
                            <div class="bg-zinc-950/50 rounded-md p-6 sm:p-8 flex items-center justify-between border border-white/5 h-[230px]">
                                <div class="space-y-4 w-1/2">
                                    <div class="h-4.5 shimmer-bg rounded w-1/3 opacity-70"></div>
                                    <div class="h-8 shimmer-bg rounded w-5/6"></div>
                                    <div class="h-3 shimmer-bg rounded w-2/3 opacity-40"></div>
                                    <div class="h-6.5 shimmer-bg rounded w-1/2"></div>
                                </div>
                                <div class="w-28 h-36 shimmer-bg rounded-md opacity-85"></div>
                            </div>
                        `).join('')}
                    `;
                }
            }
        });
    </script>
</x-main-layout>
