<div @if($order->status->isActive()) wire:poll.10s @endif>
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors" wire:navigate>
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Pesanan
        </a>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Detail Pesanan</h1>
            <p class="text-sm font-mono text-orange-600 mt-1">#{{ $order->order_number }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold uppercase tracking-wider rounded-full bg-{{ $order->status->color() }}-100 text-{{ $order->status->color() }}-700 dark:bg-{{ $order->status->color() }}-900/30 dark:text-{{ $order->status->color() }}-400">
                {{ $order->status->label() }}
            </span>
            @if($order->status->isActive())
                <span class="flex items-center gap-1 text-[10px] text-zinc-400 dark:text-zinc-500">
                    <span class="relative flex size-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex size-2 rounded-full bg-green-500"></span>
                    </span>
                    Live
                </span>
            @endif
        </div>
    </div>

    {{-- Status Description --}}
    <div class="bg-{{ $order->status->color() }}-50 dark:bg-{{ $order->status->color() }}-900/10 border border-{{ $order->status->color() }}-200 dark:border-{{ $order->status->color() }}-800/30 rounded-xl p-4 mb-8">
        <p class="text-sm font-medium text-{{ $order->status->color() }}-800 dark:text-{{ $order->status->color() }}-300">{{ $order->status->description() }}</p>
    </div>

    {{-- Status Timeline --}}
    @if($order->status_timeline_position >= 0)
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 mb-6">
            <h2 class="text-sm font-bold text-zinc-900 dark:text-white uppercase tracking-wider mb-6">Status Pesanan</h2>
            <div class="relative">
                {{-- Progress Line --}}
                <div class="absolute left-[15px] top-0 bottom-0 w-0.5 bg-zinc-200 dark:bg-zinc-700"></div>
                @if($currentPosition > 0)
                    <div class="absolute left-[15px] top-0 w-0.5 bg-orange-500 transition-all duration-700" style="height: {{ ($currentPosition / (count($timelineSteps) - 1)) * 100 }}%"></div>
                @endif

                {{-- Steps --}}
                <div class="space-y-6">
                    @foreach($timelineSteps as $index => $step)
                        @php
                            $isCompleted = $index < $currentPosition;
                            $isCurrent = $index === $currentPosition;
                            $isPending = $index > $currentPosition;
                        @endphp
                        <div class="relative flex items-start gap-4 {{ $isPending ? 'opacity-40' : '' }}">
                            {{-- Dot --}}
                            <div class="relative z-10 flex items-center justify-center shrink-0">
                                @if($isCompleted)
                                    <div class="size-8 rounded-full bg-orange-500 flex items-center justify-center">
                                        <svg class="size-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @elseif($isCurrent)
                                    <div class="size-8 rounded-full bg-orange-500 flex items-center justify-center ring-4 ring-orange-100 dark:ring-orange-900/30">
                                        <div class="size-3 rounded-full bg-white animate-pulse"></div>
                                    </div>
                                @else
                                    <div class="size-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                        <div class="size-2.5 rounded-full bg-zinc-300 dark:bg-zinc-600"></div>
                                    </div>
                                @endif
                            </div>

                            {{-- Text --}}
                            <div class="pt-1">
                                <p class="text-sm font-bold {{ $isCurrent ? 'text-orange-600' : ($isCompleted ? 'text-zinc-900 dark:text-white' : 'text-zinc-400') }}">
                                    {{ $step->label() }}
                                </p>
                                @if($isCurrent)
                                    <p class="text-xs text-zinc-500 mt-0.5">{{ $step->description() }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Cancelled/Failed Banner --}}
    @if(in_array($order->status, [\App\Enums\OrderStatus::Cancelled, \App\Enums\OrderStatus::Failed]))
        <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-xl p-6 mb-6 text-center">
            <svg class="size-12 mx-auto text-red-300 dark:text-red-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-bold text-red-800 dark:text-red-300">{{ $order->status->label() }}</p>
            <p class="text-xs text-red-600 dark:text-red-400 mt-1">{{ $order->status->description() }}</p>
        </div>
    @endif

    {{-- Order Items --}}
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
            <h2 class="text-sm font-bold text-zinc-900 dark:text-white uppercase tracking-wider">Item Pesanan</h2>
        </div>
        <div class="divide-y divide-zinc-100 dark:divide-zinc-700">
            @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $item->menuItem->name }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                            {{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </p>
                    </div>
                    <p class="text-sm font-bold text-zinc-900 dark:text-white shrink-0">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Notes --}}
    @if($order->notes)
        <div class="bg-orange-50 dark:bg-orange-900/10 border border-orange-200 dark:border-orange-800/30 rounded-xl p-4 mb-6">
            <p class="text-[10px] font-bold text-orange-800 dark:text-orange-400 uppercase tracking-wider mb-1">Catatan</p>
            <p class="text-sm text-orange-700 dark:text-orange-300">{{ $order->notes }}</p>
        </div>
    @endif

    {{-- Order Summary --}}
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <h2 class="text-sm font-bold text-zinc-900 dark:text-white uppercase tracking-wider mb-4">Ringkasan</h2>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->delivery_fee > 0)
                <div class="flex justify-between text-zinc-600 dark:text-zinc-400">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($order->discount_amount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Diskon</span>
                    <span>-Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex justify-between items-center pt-3 border-t border-zinc-200 dark:border-zinc-700">
                <span class="text-base font-bold text-zinc-900 dark:text-white">Total</span>
                <span class="text-xl font-black text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Meta Info --}}
        <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-700 grid grid-cols-2 gap-3 text-xs text-zinc-500 dark:text-zinc-400">
            <div>
                <p class="font-semibold text-zinc-400 uppercase tracking-wider mb-0.5">Tipe</p>
                <p class="font-medium text-zinc-700 dark:text-zinc-300">{{ $order->type->label() }}</p>
            </div>
            @if($order->table)
                <div>
                    <p class="font-semibold text-zinc-400 uppercase tracking-wider mb-0.5">Meja</p>
                    <p class="font-medium text-zinc-700 dark:text-zinc-300">Meja {{ $order->table->number }}</p>
                </div>
            @endif
            <div>
                <p class="font-semibold text-zinc-400 uppercase tracking-wider mb-0.5">Waktu Pesan</p>
                <p class="font-medium text-zinc-700 dark:text-zinc-300">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>
