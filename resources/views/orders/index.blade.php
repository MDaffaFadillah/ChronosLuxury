<x-main-layout>
    <x-slot name="title">My Timepiece Orders — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl text-white font-bold tracking-wide">My Booking Orders</h1>
                <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">History of your acquisitions</p>
            </div>
            
            <a href="{{ url('/dashboard') }}" class="text-zinc-400 hover:text-luxury-gold text-xs uppercase tracking-widest transition flex items-center gap-2 mt-4 md:mt-0 font-medium">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Client Dashboard
            </a>
        </div>
    </section>

    <!-- Order History Main View -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                
                @if ($orders->isEmpty())
                    <div class="text-center py-20">
                        <i class="fa-solid fa-box-open text-4xl text-zinc-700 mb-4"></i>
                        <h2 class="font-serif text-lg text-white font-semibold">No Orders Placed</h2>
                        <p class="text-zinc-500 text-xs mt-2 max-w-sm mx-auto">You have not placed any boutique watch orders yet. Take your time to discover our handcrafted watches catalog.</p>
                        <a href="{{ url('/products') }}" class="inline-block mt-8 bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest py-3 px-6 rounded transition duration-300">Browse Catalog</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-zinc-400">
                            <thead>
                                <tr class="text-zinc-500 uppercase tracking-widest border-b border-white/5">
                                    <th class="py-3 font-semibold pb-4">Order Reference</th>
                                    <th class="py-3 font-semibold pb-4">Recipient Name</th>
                                    <th class="py-3 font-semibold pb-4">Booking Date</th>
                                    <th class="py-3 font-semibold pb-4">Total Price</th>
                                    <th class="py-3 font-semibold pb-4">Delivery Status</th>
                                    <th class="py-3 font-semibold pb-4 text-right">Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="py-4 font-mono font-medium text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="py-4 text-white font-medium">{{ $order->shipping_name }}</td>
                                        <td class="py-4">{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        <td class="py-4 text-white font-medium">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="py-4">
                                            @if ($order->status === 'pending')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-amber-500 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">Pending</span>
                                            @elseif ($order->status === 'processing')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-blue-400 bg-blue-400/10 px-2 py-0.5 rounded border border-blue-400/20">Processing</span>
                                            @elseif ($order->status === 'shipped')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-purple-400 bg-purple-400/10 px-2 py-0.5 rounded border border-purple-400/20">Shipped</span>
                                            @elseif ($order->status === 'completed')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-emerald-400 bg-emerald-400/10 px-2 py-0.5 rounded border border-emerald-400/20">Completed</span>
                                            @else
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-red-400 bg-red-400/10 px-2 py-0.5 rounded border border-red-400/20">Cancelled</span>
                                            @endif
                                        </td>
                                        <td class="py-4 text-right">
                                            <a href="{{ url('/orders/' . $order->id) }}" class="text-luxury-gold hover:text-white transition font-medium">
                                                View Receipt <i class="fa-solid fa-chevron-right ml-1 text-[9px]"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6 mt-6 border-t border-white/5">
                        {{ $orders->links('partials.pagination') }}
                    </div>
                @endif

            </div>
        </div>
    </section>

</x-main-layout>
