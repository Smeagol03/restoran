<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl border-t border-zinc-200 dark:border-zinc-800 md:hidden pb-safe">
    <div class="grid h-full max-w-lg grid-cols-3 mx-auto font-medium">
        <!-- Home -->
        <a href="{{ route('home') }}" wire:navigate class="inline-flex flex-col items-center justify-center px-5 hover:bg-zinc-50 dark:hover:bg-zinc-900 group {{ request()->routeIs('home') ? 'text-orange-600' : 'text-zinc-500 dark:text-zinc-400' }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter">Home</span>
        </a>

        <!-- Menu -->
        <a href="{{ route('menu.index') }}" wire:navigate class="inline-flex flex-col items-center justify-center px-5 hover:bg-zinc-50 dark:hover:bg-zinc-900 group {{ request()->routeIs('menu.*') ? 'text-orange-600' : 'text-zinc-500 dark:text-zinc-400' }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter">Menu</span>
        </a>

        <!-- My Orders -->
        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex flex-col items-center justify-center px-5 hover:bg-zinc-50 dark:hover:bg-zinc-900 group {{ request()->routeIs('dashboard') ? 'text-orange-600' : 'text-zinc-500 dark:text-zinc-400' }}">
            <svg class="w-6 h-6 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.659-.414 1.243-1.074 1.243H4.204c-.66 0-1.144-.584-1.074-1.243l1.263-12c.07-.659.591-1.157 1.256-1.157h12.654c.665 0 1.186.498 1.256 1.157z" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter">Orders</span>
        </a>
    </div>
</div>
