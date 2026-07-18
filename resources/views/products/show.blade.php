<x-main-layout>
    <x-slot name="title">{{ $product->name }} — ChronosLuxury Boutique</x-slot>

    <!-- Navigation Trail / Breadcrumbs -->
    <section class="bg-neutral-900 border-b border-white/5 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between text-xs tracking-wider uppercase">
            <div class="flex items-center gap-2 text-zinc-500 font-medium">
                <a href="{{ url('/') }}" class="hover:text-luxury-gold transition">Home</a>
                <span class="text-zinc-700">/</span>
                <a href="{{ url('/products') }}" class="hover:text-luxury-gold transition">Shop</a>
                <span class="text-zinc-700">/</span>
                <span class="text-luxury-gold">{{ $product->name }}</span>
            </div>
            
            <a href="{{ url('/products') }}" class="text-zinc-500 hover:text-luxury-gold transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back to Catalog
            </a>
        </div>
    </section>

    <!-- Product Detail Section -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                
                <!-- LEFT COLUMN: Image Showcase (col-span-5) -->
                <div class="lg:col-span-5 flex flex-col items-center">
                    <div class="bg-white/95 rounded-lg w-full aspect-square flex items-center justify-center p-8 sm:p-12 relative border border-zinc-100 shadow-lg group select-none">
                        
                        <!-- Wishlist button -->
                        <button class="absolute top-6 left-6 text-zinc-400 hover:text-emerald-700 transition" title="Add to Wishlist">
                            <i class="fa-regular fa-heart text-2xl"></i>
                        </button>
                        
                        <!-- Image Container with soft shadow and bounce animation -->
                        <div class="relative w-4/5 h-4/5 flex items-center justify-center">
                            <div class="absolute bottom-[-10px] left-1/2 -translate-x-1/2 w-11/12 h-6 bg-black/15 blur-md rounded-full transition-transform duration-500 group-hover:scale-x-105"></div>
                            
                            <img src="{{ asset($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="max-h-full w-auto object-contain z-10 drop-shadow-[0_15px_30px_rgba(0,0,0,0.15)] transition-transform duration-500 group-hover:-translate-y-3">
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Purchase Details & Technical Specs (col-span-7) -->
                <div class="lg:col-span-7 flex flex-col justify-between">
                    <div>
                        <!-- Category Badge and Stock Status -->
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-luxury-gold bg-luxury-gold/10 border border-luxury-gold/20 px-3 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                            @if ($product->stock > 0)
                                <span class="text-[10px] uppercase font-bold tracking-widest text-emerald-400 flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span> In Stock ({{ $product->stock }})
                                </span>
                            @else
                                <span class="text-[10px] uppercase font-bold tracking-widest text-red-500 flex items-center gap-1.5">
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span> Sold Out
                                </span>
                            @endif
                        </div>

                        <!-- Product Title -->
                        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-white font-bold tracking-wide leading-tight mb-2">
                            {{ $product->name }}
                        </h1>
                        
                        <!-- Reference Number -->
                        @if ($product->reference_number)
                            <p class="text-xs uppercase tracking-widest text-zinc-500 mb-6 font-mono font-medium">Model Ref: {{ $product->reference_number }}</p>
                        @endif

                        <!-- Price Detail -->
                        <div class="flex items-baseline gap-4 py-4 border-y border-white/5 my-6">
                            <span class="text-2xl sm:text-3xl text-luxury-gold font-bold font-serif">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs text-zinc-500 tracking-wider">MSRP (Incl. local taxes)</span>
                        </div>

                        <!-- Description text -->
                        <div class="text-zinc-300 text-sm font-light leading-relaxed mb-8">
                            <p>{{ $product->description }}</p>
                        </div>

                        <!-- Add to Cart Form -->
                        @if ($product->stock > 0)
                            <form action="{{ url('/cart') }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-stretch max-w-md pb-8 border-b border-white/5 mb-8" x-data="{ qty: 1 }">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Qty Counter -->
                                <div class="flex items-center justify-between border border-white/10 rounded-md bg-zinc-950 px-3 py-2 w-full sm:w-32">
                                    <button type="button" @click="if(qty > 1) qty--" class="text-zinc-400 hover:text-white px-2 py-1 focus:outline-none transition">
                                        <i class="fa-solid fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" name="quantity" x-model="qty" readonly class="bg-transparent border-0 text-center text-sm font-bold text-white w-8 p-0 focus:ring-0 focus:outline-none">
                                    <button type="button" @click="if(qty < {{ $product->stock }}) qty++" class="text-zinc-400 hover:text-white px-2 py-1 focus:outline-none transition">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" class="flex-grow bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3 px-6 rounded transition duration-300 flex items-center justify-center gap-2 shadow">
                                    <i class="fa-solid fa-bag-shopping"></i> Add to Boutique Cart
                                </button>
                            </form>
                        @endif

                    </div>
                </div>

            </div>

            <!-- Technical Specifications Table (Nuansa mewah rapi) -->
            <div class="mt-20 pt-12 border-t border-white/5">
                <div class="max-w-4xl mx-auto">
                    <h2 class="font-serif text-xl sm:text-2xl text-white font-bold tracking-wider mb-8 text-center sm:text-left">Technical Specifications</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 text-xs">
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Model Reference</span>
                            <span class="text-zinc-300 font-mono font-medium text-right">{{ $product->reference_number ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Movement type</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->movement ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Case Material</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->case_material ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Dial Type</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->dial_color ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Bracelet style</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->bracelet ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Power Reserve</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->power_reserve ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Water Resistance</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->water_resistance ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Case Diameter</span>
                            <span class="text-zinc-300 font-medium text-right">{{ $product->case_diameter ?? 'N/A' }}</span>
                        </div>

                        <div class="border-b border-white/5 py-3 flex justify-between gap-4">
                            <span class="text-zinc-500 uppercase tracking-widest">Item Condition</span>
                            <span class="text-zinc-300 font-medium text-right text-luxury-gold">{{ $product->condition ?? 'N/A' }}</span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- RELATED PRODUCTS SECTION -->
            @if ($relatedProducts->isNotEmpty())
                <div class="mt-24 pt-16 border-t border-white/5">
                    <h2 class="font-serif text-2xl text-white font-semibold tracking-wide text-center mb-12">Related Masterpieces</h2>
                    
                    <!-- Clean White Card horizontal layouts -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($relatedProducts as $related)
                            <div class="bg-white rounded-md p-6 sm:p-8 flex items-center justify-between border border-zinc-100 shadow-md hover:shadow-xl transition-all duration-300 relative group overflow-hidden">
                                
                                <div class="flex flex-col justify-between h-full z-10 max-w-[60%]">
                                    <div>
                                        <button class="text-emerald-700 hover:text-emerald-500 transition mb-4 block">
                                            <i class="fa-regular fa-heart text-xl"></i>
                                        </button>
                                        
                                        <a href="{{ url('/products/' . $related->slug) }}" class="block">
                                            <h3 class="font-sans text-xl sm:text-2xl text-zinc-900 font-bold tracking-tight mb-2 hover:text-luxury-gold transition duration-300">
                                                {{ $related->name }}
                                            </h3>
                                        </a>
                                        
                                        <p class="text-zinc-500 text-xs sm:text-sm font-light leading-relaxed mb-6">
                                            Ref: {{ $related->reference_number }} — {{ $related->case_diameter }}
                                        </p>
                                    </div>

                                    <div>
                                        <div class="flex items-center gap-2 text-zinc-950 font-semibold text-md sm:text-lg">
                                            <span>IDR {{ number_format($related->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <a href="{{ url('/products/' . $related->slug) }}" class="relative w-[130px] sm:w-[160px] h-[180px] flex items-center justify-center select-none z-10 shrink-0">
                                    <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-4/5 h-4 bg-black/15 blur-md rounded-full transition-transform duration-500 group-hover:scale-x-110"></div>
                                    
                                    <img src="{{ asset($related->image) }}" 
                                         alt="{{ $related->name }}" 
                                         class="h-[155px] w-auto object-contain z-10 drop-shadow-[0_10px_20px_rgba(0,0,0,0.1)] transition-transform duration-500 group-hover:-translate-y-2">
                                </a>

                                <div class="absolute bottom-0 left-0 w-full h-[3px] bg-luxury-gold transform scale-x-0 group-hover:scale-x-100 origin-left transition duration-300"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-main-layout>
