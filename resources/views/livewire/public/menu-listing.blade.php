<div>
    {{-- Search and Filter --}}
    <div class="mb-12 space-y-6">
        <div class="relative max-w-md mx-auto md:mx-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="size-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input 
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Cari menu favorit Anda..." 
                class="w-full pl-10 pr-4 py-3 rounded-xl border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-orange-500 focus:border-orange-500 shadow-sm transition-all"
            >
        </div>

        <div class="flex flex-wrap gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-4 overflow-x-auto scrollbar-hide">
            <button
                wire:click="setCategory('all')"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ $activeCategory === 'all' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
            >
                Semua
            </button>
            @foreach ($categories as $category)
                <button
                    wire:click="setCategory('{{ $category->slug }}')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap {{ $activeCategory === $category->slug ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700' }}"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Menu Grid --}}
    <div wire:loading.class="opacity-50" class="transition-opacity">
        @if ($menuItems->isNotEmpty())
            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($menuItems as $item)
                    <x-menu-card :item="$item" :wire:key="'menu-item-'.$item->id" />
                @endforeach
            </div>
        @else
            <x-empty-state
                title="Menu Tidak Ditemukan"
                description="{{ $search ? 'Tidak ada hidangan yang cocok dengan kata kunci ' . $search : 'Belum ada hidangan yang tersedia untuk saat ini.' }}"
            />
        @endif
    </div>
</div>
