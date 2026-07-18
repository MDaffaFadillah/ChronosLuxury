<x-guest-layout>
    <!-- Title -->
    <div class="mb-8 text-center">
        <h2 class="font-serif text-2xl text-white font-bold tracking-wide">Welcome Back</h2>
        <p class="text-xs text-zinc-500 mt-1 tracking-widest uppercase">Sign in to your boutique account</p>
        <div class="mt-3 w-10 h-px bg-luxury-gold mx-auto"></div>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-xs text-emerald-400 bg-emerald-950/30 border border-emerald-500/20 rounded px-3 py-2">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-widest text-zinc-400 font-semibold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full bg-zinc-800/60 border border-white/10 rounded px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-600 focus:outline-none focus:border-luxury-gold focus:ring-0 transition duration-200">
            @error('email')
                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="text-[10px] uppercase tracking-widest text-zinc-400 font-semibold">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full bg-zinc-800/60 border border-white/10 rounded px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-luxury-gold focus:ring-0 transition duration-200">
            @error('password')
                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-zinc-800 border-white/10 text-luxury-gold focus:ring-0 h-3.5 w-3.5">
                <span class="text-[10px] text-zinc-500">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[10px] text-zinc-500 hover:text-luxury-gold transition">Forgot password?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200 shadow mt-2">
            Sign In to Boutique
        </button>

        <!-- Register link -->
        <p class="text-center text-[10px] text-zinc-500 mt-4">
            New to ChronosLuxury?
            <a href="{{ route('register') }}" class="text-luxury-gold hover:text-white transition font-semibold ml-1">Create Account</a>
        </p>
    </form>
</x-guest-layout>
