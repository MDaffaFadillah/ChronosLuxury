<x-main-layout>
    <x-slot name="title">Customer Area — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-3xl text-white font-bold tracking-wide">Customer Area</h1>
                <p class="text-zinc-500 text-xs mt-2 uppercase tracking-widest font-light">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            
            <div class="flex items-center gap-2 text-xs tracking-wider uppercase text-zinc-500 mt-4 md:mt-0 font-medium">
                <span class="text-luxury-gold"><i class="fa-solid fa-circle-user mr-1.5"></i> Client Account</span>
            </div>
        </div>
    </section>

    <!-- Customer Dashboard Content -->
    <section class="py-16 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistical Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Card 1: Total Orders -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest block mb-1">Timepiece Orders</span>
                        <span class="text-2xl font-serif text-white font-bold">{{ $totalOrders }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-luxury-gold">
                        <i class="fa-solid fa-receipt text-md"></i>
                    </div>
                </div>

                <!-- Card 2: Pending Booking -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest block mb-1">Unprocessed Bookings</span>
                        <span class="text-2xl font-serif text-white font-bold">{{ $pendingOrders }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-amber-500">
                        <i class="fa-solid fa-clock text-md"></i>
                    </div>
                </div>

                <!-- Card 3: Completed Orders -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest block mb-1">Acquired Masterpieces</span>
                        <span class="text-2xl font-serif text-white font-bold">{{ $completedOrders }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-emerald-500">
                        <i class="fa-solid fa-circle-check text-md"></i>
                    </div>
                </div>

                <!-- Card 4: Total Spend -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-zinc-500 uppercase tracking-widest block mb-1">Total Investment</span>
                        <span class="text-lg font-serif text-luxury-gold font-bold">IDR {{ number_format($totalSpend, 0, ',', '.') }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-luxury-gold">
                        <i class="fa-solid fa-wallet text-md"></i>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Section -->
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                <div class="flex items-center justify-between pb-4 border-b border-white/5 mb-6">
                    <h2 class="font-serif text-lg text-white font-semibold tracking-wide">Recent Bookings History</h2>
                    <a href="{{ url('/orders') }}" class="text-xs text-luxury-gold hover:text-white uppercase tracking-widest transition">View All Orders</a>
                </div>

                @if ($recentOrders->isEmpty())
                    <div class="text-center py-16">
                        <i class="fa-solid fa-box-open text-3xl text-zinc-700 mb-3"></i>
                        <h3 class="text-sm text-zinc-400 font-medium">No Bookings Recorded</h3>
                        <p class="text-zinc-600 text-xs mt-1">Explore our exclusive collections to place your first booking.</p>
                        <a href="{{ url('/products') }}" class="inline-block mt-6 bg-zinc-900 hover:bg-luxury-gold text-zinc-300 hover:text-black font-semibold text-xs tracking-widest uppercase py-2.5 px-6 rounded border border-white/10 hover:border-luxury-gold transition duration-300">Browse Catalog</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-zinc-400">
                            <thead>
                                <tr class="text-zinc-500 uppercase tracking-widest border-b border-white/5">
                                    <th class="py-3 font-semibold pb-4">Order ID</th>
                                    <th class="py-3 font-semibold pb-4">Recipient</th>
                                    <th class="py-3 font-semibold pb-4">Booking Date</th>
                                    <th class="py-3 font-semibold pb-4">Total Amount</th>
                                    <th class="py-3 font-semibold pb-4">Status</th>
                                    <th class="py-3 font-semibold pb-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($recentOrders as $order)
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
                                                Manage <i class="fa-solid fa-chevron-right ml-1 text-[9px]"></i>
                                            </a>
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
