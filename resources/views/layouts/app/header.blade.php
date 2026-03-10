<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800 font-sans antialiased" x-data="{ sidebarOpen: false }">
        {{-- Header --}}
        <header class="sticky top-0 z-30 border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    {{-- Left: Mobile toggle + Logo --}}
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-semibold text-zinc-900 dark:text-white" wire:navigate>
                            <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
                                <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                            </span>
                            <span class="hidden sm:inline">{{ config('app.name') }}</span>
                        </a>
                    </div>

                    {{-- Center: Nav --}}
                    <nav class="hidden lg:flex items-center gap-1">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'text-zinc-900 dark:text-white bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:bg-zinc-50 dark:hover:bg-zinc-800' }}" wire:navigate>
                            {{ __('Dashboard') }}
                        </a>
                    </nav>

                    {{-- Right: User --}}
                    <x-desktop-user-menu />
                </div>
            </div>
        </header>

        {{-- Mobile Sidebar --}}
        <aside
            x-show="sidebarOpen"
            class="fixed inset-y-0 inset-s-0 z-40 w-64 border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 lg:hidden"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            style="display: none;"
        >
            <div class="flex h-full flex-col">
                <div class="flex h-16 items-center justify-between border-b border-zinc-200 px-4 dark:border-zinc-700">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-semibold text-zinc-900 dark:text-white" wire:navigate>
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
                            <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                        </span>
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <button @click="sidebarOpen = false" class="p-1.5 rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                    <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">{{ __('Platform') }}</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>
                        {{ __('Dashboard') }}
                    </a>
                </nav>
            </div>
        </aside>
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/50 lg:hidden" x-transition.opacity style="display: none;"></div>

        {{ $slot }}

        @livewireScripts
    </body>
</html>
