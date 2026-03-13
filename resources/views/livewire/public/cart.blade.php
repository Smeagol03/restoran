<div>
    @if($mode === 'inline')
        {{-- Inline Mode for Checkout --}}
        <div class="space-y-6">
            @if(count($items) > 0)
                <ul class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($items as $id => $item)
                        <li class="flex py-4 group">
                            <div class="flex-1 space-y-1">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-black uppercase tracking-tight text-zinc-900 dark:text-white">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="ml-4 font-black text-zinc-900 dark:text-white uppercase text-sm"><x-currency :value="$item['subtotal']" /></p>
                                </div>
                                <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-zinc-400">
                                    <span>@ <x-currency :value="$item['unit_price']" /></span>
                                    
                                    <div class="flex items-center gap-3 bg-white dark:bg-zinc-950 px-2 py-1 rounded-full border border-zinc-100 dark:border-zinc-800">
                                        <button type="button" wire:click="decrement({{ $id }})" class="hover:text-orange-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" /></svg>
                                        </button>
                                        <span class="text-zinc-900 dark:text-white min-w-[10px] text-center">{{ $item['quantity'] }}</span>
                                        <button type="button" wire:click="increment({{ $id }})" class="hover:text-orange-600 transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="pt-6 border-t border-zinc-200 dark:border-zinc-800 flex justify-between items-end">
                    <span class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Total Pembayaran</span>
                    <span class="text-2xl font-black text-orange-600 tracking-tighter italic uppercase"><x-currency :value="$subtotal" /></span>
                </div>
            @else
                <div class="py-10 text-center opacity-40">
                    <p class="text-xs font-black uppercase tracking-widest text-zinc-500">Keranjang kosong</p>
                </div>
            @endif
        </div>
    @else
        {{-- Drawer Mode --}}
        <div class="relative inline-block" x-data="{ open: false, animating: false }" @item-added.window="animating = true; setTimeout(() => animating = false, 300)">
            <button
                type="button"
                x-on:click="open = true"
                :class="animating ? 'text-orange-600 scale-125' : 'text-zinc-600 dark:text-zinc-400'"
                class="relative p-2 transition-all duration-300 hover:text-orange-600 focus:outline-none bg-zinc-100 dark:bg-zinc-800 rounded-full"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>

                @if($count > 0)
                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-[10px] font-black text-white bg-orange-600 rounded-full border-2 border-white dark:border-zinc-900 shadow-sm">
                        {{ $count }}
                    </span>
                @endif
            </button>

            {{-- Slide-over Drawer --}}
            <template x-teleport="body">
                <div
                    x-show="open"
                    class="fixed inset-0 z-[100] overflow-hidden"
                    style="display: none;"
                >
                    {{-- Backdrop --}}
                    <div 
                        x-show="open"
                        x-transition:enter="ease-in-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 bg-zinc-900/60 backdrop-blur-sm transition-opacity" 
                        @click="open = false"
                    ></div>

                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div 
                            x-show="open"
                            x-transition:enter="transform transition ease-in-out duration-500"
                            x-transition:enter-start="translate-x-full"
                            x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-500"
                            x-transition:leave-start="translate-x-0"
                            x-transition:leave-end="translate-x-full"
                            class="w-screen max-w-md"
                        >
                            <div class="flex h-full flex-col bg-white dark:bg-zinc-950 shadow-2xl">
                                <div class="flex-1 overflow-y-auto px-6 py-8">
                                    <div class="flex items-start justify-between mb-10">
                                        <h2 class="text-2xl font-black uppercase tracking-tighter text-zinc-900 dark:text-white">
                                            Pesanan Anda
                                        </h2>
                                        <button @click="open = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>

                                    @if(count($items) > 0)
                                        <div class="flow-root">
                                            <ul class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                @foreach($items as $id => $item)
                                                    <li class="flex py-6 group">
                                                        <div class="flex-1 space-y-1">
                                                            <div class="flex justify-between">
                                                                <h3 class="text-base font-black uppercase tracking-tight text-zinc-900 dark:text-white group-hover:text-orange-600 transition-colors">
                                                                    {{ $item['name'] }}
                                                                </h3>
                                                                <p class="ml-4 font-black text-zinc-900 dark:text-white uppercase"><x-currency :value="$item['subtotal']" /></p>
                                                            </div>
                                                            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-widest text-zinc-400">
                                                                <span>@ <x-currency :value="$item['unit_price']" /></span>
                                                                
                                                                <div class="flex items-center gap-4 bg-zinc-50 dark:bg-zinc-900 px-3 py-1.5 rounded-full">
                                                                    <button type="button" wire:click="decrement({{ $id }})" class="hover:text-orange-600 transition-colors">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" /></svg>
                                                                    </button>
                                                                    <span class="text-zinc-900 dark:text-white min-w-[12px] text-center">{{ $item['quantity'] }}</span>
                                                                    <button type="button" wire:click="increment({{ $id }})" class="hover:text-orange-600 transition-colors">
                                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" wire:click="remove({{ $id }})" class="ml-4 text-zinc-300 hover:text-red-500 transition-colors p-2 self-start">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center py-32 text-center opacity-40">
                                            <svg class="w-20 h-20 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                            <p class="text-sm font-black uppercase tracking-widest">Belum ada hidangan</p>
                                        </div>
                                    @endif
                                </div>

                                @if(count($items) > 0)
                                    <div class="border-t border-zinc-100 dark:border-zinc-800 px-6 py-8 space-y-6">
                                        <div class="flex justify-between items-end">
                                            <span class="text-xs font-black uppercase tracking-widest text-zinc-400">Total Harga</span>
                                            <span class="text-3xl font-black text-zinc-900 dark:text-white uppercase tracking-tighter"><x-currency :value="$subtotal" /></span>
                                        </div>
                                        <a href="{{ route('checkout') }}" 
                                           class="flex w-full items-center justify-center bg-orange-600 hover:bg-black text-white px-8 py-5 text-lg font-black uppercase tracking-widest transition-all shadow-xl shadow-orange-600/20"
                                           wire:navigate>
                                            Selesaikan Pesanan &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Toast Notification --}}
            <template x-teleport="body">
                <div
                    x-data="{ show: false, message: '' }"
                    @item-added.window="
                        message = 'Item ditambahkan ke keranjang';
                        show = true;
                        setTimeout(() => show = false, 3000);
                    "
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 -translate-y-4 sm:scale-95"
                    class="fixed top-24 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-zinc-900 border border-zinc-800 text-white dark:bg-white dark:text-zinc-900 px-4 py-3 rounded-xl shadow-2xl"
                    style="display: none;"
                >
                    <div class="shrink-0 bg-emerald-500/20 text-emerald-500 dark:text-emerald-600 rounded-full p-1">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium" x-text="message"></p>
                </div>
            </template>
        </div>
    @endif
</div>
