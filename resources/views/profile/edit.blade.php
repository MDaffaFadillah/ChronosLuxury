<x-main-layout>
    <x-slot name="title">Account Settings — ChronosLuxury</x-slot>

    <style>
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.6s cubic-bezier(0.16,1,0.3,1), transform 0.6s cubic-bezier(0.16,1,0.3,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 0.10s; }
        .delay-200 { transition-delay: 0.20s; }
        .settings-input {
            width: 100%; background: rgba(39,39,42,0.7); border: 1px solid rgba(255,255,255,0.08);
            border-radius: 0.375rem; padding: 0.65rem 0.875rem; font-size: 0.75rem; color: #e4e4e7;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
            font-family: 'Poppins', sans-serif;
        }
        .settings-input:focus { border-color: #D4AF37; box-shadow: 0 0 0 3px rgba(212,175,55,0.1); }
        .settings-input::placeholder { color: #52525b; }
        .settings-input:disabled { opacity: 0.4; cursor: not-allowed; }
        .tab-btn { transition: color 0.2s, border-color 0.2s; }
        .tab-btn.active { color: #D4AF37; border-bottom-color: #D4AF37; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
    </style>

    {{-- ── Page Header ─────────────────────────────────────────────── --}}
    <section class="bg-neutral-900 border-b border-white/5 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div>
                <h1 class="font-serif text-2xl text-white font-bold tracking-wide">Account Settings</h1>
                <p class="text-[10px] text-zinc-500 mt-1 uppercase tracking-widest">
                    Manage your boutique profile & security
                </p>
            </div>
            <a href="{{ url('/dashboard') }}" class="text-zinc-400 hover:text-white text-xs uppercase tracking-widest transition flex items-center gap-2 font-medium">
                <i class="fa-solid fa-chevron-left text-[10px]"></i> Dashboard
            </a>
        </div>
    </section>

    {{-- ── Settings Body ────────────────────────────────────────────── --}}
    <section class="py-12 bg-luxury-bg min-h-[70vh]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash alerts --}}
            @if (session('status') === 'profile-updated')
                <div class="mb-6 bg-emerald-950/40 border border-emerald-500/20 rounded-lg px-5 py-3 flex items-center gap-3 reveal">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                    <span class="text-emerald-300 text-xs">Profile information updated successfully.</span>
                </div>
            @endif
            @if (session('status') === 'password-updated')
                <div class="mb-6 bg-emerald-950/40 border border-emerald-500/20 rounded-lg px-5 py-3 flex items-center gap-3 reveal">
                    <i class="fa-solid fa-shield-check text-emerald-400"></i>
                    <span class="text-emerald-300 text-xs">Password changed securely.</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- ── Sidebar Nav ───────────────────────────────────── --}}
                <div class="lg:col-span-1 reveal">
                    {{-- Avatar Card --}}
                    <div class="bg-zinc-900 border border-white/5 rounded-lg p-6 text-center mb-6">
                        <div class="w-16 h-16 bg-luxury-gold/10 border border-luxury-gold/30 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="font-serif text-2xl text-luxury-gold font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <p class="text-white text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-zinc-500 text-[10px] mt-0.5">{{ auth()->user()->email }}</p>
                        <span class="inline-block mt-2 text-[9px] uppercase tracking-widest px-2 py-0.5 rounded bg-luxury-gold/10 text-luxury-gold border border-luxury-gold/20">
                            {{ auth()->user()->role ?? 'Member' }}
                        </span>
                    </div>

                    {{-- Nav links --}}
                    <nav class="space-y-1">
                        <button onclick="switchTab('profile')" id="tab-btn-profile"
                                class="tab-btn active w-full text-left text-xs px-4 py-3 rounded-lg border-l-2 border-luxury-gold bg-luxury-gold/5 text-luxury-gold font-semibold uppercase tracking-wider">
                            <i class="fa-solid fa-user w-4 mr-2"></i> Profile Info
                        </button>
                        <button onclick="switchTab('password')" id="tab-btn-password"
                                class="tab-btn w-full text-left text-xs px-4 py-3 rounded-lg border-l-2 border-transparent text-zinc-400 hover:text-white hover:bg-white/5 font-semibold uppercase tracking-wider transition">
                            <i class="fa-solid fa-lock w-4 mr-2"></i> Password
                        </button>
                        <button onclick="switchTab('danger')" id="tab-btn-danger"
                                class="tab-btn w-full text-left text-xs px-4 py-3 rounded-lg border-l-2 border-transparent text-zinc-400 hover:text-red-400 hover:bg-red-950/20 font-semibold uppercase tracking-wider transition">
                            <i class="fa-solid fa-triangle-exclamation w-4 mr-2"></i> Danger Zone
                        </button>
                    </nav>
                </div>

                {{-- ── Main Content ──────────────────────────────────── --}}
                <div class="lg:col-span-3">

                    {{-- ── Panel: Profile Info ─────────────────────── --}}
                    <div id="panel-profile" class="tab-panel active reveal delay-100">
                        <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                            <h2 class="font-serif text-lg text-white font-semibold mb-1">Profile Information</h2>
                            <p class="text-zinc-500 text-xs mb-6">Update your account's name and email address.</p>
                            <div class="h-px bg-white/5 mb-6"></div>

                            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                                @csrf
                                @method('PATCH')

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                           class="settings-input" placeholder="Your full name">
                                    @error('name') <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                           class="settings-input" placeholder="your@email.com">
                                    @error('email') <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Account Role</label>
                                    <input type="text" value="{{ ucfirst(auth()->user()->role ?? 'customer') }}" disabled class="settings-input">
                                    <p class="text-[10px] text-zinc-600">Role cannot be changed from this panel.</p>
                                </div>

                                <div class="flex items-center gap-4 pt-2">
                                    <button type="submit" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-bold text-xs tracking-widest uppercase px-8 py-3 rounded transition duration-200">
                                        Save Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ── Panel: Password ─────────────────────────── --}}
                    <div id="panel-password" class="tab-panel">
                        <div class="bg-zinc-950 border border-white/5 rounded-lg p-6 sm:p-8">
                            <h2 class="font-serif text-lg text-white font-semibold mb-1">Change Password</h2>
                            <p class="text-zinc-500 text-xs mb-6">Use a strong, unique password to protect your account.</p>
                            <div class="h-px bg-white/5 mb-6"></div>

                            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Current Password</label>
                                    <input type="password" name="current_password" required
                                           class="settings-input" placeholder="••••••••">
                                    @error('current_password', 'updatePassword')
                                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">New Password</label>
                                    <input type="password" name="password" required
                                           class="settings-input" placeholder="••••••••">
                                    @error('password', 'updatePassword')
                                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" required
                                           class="settings-input" placeholder="••••••••">
                                    @error('password_confirmation', 'updatePassword')
                                        <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-2">
                                    <button type="submit" class="bg-luxury-gold hover:bg-luxury-goldLight text-black font-bold text-xs tracking-widest uppercase px-8 py-3 rounded transition duration-200">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- ── Panel: Danger Zone ──────────────────────── --}}
                    <div id="panel-danger" class="tab-panel">
                        <div class="bg-zinc-950 border border-red-900/30 rounded-lg p-6 sm:p-8">
                            <h2 class="font-serif text-lg text-red-400 font-semibold mb-1">Danger Zone</h2>
                            <p class="text-zinc-500 text-xs mb-6">Once you delete your account, there is no going back. All your data will be permanently erased.</p>
                            <div class="h-px bg-red-900/20 mb-6"></div>

                            <div class="bg-red-950/20 border border-red-800/20 rounded-lg p-5 flex items-start gap-4">
                                <i class="fa-solid fa-skull text-red-500 text-sm mt-0.5 shrink-0"></i>
                                <div class="flex-1">
                                    <p class="text-red-300 text-xs font-semibold mb-1">Delete Account Permanently</p>
                                    <p class="text-zinc-500 text-[11px] leading-relaxed mb-4">All orders, cart items, and personal data associated with this account will be erased. This action is irreversible.</p>

                                    <form method="POST" action="{{ route('profile.destroy') }}"
                                          onsubmit="return confirm('Are you absolutely sure? This will permanently delete your account and all its data.')">
                                        @csrf
                                        @method('DELETE')

                                        <div class="space-y-1.5 mb-4">
                                            <label class="text-[10px] uppercase tracking-widest text-zinc-500 font-semibold">Confirm your password to proceed</label>
                                            <input type="password" name="password" required
                                                   class="settings-input max-w-xs" placeholder="Enter your password">
                                            @error('password', 'userDeletion')
                                                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit" class="bg-red-700 hover:bg-red-600 text-white font-bold text-xs tracking-widest uppercase px-6 py-2.5 rounded transition duration-200">
                                            <i class="fa-solid fa-trash mr-2"></i> Delete My Account
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
    // Tab switcher
    function switchTab(tab) {
        ['profile', 'password', 'danger'].forEach(t => {
            document.getElementById('panel-' + t).classList.remove('active');
            const btn = document.getElementById('tab-btn-' + t);
            btn.classList.remove('active', 'border-luxury-gold', 'bg-luxury-gold/5', 'text-luxury-gold');
            btn.classList.add('border-transparent', 'text-zinc-400');
        });

        document.getElementById('panel-' + tab).classList.add('active');
        const activeBtn = document.getElementById('tab-btn-' + tab);
        activeBtn.classList.add('active');
        activeBtn.classList.remove('border-transparent', 'text-zinc-400');

        if (tab !== 'danger') {
            activeBtn.classList.add('border-luxury-gold', 'bg-luxury-gold/5', 'text-luxury-gold');
        } else {
            activeBtn.classList.add('border-red-700', 'bg-red-950/20', 'text-red-400');
        }
    }

    // Scroll reveal
    document.addEventListener('DOMContentLoaded', () => {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
    });
    </script>
</x-main-layout>
