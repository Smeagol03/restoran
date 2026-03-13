{{-- Mobile Side Menu (Drawer Style) --}}
<div x-show="mobileOpen" 
     class="fixed inset-0 z-[100] md:hidden" 
     style="display: none;">
    
    {{-- Backdrop --}}
    <div x-show="mobileOpen"
         x-transition:enter="ease-in-out duration-500"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-zinc-900/60 backdrop-blur-sm transition-opacity" 
         @click="mobileOpen = false"></div>

    {{-- Drawer Content --}}
    <div x-show="mobileOpen"
         x-transition:enter="transform transition ease-in-out duration-500"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-500"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute right-0 top-0 h-full w-80 bg-white dark:bg-zinc-950 shadow-2xl flex flex-col overflow-hidden">
        
        <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex justify-between items-center">
            <span class="font-black uppercase tracking-widest text-zinc-900 dark:text-white text-xs">Account & More</span>
            <button @click="mobileOpen = false" class="text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="flex-1 overflow-y-auto p-6 space-y-8 pb-32">
            @auth
                <div class="flex items-center gap-4 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-2xl">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-600 text-white font-black text-lg">{{ auth()->user()->initials() }}</span>
                    <div>
                        <p class="font-black text-zinc-900 dark:text-white uppercase leading-none mb-1 text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-bold text-orange-600 uppercase tracking-widest">{{ auth()->user()->role->label() }}</p>
                    </div>
                </div>
                <nav class="space-y-2">
                    @if(auth()->user()->isStaff())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-zinc-700 dark:text-zinc-300 active:bg-zinc-100 dark:active:bg-zinc-900 transition-colors" wire:navigate>
                            <svg class="size-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Admin Panel
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-zinc-700 dark:text-zinc-300 active:bg-zinc-100 dark:active:bg-zinc-900 transition-colors" wire:navigate>
                        <svg class="size-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        My Orders
                    </a>
                    <a href="{{ route('about') }}" class="flex items-center gap-3 p-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-zinc-700 dark:text-zinc-300 active:bg-zinc-100 dark:active:bg-zinc-900 transition-colors" wire:navigate>
                        <svg class="size-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        About Restaurant
                    </a>
                </nav>
                <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 p-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-red-600 active:bg-red-50 dark:active:bg-red-900/10 transition-colors cursor-pointer">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Log out
                        </button>
                    </form>
                </div>
            @else
                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="flex w-full items-center justify-center p-5 rounded-2xl text-[10px] font-black uppercase tracking-widest bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-xl" wire:navigate>Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex w-full items-center justify-center p-5 rounded-2xl text-[10px] font-black uppercase tracking-widest border-2 border-zinc-900 dark:border-white text-zinc-900 dark:text-white" wire:navigate>Register</a>
                    @endif
                    <a href="{{ route('about') }}" class="flex items-center justify-center gap-2 p-5 text-[10px] font-black uppercase tracking-widest text-zinc-500" wire:navigate>
                        About Restaurant
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
