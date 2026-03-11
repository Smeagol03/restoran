<div class="space-y-6">
    {{-- Tab Switcher --}}
    <div class="flex gap-2">
        <button
            wire:click="$set('tab', 'active')"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl transition-all {{ $tab === 'active' ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/25' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:border-orange-300 dark:hover:border-orange-700' }}"
        >
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Aktif
            @if($activeCount > 0)
                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full {{ $tab === 'active' ? 'bg-white/20 text-white' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' }}">{{ $activeCount }}</span>
            @endif
        </button>
        <button
            wire:click="$set('tab', 'completed')"
            class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-xl transition-all {{ $tab === 'completed' ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/25' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:border-orange-300 dark:hover:border-orange-700' }}"
        >
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Riwayat
            @if($completedCount > 0)
                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full {{ $tab === 'completed' ? 'bg-white/20 text-white' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400' }}">{{ $completedCount }}</span>
            @endif
        </button>
    </div>

    {{-- Order Cards --}}
    <div class="space-y-4" wire:loading.class="opacity-50" wire:target="tab">
        @forelse($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block group" wire:navigate wire:key="order-{{ $order->id }}">
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 transition-all hover:border-orange-300 dark:hover:border-orange-600 hover:shadow-md hover:shadow-orange-600/5">
                    <div class="flex items-start justify-between gap-4">
                        {{-- Left: Order Info --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-mono text-sm font-bold text-orange-600">#{{ $order->order_number }}</span>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-{{ $order->status->color() }}-100 text-{{ $order->status->color() }}-700 dark:bg-{{ $order->status->color() }}-900/30 dark:text-{{ $order->status->color() }}-400">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                                {{ $order->created_at->translatedFormat('d F Y, H:i') }} · {{ $order->type->label() }}
                            </p>

                            {{-- Items Preview --}}
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($order->items->take(3) as $item)
                                    <span class="px-2 py-1 text-[11px] font-medium rounded-lg bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300">
                                        {{ $item->menuItem->name }} <span class="text-zinc-400">×{{ $item->quantity }}</span>
                                    </span>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <span class="px-2 py-1 text-[11px] font-medium rounded-lg bg-zinc-100 dark:bg-zinc-700 text-zinc-400">
                                        +{{ $order->items->count() - 3 }} lainnya
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Total + Arrow --}}
                        <div class="text-right flex flex-col items-end gap-2 shrink-0">
                            <p class="text-lg font-black text-zinc-900 dark:text-white">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            <span class="text-zinc-300 dark:text-zinc-600 group-hover:text-orange-500 transition-colors">
                                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Progress Bar (only for active) --}}
                    @if($order->status->isActive())
                        <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-700">
                            <div class="flex items-center justify-between text-[10px] font-semibold text-zinc-400 mb-1.5">
                                <span>{{ $order->status->description() }}</span>
                                <span>{{ $order->status->progressPercentage() }}%</span>
                            </div>
                            <div class="h-1.5 bg-zinc-100 dark:bg-zinc-700 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $order->status->color() }}-500 rounded-full transition-all duration-500" style="width: {{ $order->status->progressPercentage() }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-12 text-center">
                @if($tab === 'active')
                    <svg class="size-16 mx-auto text-zinc-200 dark:text-zinc-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <p class="text-zinc-600 dark:text-zinc-400 font-medium mb-1">Belum ada pesanan aktif</p>
                    <p class="text-sm text-zinc-400 dark:text-zinc-500 mb-4">Pesanan yang sedang diproses akan muncul di sini.</p>
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-600 text-white text-sm font-semibold rounded-xl hover:bg-orange-700 transition-colors shadow-lg shadow-orange-600/25" wire:navigate>
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Pesan Sekarang
                    </a>
                @else
                    <svg class="size-16 mx-auto text-zinc-200 dark:text-zinc-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-zinc-600 dark:text-zinc-400 font-medium mb-1">Belum ada riwayat pesanan</p>
                    <p class="text-sm text-zinc-400 dark:text-zinc-500">Pesanan yang sudah selesai akan muncul di sini.</p>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
