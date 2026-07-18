<x-guest-layout>
    <!-- Title -->
    <div class="mb-8 text-center">
        <h2 class="font-serif text-2xl text-white font-bold tracking-wide">Create Account</h2>
        <p class="text-xs text-zinc-500 mt-1 tracking-widest uppercase">Join the ChronosLuxury Private Club</p>
        <div class="mt-3 w-10 h-px bg-luxury-gold mx-auto"></div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="space-y-1">
            <label for="name" class="text-[10px] uppercase tracking-widest text-zinc-400 font-semibold">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full bg-zinc-800/60 border border-white/10 rounded px-3 py-2.5 text-xs text-zinc-200 placeholder-zinc-600 focus:outline-none focus:border-luxury-gold focus:ring-0 transition duration-200">
            @error('name')
                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="space-y-1">
            <label for="email" class="text-[10px] uppercase tracking-widest text-zinc-400 font-semibold">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full bg-zinc-800/60 border border-white/10 rounded px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-luxury-gold focus:ring-0 transition duration-200">
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

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="text-[10px] uppercase tracking-widest text-zinc-400 font-semibold">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full bg-zinc-800/60 border border-white/10 rounded px-3 py-2.5 text-xs text-zinc-200 focus:outline-none focus:border-luxury-gold focus:ring-0 transition duration-200">
            @error('password_confirmation')
                <p class="text-[10px] text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-luxury-gold hover:bg-luxury-goldLight text-black font-semibold text-xs tracking-widest uppercase py-3 rounded transition duration-200 shadow mt-2">
            Join Boutique
        </button>

        <!-- Login link -->
        <p class="text-center text-[10px] text-zinc-500 mt-4">
            Already a member?
            <a href="{{ route('login') }}" class="text-luxury-gold hover:text-white transition font-semibold ml-1">Sign In</a>
        </p>
    </form>
</x-guest-layout>
