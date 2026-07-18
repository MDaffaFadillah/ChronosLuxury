<x-main-layout>
    <x-slot name="title">Secure Checkout — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
            <h1 class="font-serif text-3xl text-white font-bold tracking-wide">Secure Boutique Checkout</h1>
            <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">Complete your luxury timepiece order</p>
        </div>
    </section>

    <!-- Main Checkout Section -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ url('/checkout') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                @csrf
                
                <!-- LEFT COLUMN: Delivery Form (col-span-7) -->
                <div class="lg:col-span-7 bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-6">
                    <h2 class="font-serif text-xl text-white font-semibold pb-3 border-b border-white/5 tracking-wide">1. Shipping & Delivery Address</h2>
                    
                    <div class="space-y-4">
                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label for="shipping_name" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Receiver Name</label>
                            <input type="text" id="shipping_name" name="shipping_name" 
                                   value="{{ old('shipping_name', auth()->user()->name) }}" required
                                   class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 focus:outline-none focus:border-luxury-gold focus:ring-0">
                            @error('shipping_name')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="space-y-1">
                            <label for="shipping_address" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Boutique Delivery Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="4" required placeholder="Street name, suite, district, province, postal code..."
                                      class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 placeholder-zinc-650 focus:outline-none focus:border-luxury-gold focus:ring-0">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes Info -->
                        <div class="space-y-1">
                            <label for="notes" class="text-xs uppercase tracking-wider text-zinc-400 font-medium">Private Instruction (Optional)</label>
                            <textarea id="notes" name="notes" rows="2" placeholder="e.g. Please wrap with custom luxury satin ribbon or call before delivery..."
                                      class="w-full bg-zinc-900 border border-white/10 rounded px-3 py-2 text-xs text-zinc-300 placeholder-zinc-650 focus:outline-none focus:border-luxury-gold focus:ring-0">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <div class="flex items-start gap-3 bg-luxury-gold/5 border border-luxury-gold/10 p-4 rounded text-[11px] text-zinc-400 leading-relaxed">
                            <i class="fa-solid fa-shield-halved text-luxury-gold text-lg mt-0.5"></i>
                            <div>
                                <h4 class="text-white font-medium mb-1">Authenticated Transit Protection</h4>
                                Our watches are delivered in secure armored containers. Transit insurance is fully pre-arranged by ChronosLuxury. A signature and government ID proof matching the Receiver Name will be required.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Order Review (col-span-5) -->
                <div class="lg:col-span-5 bg-zinc-950 border border-white/5 rounded-lg p-6 space-y-6">
                    <h2 class="font-serif text-xl text-white font-semibold pb-3 border-b border-white/5 tracking-wide">2. Review Masterpieces</h2>
                    
                    <!-- Selected items list -->
                    <div class="space-y-4 max-h-[250px] overflow-y-auto pr-2 divide-y divide-white/5">
                        @foreach ($cartItems as $index => $item)
                            <div class="flex justify-between items-center text-xs pt-4 {{ $index === 0 ? 'pt-0 border-t-0' : '' }}">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white rounded p-1 w-10 h-10 flex items-center justify-center shrink-0 border border-zinc-100">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="h-8 w-auto object-contain">
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium">{{ $item->product->name }}</h4>
                                        <p class="text-[9px] text-zinc-500 uppercase tracking-wider mt-0.5">Qty: {{ $item->quantity }} x IDR {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="text-white font-mono font-medium text-right">
                                    IDR {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Fine line -->
                    <hr class="border-white/5">

                    <!-- Prices breakdown -->
                    <div class="space-y-3 text-xs text-zinc-400">
                        <div class="flex justify-between">
                            <span>Subtotal amount</span>
                            <span class="text-white font-medium">IDR {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Insured Armored Delivery</span>
                            <span class="text-emerald-400 uppercase font-semibold tracking-wider">Complimentary</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between pt-4 border-t border-white/5 text-sm">
                        <span class="text-white font-medium">Total Amount Due</span>
                        <span class="text-luxury-gold font-bold font-serif text-lg">IDR {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Complete button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3.5 rounded transition duration-300 shadow">
                            Complete Order Booking
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </section>

</x-main-layout>
