<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Daftar Pesanan</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Kelola dan pantau status pesanan pelanggan.</p>
        </div>

        <div class="flex flex-col md:flex-row items-center gap-3">
            <div class="w-full md:w-64">
                <x-input type="text" wire:model.live="search" placeholder="Cari nomor pesanan atau nama..." />
            </div>

            <div class="flex items-center gap-3">
                <x-select wire:model.live="statusFilter" id="statusFilter" class="w-40 py-2 text-xs font-bold uppercase">
                    <option value="">Semua</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Order Table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">ID Pesanan</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Tipe / Meja</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($orders as $order)
                        <tr class="text-zinc-900 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-medium text-orange-600">#{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-semibold">{{ $order->user->name ?? 'Guest' }}</div>
                                <div class="text-[10px] text-zinc-500">{{ $order->user->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->type->value === 'dine_in' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                    {{ $order->type->label() }}
                                </span>
                                @if($order->table)
                                    <span class="ml-1 text-xs font-bold text-zinc-600">Meja {{ $order->table->number }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-emerald-600"><x-currency :value="$order->total" /></td>
                            <td class="px-6 py-4">
                                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)" class="text-xs font-bold uppercase rounded-lg border-zinc-200 dark:border-zinc-700 bg-{{ $order->status->color() }}-50 text-{{ $order->status->color() }}-700 dark:bg-{{ $order->status->color() }}-900/30 dark:text-{{ $order->status->color() }}-400 focus:ring-0">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->value }}" {{ $order->status === $status ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4 text-zinc-500 whitespace-nowrap">{{ $order->created_at->format('d M, H:i') }}</td>
                            <td class="px-6 py-4 flex items-center gap-2">
                                <button wire:click="showDetails({{ $order->id }})" class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors" title="Lihat Detail">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="text-zinc-400 hover:text-orange-600 transition-colors" title="Cetak Struk">
                                    <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-zinc-500">
                                <svg class="size-12 mx-auto text-zinc-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Tidak ada pesanan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Detail Modal --}}
    @if($selectedOrder)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/50 backdrop-blur-sm">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-2xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/50">
                    <div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Detail Pesanan</h2>
                        <span class="text-xs font-mono text-zinc-500">#{{ $selectedOrder->order_number }}</span>
                    </div>
                    <button wire:click="closeDetails" class="p-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                    {{-- Customer Info --}}
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-zinc-500">Pelanggan</p>
                            <p class="font-bold text-zinc-900 dark:text-white">{{ $selectedOrder->user->name ?? 'Guest' }}</p>
                        </div>
                        <div>
                            <p class="text-zinc-500">Tipe / Meja</p>
                            <p class="font-bold text-zinc-900 dark:text-white">{{ $selectedOrder->type->label() }} {{ $selectedOrder->table ? '- Meja '.$selectedOrder->table->number : '' }}</p>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div>
                        <p class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Item Pesanan</p>
                        <div class="space-y-3">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex justify-between items-center text-sm border-b border-zinc-100 dark:border-zinc-800 pb-2">
                                    <div class="flex-1">
                                        <p class="font-medium text-zinc-900 dark:text-white">{{ $item->menuItem->name }}</p>
                                        <p class="text-xs text-zinc-500">{{ $item->quantity }} x <x-currency :value="$item->unit_price" /></p>
                                    </div>
                                    <p class="font-bold text-zinc-900 dark:text-white"><x-currency :value="$item->subtotal" /></p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($selectedOrder->notes)
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-xl border border-orange-100 dark:border-orange-800">
                            <p class="text-xs font-bold text-orange-800 dark:text-orange-400 uppercase tracking-wider mb-1">Catatan:</p>
                            <p class="text-sm text-orange-700 dark:text-orange-300">{{ $selectedOrder->notes }}</p>
                        </div>
                    @endif

                    <div class="flex justify-between items-center pt-4 border-t border-zinc-200 dark:border-zinc-800">
                        <span class="text-base font-bold text-zinc-900 dark:text-white">Total</span>
                        <span class="text-xl font-black text-emerald-600"><x-currency :value="$selectedOrder->total" /></span>
                    </div>
                </div>

                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-800 text-center">
                    <x-button variant="ghost" wire:click="closeDetails" class="w-full">Tutup Detail</x-button>
                </div>
            </div>
        </div>
    @endif
</div>
