<x-main-layout>
    <x-slot name="title">Contact ChronosLuxury — Private Consultation</x-slot>

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
        @keyframes goldShimmer { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
        .text-gold-shimmer {
            background: linear-gradient(90deg, #D4AF37 0%, #F5D97A 40%, #D4AF37 60%, #B3922E 100%);
            background-size: 200% auto; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            animation: goldShimmer 4s linear infinite;
        }
        .contact-input {
            width: 100%; background: rgba(39,39,42,0.7); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 0.375rem; padding: 0.75rem 1rem; font-size: 0.75rem; color: #e4e4e7;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .contact-input:focus { border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212,175,55,0.1); }
        .contact-input::placeholder { color: #52525b; }
        .info-card { transition: border-color 0.3s, transform 0.35s cubic-bezier(0.23,1,0.32,1); }
        .info-card:hover { border-color: rgba(212,175,55,0.4) !important; transform: translateY(-2px); }
    </style>

    {{-- ── Hero ─────────────────────────────────────────────────────── --}}
    <section class="bg-neutral-900 border-b border-white/5 py-20 md:py-28 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5" style="background-image: repeating-linear-gradient(0deg,transparent,transparent 60px,rgba(212,175,55,0.4) 60px,rgba(212,175,55,0.4) 61px),repeating-linear-gradient(90deg,transparent,transparent 60px,rgba(212,175,55,0.4) 60px,rgba(212,175,55,0.4) 61px);"></div>
        <div class="max-w-3xl mx-auto px-4 text-center relative z-10">
            <span class="text-luxury-gold text-[10px] tracking-[0.55em] uppercase font-semibold reveal">Boutique Service</span>
            <h1 class="font-serif text-4xl md:text-6xl text-white font-bold tracking-wide mt-4 reveal delay-100">
                Private <span class="text-gold-shimmer italic">Consultation</span>
            </h1>
            <div class="h-px w-16 bg-luxury-gold mx-auto mt-6 reveal delay-200"></div>
            <p class="text-zinc-400 text-sm leading-relaxed max-w-xl mx-auto mt-8 font-light reveal delay-300">
                Our expert team is available to assist you with acquisitions, valuations, and private consultations. Every enquiry is handled with the utmost discretion.
            </p>
        </div>
    </section>

    {{-- ── Main Content ─────────────────────────────────────────────── --}}
    <section class="py-24 bg-luxury-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- ── Contact Information (Left) ──────────────────── --}}
                <div class="lg:col-span-2 reveal-left space-y-6">
                    <div>
                        <h2 class="font-serif text-2xl text-white font-semibold tracking-wide mb-2">Get in Touch</h2>
                        <p class="text-zinc-500 text-xs leading-relaxed font-light">We respond to all enquiries within 24 business hours. For urgent matters, please reach us by WhatsApp.</p>
                    </div>

                    @php
                        $infos = [
                            [
                                'icon'  => 'fa-location-dot',
                                'title' => 'Boutique Address',
                                'lines' => ['Jl. Sudirman No. 88, Lantai 12', 'Jakarta Selatan 12190', 'Indonesia'],
                            ],
                            [
                                'icon'  => 'fa-phone',
                                'title' => 'By Phone',
                                'lines' => ['+62 21 5555 8888', 'Mon–Sat, 09:00–18:00 WIB'],
                            ],
                            [
                                'icon'  => 'fa-brands fa-whatsapp',
                                'title' => 'WhatsApp Concierge',
                                'lines' => ['+62 812 9999 0000', 'Available 24/7 for VIP clients'],
                            ],
                            [
                                'icon'  => 'fa-envelope',
                                'title' => 'Email',
                                'lines' => ['boutique@chronosluxury.com', 'consult@chronosluxury.com'],
                            ],
                        ];
                    @endphp

                    @foreach ($infos as $info)
                        <div class="info-card bg-zinc-900 border border-white/5 rounded-lg p-5 flex items-start gap-4">
                            <div class="w-10 h-10 bg-luxury-gold/10 rounded-lg flex items-center justify-center shrink-0">
                                <i class="{{ $info['icon'] }} text-luxury-gold text-sm"></i>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold mb-1">{{ $info['title'] }}</p>
                                @foreach ($info['lines'] as $line)
                                    <p class="text-zinc-300 text-xs font-light">{{ $line }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    {{-- Business Hours --}}
                    <div class="bg-zinc-900/50 border border-white/5 rounded-lg p-5">
                        <p class="text-[10px] uppercase tracking-widest text-luxury-gold font-semibold mb-3">Boutique Hours</p>
                        <div class="space-y-1.5 text-xs text-zinc-400 font-light">
                            <div class="flex justify-between"><span>Monday — Friday</span><span class="text-zinc-300">09:00 – 18:00</span></div>
                            <div class="flex justify-between"><span>Saturday</span><span class="text-zinc-300">10:00 – 16:00</span></div>
                            <div class="flex justify-between"><span>Sunday</span><span class="text-zinc-500 italic">By appointment only</span></div>
                        </div>
                    </div>
                </div>

                {{-- ── Contact Form (Right) ─────────────────────────── --}}
                <div class="lg:col-span-3 reveal-right">
                    <div class="bg-zinc-950 border border-white/5 rounded-lg p-8 sm:p-10">

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="mb-6 bg-emerald-950/40 border border-emerald-500/20 rounded-lg px-5 py-4 flex items-start gap-3">
                                <i class="fa-solid fa-circle-check text-emerald-400 mt-0.5 text-sm shrink-0"></i>
                                <p class="text-emerald-300 text-xs leading-relaxed">{{ session('success') }}</p>
                            </div>
                        @endif

                        <h3 class="font-serif text-xl text-white font-semibold mb-2">Send an Enquiry</h3>
                        <p class="text-zinc-500 text-[11px] mb-8">All fields marked with <span class="text-luxury-gold">*</span> are required.</p>

                        <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Your Name <span class="text-luxury-gold">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required class="contact-input">
                                    @error('name') <p class="text-[10px] text-red-400">{{ $message }}</p> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Email Address <span class="text-luxury-gold">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com" required class="contact-input">
                                    @error('email') <p class="text-[10px] text-red-400">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Subject <span class="text-luxury-gold">*</span></label>
                                <select name="subject" required class="contact-input">
                                    <option value="" disabled {{ old('subject') ? '' : 'selected' }}>Select enquiry type</option>
                                    <option value="Purchase Enquiry" {{ old('subject') == 'Purchase Enquiry' ? 'selected' : '' }}>Purchase Enquiry</option>
                                    <option value="Watch Valuation" {{ old('subject') == 'Watch Valuation' ? 'selected' : '' }}>Watch Valuation</option>
                                    <option value="Private Consultation" {{ old('subject') == 'Private Consultation' ? 'selected' : '' }}>Private Consultation</option>
                                    <option value="Authentication Request" {{ old('subject') == 'Authentication Request' ? 'selected' : '' }}>Authentication Request</option>
                                    <option value="After-Sales Support" {{ old('subject') == 'After-Sales Support' ? 'selected' : '' }}>After-Sales Support</option>
                                    <option value="General Enquiry" {{ old('subject') == 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                </select>
                                @error('subject') <p class="text-[10px] text-red-400">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Message <span class="text-luxury-gold">*</span></label>
                                <textarea name="message" rows="6" placeholder="Tell us about your enquiry, preferred timepieces, or any specific requirements..." required class="contact-input resize-none">{{ old('message') }}</textarea>
                                @error('message') <p class="text-[10px] text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Privacy note --}}
                            <p class="text-[10px] text-zinc-600 leading-relaxed">
                                <i class="fa-solid fa-lock text-zinc-700 mr-1"></i>
                                Your enquiry is completely confidential. We will never share your information with third parties.
                            </p>

                            <button type="submit" class="w-full bg-luxury-gold hover:bg-luxury-goldLight text-black font-bold text-xs tracking-widest uppercase py-4 rounded transition duration-200 shadow-lg shadow-luxury-gold/20 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                Send Enquiry
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Map Placeholder ──────────────────────────────────────────── --}}
    <section class="bg-zinc-950 border-t border-white/5 reveal">
        <div class="w-full h-64 bg-zinc-900 flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: repeating-linear-gradient(0deg,transparent,transparent 30px,rgba(212,175,55,0.3) 30px,rgba(212,175,55,0.3) 31px),repeating-linear-gradient(90deg,transparent,transparent 30px,rgba(212,175,55,0.3) 30px,rgba(212,175,55,0.3) 31px);"></div>
            <div class="text-center z-10">
                <i class="fa-solid fa-map-location-dot text-luxury-gold text-3xl mb-3 block"></i>
                <p class="text-zinc-400 text-xs uppercase tracking-widest">Jl. Sudirman No. 88, Jakarta Selatan</p>
                <a href="https://maps.google.com" target="_blank" class="text-luxury-gold text-[10px] uppercase tracking-widest mt-2 block hover:text-white transition">View on Google Maps →</a>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => obs.observe(el));
    });
    </script>

</x-main-layout>
