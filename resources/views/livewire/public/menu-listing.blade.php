<div>
    {{-- Search and Filter - Sticky Header --}}
    <div class="sticky top-16 z-30 -mx-6 px-6 py-4 bg-white/80 dark:bg-black/80 backdrop-blur-md border-b border-zinc-100 dark:border-zinc-800 mb-10 transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-4">
            <div class="relative max-w-md mx-auto md:mx-0">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="size-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="Cari menu favorit..." 
                    class="w-full pl-9 pr-4 py-2.5 rounded-xl border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 text-sm text-zinc-900 dark:text-white focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 shadow-sm transition-all"
                >
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-hide -mx-2 px-2 mask-fade-right">
                <button
                    wire:click="setCategory('all')"
                    class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap {{ $activeCategory === 'all' ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20 scale-105' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-900 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                >
                    Semua
                </button>
                @foreach ($categories as $category)
                    <button
                        wire:click="setCategory('{{ $category->slug }}')"
                        class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest transition-all whitespace-nowrap {{ $activeCategory === $category->slug ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20 scale-105' : 'bg-zinc-100 text-zinc-500 dark:bg-zinc-900 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-800' }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Menu Grid - 1 Column on Mobile --}}
    <div wire:loading.class="opacity-50" class="transition-opacity duration-300">
        @if ($menuItems->isNotEmpty())
            <div class="grid grid-cols-1 gap-y-12 sm:grid-cols-2 lg:grid-cols-3 sm:gap-x-8">
                @foreach ($menuItems as $item)
                    <x-menu-card :item="$item" :wire:key="'menu-item-'.$item->id" />
                @endforeach
            </div>
        @else
            <div class="py-20">
                <x-empty-state
                    title="Menu Tidak Ditemukan"
                    description="{{ $search ? 'Tidak ada hidangan yang cocok dengan kata kunci ' . $search : 'Belum ada hidangan yang tersedia untuk saat ini.' }}"
                    action-label="Reset Filter"
                    action-url="javascript:window.location.reload()"
                />
            </div>
        @endif
    </div>
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    .mask-fade-right { mask-image: linear-gradient(to right, black 85%, transparent 100%); }
</style>
