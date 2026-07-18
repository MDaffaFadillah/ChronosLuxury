<x-main-layout>
    <x-slot name="title">About ChronosLuxury — Heritage & Story</x-slot>

    {{-- GSAP --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <style>
        .reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.75s cubic-bezier(0.16,1,0.3,1), transform 0.75s cubic-bezier(0.16,1,0.3,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-40px); transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1); }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(40px); transition: opacity 0.8s cubic-bezier(0.16,1,0.3,1), transform 0.8s cubic-bezier(0.16,1,0.3,1); }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }
        .delay-100 { transition-delay: 0.10s; }
        .delay-200 { transition-delay: 0.20s; }
        .delay-300 { transition-delay: 0.30s; }
        .delay-400 { transition-delay: 0.40s; }
        @keyframes goldShimmer { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
        .text-gold-shimmer {
            background: linear-gradient(90deg, #D4AF37 0%, #F5D97A 40%, #D4AF37 60%, #B3922E 100%);
            background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            animation: goldShimmer 4s linear infinite;
        }
        .value-card { transition: transform 0.35s cubic-bezier(0.23,1,0.32,1), box-shadow 0.35s ease, border-color 0.3s; }
        .value-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); border-color: rgba(212,175,55,0.5) !important; }
        .timeline-dot { transition: background-color 0.3s, box-shadow 0.3s; }
        .timeline-item:hover .timeline-dot { background-color: #D4AF37; box-shadow: 0 0 16px rgba(212,175,55,0.5); }
    </style>

    {{-- ── Hero Section ─────────────────────────────────────────────── --}}
    <section class="bg-neutral-900 border-b border-white/5 py-20 md:py-28 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(0deg,transparent,transparent 60px,rgba(212,175,55,0.4) 60px,rgba(212,175,55,0.4) 61px),repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(212,175,55,0.4) 60px,rgba(212,175,55,0.4) 61px);"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="text-luxury-gold text-[10px] tracking-[0.55em] uppercase font-semibold reveal">Our Story</span>
            <h1 class="font-serif text-4xl md:text-6xl text-white font-bold tracking-wide mt-4 reveal delay-100">
                Crafted for the<br><span class="text-gold-shimmer italic">Discerning Few</span>
            </h1>
            <div class="h-px w-16 bg-luxury-gold mx-auto mt-6 reveal delay-200"></div>
            <p class="text-zinc-400 text-sm md:text-base leading-relaxed max-w-2xl mx-auto mt-8 font-light reveal delay-300">
                ChronosLuxury is more than a boutique — it is a sanctuary for collectors who understand that a timepiece is not merely an instrument, but a statement of who you are.
            </p>
        </div>
    </section>

    {{-- ── Brand Story Split ─────────────────────────────────────────── --}}
    <section class="py-24 bg-luxury-bg border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- Text Side --}}
                <div class="reveal-left">
                    <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold">Founded 1998</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-white font-semibold tracking-wide mt-4 mb-6">A Heritage Built on Trust & Precision</h2>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-5 font-light">
                        Born in the heart of Jakarta, ChronosLuxury was established by a group of passionate horologists who believed the Indonesian market deserved access to the world's finest certified luxury timepieces — without compromise.
                    </p>
                    <p class="text-zinc-400 text-sm leading-relaxed mb-5 font-light">
                        Every watch in our catalog undergoes a rigorous 47-point authentication process, conducted by our in-house team of certified watchmakers trained in Geneva and Tokyo. We source exclusively from verified estates, authorized dealers, and private collectors across Europe and Asia.
                    </p>
                    <p class="text-zinc-400 text-sm leading-relaxed font-light">
                        Our promise is simple: <span class="text-luxury-gold font-medium">if it bears the ChronosLuxury seal, it is beyond question.</span>
                    </p>
                </div>

                {{-- Stats Side --}}
                <div class="reveal-right">
                    <div class="grid grid-cols-2 gap-6">
                        @php
                            $stats = [
                                ['value' => '25+',  'label' => 'Years of Heritage',    'icon' => 'fa-clock'],
                                ['value' => '1.2K+','label' => 'Masterpieces Sold',    'icon' => 'fa-gem'],
                                ['value' => '48',   'label' => 'Countries Served',     'icon' => 'fa-globe'],
                                ['value' => '100%', 'label' => 'Authentication Rate',  'icon' => 'fa-shield-halved'],
                            ];
                        @endphp
                        @foreach ($stats as $stat)
                            <div class="value-card bg-zinc-900 border border-white/5 rounded-lg p-6 text-center">
                                <i class="fa-solid {{ $stat['icon'] }} text-luxury-gold text-2xl mb-4"></i>
                                <div class="font-serif text-3xl text-white font-bold">{{ $stat['value'] }}</div>
                                <div class="text-zinc-500 text-[10px] uppercase tracking-widest mt-2">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Our Values ────────────────────────────────────────────────── --}}
    <section class="py-24 bg-neutral-900 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold">What We Stand For</span>
                <h2 class="font-serif text-3xl text-white font-semibold tracking-wide mt-3">Our Core Values</h2>
                <div class="h-px w-14 bg-luxury-gold mx-auto mt-5"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $values = [
                        [
                            'icon'  => 'fa-magnifying-glass',
                            'title' => 'Uncompromising Authenticity',
                            'text'  => 'Every timepiece undergoes our 47-point horological verification. We guarantee legitimacy on every reference number, movement, and dial configuration.',
                            'delay' => '',
                        ],
                        [
                            'icon'  => 'fa-user-tie',
                            'title' => 'White-Glove Service',
                            'text'  => 'From private consultations to armored delivery, your acquisition journey is handled with the discretion and care that a masterpiece deserves.',
                            'delay' => 'delay-200',
                        ],
                        [
                            'icon'  => 'fa-leaf',
                            'title' => 'Sustainable Luxury',
                            'text'  => 'We champion the circular luxury economy. By trading in pre-owned certified watches, we extend the life of extraordinary timepieces and reduce the industry\'s environmental footprint.',
                            'delay' => 'delay-300',
                        ],
                    ];
                @endphp
                @foreach ($values as $val)
                    <div class="value-card reveal {{ $val['delay'] }} bg-zinc-950 border border-white/5 rounded-lg p-8 text-center">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-luxury-gold/10 rounded-full mb-6">
                            <i class="fa-solid {{ $val['icon'] }} text-luxury-gold text-xl"></i>
                        </div>
                        <h3 class="font-serif text-lg text-white font-semibold mb-4">{{ $val['title'] }}</h3>
                        <p class="text-zinc-400 text-xs leading-relaxed font-light">{{ $val['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Timeline ──────────────────────────────────────────────────── --}}
    <section class="py-24 bg-luxury-bg">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <span class="text-luxury-gold text-[10px] tracking-[0.5em] uppercase font-semibold">Our Milestones</span>
                <h2 class="font-serif text-3xl text-white font-semibold tracking-wide mt-3">A Journey Through Time</h2>
                <div class="h-px w-14 bg-luxury-gold mx-auto mt-5"></div>
            </div>

            <div class="relative">
                {{-- Vertical line --}}
                <div class="absolute left-6 top-0 bottom-0 w-[1px] bg-luxury-gold/20"></div>

                @php
                    $milestones = [
                        ['year' => '1998', 'event' => 'ChronosLuxury opened its first boutique in Jakarta Selatan, specializing in vintage Rolex.'],
                        ['year' => '2003', 'event' => 'Expanded our catalog to include Patek Philippe, Audemars Piguet, and A. Lange & Söhne.'],
                        ['year' => '2010', 'event' => 'Launched the first private watch auction in Indonesia for HNW collectors.'],
                        ['year' => '2017', 'event' => 'Opened our second atelier in Bali, serving the Southeast Asian luxury hospitality sector.'],
                        ['year' => '2022', 'event' => 'Introduced our digital boutique — bringing white-glove service to collectors across 48 countries.'],
                        ['year' => '2025', 'event' => 'Surpassed 1,200 authenticated timepieces sold. Launched the ChronosLuxury Collector\'s Membership Program.'],
                    ];
                @endphp

                <div class="space-y-10">
                    @foreach ($milestones as $i => $m)
                        <div class="timeline-item flex items-start gap-8 reveal delay-{{ min($i * 100, 400) }}">
                            <div class="relative shrink-0">
                                <div class="timeline-dot w-12 h-12 bg-zinc-900 border border-luxury-gold/40 rounded-full flex items-center justify-center z-10 relative">
                                    <span class="text-luxury-gold font-bold text-[10px] font-mono">{{ $m['year'] }}</span>
                                </div>
                            </div>
                            <div class="pt-2.5 pb-6">
                                <p class="text-zinc-300 text-sm leading-relaxed font-light">{{ $m['event'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA Strip ─────────────────────────────────────────────────── --}}
    <section class="py-16 bg-zinc-950 border-t border-luxury-gold/20 reveal">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h3 class="font-serif text-2xl text-white font-semibold tracking-wide mb-4">Begin Your Collection</h3>
            <p class="text-zinc-400 text-xs mb-8 tracking-widest uppercase">Explore our fully authenticated catalog of iconic luxury timepieces</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/products') }}" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-bold text-xs tracking-widest uppercase px-10 py-4 rounded transition duration-300">
                    Browse Collection
                </a>
                <a href="{{ url('/contact') }}" class="border border-white/20 hover:border-luxury-gold text-white font-semibold text-xs tracking-widest uppercase px-10 py-4 rounded transition duration-300">
                    Private Consultation
                </a>
            </div>
        </div>
    </section>

    {{-- ── Animations ────────────────────────────────────────────────── --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => obs.observe(el));
    });
    </script>

</x-main-layout>
