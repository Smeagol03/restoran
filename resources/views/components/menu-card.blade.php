@props(['item'])

<x-card class="flex flex-col gap-4 overflow-hidden group">
    <div class="aspect-video bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center relative rounded-lg group-hover:scale-105 transition-transform duration-300 overflow-hidden">
        <svg class="size-20 text-zinc-300 dark:text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg>
        @if($item->is_featured)
            <div class="absolute top-2 right-2">
                <x-badge color="yellow" variant="solid" size="sm">Favorit</x-badge>
            </div>
        @endif
    </div>

    <div class="flex-1">
        <div class="flex justify-between items-start mb-1">
            <h3 class="text-base font-semibold text-zinc-800 dark:text-white">{{ $item->name }}</h3>
        </div>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 mb-4">{{ $item->description }}</p>
        <div class="mt-auto">
            <span class="text-xl font-bold text-orange-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="flex gap-2 pt-4 border-t border-zinc-100 dark:border-zinc-700">
         <x-button variant="primary" class="flex-1">Tambah</x-button>
         <x-button variant="ghost">Detail</x-button>
    </div>
</x-card>
