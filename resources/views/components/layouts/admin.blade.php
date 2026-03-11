<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-50 dark:bg-zinc-950 font-sans antialiased">
        <div class="flex h-screen overflow-hidden">
            {{-- Sidebar --}}
            <aside class="hidden md:flex w-64 flex-col bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800">
                <div class="flex h-16 items-center px-6 border-b border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-zinc-900 dark:text-white">
                        <x-app-logo-icon class="size-6 fill-current" />
                        <span>Admin Panel</span>
                    </a>
                </div>
                <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Pesanan
                    </a>
                    <a href="{{ route('admin.menu.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.menu.*') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Menu Makanan
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white' }}">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Kategori
                    </a>
                </nav>
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Ke Website
                    </a>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
                {{-- Top Header --}}
                <header class="h-16 flex items-center justify-between px-6 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
                    <button class="md:hidden p-2 -ml-2 text-zinc-600 dark:text-zinc-400">
                        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="flex items-center gap-4 ml-auto">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ auth()->user()->name }}</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700">{{ auth()->user()->role->label() }}</span>
                        <form method="POST" action="{{ route('admin.logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="p-2 text-zinc-500 hover:text-red-600 transition-colors" title="Logout">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    </div>
                </header>

                {{-- Content Area --}}
                <div class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
