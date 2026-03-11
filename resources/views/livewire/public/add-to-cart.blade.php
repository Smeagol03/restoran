<div 
    x-data="{ added: false }" 
    x-on:item-added.window="if ($event.detail.id === {{ $menuItemId }}) { added = true; setTimeout(() => added = false, 2000) }"
>
    <button 
        wire:click="add" 
        :class="added ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100'"
        class="relative inline-flex items-center justify-center font-medium transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed px-3 py-1.5 text-sm rounded-md"
        :disabled="added"
    >
        <span x-show="!added" class="flex items-center gap-1">Tambah</span>
        <span x-show="added" style="display: none;" class="flex items-center gap-1">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Tersimpan
        </span>
        <span wire:loading wire:target="add" class="absolute inset-0 flex items-center justify-center bg-orange-600 rounded-md">
            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </span>
    </button>
</div>
