<x-layouts.public>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="mb-12">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Menu Kami</h1>
            <p class="text-lg text-zinc-500 dark:text-zinc-400">Temukan hidangan favorit Anda dan pesan langsung melalui WhatsApp.</p>
        </div>

        {{-- Category Tabs --}}
        @if ($categories->isEmpty())
            <x-empty-state
                title="Menu Belum Tersedia"
                description="Kami sedang menyiapkan hidangan terbaik untuk Anda. Silakan kembali lagi beberapa saat lagi!"
                action-label="Kembali ke Beranda"
                action-url="{{ route('home') }}"
            />
        @else
            <div x-data="{ activeTab: 'all' }" class="space-y-8">
                <div class="flex flex-wrap gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-4 overflow-x-auto">
                    <button
                        @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
                    >
                        Semua
                    </button>
                    @foreach ($categories as $category)
                        <button
                            @click="activeTab = '{{ $category->slug }}'"
                            :class="activeTab === '{{ $category->slug }}' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-colors whitespace-nowrap"
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                {{-- All items tab --}}
                <div x-show="activeTab === 'all'" x-transition>
                    @php
                        $hasAnyItems = $categories->pluck('menuItems')->flatten()->isNotEmpty();
                    @endphp

                    @if ($hasAnyItems)
                        <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($categories as $category)
                                @foreach ($category->menuItems as $item)
                                    <x-menu-card :item="$item" />
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <x-empty-state
                            title="Menu Kosong"
                            description="Belum ada hidangan yang tersedia untuk saat ini."
                        />
                    @endif
                </div>

                {{-- Per-category tabs --}}
                @foreach ($categories as $category)
                    <div x-show="activeTab === '{{ $category->slug }}'" x-transition>
                        @if ($category->menuItems->isNotEmpty())
                            <div class="grid grid-cols-1 gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($category->menuItems as $item)
                                    <x-menu-card :item="$item" />
                                @endforeach
                            </div>
                        @else
                            <x-empty-state
                                title="Kategori Kosong"
                                description="Belum ada hidangan dalam kategori {{ $category->name }}."
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.public>
