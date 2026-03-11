<div>
    @if($open)
        <div
            x-data="{}"
            x-show="{{ $open }}"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            style="display: none;"
        >
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    x-show="{{ $open }}"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden rounded-xl bg-white dark:bg-zinc-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                    @click.away="{{ $close }}"
                >
                    <div class="flex items-center justify-between px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white">
                            {{ $title }}
                        </h3>
                        <button
                            type="button"
                            wire:click="{{ $close }}"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <div
            x-show="{{ $open }}"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
            style="display: none;"
        ></div>
    @endif
</div>
