<x-main-layout>
    <x-slot name="title">Booking Order Success — ChronosLuxury</x-slot>

    <!-- Success section -->
    <section class="py-24 bg-luxury-bg">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-8 sm:p-12 text-center relative overflow-hidden shadow-2xl">
                <!-- Golden decorative badge -->
                <div class="absolute inset-x-0 top-0 h-[3px] bg-luxury-gold"></div>

                <!-- Check icon -->
                <div class="h-16 w-16 bg-luxury-gold/10 border border-luxury-gold/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-circle-check text-luxury-gold text-3xl animate-pulse"></i>
                </div>

                <!-- Messaging success -->
                <span class="text-luxury-gold text-xs tracking-[0.4em] uppercase font-semibold mb-2 block">Order Placed Successfully</span>
                <h1 class="font-serif text-3xl text-white font-bold tracking-wide">Thank You for Your Order</h1>
                <p class="text-zinc-500 text-xs mt-3 max-w-md mx-auto leading-relaxed">
                    Timepiece booking complete. We have successfully locked your items. Our boutique consultants will contact you shortly to arrange secure, armored courier transit.
                </p>

                <!-- Order Receipt details -->
                <div class="mt-10 bg-neutral-900 border border-white/5 rounded-lg p-6 text-left space-y-4">
                    <div class="flex justify-between items-center text-xs pb-3 border-b border-white/5">
                        <span class="text-zinc-500 uppercase tracking-wider">Order Reference</span>
                        <span class="text-white font-mono font-medium">#ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="flex justify-between items-center text-xs pb-3 border-b border-white/5">
                        <span class="text-zinc-500 uppercase tracking-wider">Estimated Delivery To</span>
                        <span class="text-white font-medium text-right">{{ $order->shipping_name }}</span>
                    </div>

                    <div class="text-xs pb-3 border-b border-white/5">
                        <span class="text-zinc-500 uppercase tracking-wider block mb-2">Transit Destination Address</span>
                        <p class="text-white leading-relaxed font-light">{{ $order->shipping_address }}</p>
                    </div>

                    @if ($order->notes)
                        <div class="text-xs pb-3 border-b border-white/5">
                            <span class="text-zinc-500 uppercase tracking-wider block mb-2">Boutique Notes</span>
                            <p class="text-zinc-400 font-light italic">"{{ $order->notes }}"</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center text-xs pt-2">
                        <span class="text-zinc-500 uppercase tracking-wider">Total Amount paid</span>
                        <span class="text-luxury-gold font-serif text-sm font-semibold">IDR {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Product items purchased summary -->
                <div class="mt-8 text-left">
                    <h3 class="text-xs uppercase tracking-widest text-luxury-gold font-semibold mb-4 text-center">Secured Horology</h3>
                    
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between text-xs py-3 border-b border-white/5">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white rounded p-1 w-10 h-10 flex items-center justify-center shrink-0">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="h-8 w-auto object-contain">
                                    </div>
                                    <div>
                                        <h4 class="text-white font-medium">{{ $item->product->name }}</h4>
                                        <p class="text-[9px] text-zinc-500 uppercase tracking-wider mt-0.5">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span class="text-zinc-400 font-mono">IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation link buttons -->
                <div class="mt-12 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3 px-8 rounded transition duration-300 shadow">
                        Go back Home
                    </a>
                    <a href="{{ url('/products') }}" class="border border-white/10 hover:border-luxury-gold text-white font-semibold text-xs uppercase tracking-widest py-3 px-8 rounded transition duration-300">
                        Explore Collection
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-main-layout>
