<x-main-layout>
    <x-slot name="title">Edit Category — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Edit Category</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Refine Collection Division</p>
            </div>
            
            <a href="{{ route('categories.index') }}" class="text-zinc-400 hover:text-white text-xs uppercase tracking-widest transition flex items-center gap-2 font-medium">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back to List
            </a>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-2">
                        <label for="name" class="text-xs uppercase tracking-wider text-zinc-400 font-semibold">Category Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                               class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                        @error('name')
                            <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="submit" class="flex-grow bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200 shadow">
                            Update Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="w-1/3 text-center border border-white/10 hover:border-red-400 text-zinc-405 hover:text-red-400 font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200">
                            Cancel
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </section>

</x-main-layout>
