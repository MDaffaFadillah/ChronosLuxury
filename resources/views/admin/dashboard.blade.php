<x-main-layout>
    <x-slot name="title">Admin Control Panel — ChronosLuxury</x-slot>

    <!-- Header Section -->
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Administration Hub</h1>
                <p class="text-xs text-luxury-gold tracking-widest uppercase font-semibold mt-1">Private Boutique Management Panel</p>
            </div>
            
            <!-- Quick Sub Navigation -->
            <nav class="flex space-x-6 mt-4 md:mt-0 text-xs tracking-wider uppercase font-medium">
                <a href="{{ url('/admin/dashboard') }}" class="text-luxury-gold font-bold">Dashboard</a>
                <a href="{{ url('/admin/categories') }}" class="text-zinc-400 hover:text-white transition">Categories</a>
                <a href="{{ url('/admin/products') }}" class="text-zinc-400 hover:text-white transition">Products</a>
                <a href="{{ url('/admin/orders') }}" class="text-zinc-400 hover:text-white transition">Orders</a>
            </nav>
        </div>
    </section>

    <!-- Dashboard Content -->
    <section class="py-12 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Stat cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Stat 1: Total Revenue -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-zinc-500 uppercase tracking-widest block mb-1">Total Revenue</span>
                        <span class="text-lg font-serif text-emerald-400 font-bold">IDR {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-emerald-400">
                        <i class="fa-solid fa-coins text-md"></i>
                    </div>
                </div>

                <!-- Stat 2: Total Orders -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-zinc-500 uppercase tracking-widest block mb-1">Boutique Orders</span>
                        <span class="text-xl font-serif text-white font-bold">{{ $totalOrders }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-luxury-gold">
                        <i class="fa-solid fa-receipt text-md"></i>
                    </div>
                </div>

                <!-- Stat 3: Listed Products -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-zinc-500 uppercase tracking-widest block mb-1">Listed Timepieces Bureau</span>
                        <span class="text-xl font-serif text-white font-bold">{{ $totalProducts }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-blue-400">
                        <i class="fa-solid fa-clock text-md"></i>
                    </div>
                </div>

                <!-- Stat 4: Customers Registered -->
                <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 flex items-center justify-between">
                    <div>
                        <span class="text-[9px] text-zinc-500 uppercase tracking-widest block mb-1">Boutique Clients</span>
                        <span class="text-xl font-serif text-white font-bold">{{ $totalCustomers }}</span>
                    </div>
                    <div class="h-10 w-10 bg-zinc-900 rounded-full flex items-center justify-center text-purple-400">
                        <i class="fa-solid fa-users text-md"></i>
                    </div>
                </div>
            </div>

            <!-- Double Column layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left: Recent bookings -->
                <div class="lg:col-span-8 bg-zinc-950 border border-white/5 rounded-lg p-6">
                    <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-6">
                        <h3 class="font-serif text-md text-white font-semibold">Latest Client Bookings</h3>
                        <a href="{{ url('/admin/orders') }}" class="text-[10px] text-luxury-gold uppercase tracking-widest hover:text-white transition">Manage All Orders</a>
                    </div>

                    @if ($recentOrders->isEmpty())
                        <p class="text-zinc-500 text-xs text-center py-10">No client transactions registered yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-zinc-400">
                                <thead>
                                    <tr class="text-zinc-500 uppercase tracking-wider border-b border-white/5">
                                        <th class="py-2.5 font-semibold">Order</th>
                                        <th class="py-2.5 font-semibold">Client</th>
                                        <th class="py-2.5 font-semibold">Amount</th>
                                        <th class="py-2.5 font-semibold">Status</th>
                                        <th class="py-2.5 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td class="py-3 font-mono text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td class="py-3">
                                                <div class="text-white font-medium">{{ $order->shipping_name }}</div>
                                                <div class="text-[10px] text-zinc-500">{{ $order->user->email }}</div>
                                            </td>
                                            <td class="py-3 text-white font-medium">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="py-3">
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
                                            <td class="py-3 text-right">
                                                <a href="{{ url('/admin/orders/' . $order->id) }}" class="text-luxury-gold hover:text-white transition font-medium">
                                                    Manage <i class="fa-solid fa-chevron-right ml-0.5 text-[9px]"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- Right: Quick actions -->
                <div class="lg:col-span-4 bg-zinc-950 border border-white/5 rounded-lg p-6 space-y-6">
                    <h3 class="font-serif text-md text-white font-semibold border-b border-white/5 pb-3">Quick Actions</h3>
                    
                    <div class="space-y-4">
                        <a href="{{ route('products.create') }}" class="w-full text-center block bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200">
                            <i class="fa-solid fa-plus mr-1"></i> List New Timepiece
                        </a>
                        <a href="{{ route('categories.create') }}" class="w-full text-center block border border-white/10 hover:border-luxury-gold text-white font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200">
                            <i class="fa-solid fa-folder-plus mr-1"></i> Add Category
                        </a>
                    </div>

                    <div class="bg-neutral-900 border border-white/5 rounded p-4 text-[10px] text-zinc-500 leading-relaxed">
                        <i class="fa-solid fa-circle-info text-luxury-gold text-xs block mb-1"></i>
                        Welcome to Chronos Administrative Desk. Ensure all product prices reflect boutique standards of luxury horology. Confirm inventory adjustments promptly to avoid booking stock mismatches.
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-main-layout>
