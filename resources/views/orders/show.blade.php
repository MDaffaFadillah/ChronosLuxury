<x-main-layout>
    <x-slot name="title">Order Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Order Receipt</h1>
                <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">Reference: #ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            
            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="{{ url('/orders') }}" class="text-zinc-400 hover:text-white text-xs uppercase tracking-widest transition flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-chevron-left text-[10px]"></i> Order History
                </a>
            </div>
        </div>
    </section>

    <!-- Detailed Invoice View -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-8 shadow-xl">
                
                <!-- Order Status Tracker Banner -->
                <div class="border border-white/5 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6 bg-neutral-900">
                    <div class="text-center md:text-left">
                        <span class="text-zinc-500 text-[10px] uppercase tracking-widest block mb-1">Transit Tracker</span>
                        
                        @if ($order->status === 'pending')
                            <h3 class="text-amber-500 font-serif text-lg font-bold">Awaiting Boutique Verification</h3>
                            <p class="text-zinc-400 text-xs mt-1">Our boutique curators are verifying stock allocations.</p>
                        @elseif ($order->status === 'processing')
                            <h3 class="text-blue-400 font-serif text-lg font-bold">Preparation & Insurance Booking</h3>
                            <p class="text-zinc-400 text-xs mt-1">Timepiece is being calibrated and packaged into armored steel box.</p>
                        @elseif ($order->status === 'shipped')
                            <h3 class="text-purple-400 font-serif text-lg font-bold">In Armored Secure Transit</h3>
                            <p class="text-zinc-400 text-xs mt-1">Your package has departed with private secure transit courier.</p>
                        @elseif ($order->status === 'completed')
                            <h3 class="text-emerald-400 font-serif text-lg font-bold">Masterpiece Handed Over</h3>
                            <p class="text-zinc-400 text-xs mt-1">The package has been verified, signed, and received successfully.</p>
                        @else
                            <h3 class="text-red-500 font-serif text-lg font-bold">Order Cancelled</h3>
                            <p class="text-zinc-400 text-xs mt-1">This order booking has been cancelled and stock released.</p>
                        @endif
                    </div>

                    <div class="shrink-0">
                        @if ($order->status === 'pending')
                            <span class="text-xs uppercase font-bold tracking-widest text-amber-500 bg-amber-500/10 px-4 py-2 rounded border border-amber-500/30">Pending Verification</span>
                        @elseif ($order->status === 'processing')
                            <span class="text-xs uppercase font-bold tracking-widest text-blue-400 bg-blue-400/10 px-4 py-2 rounded border border-blue-400/30">Processing Setup</span>
                        @elseif ($order->status === 'shipped')
                            <span class="text-xs uppercase font-bold tracking-widest text-purple-400 bg-purple-400/10 px-4 py-2 rounded border border-purple-400/30">Shipped Out</span>
                        @elseif ($order->status === 'completed')
                            <span class="text-xs uppercase font-bold tracking-widest text-emerald-400 bg-emerald-400/10 px-4 py-2 rounded border border-emerald-400/30">Completed</span>
                        @else
                            <span class="text-xs uppercase font-bold tracking-widest text-red-500 bg-red-500/10 px-4 py-2 rounded border border-red-500/30">Cancelled</span>
                        @endif
                    </div>
                </div>

                <!-- Invoice split Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4 border-y border-white/5 text-xs">
                    <!-- Column 1: Client & Recipient Information -->
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-luxury-gold uppercase tracking-wider font-semibold mb-2">Transit Destination Address</h4>
                            <p class="text-white font-medium">{{ $order->shipping_name }}</p>
                            <p class="text-zinc-400 font-light mt-1.5 leading-relaxed">{{ $order->shipping_address }}</p>
                        </div>

                        @if ($order->notes)
                            <div>
                                <h4 class="text-zinc-500 uppercase tracking-wider font-semibold mb-1">Customer Transit Instruction</h4>
                                <p class="text-zinc-400 font-light italic">"{{ $order->notes }}"</p>
                            </div>
                        @endif
                    </div>

                    <!-- Column 2: Order Metadata details -->
                    <div class="space-y-2 text-zinc-400">
                        <h4 class="text-luxury-gold uppercase tracking-wider font-semibold mb-3">Order Information</h4>
                        <div class="flex justify-between">
                            <span>Placed Date</span>
                            <span class="text-white font-medium">{{ $order->created_at->format('F d, Y H:i O') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Payment Method</span>
                            <span class="text-white font-medium">Boutique Bank Transfer (Manual)</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Private Courier Insurance</span>
                            <span class="text-emerald-400 font-semibold tracking-wider uppercase">Pre-Paid (Complimentary)</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-white/5 text-sm">
                            <span class="text-white font-semibold">Total Amount</span>
                            <span class="text-luxury-gold font-serif font-bold text-md">IDR {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Items breakdown list -->
                <div>
                    <h3 class="font-serif text-lg text-white font-semibold tracking-wide border-b border-white/5 pb-3 mb-6">Secured Masterpieces list</h3>
                    
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center justify-between text-xs py-4 border-b border-white/5">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white rounded p-1.5 w-12 h-12 flex items-center justify-center shrink-0">
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="h-10 w-auto object-contain">
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">{{ $item->product->name }}</h4>
                                        <p class="text-[10px] text-zinc-500 uppercase tracking-wider mt-1">Ref: {{ $item->product->reference_number }} — {{ $item->product->category->name }}</p>
                                        <p class="text-[10px] text-zinc-500 mt-0.5">Quantity: {{ $item->quantity }} x IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="text-white font-mono font-medium">IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Print or Help actions -->
                <div class="pt-4 text-center text-[10px] text-zinc-600 leading-relaxed font-light">
                    For verification adjustments or routing inquiries, contact Chronos Private Client Desk on (+62) 21-8888-9999 or <span class="text-luxury-gold">concierge@chronosluxury.com</span>. Give order number as reference.
                </div>

            </div>
        </div>
    </section>

</x-main-layout>
