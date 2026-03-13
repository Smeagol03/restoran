<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12" x-data="{ checkoutSuccess: false }" @cart-updated.window="checkoutSuccess = true">
    {{-- Order Summary Section (First on mobile, second on desktop) --}}
    <div class="space-y-8 lg:order-2 lg:col-span-1">
        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl p-8 border border-zinc-100 dark:border-zinc-800">
            <h2 class="text-2xl font-black uppercase tracking-tighter text-zinc-900 dark:text-white mb-8 border-b border-zinc-200 dark:border-zinc-800 pb-4">
                Rincian Pesanan
            </h2>
            
            <livewire:public.cart mode="inline" />

            <div class="mt-8 pt-8 border-t border-zinc-200 dark:border-zinc-800 space-y-4">
                <div class="bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/50 rounded-2xl p-6">
                    <h3 class="flex items-center gap-3 text-blue-800 dark:text-blue-300 font-black uppercase tracking-widest text-[10px] mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Metode Pembayaran
                    </h3>
                    <p class="text-xs font-bold leading-relaxed text-blue-700/80 dark:text-blue-400/80">
                        Kami memproses pembayaran melalui WhatsApp (Transfer/Tunai). Detail instruksi akan dikirimkan otomatis ke chat admin.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Section (Second on mobile, first on desktop) --}}
    <div class="lg:order-1 lg:col-span-2 space-y-8">
        <div class="bg-white dark:bg-zinc-950 rounded-3xl p-8 border border-zinc-100 dark:border-zinc-800 shadow-sm">
            <h2 class="text-2xl font-black uppercase tracking-tighter text-zinc-900 dark:text-white mb-10">
                Informasi Pengiriman
            </h2>

            <form wire:submit="checkout" class="space-y-10">
                {{-- Order Type --}}
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Tipe Layanan</label>
                    <div class="grid grid-cols-2 gap-4">
                        <button
                            type="button"
                            wire:click="$set('type', 'dine_in')"
                            class="group relative flex flex-col items-center justify-center p-6 rounded-2xl border-2 transition-all duration-300 {{ $type === 'dine_in' ? 'border-orange-600 bg-orange-50/50 dark:bg-orange-900/10 text-orange-600' : 'border-zinc-100 dark:border-zinc-900 bg-zinc-50 dark:bg-zinc-900/30 text-zinc-400 hover:border-zinc-200' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-3 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-xs font-black uppercase tracking-widest">Makan di Tempat</span>
                            @if($type === 'dine_in')
                                <div class="absolute -top-2 -right-2 bg-orange-600 text-white rounded-full p-1.5 shadow-lg"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                            @endif
                        </button>

                        <button
                            type="button"
                            wire:click="$set('type', 'delivery')"
                            class="group relative flex flex-col items-center justify-center p-6 rounded-2xl border-2 transition-all duration-300 {{ $type === 'delivery' ? 'border-orange-600 bg-orange-50/50 dark:bg-orange-900/10 text-orange-600' : 'border-zinc-100 dark:border-zinc-900 bg-zinc-50 dark:bg-zinc-900/30 text-zinc-400 hover:border-zinc-200' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-3 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-xs font-black uppercase tracking-widest">Pesan Antar</span>
                            @if($type === 'delivery')
                                <div class="absolute -top-2 -right-2 bg-orange-600 text-white rounded-full p-1.5 shadow-lg"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></div>
                            @endif
                        </button>
                    </div>
                    <x-error :messages="$errors->get('type')" />
                </div>

                {{-- Booking Time & Table Selection (Dine In only) --}}
                @if($type === 'dine_in')
                    <div class="space-y-10 animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="space-y-4">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Waktu Kedatangan</label>
                            <x-input
                                type="datetime-local"
                                wire:model.live="reservation_time"
                                id="reservation_time"
                                class="rounded-2xl border-2 border-zinc-100 dark:border-zinc-800 focus:border-orange-600 transition-colors p-4"
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                            />
                            <p class="text-[10px] font-bold text-zinc-400 italic">Biarkan kosong jika datang sekarang.</p>
                        </div>

                        <div class="space-y-6">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Pilih Meja</label>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-4">
                                @foreach($tables as $table)
                                    @php $isOccupied = !$table->is_available_now; @endphp
                                    <button 
                                        type="button"
                                        @if($isOccupied) disabled @else wire:click="$set('table_id', {{ $table->id }})" @endif
                                        class="relative aspect-square rounded-2xl border-2 flex flex-col items-center justify-center transition-all duration-300
                                        {{ $table_id == $table->id 
                                            ? 'border-orange-600 bg-orange-600 text-white shadow-xl shadow-orange-600/30' 
                                            : ($isOccupied 
                                                ? 'border-zinc-100 bg-zinc-50 text-zinc-200 cursor-not-allowed' 
                                                : 'border-zinc-100 bg-white text-zinc-600 hover:border-orange-200 hover:bg-orange-50/50 dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400') 
                                        }}"
                                    >
                                        <span class="text-xl font-black">{{ $table->number }}</span>
                                        <span class="text-[8px] font-black uppercase tracking-tighter opacity-60">{{ $table->capacity }} Kursi</span>

                                        @if($isOccupied)
                                            <span class="absolute bottom-2 text-[7px] font-black uppercase text-rose-500">Terisi</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                            <x-error :messages="$errors->get('table_id')" />
                        </div>
                    </div>
                @endif

                {{-- Notes --}}
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500">Instruksi Khusus</label>
                    <x-textarea
                        wire:model="notes"
                        id="notes"
                        rows="4"
                        class="rounded-2xl border-2 border-zinc-100 dark:border-zinc-800 focus:border-orange-600 transition-colors p-4"
                        placeholder="Contoh: Jangan pedas, tanpa seledri, atau instruksi alamat pengiriman..."
                    ></x-textarea>
                    <x-error :messages="$errors->get('notes')" />
                </div>

                @error('cart') <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl text-xs font-bold uppercase tracking-widest border border-rose-100">{{ $message }}</div> @enderror

                <button
                    type="submit"
                    class="group w-full py-6 bg-orange-600 hover:bg-black text-white text-lg font-black uppercase tracking-[0.2em] rounded-2xl transition-all duration-500 flex items-center justify-center gap-4 shadow-2xl shadow-orange-600/20"
                >
                    Konfirmasi Pesanan
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform group-hover:translate-x-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
