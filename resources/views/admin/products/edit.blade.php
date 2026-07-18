<x-main-layout>
    <x-slot name="title">Edit Timepiece Details — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Edit Timepiece</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Modify Boutique Inventory Record</p>
            </div>
            
            <a href="{{ route('products.index') }}" class="text-zinc-400 hover:text-white text-xs uppercase tracking-widest transition flex items-center gap-2 font-medium">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back to List
            </a>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Section 1: Core details -->
                <div class="space-y-6">
                    <h3 class="font-serif text-md text-white font-semibold border-b border-white/5 pb-3">1. Identification & Price</h3>
                    
                    <!-- Image Preview -->
                    <div class="flex items-center gap-6">
                        <div class="bg-white rounded p-2 w-20 h-20 flex items-center justify-center shrink-0 border border-white/10 shadow">
                            <img src="{{ asset($product->image) }}" alt="Preview" class="h-16 w-auto object-contain">
                        </div>
                        <div>
                            <h4 class="text-white text-xs font-semibold">Active Photography</h4>
                            <p class="text-[10px] text-zinc-550 mt-1 uppercase tracking-wider font-mono">{{ $product->image }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Name -->
                        <div class="space-y-1">
                            <label for="name" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Timepiece Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('name')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="space-y-1">
                            <label for="category_id" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Collection Category</label>
                            <select id="category_id" name="category_id" required
                                    class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price -->
                        <div class="space-y-1">
                            <label for="price" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Price (IDR)</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0"
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-350 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('price')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="space-y-1">
                            <label for="stock" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Available Inventory units</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-350 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('stock')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo upload -->
                        <div class="space-y-1">
                            <label for="image" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Replace Photography (Optional)</label>
                            <input type="file" id="image" name="image" 
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-1.5 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            <span class="text-[9px] text-zinc-550 block">Leave blank to keep active photography.</span>
                            @error('image')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Featured Checkbox -->
                        <div class="flex items-center gap-2 pt-6">
                            <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}
                                   class="rounded bg-zinc-900 border-white/10 text-luxury-gold focus:ring-0 focus:outline-none h-4 w-4">
                            <label for="featured" class="text-xs uppercase tracking-wider text-zinc-400 font-semibold cursor-pointer select-none">Set as Featured Masterpiece</label>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Technical Specifications -->
                <div class="space-y-6">
                    <h3 class="font-serif text-md text-white font-semibold border-b border-white/5 pb-3">2. Horology & Technical Specs</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Model Ref -->
                        <div class="space-y-1">
                            <label for="reference_number" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Model Reference No</label>
                            <input type="text" id="reference_number" name="reference_number" value="{{ old('reference_number', $product->reference_number) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0 font-mono">
                            @error('reference_number')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Movement -->
                        <div class="space-y-1">
                            <label for="movement" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Movement Caliber</label>
                            <input type="text" id="movement" name="movement" value="{{ old('movement', $product->movement) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('movement')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Case Material -->
                        <div class="space-y-1">
                            <label for="case_material" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Case Material</label>
                            <input type="text" id="case_material" name="case_material" value="{{ old('case_material', $product->case_material) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('case_material')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dial color -->
                        <div class="space-y-1">
                            <label for="dial_color" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Dial color / Type</label>
                            <input type="text" id="dial_color" name="dial_color" value="{{ old('dial_color', $product->dial_color) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('dial_color')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Case Diameter -->
                        <div class="space-y-1">
                            <label for="case_diameter" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Case Diameter</label>
                            <input type="text" id="case_diameter" name="case_diameter" value="{{ old('case_diameter', $product->case_diameter) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('case_diameter')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bracelet -->
                        <div class="space-y-1">
                            <label for="bracelet" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Bracelet style</label>
                            <input type="text" id="bracelet" name="bracelet" value="{{ old('bracelet', $product->bracelet) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('bracelet')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Power reserve -->
                        <div class="space-y-1">
                            <label for="power_reserve" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Power Reserve</label>
                            <input type="text" id="power_reserve" name="power_reserve" value="{{ old('power_reserve', $product->power_reserve) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('power_reserve')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Water Resistance -->
                        <div class="space-y-1">
                            <label for="water_resistance" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Water Resistance</label>
                            <input type="text" id="water_resistance" name="water_resistance" value="{{ old('water_resistance', $product->water_resistance) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('water_resistance')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Condition -->
                        <div class="space-y-1">
                            <label for="condition" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Boutique Item Condition</label>
                            <select id="condition" name="condition" required
                                    class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                                <option value="Pristine / Unworn" {{ old('condition', $product->condition) == 'Pristine / Unworn' ? 'selected' : '' }}>Pristine / Unworn</option>
                                <option value="Excellent / Pre-owned" {{ old('condition', $product->condition) == 'Excellent / Pre-owned' ? 'selected' : '' }}>Excellent / Pre-owned</option>
                                <option value="Vintage / Heirloom" {{ old('condition', $product->condition) == 'Vintage / Heirloom' ? 'selected' : '' }}>Vintage / Heirloom</option>
                            </select>
                            @error('condition')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Text details -->
                <div class="space-y-6">
                    <h3 class="font-serif text-md text-white font-semibold border-b border-white/5 pb-3">3. Story & Description</h3>
                    
                    <div class="space-y-1">
                        <label for="description" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Timepiece Legacy Story</label>
                        <textarea id="description" name="description" rows="5" required
                                  class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form submissions buttons -->
                <div class="pt-6 border-t border-white/5 flex gap-4">
                    <button type="submit" class="flex-grow bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs tracking-widest uppercase py-3.5 rounded transition duration-200 shadow">
                        Update Product Record
                    </button>
                    <a href="{{ route('products.index') }}" class="w-1/4 text-center border border-white/10 hover:border-red-400 text-zinc-400 hover:text-red-400 font-semibold text-xs tracking-widest uppercase py-3.5 rounded transition duration-200">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </section>

</x-main-layout>
