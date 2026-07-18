<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'ChronosLuxury — Official Luxury Boutique' }}</title>

    <!-- Google Fonts: Playfair Display (Serif) & Poppins (Sans-serif) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- AlpineJS for Interactive components -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN with configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            bg: '#121212',
                            gold: '#D4AF37',
                            goldDark: '#B3922E',
                            goldLight: '#E5C453',
                            navy: '#0B1325',
                            cardBg: '#1C1C1C',
                            textLight: '#E5E5E5',
                            textMuted: '#A3A3A3',
                            lightGray: '#F5F5F7',
                            darkGray: '#18181A'
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body {
            background-color: #121212;
            color: #E5E5E5;
        }
        .luxury-gradient {
            background: linear-gradient(135deg, #1C1C1C 0%, #121212 100%);
        }
        .gold-border-glow:hover {
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
            border-color: #D4AF37;
        }
    </style>
</head>
<body class="font-sans antialiased flex flex-col min-h-screen selection:bg-luxury-gold selection:text-black">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-luxury-bg/95 backdrop-blur-md border-b border-white/5" x-data="{ openMob: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand Name -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/images/icon-logo-rolexnya.png') }}" alt="ChronosLogo" class="h-10 w-auto filter brightness-110">
                        <div class="flex flex-col">
                            <span class="font-serif text-lg tracking-[0.25em] text-luxury-gold font-bold leading-none">CHRONOS</span>
                            <span class="text-[9px] tracking-[0.4em] text-white font-light uppercase leading-none mt-1">LUXURY</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Menu Desktop -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-sm tracking-widest uppercase hover:text-luxury-gold transition duration-300 {{ Request::is('/') ? 'text-luxury-gold font-medium' : 'text-zinc-400' }}">Home</a>
                    <a href="{{ url('/products') }}" class="text-sm tracking-widest uppercase hover:text-luxury-gold transition duration-300 {{ Request::is('products*') ? 'text-luxury-gold font-medium' : 'text-zinc-400' }}">Shop</a>
                    <a href="{{ route('about') }}" class="text-sm tracking-widest uppercase hover:text-luxury-gold transition duration-300 {{ Request::routeIs('about') ? 'text-luxury-gold font-medium' : 'text-zinc-400' }}">About</a>
                    <a href="{{ route('contact') }}" class="text-sm tracking-widest uppercase hover:text-luxury-gold transition duration-300 {{ Request::routeIs('contact') ? 'text-luxury-gold font-medium' : 'text-zinc-400' }}">Contact</a>
                </nav>

                <!-- Right Header Actions (Search, Cart, User Auth) -->
                <div class="hidden md:flex items-center space-x-6">
                    <!-- Search Bar -->
                    <form action="{{ url('/products') }}" method="GET" class="relative">
                        <i class="fa-regular fa-clock text-zinc-500 absolute left-3.5 top-1/2 -translate-y-1/2 text-[10px]"></i>
                        <input type="text" name="search" placeholder="Search timepiece..." 
                               value="{{ request('search') }}"
                               class="bg-zinc-900/80 border border-white/10 rounded-full py-1.5 pl-9 pr-10 text-xs w-48 text-zinc-300 placeholder-zinc-500 focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold/30 transition duration-300">
                        <button type="submit" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-luxury-gold transition">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>

                    <!-- Cart Link -->
                    <a href="{{ url('/cart') }}" class="relative text-zinc-400 hover:text-luxury-gold transition duration-350">
                        <i class="fa-solid fa-bag-shopping text-lg"></i>
                        @php
                            $cartCount = 0;
                            if (auth()->check()) {
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            }
                        @endphp
                        @if ($cartCount > 0)
                            <span class="absolute -top-1.5 -right-2 bg-luxury-gold text-black font-semibold text-[10px] w-4.5 h-4.5 flex items-center justify-center rounded-full ring-2 ring-luxury-bg">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Account / Dashboard Dropdown -->
                    @auth
                        <div class="relative" x-data="{ openUser: false }">
                            <button @click="openUser = !openUser" @click.outside="openUser = false" class="flex items-center gap-2 text-zinc-400 hover:text-luxury-gold transition focus:outline-none">
                                <i class="fa-solid fa-user-circle text-lg"></i>
                                <span class="text-xs tracking-wider max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[9px] transition" :class="openUser ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="openUser" x-cloak x-transition.origin.top.right 
                                 class="absolute right-0 mt-3 w-48 bg-zinc-900 border border-white/10 rounded-md shadow-xl py-1 z-50">
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-xs text-zinc-300 hover:bg-neutral-800 hover:text-luxury-gold transition">
                                        <i class="fa-solid fa-gauge mr-2"></i> Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-xs text-zinc-300 hover:bg-neutral-800 hover:text-luxury-gold transition">
                                        <i class="fa-solid fa-table-columns mr-2"></i> Customer Area
                                    </a>
                                @endif
                                <a href="{{ url('/orders') }}" class="block px-4 py-2 text-xs text-zinc-300 hover:bg-neutral-800 hover:text-luxury-gold transition">
                                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> My Orders
                                </a>
                                <a href="{{ url('/profile') }}" class="block px-4 py-2 text-xs text-zinc-300 hover:bg-neutral-800 hover:text-luxury-gold transition">
                                    <i class="fa-solid fa-user-gear mr-2"></i> Settings
                                </a>
                                <hr class="border-white/5 my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-red-400 hover:bg-neutral-800 hover:text-red-300 transition">
                                        <i class="fa-solid fa-sign-out-alt mr-2"></i> Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-xs uppercase tracking-widest text-zinc-300 hover:text-luxury-gold border border-white/20 hover:border-luxury-gold px-4 py-2 rounded transition duration-300">
                            Log In
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center gap-4">
                    <a href="{{ url('/cart') }}" class="relative text-zinc-400 hover:text-luxury-gold transition">
                        <i class="fa-solid fa-bag-shopping text-lg"></i>
                        @if (isset($cartCount) && $cartCount > 0)
                            <span class="absolute -top-1.5 -right-2 bg-luxury-gold text-black font-semibold text-[9px] w-4.5 h-4.5 flex items-center justify-center rounded-full ring-2 ring-luxury-bg">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    
                    <button @click="openMob = !openMob" class="text-zinc-400 hover:text-luxury-gold focus:outline-none">
                        <i class="fa-solid text-xl" :class="openMob ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="openMob" x-cloak x-transition class="md:hidden bg-zinc-950/95 border-b border-white/10 px-4 pt-2 pb-6 space-y-3">
            <nav class="flex flex-col space-y-3 font-medium">
                <a href="{{ url('/') }}" class="text-sm tracking-wider uppercase text-zinc-300 hover:text-luxury-gold">Home</a>
                <a href="{{ url('/products') }}" class="text-sm tracking-wider uppercase text-zinc-300 hover:text-luxury-gold">Shop</a>
                <a href="{{ route('about') }}" class="text-sm tracking-wider uppercase {{ Request::routeIs('about') ? 'text-luxury-gold font-medium' : 'text-zinc-300' }} hover:text-luxury-gold">About</a>
                <a href="{{ route('contact') }}" class="text-sm tracking-wider uppercase {{ Request::routeIs('contact') ? 'text-luxury-gold font-medium' : 'text-zinc-300' }} hover:text-luxury-gold">Contact</a>
            </nav>
            <div class="pt-4 border-t border-white/5">
                @auth
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-circle-user text-2xl text-luxury-gold"></i>
                        <div>
                            <p class="text-xs text-white">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-zinc-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="text-xs text-zinc-400 hover:text-luxury-gold"><i class="fa-solid fa-gauge mr-2"></i> Admin Dashboard</a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="text-xs text-zinc-400 hover:text-luxury-gold"><i class="fa-solid fa-table-columns mr-2"></i> Customer Area</a>
                        @endif
                        <a href="{{ url('/orders') }}" class="text-xs text-zinc-400 hover:text-luxury-gold"><i class="fa-solid fa-clock-rotate-left mr-2"></i> My Orders</a>
                        <a href="{{ url('/profile') }}" class="text-xs text-zinc-400 hover:text-luxury-gold"><i class="fa-solid fa-user-gear mr-2"></i> Settings</a>
                        <form method="POST" action="{{ route('logout') }}" class="pt-2">
                            @csrf
                            <button type="submit" class="text-xs text-red-400 hover:text-red-300"><i class="fa-solid fa-sign-out-alt mr-2"></i> Log Out</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block text-center text-xs uppercase tracking-widest text-black bg-luxury-gold font-medium py-2 rounded hover:bg-luxury-goldLight transition duration-300">
                        Log In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        <!-- Display Session Flash Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-950/50 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded relative text-xs flex items-center justify-between" role="alert">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-950/50 border border-red-500/30 text-red-400 px-4 py-3 rounded relative text-xs flex items-center justify-between" role="alert">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </span>
                    <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-200">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-950 border-t border-white/5 py-16 text-zinc-500 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <!-- Branding -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('assets/images/icon-logo-rolexnya.png') }}" alt="ChronosLogo" class="h-8 w-auto filter opacity-80">
                        <span class="font-serif text-md tracking-[0.2em] text-white font-bold">CHRONOS</span>
                    </div>
                    <p class="text-zinc-650 leading-relaxed mb-4">
                        ChronosLuxury is an official luxury timepiece boutique providing the rarest, pristine condition luxury watches for premium collectors.
                    </p>
                </div>
                <!-- Categories Links -->
                <div>
                    <h3 class="text-white font-serif tracking-widest text-[11px] uppercase mb-4">Collections</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/products?category=diver') }}" class="hover:text-luxury-gold transition">Diver Collection</a></li>
                        <li><a href="{{ url('/products?category=dress') }}" class="hover:text-luxury-gold transition">Dress & Elegant</a></li>
                        <li><a href="{{ url('/products?category=chronograph') }}" class="hover:text-luxury-gold transition">Chronograph Series</a></li>
                        <li><a href="{{ url('/products?category=classic') }}" class="hover:text-luxury-gold transition">Classic Heritage</a></li>
                    </ul>
                </div>
                <!-- Support / Info -->
                <div>
                    <h3 class="text-white font-serif tracking-widest text-[11px] uppercase mb-4">Service & Support</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-luxury-gold transition">Boutique Locator</a></li>
                        <li><a href="#" class="hover:text-luxury-gold transition">Watch Care & Servicing</a></li>
                        <li><a href="#" class="hover:text-luxury-gold transition">Warranty & Returns</a></li>
                        <li><a href="#" class="hover:text-luxury-gold transition">Private Appointments</a></li>
                    </ul>
                </div>
                <!-- Newsletter -->
                <div>
                    <h3 class="text-white font-serif tracking-widest text-[11px] uppercase mb-4">Newsletter</h3>
                    <p class="text-zinc-600 leading-relaxed mb-4">Subscribe to receive private updates on new collections and exclusive releases.</p>
                    <form class="relative flex">
                        <div class="relative w-full">
                            <i class="fa-regular fa-envelope text-zinc-500 absolute left-3 top-1/2 -translate-y-1/2 text-xs"></i>
                            <input type="email" placeholder="Your email address" class="bg-zinc-900/80 border border-white/5 pl-9 pr-4 py-2.5 text-xs text-zinc-300 w-full focus:outline-none focus:border-luxury-gold focus:ring-1 focus:ring-luxury-gold/25 rounded-l transition duration-200">
                        </div>
                        <button type="submit" class="bg-luxury-gold text-black font-semibold text-xs tracking-wider px-4 py-2.5 hover:bg-luxury-goldLight transition rounded-r flex items-center justify-center" title="Subscribe">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between text-zinc-600 text-[10px]">
                <p>&copy; {{ date('Y') }} ChronosLuxury Boutique. All rights reserved.</p>
                
                {{-- Social Icons --}}
                <div class="flex items-center gap-3 my-4 md:my-0">
                    <a href="https://instagram.com" target="_blank" class="w-6.5 h-6.5 rounded-full border border-zinc-800/80 flex items-center justify-center text-zinc-500 hover:text-black hover:bg-luxury-gold hover:border-luxury-gold transition duration-300">
                        <i class="fa-brands fa-instagram text-[10px]"></i>
                    </a>
                    <a href="https://wa.me" target="_blank" class="w-6.5 h-6.5 rounded-full border border-zinc-800/80 flex items-center justify-center text-zinc-500 hover:text-black hover:bg-luxury-gold hover:border-luxury-gold transition duration-300">
                        <i class="fa-brands fa-whatsapp text-[10px]"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" class="w-6.5 h-6.5 rounded-full border border-zinc-800/80 flex items-center justify-center text-zinc-500 hover:text-black hover:bg-luxury-gold hover:border-luxury-gold transition duration-300">
                        <i class="fa-brands fa-youtube text-[10px]"></i>
                    </a>
                </div>

                <div class="flex space-x-6">
                    <a href="#" class="hover:text-luxury-gold transition">Privacy Policy</a>
                    <a href="#" class="hover:text-luxury-gold transition">Terms & Conditions</a>
                    <a href="#" class="hover:text-luxury-gold transition">Legal Statement</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
