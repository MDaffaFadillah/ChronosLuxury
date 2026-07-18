<x-main-layout>
    <x-slot name="title">Your Boutique Cart — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl text-white font-bold tracking-wide">Boutique Shopping Cart</h1>
                <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">Confirm your selected masterpieces</p>
            </div>
            
            <a href="{{ url('/products') }}" class="text-zinc-400 hover:text-luxury-gold text-xs uppercase tracking-widest transition flex items-center gap-2 mt-4 md:mt-0 font-medium">
                <i class="fa-solid fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </section>

    <!-- Cart Main Content -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($cartItems->isEmpty())
                <div class="text-center py-24 bg-zinc-950 rounded-lg border border-white/5">
                    <i class="fa-solid fa-bag-shopping text-4xl text-luxury-gold mb-4"></i>
                    <h2 class="font-serif text-xl text-white font-semibold">Your Cart is Empty</h2>
                    <p class="text-zinc-500 text-xs mt-2 max-w-sm mx-auto">You have not added any luxury timepieces to your boutique cart yet. Explore our catalog to find your collection.</p>
                    <a href="{{ url('/products') }}" class="inline-block mt-8 bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3.5 px-8 rounded transition duration-300">
                        Explore Masterpieces
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- CART ITEMS LIST (col-span-8) -->
                    <div class="lg:col-span-8 space-y-6">
                        @foreach ($cartItems as $item)
                            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex flex-col sm:flex-row items-center justify-between gap-6 hover:border-luxury-gold/50 transition duration-300">
                                
                                <!-- Product Img + Name -->
                                <div class="flex items-center gap-6 w-full sm:w-auto">
                                    <div class="bg-white rounded p-3 w-20 h-20 flex items-center justify-center shrink-0 shadow relative">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="h-16 w-auto object-contain drop-shadow-sm">
                                    </div>
                                    <div>
                                        <a href="{{ url('/products/' . $item->product->slug) }}" class="text-white hover:text-luxury-gold font-semibold text-sm transition">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-[10px] text-zinc-500 uppercase tracking-widest mt-1">Ref: {{ $item->product->reference_number }} — {{ $item->product->category->name }}</p>
                                        <p class="text-xs text-luxury-gold mt-2 font-medium">IDR {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Qty Update & Remove Action -->
                                <div class="flex items-center justify-between sm:justify-end gap-8 w-full sm:w-auto border-t sm:border-t-0 pt-4 sm:pt-0">
                                    
                                    <!-- Qty Control Form -->
                                    <form action="{{ url('/cart/' . $item->id) }}" method="POST" class="flex items-center border border-white/10 rounded bg-zinc-900 px-2 py-1 w-24">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                               onchange="this.form.submit()"
                                               class="bg-transparent border-0 text-center text-xs font-bold text-white w-full p-0 focus:ring-0 focus:outline-none cursor-pointer" 
                                               title="Change Quantity">
                                    </form>

                                    <!-- Price Subtotal -->
                                    <div class="text-right">
                                        <p class="text-xs text-zinc-500 uppercase tracking-widest">Subtotal</p>
                                        <p class="text-xs font-semibold text-white mt-1">IDR {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Delete Item Form -->
                                    <form action="{{ url('/cart/' . $item->id) }}" method="POST" onsubmit="return confirm('Remove {{ $item->product->name }} from cart?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-zinc-650 hover:text-red-400 transition" title="Remove timepiece">
                                            <i class="fa-regular fa-trash-can text-md"></i>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        @endforeach
                    </div>

                    <!-- CART SUMMARY CARD (col-span-4) -->
                    <div class="lg:col-span-4 bg-zinc-950 border border-white/5 rounded-lg p-6 space-y-6">
                        <h3 class="font-serif text-lg text-white font-semibold pb-3 border-b border-white/5 tracking-wide">Order Summary</h3>
                        
                        <div class="space-y-3 text-xs text-zinc-400">
                            <div class="flex justify-between">
                                <span>Cart Subtotal</span>
                                <span class="text-white font-medium">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping Fee</span>
                                <span class="text-emerald-400 font-semibold uppercase tracking-wider">Complimentary</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Boutique Insurance</span>
                                <span class="text-emerald-400 font-semibold uppercase tracking-wider text-right">Complimentary</span>
                            </div>
                        </div>

                        <hr class="border-white/5">

                        <div class="flex justify-between text-sm">
                            <span class="text-white font-medium">Estimated Total</span>
                            <span class="text-luxury-gold font-bold font-serif text-md">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-4 space-y-4">
                            <a href="{{ url('/checkout') }}" class="w-full block text-center bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3.5 rounded transition duration-300 shadow">
                                Proceed to Checkout
                            </a>
                            <p class="text-[9px] text-zinc-600 text-center leading-relaxed">
                                Purchases are secure. Insured delivery via FedEx Private Armored Service (domestic).
                            </p>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </section>

</x-main-layout>
