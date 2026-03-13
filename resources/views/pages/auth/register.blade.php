<x-layouts::auth :title="__('Daftar Akun Baru')">
    <div class="flex flex-col gap-8 py-4">
        <div class="space-y-3">
            <h1 class="text-3xl font-black uppercase tracking-tight text-zinc-900 dark:text-white leading-none">
                Mulai <span class="text-orange-600">Perjalanan.</span>
            </h1>
            <p class="text-zinc-500 dark:text-zinc-400 font-medium">
                Buat akun untuk mulai memesan dan nikmati penawaran eksklusif kami.
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <x-input
                name="name"
                :label="__('Nama Lengkap')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Nama Lengkap Anda')"
                class="bg-zinc-50 dark:bg-zinc-900/50"
            />

            <!-- Email Address -->
            <x-input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="nama@email.com"
                class="bg-zinc-50 dark:bg-zinc-900/50"
            />

            <!-- Password -->
            <x-input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Buat Kata Sandi')"
                class="bg-zinc-50 dark:bg-zinc-900/50"
            />

            <!-- Confirm Password -->
            <x-input
                name="password_confirmation"
                :label="__('Konfirmasi Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Ulangi Kata Sandi')"
                class="bg-zinc-50 dark:bg-zinc-900/50"
            />

            <div class="pt-2">
                <x-button type="submit" variant="primary" class="w-full py-4 text-lg font-black uppercase tracking-widest bg-orange-600 hover:bg-orange-700 shadow-lg shadow-orange-600/20" data-test="register-user-button">
                    {{ __('Daftar Sekarang') }}
                </x-button>
            </div>
        </form>

        <div class="border-t border-zinc-100 dark:border-zinc-800 pt-8 text-center">
            <p class="text-zinc-500 dark:text-zinc-500 font-medium mb-4">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="inline-block w-full border-2 border-zinc-900 dark:border-zinc-200 text-zinc-900 dark:text-white hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black py-4 font-black uppercase tracking-widest transition-all duration-300" wire:navigate>
                {{ __('Masuk ke Akun') }}
            </a>
        </div>
        
        <div class="mt-4 text-center">
            <a href="/" class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 hover:text-orange-600 transition-colors" wire:navigate>
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</x-layouts::auth>
