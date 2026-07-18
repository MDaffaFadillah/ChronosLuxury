<x-main-layout>
    <x-slot name="title">Manage Orders — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Customer Bookings</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Private Client Transactions</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-4">
                <nav class="flex space-x-6 text-xs tracking-wider uppercase font-medium mr-4">
                    <a href="{{ url('/admin/dashboard') }}" class="text-zinc-400 hover:text-white transition">Dashboard</a>
                    <a href="{{ url('/admin/categories') }}" class="text-zinc-400 hover:text-white transition">Categories</a>
                    <a href="{{ url('/admin/products') }}" class="text-zinc-400 hover:text-white transition">Products</a>
                    <a href="{{ url('/admin/orders') }}" class="text-luxury-gold font-bold">Orders</a>
                </nav>
            </div>
        </div>
    </section>

    <!-- List Section -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8 space-y-6">
                
                <!-- Quick Filter status buttons -->
                <div class="flex flex-wrap gap-2 pb-2 border-b border-white/5">
                    <a href="{{ url('/admin/orders') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ !request('status') ? 'bg-luxury-gold text-black' : 'bg-zinc-900 text-zinc-400 hover:text-white' }}">
                        All Orders
                    </a>
                    <a href="{{ url('/admin/orders?status=pending') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ request('status') === 'pending' ? 'bg-amber-500 text-black' : 'bg-zinc-900 text-zinc-400 hover:text-amber-500' }}">
                        Pending
                    </a>
                    <a href="{{ url('/admin/orders?status=processing') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ request('status') === 'processing' ? 'bg-blue-500 text-black' : 'bg-zinc-900 text-zinc-400 hover:text-blue-400' }}">
                        Processing
                    </a>
                    <a href="{{ url('/admin/orders?status=shipped') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ request('status') === 'shipped' ? 'bg-purple-500 text-black' : 'bg-zinc-900 text-zinc-400 hover:text-purple-400' }}">
                        Shipped
                    </a>
                    <a href="{{ url('/admin/orders?status=completed') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ request('status') === 'completed' ? 'bg-emerald-500 text-black' : 'bg-zinc-900 text-zinc-400 hover:text-emerald-400' }}">
                        Completed
                    </a>
                    <a href="{{ url('/admin/orders?status=cancelled') }}" class="text-[10px] uppercase font-bold tracking-widest px-3 py-1.5 rounded transition {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-zinc-900 text-zinc-400 hover:text-red-400' }}">
                        Cancelled
                    </a>
                </div>

                @if ($orders->isEmpty())
                    <div class="text-center py-16 text-zinc-550 text-xs">
                        No transactions registered under this filter.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-zinc-400">
                            <thead>
                                <tr class="text-zinc-500 uppercase tracking-wider border-b border-white/5 pb-4">
                                    <th class="py-3 font-semibold pb-4">Order ID</th>
                                    <th class="py-3 font-semibold pb-4">Recipient Name</th>
                                    <th class="py-3 font-semibold pb-4">Placed Date</th>
                                    <th class="py-3 font-semibold pb-4">Total Price</th>
                                    <th class="py-3 font-semibold pb-4">Status</th>
                                    <th class="py-3 font-semibold pb-4 text-right">Invoice</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($orders as $order)
                                    <tr>
                                        <!-- ID -->
                                        <td class="py-4 font-mono font-medium text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        
                                        <!-- Shipping name -->
                                        <td class="py-4 font-medium text-white">
                                            {{ $order->shipping_name }}
                                            <span class="text-[10px] text-zinc-500 block font-normal">{{ $order->user->name }} ({{ $order->user->email }})</span>
                                        </td>
                                        
                                        <!-- Booking Date -->
                                        <td class="py-4 text-zinc-450">{{ $order->created_at->format('M d, Y H:i px') }}</td>
                                        
                                        <!-- Price -->
                                        <td class="py-4 font-semibold text-white">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        
                                        <!-- Status tag wrapper -->
                                        <td class="py-4">
                                            @if ($order->status === 'pending')
                                                <span class="text-[9px] uppercase font-bold tracking-wider text-amber-505 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">Pending</span>
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

                                        <!-- Invoice link -->
                                        <td class="py-4 text-right">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-luxury-gold hover:text-white transition font-medium">
                                                Manage invoice <i class="fa-solid fa-chevron-right ml-1 text-[9px]"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination links -->
                    <div class="pt-6 border-t border-white/5">
                        {{ $orders->links('partials.pagination') }}
                    </div>
                @endif

            </div>
        </div>
    </section>

</x-main-layout>
