<x-main-layout>
    <x-slot name="title">Manage Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — Admin Hub</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Manage Order Invoice</h1>
                <p class="text-xs text-zinc-500 mt-1 uppercase tracking-widest font-mono">Reference: #ORD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            
            <a href="{{ route('admin.orders.index') }}" class="text-zinc-400 hover:text-white text-xs uppercase tracking-widest transition flex items-center gap-2 font-medium">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Back to List
            </a>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8">
                
                <!-- Main Invoice Detail Card & Action Update -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-8 shadow-xl">
                    
                    <!-- State Adjustment Form -->
                    <div class="border border-white/5 rounded-lg p-6 bg-neutral-900 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <span class="text-zinc-500 text-[10px] uppercase tracking-widest block mb-1">State Administration</span>
                            <h3 class="text-white text-sm font-semibold">Active Status: <span class="capitalize text-luxury-gold">{{ $order->status }}</span></h3>
                            <p class="text-zinc-500 text-[11px] mt-1">Status changes will adjust client history and inventory states securely.</p>
                        </div>

                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" class="flex items-center gap-3 w-full md:w-auto">
                            @csrf
                            @method('PATCH')
                            
                            <select name="status" class="bg-zinc-955 border border-white/10 text-xs text-zinc-300 rounded px-3 py-2 focus:outline-none focus:border-luxury-gold focus:ring-0 w-full md:w-40">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>

                            <button type="submit" class="bg-luxury-gold hover:bg-luxury-goldLight text-black text-xs font-semibold px-4 py-2 rounded transition tracking-wide text-center shrink-0">
                                Apply Status
                            </button>
                        </form>
                    </div>

                    <!-- Client Profile Information -->
                    <div class="bg-zinc-900 border border-white/5 rounded-lg p-4 text-xs space-y-2">
                        <h4 class="text-luxury-gold uppercase tracking-wider font-semibold mb-2">Registered client profile</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-zinc-500">Register name:</span>
                                <p class="text-white font-medium mt-0.5">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <span class="text-zinc-550">Registered Email Address:</span>
                                <p class="text-white font-medium mt-0.5 font-mono">{{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice metadata split detail layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4 border-y border-white/5 text-xs">
                        <!-- Column 1: Client Delivery Target -->
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-luxury-gold uppercase tracking-wider font-semibold mb-2">Armored Delivery Destination</h4>
                                <p class="text-white font-semibold">{{ $order->shipping_name }}</p>
                                <p class="text-zinc-400 font-light mt-1.5 leading-relaxed">{{ $order->shipping_address }}</p>
                            </div>

                            @if ($order->notes)
                                <div>
                                    <h4 class="text-zinc-500 uppercase tracking-wider font-semibold mb-1">Customer instructions</h4>
                                    <p class="text-zinc-400 font-light italic">"{{ $order->notes }}"</p>
                                </div>
                            @endif
                        </div>

                        <!-- Column 2: Financial pricing & dates metadata -->
                        <div class="space-y-3 text-zinc-400">
                            <h4 class="text-luxury-gold uppercase tracking-wider font-semibold mb-2">Transaction specs</h4>
                            <div class="flex justify-between">
                                <span>Booking Timestamp</span>
                                <span class="text-white font-medium">{{ $order->created_at->format('Y-m-d H:i:s') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Transit Protection</span>
                                <span class="text-emerald-400 uppercase font-semibold tracking-wider">Fully Insured</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-white/5 text-sm">
                                <span class="text-white font-semibold">Total Invoice Amount</span>
                                <span class="text-luxury-gold font-serif font-bold text-md">IDR {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items bought -->
                    <div>
                        <h3 class="font-serif text-lg text-white font-bold tracking-wide border-b border-white/5 pb-3 mb-6">List Secured Masterpieces</h3>
                        
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between text-xs py-4 border-b border-white/5">
                                    <div class="flex items-center gap-4">
                                        <div class="bg-white rounded p-1.5 w-12 h-12 flex items-center justify-center shrink-0">
                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="h-10 w-auto object-contain">
                                        </div>
                                        <div>
                                            <h4 class="text-white font-semibold text-sm">{{ $item->product->name }}</h4>
                                            <p class="text-[10px] text-zinc-550 uppercase tracking-wider mt-1">Model Ref: {{ $item->product->reference_number }} — {{ $item->product->category->name }}</p>
                                            <p class="text-[10px] text-zinc-500 mt-0.5">Quantity: {{ $item->quantity }} x IDR {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-white font-mono font-medium">IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

</x-main-layout>
