<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 font-sans antialiased flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <a href="/" class="inline-flex items-center gap-2 font-black text-2xl text-zinc-900 dark:text-white mb-8 uppercase tracking-tighter">
            <span class="flex h-12 w-12 items-center justify-center bg-zinc-900 dark:bg-white">
                <x-app-logo-icon class="size-8 fill-current text-white dark:text-zinc-900" />
            </span>
            {{ config('app.name') }} <span class="text-orange-600">Admin</span>
        </a>
        <h2 class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white uppercase">Akses Dashboard</h2>
        <p class="mt-2 text-zinc-500 dark:text-zinc-400 font-medium">Khusus untuk pengelola restoran</p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-zinc-900 py-10 px-4 shadow-xl sm:rounded-none sm:px-10 border border-zinc-200 dark:border-zinc-800">
            <form class="space-y-6" action="{{ route('admin.login') }}" method="POST">
                @csrf
                <x-input 
                    label="Email address" 
                    name="email" 
                    type="email" 
                    autocomplete="email" 
                    required 
                    :value="old('email')" 
                    placeholder="admin@restoran.com"
                    class="bg-zinc-50 dark:bg-zinc-950/50"
                />

                <x-input 
                    label="Password" 
                    name="password" 
                    type="password" 
                    autocomplete="current-password" 
                    required 
                    placeholder="••••••••"
                    class="bg-zinc-50 dark:bg-zinc-950/50"
                />

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <x-checkbox id="remember" name="remember" class="h-4 w-4 rounded-none border-zinc-300 text-orange-600 focus:ring-orange-500" />
                        <x-label for="remember" value="Ingat sesi ini" class="ml-2 mb-0" />
                    </div>
                </div>

                <div>
                    <x-button type="submit" variant="primary" class="w-full justify-center py-4 text-sm font-black uppercase tracking-widest bg-zinc-900 hover:bg-orange-600 dark:bg-white dark:text-black dark:hover:bg-orange-600 dark:hover:text-white transition-all duration-300">
                        Masuk Dashboard
                    </x-button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 text-center">
            <a href="/" class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 hover:text-orange-600 transition-colors" wire:navigate>
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
