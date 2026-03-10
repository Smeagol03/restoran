<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 font-sans antialiased" x-data="{ sidebarOpen: false }">
        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 inset-s-0 z-40 w-64 transform border-e border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-950 transition-transform duration-200 lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-full flex-col">
                {{-- Sidebar Header --}}
                <div class="flex h-16 items-center justify-between border-b border-zinc-200 px-4 dark:border-zinc-700">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-semibold text-zinc-900 dark:text-white" wire:navigate>
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
                            <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                        </span>
                        <span>{{ config('app.name') }}</span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Sidebar Nav --}}
                <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                    <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">{{ __('Platform') }}</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        {{ __('Dashboard') }}
                    </a>
                </nav>

                {{-- Sidebar Footer (User) --}}
                <div class="border-t border-zinc-200 p-3 dark:border-zinc-700" x-data="{ userMenuOpen: false }">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-xs font-bold dark:bg-zinc-700 dark:text-white">{{ auth()->user()->initials() }}</span>
                        <span class="flex-1 truncate text-start text-sm font-medium text-zinc-900 dark:text-white">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4 text-zinc-400 transition-transform" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="userMenuOpen" x-transition class="mt-1 space-y-1" style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800" wire:navigate>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ __('Settings') }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800 cursor-pointer" data-test="logout-button">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Overlay (mobile) --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/50 lg:hidden" x-transition.opacity style="display: none;"></div>

        {{-- Main Content --}}
        <div class="lg:ps-64">
            {{-- Mobile header --}}
            <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-zinc-200 bg-white px-4 dark:border-zinc-700 dark:bg-zinc-950 lg:hidden">
                <button @click="sidebarOpen = true" class="p-2 rounded-lg text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex-1"></div>
                {{-- Mobile user dropdown --}}
                <div x-data="{ mobileUserOpen: false }" class="relative">
                    <button @click="mobileUserOpen = !mobileUserOpen" class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-zinc-200 text-xs font-bold dark:bg-zinc-700 dark:text-white">{{ auth()->user()->initials() }}</span>
                        <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="mobileUserOpen" @click.away="mobileUserOpen = false" x-transition class="absolute right-0 mt-2 w-48 rounded-lg border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-800" style="display: none;">
                        <div class="px-4 py-2 border-b border-zinc-200 dark:border-zinc-700">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700" wire:navigate>{{ __('Settings') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-start text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-700 cursor-pointer" data-test="logout-button">{{ __('Log out') }}</button>
                        </form>
                    </div>
                </div>
            </header>

            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
