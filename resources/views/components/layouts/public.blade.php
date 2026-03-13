<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900 font-sans antialiased" x-data="{ mobileOpen: false }" @keydown.window.escape="mobileOpen = false">
        
        @include('layouts.app.navbar')

        {{-- Main Content --}}
        <main class="pb-20 md:pb-0">
            {{ $slot }}
        </main>

        @include('layouts.app.bottom-nav')
        @include('layouts.app.mobile-drawer')

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 py-12 mt-12 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950">
             <div class="container mx-auto px-6 text-center text-zinc-500 pb-20 md:pb-0">
                <p class="text-sm font-medium">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="text-xs mt-2">Dibuat dengan Laravel 12 & Tailwind CSS</p>
             </div>
        </footer>

        @livewireScripts
    </body>
</html>
