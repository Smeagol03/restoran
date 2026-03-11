<div class="grid grid-cols-1 lg:grid-cols-2 gap-8" x-data="{ checkoutSuccess: false }" @cart-updated.window="checkoutSuccess = true">
    {{-- Form Section --}}
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm">
        <h2 class="text-xl font-bold text-zinc-900 dark:text-white mb-6">Informasi Pesanan</h2>

        <form wire:submit="checkout" class="space-y-6">
            {{-- Order Type --}}
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Tipe Pesanan</label>
                <div class="grid grid-cols-2 gap-4">
                    <button
                        type="button"
                        wire:click="$set('type', 'dine_in')"
                        class="flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all {{ $type === 'dine_in' ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-zinc-100 bg-zinc-50 text-zinc-500 hover:border-zinc-200' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold">Makan di Tempat</span>
                    </button>

                    <button
                        type="button"
                        wire:click="$set('type', 'delivery')"
                        class="flex flex-col items-center justify-center p-4 rounded-xl border-2 transition-all {{ $type === 'delivery' ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-zinc-100 bg-zinc-50 text-zinc-500 hover:border-zinc-200' }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-sm font-semibold">Pesan Antar</span>
                    </button>
                </div>
                @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Table Selection (Dine In only) --}}
            @if($type === 'dine_in')
                <div>
                    <label for="table_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Pilih Nomor Meja</label>
                    <select
                        wire:model="table_id"
                        id="table_id"
                        class="w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-orange-500 focus:border-orange-500"
                    >
                        <option value="">-- Pilih Meja --</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">Meja {{ $table->number }} (Kapasitas: {{ $table->capacity }})</option>
                        @endforeach
                    </select>
                    @error('table_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            @endif

            {{-- Notes --}}
            <div>
                <label for="notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea
                    wire:model="notes"
                    id="notes"
                    rows="3"
                    placeholder="Contoh: Jangan terlalu pedas, tambah sendok, dll."
                    class="w-full rounded-lg border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-orange-500 focus:border-orange-500"
                ></textarea>
                @error('notes') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            @error('cart') <div class="p-3 bg-red-50 text-red-600 rounded-lg text-sm">{{ $message }}</div> @enderror

            <button
                type="submit"
                class="w-full py-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-colors flex items-center justify-center gap-2 shadow-lg shadow-orange-200 dark:shadow-none"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Pesan via WhatsApp
            </button>
        </form>
    </div>

    {{-- Order Summary Section --}}
    <div class="space-y-6">
        <livewire:public.cart />

        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-xl p-6">
            <h3 class="flex items-center gap-2 text-blue-800 dark:text-blue-300 font-semibold mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Info Pembayaran
            </h3>
            <p class="text-sm text-blue-700 dark:text-blue-400">
                Saat ini kami hanya melayani pembayaran melalui WhatsApp (Transfer/Cash). Klik tombol "Pesan via WhatsApp" untuk mengirim rincian pesanan ke admin kami.
            </p>
        </div>
    </div>
</div>
