<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ChronosLuxury') }} — Authentication</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        luxury: {
                            bg: '#121212', gold: '#D4AF37', goldLight: '#E5C453',
                            cardBg: '#1C1C1C', textLight: '#E5E5E5', textMuted: '#A3A3A3',
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
        body { background-color: #121212; color: #E5E5E5; }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- Dark Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-zinc-950 via-[#121212] to-neutral-950 z-0"></div>
    <div class="absolute inset-0 opacity-5 z-0" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 50px, rgba(212,175,55,0.3) 50px, rgba(212,175,55,0.3) 51px), repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(212,175,55,0.3) 50px, rgba(212,175,55,0.3) 51px);"></div>

    <!-- Logo top -->
    <div class="absolute top-8 left-1/2 -translate-x-1/2 flex flex-col items-center z-10">
        <a href="{{ url('/') }}" class="flex flex-col items-center gap-1 group">
            <img src="{{ asset('assets/images/icon-logo-rolexnya.png') }}" alt="ChronosLuxury" class="h-10 w-auto filter brightness-110 group-hover:brightness-125 transition duration-300">
            <span class="font-serif text-sm tracking-[0.4em] text-luxury-gold font-bold uppercase">Chronos<span class="text-white font-light">Luxury</span></span>
        </a>
    </div>

    <!-- Auth Card -->
    <div class="relative z-10 w-full max-w-md px-6 py-10 mt-20">
        <div class="bg-zinc-900/90 backdrop-blur-sm border border-white/10 rounded-lg shadow-2xl px-8 py-10">
            {{ $slot }}
        </div>
        <p class="text-center text-[10px] text-zinc-600 mt-6 tracking-widest uppercase">
            &copy; {{ date('Y') }} ChronosLuxury Boutique. All rights reserved.
        </p>
    </div>

</body>
</html>
