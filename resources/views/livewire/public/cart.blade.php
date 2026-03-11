<div class="relative inline-block" x-data="{ open: false, animating: false }" @item-added.window="animating = true; setTimeout(() => animating = false, 300)">
    <button
        type="button"
        x-on:click="open = !open"
        :class="animating ? 'text-orange-600 scale-125' : 'text-zinc-600 dark:text-zinc-400'"
        class="relative p-2 transition-all duration-300 hover:text-orange-600 focus:outline-none"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>

        @if($count > 0)
            <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-orange-600 rounded-full border-2 border-white dark:border-zinc-900">
                {{ $count }}
            </span>
        @endif
    </button>

    <div
        x-show="open"
        x-on:click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 z-50 mt-2 origin-top-right bg-white dark:bg-zinc-800 rounded-lg shadow-xl w-80 ring-1 ring-black ring-opacity-5 overflow-hidden"
        style="display: none;"
    >
        <div class="p-4 border-b border-zinc-100 dark:border-zinc-700">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-white uppercase tracking-wider">Keranjang Belanja</h3>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @if(count($items) > 0)
                <ul class="divide-y divide-zinc-100 dark:divide-zinc-700">
                    @foreach($items as $id => $item)
                        <li class="flex items-center p-4 gap-3">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $item['name'] }}</h4>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400"><x-currency :value="$item['unit_price']" /></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="decrement({{ $id }})" class="p-1 text-zinc-400 hover:text-orange-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="text-xs font-bold text-zinc-900 dark:text-white w-4 text-center">{{ $item['quantity'] }}</span>
                                <button type="button" wire:click="increment({{ $id }})" class="p-1 text-zinc-400 hover:text-orange-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                                <button type="button" wire:click="remove({{ $id }})" class="p-1 ml-1 text-zinc-300 hover:text-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-zinc-200 dark:text-zinc-700 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Keranjang masih kosong</p>
                </div>
            @endif
        </div>

        @if(count($items) > 0)
            <div class="p-4 bg-zinc-50 dark:bg-zinc-900/50 border-t border-zinc-100 dark:border-zinc-700">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400 uppercase">Subtotal</span>
                    <span class="text-base font-black text-zinc-900 dark:text-white"><x-currency :value="$subtotal" /></span>
                </div>
                <a
                    href="{{ route('checkout') }}"
                    class="block w-full py-3 text-xs font-bold text-center text-white bg-zinc-900 hover:bg-zinc-800 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200 rounded-lg transition-all uppercase tracking-widest shadow-lg shadow-zinc-200 dark:shadow-none"
                    wire:navigate
                >
                    Lanjut Checkout
                </a>
            </div>
        @endif
    </div>

    {{-- Toast Notification --}}
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
</div>
