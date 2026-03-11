<x-layouts.public>
    <div class="py-12 bg-zinc-50 dark:bg-zinc-950 min-h-screen">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Riwayat Pesanan Saya</h1>
                <p class="text-zinc-500 dark:text-zinc-400">Pantau status pesanan yang pernah Anda buat.</p>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-zinc-200 dark:text-zinc-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="text-zinc-600 dark:text-zinc-400">Anda belum memiliki riwayat pesanan.</p>
                <a href="{{ route('menu.index') }}" class="mt-4 inline-block px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    Mulai Belanja
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
