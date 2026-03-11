<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900 font-sans antialiased">
        {{-- Public Header/Navbar --}}
        <header class="sticky top-0 z-50 border-b border-zinc-200 bg-white/95 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/95" x-data="{ mobileOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-2 font-semibold text-zinc-900 dark:text-white" wire:navigate>
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
                            <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                        </span>
                        <span class="hidden sm:inline">{{ config('app.name') }}</span>
                    </a>

                    {{-- Desktop Navigation --}}
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('/') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800' }}" wire:navigate>
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('menu.index') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('menu*') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800' }}" wire:navigate>
                            {{ __('Menu') }}
                        </a>
                        <a href="{{ route('about') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('about*') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800' }}" wire:navigate>
                            {{ __('About') }}
                        </a>
                    </nav>

                    {{-- Right Side --}}
                    <div class="flex items-center gap-3">
                        <livewire:public.cart />
                        
                        @auth
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800 transition-colors">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-zinc-200 text-xs font-bold dark:bg-zinc-700 dark:text-white">{{ auth()->user()->initials() }}</span>
                                    <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-800" style="display: none;">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700" wire:navigate>{{ __('Dashboard') }}</a>
                                    <hr class="my-1 border-zinc-200 dark:border-zinc-700">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-start text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700 cursor-pointer">{{ __('Log out') }}</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="hidden md:flex items-center gap-2">
                                <x-button href="{{ route('login') }}" variant="ghost">{{ __('Log in') }}</x-button>
                                @if (Route::has('register'))
                                    <x-button href="{{ route('register') }}" variant="primary">{{ __('Register') }}</x-button>
                                @endif
                            </div>
                        @endauth

                        {{-- Mobile Menu Toggle --}}
                        <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800">
                            <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            <svg x-show="mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Navigation --}}
            <div x-show="mobileOpen" x-transition class="md:hidden border-t border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900" style="display: none;">
                <div class="px-4 py-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('/') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400' }}" wire:navigate>{{ __('Home') }}</a>
                    <a href="{{ route('menu.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('menu*') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400' }}" wire:navigate>{{ __('Menu') }}</a>
                    <a href="{{ route('about') }}" class="block px-3 py-2 rounded-lg text-sm font-medium {{ request()->is('about*') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400' }}" wire:navigate>{{ __('About') }}</a>
                    @guest
                        <hr class="my-2 border-zinc-200 dark:border-zinc-700">
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-600 dark:text-zinc-400" wire:navigate>{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-zinc-900 dark:text-white" wire:navigate>{{ __('Register') }}</a>
                        @endif
                    @endguest
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main>
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 py-12 mt-12 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-950">
             <div class="container mx-auto px-6 text-center text-zinc-500">
                <p class="text-sm font-medium">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p class="text-xs mt-2">Dibuat dengan Laravel 12 & Tailwind CSS</p>
             </div>
        </footer>

        @livewireScripts
    </body>
</html>
