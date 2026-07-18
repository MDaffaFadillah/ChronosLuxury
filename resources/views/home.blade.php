<x-main-layout>
    <x-slot name="title">ChronosLuxury — Official Luxury Boutique</x-slot>

    {{-- =====================================================================
         GSAP + ScrollTrigger + Custom CSS Animations
    ===================================================================== --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <style>
        /* Hero Video Overlay */
        .hero-video-overlay {
            background: linear-gradient(to bottom,
                rgba(18,18,18,0.45) 0%,
                rgba(18,18,18,0.25) 40%,
                rgba(18,18,18,0.85) 85%,
                rgba(18,18,18,1) 100%
            );
        }

        /* Scroll-triggered fade-up visibility */
        .reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity 0.75s cubic-bezier(0.16, 1, 0.3, 1), transform 0.75s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left {
            opacity: 0; transform: translateX(-40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right {
            opacity: 0; transform: translateX(40px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .reveal-scale {
            opacity: 0; transform: scale(0.92);
            transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1), transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-scale.visible { opacity: 1; transform: scale(1); }

        /* Stagger delay utility */
        .delay-100 { transition-delay: 0.10s; }
        .delay-200 { transition-delay: 0.20s; }
        .delay-300 { transition-delay: 0.30s; }
        .delay-400 { transition-delay: 0.40s; }
        .delay-500 { transition-delay: 0.50s; }

        /* Gold shimmer on text */
        @keyframes goldShimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .text-gold-shimmer {
            background: linear-gradient(90deg, #D4AF37 0%, #F5D97A 40%, #D4AF37 60%, #B3922E 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: goldShimmer 4s linear infinite;
        }

        /* Ticker / marquee */
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .marquee-track { animation: marquee 22s linear infinite; display: flex; align-items: center; width: max-content; }
        .marquee-track:hover { animation-play-state: paused; }

        /* Parallax via GSAP */
        .parallax-slow { will-change: transform; }

        /* Product card micro-interaction */
        .product-card { transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1), box-shadow 0.4s ease; }
        .product-card:hover { transform: translateY(-4px); }
        .product-card-gold-glow:hover {
            box-shadow: 0 16px 36px rgba(212,175,55,0.06), 0 0 0 1px rgba(212,175,55,0.15) !important;
        }
        .product-card:hover .watch-img { transform: scale(1.06) translateY(-4px) rotate(1.5deg); }
        .watch-img { transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1); }

        /* Category card zoom */
        .cat-card .cat-bg { transition: transform 0.7s cubic-bezier(0.23, 1, 0.32, 1); }
        .cat-card:hover .cat-bg { transform: scale(1.08); }
        .cat-card:hover { border-color: rgba(212,175,55,0.6) !important; }

        /* Active nav gold underline animation */
        .gold-line { transition: width 0.3s cubic-bezier(0.23, 1, 0.32, 1); }

        /* Shine Sweep Effect on CTA button */
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.45),
                transparent
            );
            transform: skewX(-20deg);
            transition: 0.75s;
        }
        .btn-shine:hover::before {
            left: 150%;
            transition: 0.75s;
        }

        /* Crown Breathing Animation */
        @keyframes crownBreathe {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.04) rotate(3deg); }
        }
        .crown-breathe {
            animation: crownBreathe 3.5s ease-in-out infinite;
            display: inline-block;
        }

        /* Gear slow rotate */
        @keyframes gearRotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .slow-gear-rotate {
            animation: gearRotate 75s linear infinite;
        }

        /* Hide scrollbars */
        .carousel-hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .carousel-hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Eye Button Hover Animation */
        .hover-eye-btn {
            opacity: 0;
            transform: scale(0.9) translateY(8px);
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .product-card:hover .hover-eye-btn {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    </style>

    {{-- =====================================================================
         SECTION 1: HERO — with Background.webm Video
    ===================================================================== --}}
    <section class="relative h-screen min-h-[600px] overflow-hidden flex items-center justify-center">

        {{-- Video Background --}}
        <video
            id="hero-video"
            class="absolute inset-0 w-full h-full object-cover parallax-slow"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
        >
            <source src="{{ asset('assets/videos/Background.webm') }}" type="video/webm">
            {{-- Fallback: gradient if video not available --}}
        </video>

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 hero-video-overlay z-10"></div>

        {{-- Subtle golden grain / noise --}}
        <div class="absolute inset-0 opacity-[0.03] z-10 pointer-events-none"
             style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22n%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.85%22 numOctaves=%224%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/%3E%3C/svg%3E'); background-size: 200px 200px;">
        </div>

        {{-- Hero Content --}}
        <div class="relative z-20 flex flex-col items-center text-center px-4 max-w-4xl mx-auto">
            <span class="crown-breathe mb-6">
                <img id="hero-crown" src="{{ asset('assets/images/icon-logo-rolexnya.png') }}" alt="ChronosLuxury Crown" class="h-14 w-auto filter brightness-110" style="opacity:0; transform:translateY(-20px)">
            </span>

            <span id="hero-eyebrow" class="text-luxury-gold text-xs tracking-[0.6em] uppercase font-semibold mb-4 block" style="opacity:0; transform:translateY(20px)">
                Welcome to ChronosLuxury
            </span>

            <h1 id="hero-title" class="font-serif text-5xl md:text-7xl text-white font-bold tracking-wide leading-tight mb-6" style="opacity:0; transform:translateY(30px)">
                Elegance is an <span class="text-gold-shimmer italic">Attitude.</span>
            </h1>

            <p id="hero-sub" class="text-zinc-300 text-sm md:text-base max-w-xl font-light leading-relaxed mb-10" style="opacity:0; transform:translateY(20px)">
                Discover our curated heritage of world-renowned luxury timepieces.<br>Crafted with precision, designed for generations.
            </p>

            <div id="hero-btns" class="flex flex-col sm:flex-row gap-4" style="opacity:0; transform:translateY(20px)">
                <a href="{{ url('/products') }}" class="btn-shine bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs uppercase tracking-widest px-10 py-4 rounded transition duration-300 shadow-lg shadow-luxury-gold/20">
                    Explore Collection
                </a>
                <a href="#categories-section" class="border border-white/30 hover:border-luxury-gold text-white font-semibold text-xs uppercase tracking-widest px-10 py-4 rounded transition duration-300 backdrop-blur-sm">
                    Browse Categories
                </a>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-2 opacity-60" id="scroll-indicator">
            <span class="text-[9px] tracking-widest uppercase text-zinc-400">Scroll</span>
            <div class="w-[1px] h-8 bg-luxury-gold" style="animation: scrollPulse 1.8s ease-in-out infinite;"></div>
        </div>
    </section>

    <style>
        @keyframes scrollPulse {
            0%, 100% { opacity: 0.3; transform: scaleY(0.7) translateY(0); }
            50% { opacity: 1; transform: scaleY(1) translateY(4px); }
        }
    </style>

    {{-- =====================================================================
         TICKER / Marquee Brand Strip
    ===================================================================== --}}
    <div class="bg-luxury-gold py-3.5 overflow-hidden border-y border-luxury-gold/40">
        <div class="marquee-track text-black text-[9px] uppercase font-bold tracking-[0.35em]">
            @for ($i = 0; $i < 2; $i++)
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-[10px] text-zinc-950"></i> Authenticated Masterpieces</span>
                <span class="mx-6">✦</span>
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-certificate text-[10px] text-zinc-950"></i> Rolex Certified</span>
                <span class="mx-6">✦</span>
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-crown text-[10px] text-zinc-950"></i> Private Boutique Experience</span>
                <span class="mx-6">✦</span>
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-[10px] text-zinc-950"></i> Fully Insured Delivery</span>
                <span class="mx-6">✦</span>
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-hourglass-half text-[10px] text-zinc-950"></i> Heritage Since 1998</span>
                <span class="mx-6">✦</span>
                <span class="mx-10 flex items-center gap-1.5"><i class="fa-solid fa-gear text-[10px] text-zinc-950"></i> World-Class Horology</span>
                <span class="mx-6">✦</span>
            @endfor
        </div>
    </div>

    {{-- =====================================================================
         SECTION 2: Shop by Category
    ===================================================================== --}}
    <section id="categories-section" class="py-24 bg-luxury-bg border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold">Curated Collections</span>
                <h2 class="font-serif text-3xl md:text-4xl text-white font-semibold tracking-wide mt-3">Shop by Category</h2>
                <div class="h-[1px] w-16 bg-luxury-gold mx-auto mt-5"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 min-h-[600px]">

                {{-- Diver (Left Tall) --}}
                @php $diver = $categories->firstWhere('slug', 'diver'); @endphp
                @if ($diver)
                <div class="lg:col-span-5 cat-card relative overflow-hidden bg-zinc-900 border border-white/5 rounded-lg flex flex-col justify-end p-8 h-[300px] lg:h-auto min-h-[350px] reveal-left cursor-pointer">
                    <div class="absolute inset-0 cat-bg bg-cover bg-center opacity-70"
                         style="background-image: url('{{ asset('assets/images/diver-submariner.png') }}'); background-size: cover;"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                    <div class="relative z-10 text-center flex flex-col items-center">
                        <span class="text-[10px] uppercase tracking-[0.35em] text-luxury-gold mb-3">Ocean & Sport Heritage</span>
                        <a href="{{ url('/products?category=diver') }}"
                           class="bg-white text-zinc-950 text-xs font-bold tracking-widest uppercase py-3 px-8 rounded-full hover:bg-luxury-gold hover:text-black transition duration-300">
                            Diver
                        </a>
                    </div>
                </div>
                @endif

                {{-- Right Column --}}
                <div class="lg:col-span-7 flex flex-col gap-6">

                    {{-- Chronograph (Right Top) --}}
                    @php $chrono = $categories->firstWhere('slug', 'chronograph'); @endphp
                    @if ($chrono)
                    <div class="cat-card relative overflow-hidden bg-zinc-900 border border-white/5 rounded-lg flex flex-col justify-end p-8 h-[250px] reveal-right cursor-pointer">
                        <div class="absolute inset-0 cat-bg bg-cover bg-center opacity-70"
                             style="background-image: url('{{ asset('assets/images/chrono-daytona.png') }}'); background-size: cover; background-position: center 25%;"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                        <div class="relative z-10 text-center flex flex-col items-center">
                            <span class="text-[10px] uppercase tracking-[0.35em] text-luxury-gold mb-3">Race & Precision</span>
                            <a href="{{ url('/products?category=chronograph') }}"
                               class="bg-white text-zinc-950 text-xs font-bold tracking-widest uppercase py-3 px-8 rounded-full hover:bg-luxury-gold hover:text-black transition duration-300">
                                Chronograph
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Dress & Classic (Bottom Row) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow">

                        @php $dress = $categories->firstWhere('slug', 'dress'); @endphp
                        @if ($dress)
                        <div class="cat-card relative overflow-hidden bg-zinc-900 border border-white/5 rounded-lg flex flex-col justify-end p-8 min-h-[220px] reveal cursor-pointer delay-100">
                            <div class="absolute inset-0 cat-bg bg-cover bg-center opacity-70"
                                 style="background-image: url('{{ asset('assets/images/dress-datajust.png') }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                            <div class="relative z-10 text-center flex flex-col items-center">
                                <span class="text-[10px] uppercase tracking-[0.35em] text-luxury-gold mb-3">Timeless Aesthetics</span>
                                <a href="{{ url('/products?category=dress') }}"
                                   class="bg-white text-zinc-950 text-xs font-bold tracking-widest uppercase py-3 px-8 rounded-full hover:bg-luxury-gold hover:text-black transition duration-300">
                                    Dress
                                </a>
                            </div>
                        </div>
                        @endif

                        @php $classic = $categories->firstWhere('slug', 'classic'); @endphp
                        @if ($classic)
                        <div class="cat-card relative overflow-hidden bg-zinc-900 border border-white/5 rounded-lg flex flex-col justify-end p-8 min-h-[220px] reveal cursor-pointer delay-200">
                            <div class="absolute inset-0 cat-bg bg-cover bg-center opacity-70"
                                 style="background-image: url('{{ asset('assets/images/classic-oyster.png') }}');"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                            <div class="relative z-10 text-center flex flex-col items-center">
                                <span class="text-[10px] uppercase tracking-[0.35em] text-luxury-gold mb-3">Heritage Classics</span>
                                <a href="{{ url('/products?category=classic') }}"
                                   class="bg-white text-zinc-950 text-xs font-bold tracking-widest uppercase py-3 px-8 rounded-full hover:bg-luxury-gold hover:text-black transition duration-300">
                                    Classic
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =====================================================================
         SECTION 3: Featured Timepieces
    ===================================================================== --}}
    <section class="py-24 bg-neutral-900 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row items-center justify-between mb-16 reveal">
                <div>
                    <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold">Exquisite Curation</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-white font-semibold tracking-wide mt-3">Featured Timepieces</h2>
                </div>
                <a href="{{ url('/products') }}" class="text-xs uppercase tracking-widest text-luxury-gold hover:text-white transition duration-300 mt-4 md:mt-0 flex items-center gap-2 group">
                    View All Timepieces
                    <i class="fa-solid fa-arrow-right-long transform group-hover:translate-x-1 transition-transform duration-200"></i>
                </a>
            </div>

            {{-- Carousel Slider container --}}
            <div class="relative" x-data="{ 
                 scrollNext() { $refs.slider.scrollBy({ left: 360, behavior: 'smooth' }) },
                 scrollPrev() { $refs.slider.scrollBy({ left: -360, behavior: 'smooth' }) }
            }">
                <!-- Minimal Navigation Controls -->
                <div class="absolute -top-16 right-0 flex gap-2">
                    <button @click="scrollPrev()" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold bg-zinc-950 transition duration-300" title="Previous">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </button>
                    <button @click="scrollNext()" class="w-8 h-8 rounded-full border border-white/10 flex items-center justify-center text-zinc-400 hover:text-luxury-gold hover:border-luxury-gold bg-zinc-950 transition duration-300" title="Next">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>

                <!-- Slider Track -->
                <div x-ref="slider" class="carousel-hide-scrollbar flex gap-6 overflow-x-auto snap-x snap-mandatory py-4" style="scroll-behavior: smooth;">
                    @php
                       // Multiply featured products to at least 8 to offer a rich catalog swipe experience
                       $sliderProducts = collect($featuredProducts);
                       if ($sliderProducts->count() > 0 && $sliderProducts->count() < 8) {
                           $sliderProducts = $sliderProducts->concat($sliderProducts)->concat($sliderProducts)->take(8);
                       }
                    @endphp

                    @foreach ($sliderProducts as $index => $product)
                        @php
                            // Different backgrounds
                            $bgMod = $index % 3;
                            if ($bgMod === 0) {
                                $cardBg = "bg-white text-zinc-900 border-zinc-100/80";
                                $textCol = "text-zinc-900 hover:text-luxury-gold";
                                $subTextCol = "text-zinc-500";
                                $priceCol = "text-zinc-950";
                                $cardShadow = "shadow-lg shadow-black/5";
                            } elseif ($bgMod === 1) {
                                $cardBg = "bg-gradient-to-br from-zinc-50 to-zinc-100/50 text-zinc-900 border-zinc-200/50";
                                $textCol = "text-zinc-900 hover:text-luxury-gold";
                                $subTextCol = "text-zinc-500";
                                $priceCol = "text-zinc-950";
                                $cardShadow = "shadow-lg shadow-black/5";
                            } else {
                                $cardBg = "bg-zinc-950 text-zinc-200 border-white/5";
                                $textCol = "text-white hover:text-luxury-gold";
                                $subTextCol = "text-zinc-450";
                                $priceCol = "text-luxury-gold";
                                $cardShadow = "shadow-2xl shadow-black/20";
                            }

                            // Badges
                            $customBadge = null;
                            if ($index % 4 === 0) {
                                $customBadge = "NEW ARRIVAL";
                            } elseif ($index % 4 === 2) {
                                $customBadge = "LIMITED";
                            }
                        @endphp

                        <div class="product-card product-card-gold-glow {{ $cardBg }} {{ $cardShadow }} shrink-0 w-[290px] sm:w-[360px] rounded-lg p-6 flex items-center justify-between border relative overflow-hidden snap-start transition-all duration-300 group">
                            
                            {{-- Text columns --}}
                            <div class="flex flex-col justify-between h-full z-10 max-w-[55%]">
                                <div>
                                    <div class="text-[9px] uppercase tracking-[0.4em] text-zinc-400 font-semibold mb-3">
                                        {{ $product->category->name ?? 'Collection' }}
                                    </div>
                                    <h3 class="font-sans text-base sm:text-lg font-bold tracking-tight mb-2">
                                        <a href="{{ url('/products/' . $product->slug) }}" class="{{ $textCol }} transition duration-200">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    <p class="{{ $subTextCol }} text-[10px] font-light leading-relaxed mb-6">
                                        Ref: {{ $product->reference_number }} — {{ $product->movement }}
                                    </p>
                                </div>

                                <div>
                                    <div class="{{ $priceCol }} font-bold text-base">IDR {{ number_format($product->price, 0, ',', '.') }}</div>
                                    <span class="text-[9px] uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2 py-1 rounded inline-block mt-2 font-semibold border border-emerald-100">
                                        {{ $product->condition ?? 'Pristine / Unworn' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Image container --}}
                            <div class="relative w-[110px] sm:w-[135px] h-[160px] flex items-center justify-center select-none z-10 shrink-0">
                                <div class="absolute bottom-2 left-1/2 -translate-x-1/2 w-4/5 h-4 bg-black/10 blur-md rounded-full transition-transform duration-500 group-hover:scale-x-110"></div>
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="watch-img h-[130px] w-auto object-contain z-10 drop-shadow-[0_12px_20px_rgba(0,0,0,0.12)]">
                            </div>

                            {{-- Custom badge (NEW ARRIVAL / LIMITED) --}}
                            @if ($customBadge)
                                <div class="absolute top-4 left-4 border border-luxury-gold/50 bg-luxury-gold/5 text-luxury-gold text-[8px] font-bold px-2 py-0.5 rounded tracking-widest uppercase">
                                    {{ $customBadge }}
                                </div>
                            @endif

                            {{-- Gold accent line bottom --}}
                            <div class="absolute bottom-0 left-0 w-full h-[3px] bg-luxury-gold transform scale-x-0 group-hover:scale-x-100 origin-left transition duration-300 cat-line"></div>

                            {{-- Floating eye button --}}
                            <div class="absolute top-4 right-4 hover-eye-btn z-20">
                                <a href="{{ url('/products/' . $product->slug) }}" class="bg-zinc-900 hover:bg-luxury-gold text-white hover:text-black h-8 w-8 rounded-full flex items-center justify-center shadow transition duration-300" title="Quick View">
                                    <i class="fa-regular fa-eye text-xs"></i>
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- =====================================================================
         SECTION 4: Brand Story / Heritage
    ===================================================================== --}}
    <section class="py-28 bg-luxury-bg relative overflow-hidden">
        {{-- Parallax decorative element with rotating gear wrapper --}}
        <div class="absolute -right-24 top-1/2 -translate-y-1/2 w-80 h-80 opacity-5 parallax-slow" id="deco-circle-1">
            <div class="w-full h-full rounded-full border-2 border-dashed border-luxury-gold slow-gear-rotate"></div>
        </div>
        <div class="absolute -left-32 bottom-0 w-96 h-96 opacity-5 parallax-slow" id="deco-circle-2">
            <div class="w-full h-full rounded-full border border-dashed border-luxury-gold slow-gear-rotate"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold reveal">The Chronos Heritage</span>
            <h2 class="font-serif text-3xl md:text-5xl text-white font-semibold tracking-wide mt-4 mb-8 reveal delay-100">
                Pioneering Luxury <span class="text-gold-shimmer">Since 1998</span>
            </h2>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed font-light mb-10 max-w-2xl mx-auto reveal delay-200">
                ChronosLuxury was founded on a simple principle: to connect discerning watch collectors with the world's most storied luxury watches. In our boutique, time is not just measured — it is valued. Every dial, bezel, and movement has been authenticated and polished to immaculate standards.
            </p>

            {{-- Stats Row --}}
            <div class="grid grid-cols-3 gap-8 mt-12 reveal delay-300">
                <div class="text-center flex flex-col items-center">
                    <i class="fa-solid fa-hourglass-start text-luxury-gold/70 text-2xl mb-4"></i>
                    <div class="font-serif text-3xl md:text-4xl text-luxury-gold font-bold" data-count="25">0</div>
                    <div class="text-zinc-500 text-[10px] uppercase tracking-widest mt-2 font-medium">Years of Heritage</div>
                </div>
                <div class="text-center flex flex-col items-center">
                    <i class="fa-solid fa-tags text-luxury-gold/70 text-2xl mb-4"></i>
                    <div class="font-serif text-3xl md:text-4xl text-luxury-gold font-bold" data-count="1200">0</div>
                    <div class="text-zinc-500 text-[10px] uppercase tracking-widest mt-2 font-medium">Timepieces Sold</div>
                </div>
                <div class="text-center flex flex-col items-center">
                    <i class="fa-solid fa-earth-americas text-luxury-gold/70 text-2xl mb-4"></i>
                    <div class="font-serif text-3xl md:text-4xl text-luxury-gold font-bold" data-count="48">0</div>
                    <div class="text-zinc-500 text-[10px] uppercase tracking-widest mt-2 font-medium">Countries Served</div>
                </div>
            </div>

            <div class="flex items-center justify-center gap-4 mt-12 reveal delay-400">
                <span class="h-[1px] w-12 bg-luxury-gold"></span>
                <img src="{{ asset('assets/images/icon-logo-rolexnya.png') }}" alt="ChronosLuxury" class="h-7 w-auto filter opacity-50">
                <span class="h-[1px] w-12 bg-luxury-gold"></span>
            </div>
        </div>
    </section>

    {{-- =====================================================================
         SECTION 5: CTA Strip
    ===================================================================== --}}
    <section class="py-16 bg-zinc-950 border-y border-luxury-gold/20 reveal">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h3 class="font-serif text-2xl md:text-3xl text-white font-semibold tracking-wide mb-4">Ready to Acquire Your Masterpiece?</h3>
            <p class="text-zinc-400 text-xs mb-8 tracking-wider uppercase">Browse our full authenticated catalog of iconic luxury timepieces</p>
            <a href="{{ url('/products') }}" class="inline-block bg-luxury-gold hover:bg-luxury-goldLight text-black font-bold text-xs tracking-widest uppercase px-12 py-4 rounded transition duration-300 shadow-lg shadow-luxury-gold/20">
                Enter the Boutique
            </a>
        </div>
    </section>

    {{-- =====================================================================
         ANIMATION SCRIPTS
    ===================================================================== --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // ─── 1. Hero Entry Animation (GSAP Timeline) ──────────────────────────
        gsap.registerPlugin(ScrollTrigger);

        const heroTL = gsap.timeline({ defaults: { ease: 'power3.out' } });
        heroTL
            .to('#hero-crown',   { opacity: 1, y: 0, duration: 0.9, delay: 0.3 })
            .to('#hero-eyebrow', { opacity: 1, y: 0, duration: 0.7 }, '-=0.5')
            .to('#hero-title',   { opacity: 1, y: 0, duration: 0.9 }, '-=0.5')
            .to('#hero-sub',     { opacity: 1, y: 0, duration: 0.7 }, '-=0.6')
            .to('#hero-btns',    { opacity: 1, y: 0, duration: 0.7 }, '-=0.5');

        // ─── 2. Hero Parallax on Scroll (GSAP ScrollTrigger) ─────────────────
        gsap.to('#hero-video', {
            yPercent: 18,
            ease: 'none',
            scrollTrigger: {
                trigger: 'body',
                start: 'top top',
                end: '30% top',
                scrub: true
            }
        });

        gsap.to('#hero-title', {
            yPercent: -12,
            ease: 'none',
            scrollTrigger: {
                trigger: 'body',
                start: 'top top',
                end: '50% top',
                scrub: true
            }
        });

        gsap.to('#hero-sub', {
            yPercent: -20,
            ease: 'none',
            scrollTrigger: {
                trigger: 'body',
                start: 'top top',
                end: '50% top',
                scrub: true
            }
        });

        // ─── 3. Decorative circle parallax ───────────────────────────────────
        ['#deco-circle-1', '#deco-circle-2'].forEach((el, i) => {
            gsap.to(el, {
                yPercent: i === 0 ? -20 : 15,
                ease: 'none',
                scrollTrigger: { trigger: el, start: 'top bottom', end: 'bottom top', scrub: 1.5 }
            });
        });

        // ─── 4. Scroll-triggered Reveal (IntersectionObserver) ───────────────
        const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(el => observer.observe(el));

        // ─── 5. Product card hover: expose quick-add button ──────────────────
        document.querySelectorAll('.product-card').forEach(card => {
            const btn = card.querySelector('.hover-show');
            const line = card.querySelector('.cat-line');
            card.addEventListener('mouseenter', () => {
                if (btn) btn.style.opacity = '1';
                if (line) line.style.transform = 'scaleX(1)';
            });
            card.addEventListener('mouseleave', () => {
                if (btn) btn.style.opacity = '0';
                if (line) line.style.transform = 'scaleX(0)';
            });
        });

        // ─── 6. Animated Number Counter (Stats Section) ──────────────────────
        const counters = document.querySelectorAll('[data-count]');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseInt(el.dataset.count);
                const suffix = target > 100 ? '+' : '';
                let current = 0;
                const step = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    current = Math.min(current + step, target);
                    el.textContent = current.toLocaleString() + suffix;
                    if (current >= target) clearInterval(timer);
                }, 25);
                counterObserver.unobserve(el);
            });
        }, { threshold: 0.5 });
        counters.forEach(c => counterObserver.observe(c));

        // ─── 7. Scroll indicator fade on scroll ──────────────────────────────
        const scrollInd = document.getElementById('scroll-indicator');
        if (scrollInd) {
            window.addEventListener('scroll', () => {
                scrollInd.style.opacity = window.scrollY > 80 ? '0' : '0.6';
            }, { passive: true });
        }

        // ─── 8. Hero Video: pause when not in viewport (performance) ─────────
        const heroVideo = document.getElementById('hero-video');
        if (heroVideo) {
            const videoObs = new IntersectionObserver(entries => {
                entries[0].isIntersecting ? heroVideo.play() : heroVideo.pause();
            });
            videoObs.observe(heroVideo);
        }
    });
    </script>

</x-main-layout>
