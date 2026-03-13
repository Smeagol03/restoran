<x-layouts::auth :title="__('Masuk ke Akun Anda')">
    <div class="flex flex-col gap-8 py-4">
        <div class="space-y-3">
            <h1 class="text-3xl font-black uppercase tracking-tight text-zinc-900 dark:text-white leading-none">
                Selamat <span class="text-orange-600">Datang.</span>
            </h1>
            <p class="text-zinc-500 dark:text-zinc-400 font-medium">
                Masuk untuk melanjutkan pesanan Anda dan nikmati hidangan terbaik kami.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <x-input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="nama@email.com"
                class="bg-zinc-50 dark:bg-zinc-900/50"
            />

            <!-- Password -->
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <x-label for="password" :value="__('Password')" />
                    @if (Route::has('password.request'))
                        <a class="text-xs text-orange-600 hover:text-orange-700 font-bold uppercase tracking-widest" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Lupa Sandi?') }}
                        </a>
                    @endif
                </div>
                <x-input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('••••••••')"
                    class="bg-zinc-50 dark:bg-zinc-900/50"
                />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <x-checkbox id="remember" name="remember" :checked="old('remember')" />
                <label for="remember" class="ml-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 cursor-pointer">Ingat saya</label>
            </div>

            <div class="pt-2">
                <x-button variant="primary" type="submit" class="w-full py-4 text-lg font-black uppercase tracking-widest bg-orange-600 hover:bg-orange-700 shadow-lg shadow-orange-600/20" data-test="login-button">
                    {{ __('Masuk Sekarang') }}
                </x-button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="border-t border-zinc-100 dark:border-zinc-800 pt-8 text-center">
                <p class="text-zinc-500 dark:text-zinc-500 font-medium mb-4">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="inline-block w-full border-2 border-zinc-900 dark:border-zinc-200 text-zinc-900 dark:text-white hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black py-4 font-black uppercase tracking-widest transition-all duration-300" wire:navigate>
                    {{ __('Daftar Akun Baru') }}
                </a>
            </div>
        @endif
        
        <div class="mt-4 text-center">
            <a href="/" class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 hover:text-orange-600 transition-colors" wire:navigate>
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</x-layouts::auth>
