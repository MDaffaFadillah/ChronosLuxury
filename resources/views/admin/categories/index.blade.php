<x-main-layout>
    <x-slot name="title">Manage Categories — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Manage Categories</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Boutique Collections Hierarchy</p>
            </div>
            
            <div class="flex items-center gap-6 mt-4 md:mt-0">
                <nav class="flex space-x-6 text-xs tracking-wider uppercase font-medium mr-4">
                    <a href="{{ url('/admin/dashboard') }}" class="text-zinc-400 hover:text-white transition">Dashboard</a>
                    <a href="{{ url('/admin/categories') }}" class="text-luxury-gold font-bold">Categories</a>
                    <a href="{{ url('/admin/products') }}" class="text-zinc-400 hover:text-white transition">Products</a>
                    <a href="{{ url('/admin/orders') }}" class="text-zinc-400 hover:text-white transition">Orders</a>
                </nav>
                <a href="{{ route('categories.create') }}" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-[10px] tracking-widest uppercase px-4 py-2 rounded transition">
                    <i class="fa-solid fa-plus mr-1"></i> Add Category
                </a>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                
                @if ($categories->isEmpty())
                    <p class="text-zinc-550 text-xs text-center py-10">No categories found in the system database.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-zinc-400">
                            <thead>
                                <tr class="text-zinc-500 uppercase tracking-wider border-b border-white/5 pb-4">
                                    <th class="py-3 font-semibold pb-4">Category ID</th>
                                    <th class="py-3 font-semibold pb-4">Name</th>
                                    <th class="py-3 font-semibold pb-4">Slug</th>
                                    <th class="py-3 font-semibold pb-4 text-center">Listed Watches</th>
                                    <th class="py-3 font-semibold pb-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="py-4 font-mono font-medium text-white">#CAT-{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td class="py-4 text-white font-semibold">{{ $category->name }}</td>
                                        <td class="py-4 font-mono text-zinc-500">{{ $category->slug }}</td>
                                        <td class="py-4 text-center text-white">{{ $category->products_count }}</td>
                                        <td class="py-4 text-right">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('categories.edit', $category->id) }}" class="text-luxury-gold hover:text-white transition" title="Edit category">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" 
                                                      onsubmit="return confirm('Attention: Deleting Category \'{{ $category->name }}\' is destructive. Proceed?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-zinc-600 hover:text-red-400 transition" title="Delete category">
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
                @endif

            </div>
        </div>
    </section>

</x-main-layout>
