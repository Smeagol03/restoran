<header class="sticky top-0 z-[60] border-b border-zinc-200 dark:border-zinc-700">
    <div class="absolute inset-0 -z-10 bg-white/95 backdrop-blur dark:bg-zinc-900/95"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative">
        <div class="flex h-16 items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 font-semibold text-zinc-900 dark:text-white" wire:navigate>
                <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
                    <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
                </span>
                <span class="hidden sm:inline">{{ config('app.name') }}</span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center gap-1 mx-auto">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">Home</x-nav-link>
                <x-nav-link href="{{ route('menu.index') }}" :active="request()->routeIs('menu.*')">Menu</x-nav-link>
                <x-nav-link href="{{ route('about') }}" :active="request()->routeIs('about')">About</x-nav-link>
            </nav>

            {{-- Right Side --}}
            <div class="flex items-center gap-2 sm:gap-4 relative">
                <livewire:public.cart />
                
                @auth
                    <div x-data="{ open: false }" class="relative hidden md:block">
                        <button @click="open = !open" class="flex items-center gap-3 rounded-full pl-1 pr-3 py-1 text-sm font-black uppercase tracking-widest text-zinc-700 bg-zinc-100 hover:bg-zinc-200 dark:text-zinc-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 transition-all border border-transparent hover:border-orange-600/20">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-600 text-[10px] font-black text-white">{{ auth()->user()->initials() }}</span>
                            <span class="hidden lg:inline text-[10px]">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <svg class="h-3 w-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 rounded-xl border border-zinc-100 bg-white py-2 shadow-2xl dark:border-zinc-800 dark:bg-zinc-950 overflow-hidden" style="display: none;">
                            <div class="px-4 py-3 border-b border-zinc-50 dark:border-zinc-900 bg-zinc-50/50 dark:bg-zinc-900/50">
                                <p class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Signed in as</p>
                                <p class="text-xs font-black text-zinc-900 dark:text-white truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                @if(auth()->user()->isStaff())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-zinc-700 hover:bg-orange-50 hover:text-orange-600 dark:text-zinc-300 dark:hover:bg-orange-950/20 transition-colors" wire:navigate>
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        Admin Panel
                                    </a>
                                @endif
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-zinc-700 hover:bg-orange-50 hover:text-orange-600 dark:text-zinc-300 dark:hover:bg-orange-950/20 transition-colors" wire:navigate>
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    My Orders
                                </a>
                                <div class="border-t border-zinc-50 dark:border-zinc-900 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-red-600 hover:bg-red-50 dark:hover:bg-red-950/10 transition-colors cursor-pointer">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Log out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden md:flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-orange-600 transition-colors" wire:navigate>{{ __('Log in') }}</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 dark:hover:bg-orange-600 dark:hover:text-white transition-all shadow-lg shadow-zinc-200 dark:shadow-none" wire:navigate>{{ __('Register') }}</a>
                        @endif
                    </div>
                @endauth

                {{-- Mobile Menu Toggle (Account Drawer) --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-full text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800 transition-colors">
                    @auth
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-900 text-[10px] font-black text-white dark:bg-white dark:text-zinc-900">{{ auth()->user()->initials() }}</span>
                    @else
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    @endauth
                </button>
            </div>
        </div>
    </div>
</header>
