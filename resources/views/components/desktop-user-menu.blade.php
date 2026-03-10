{{-- This component is no longer needed since the sidebar layout has the user menu built-in --}}
{{-- Kept for backwards compatibility in case it's referenced elsewhere --}}
<div {{ $attributes }} x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-xs font-bold dark:bg-zinc-700 dark:text-white">{{ auth()->user()->initials() }}</span>
        <span class="flex-1 truncate text-start text-sm font-medium text-zinc-900 dark:text-white">{{ auth()->user()->name }}</span>
        <svg class="h-4 w-4 text-zinc-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </button>
    <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full mb-1 inset-s-0 w-full rounded-lg border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-800" style="display: none;">
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
