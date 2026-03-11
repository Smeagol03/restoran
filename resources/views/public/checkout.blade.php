<x-layouts.public>
    <div class="py-12 bg-zinc-50 dark:bg-zinc-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('menu.index') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700 flex items-center gap-1 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Menu
                </a>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Checkout</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Selesaikan pesanan Anda dan konfirmasi via WhatsApp.</p>
            </div>
            
            <livewire:public.checkout-form />
        </div>
    </div>
</x-layouts.public>

