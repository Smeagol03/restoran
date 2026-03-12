<div class="space-y-6">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    {{-- Header & Stats Summary --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manajemen Meja</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Peta visual ketersediaan meja restoran.</p>
        </div>
        <x-button variant="primary" wire:click="create">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Meja
        </x-button>
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-zinc-600 dark:text-zinc-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-zinc-500 uppercase">Total Meja</p>
                <p class="text-xl font-black text-zinc-900 dark:text-white">{{ $totalTables }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-emerald-100 dark:border-emerald-900/30 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-emerald-600 uppercase">Tersedia</p>
                <p class="text-xl font-black text-emerald-700 dark:text-emerald-400">{{ $availableCount }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-zinc-900 p-4 rounded-xl border border-rose-100 dark:border-rose-900/30 shadow-sm flex items-center gap-4">
            <div class="p-3 bg-rose-100 dark:bg-rose-900/30 rounded-lg text-rose-600 dark:text-rose-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-rose-600 uppercase">Terisi</p>
                <p class="text-xl font-black text-rose-700 dark:text-rose-400">{{ $occupiedCount }}</p>
            </div>
        </div>
    </div>

    {{-- Search Filter --}}
    <div class="max-w-sm">
        <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nomor meja..." />
    </div>

    {{-- Visual Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($tables as $table)
            @php
                $activeOrder = $table->orders->first();
                $isOccupied = $table->status === 'occupied';
            @endphp
            <div 
                wire:key="table-{{ $table->id }}"
                wire:click="showDetails({{ $table->id }})"
                class="relative group cursor-pointer aspect-square rounded-2xl border-4 transition-all duration-300 flex flex-col items-center justify-center p-4 text-center
                {{ $isOccupied 
                    ? 'bg-rose-50 border-rose-500 text-rose-700 dark:bg-rose-950/20 dark:border-rose-800' 
                    : 'bg-emerald-50 border-emerald-500 text-emerald-700 dark:bg-emerald-950/20 dark:border-emerald-800' 
                }} 
                hover:scale-105 hover:shadow-lg"
            >
                <span class="text-3xl font-black mb-1">{{ $table->number }}</span>
                <span class="text-[10px] font-bold uppercase tracking-wider opacity-70">{{ $table->capacity }} Orang</span>
                
                @if($isOccupied && $activeOrder)
                    <div class="mt-2 px-2 py-1 bg-white/50 dark:bg-black/20 rounded-lg backdrop-blur-sm w-full truncate">
                        <p class="text-[10px] font-bold truncate">{{ $activeOrder->user->name ?? 'Guest' }}</p>
                    </div>
                @endif

                {{-- Action Overlay (Visible on Hover) --}}
                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center gap-2">
                    <!-- Icons will show on hover for quick actions if needed -->
                </div>
            </div>
        @endforeach
    </div>

    {{-- Modals (Store/Edit, QR, Detail) --}}
    
    {{-- Form Modal --}}
    @if($isCreating || $isEditing)
        <x-modal :open="$isCreating || $isEditing" title="{{ $isEditing ? 'Edit Meja' : 'Tambah Meja Baru' }}" close="cancel">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-5">
                <div>
                    <x-label for="number" value="Nomor/Nama Meja" />
                    <x-input type="text" id="number" wire:model="number" placeholder="Contoh: Meja 1 / VIP A" />
                    <x-error :messages="$errors->get('number')" />
                </div>
                <div>
                    <x-label for="capacity" value="Kapasitas (Orang)" />
                    <x-input type="number" id="capacity" wire:model="capacity" placeholder="Contoh: 4" min="1" />
                    <x-error :messages="$errors->get('capacity')" />
                </div>
                <div>
                    <x-label for="status" value="Status Manual" />
                    <x-select id="status" wire:model="status">
                        <option value="available">Tersedia (Emerald)</option>
                        <option value="occupied">Terisi (Rose)</option>
                    </x-select>
                    <x-error :messages="$errors->get('status')" />
                </div>
                <div class="flex gap-3 pt-4 justify-end border-t border-zinc-200 dark:border-zinc-800">
                    <x-button type="button" variant="ghost" wire:click="cancel">Batal</x-button>
                    <x-button type="submit">{{ $isEditing ? 'Simpan Perubahan' : 'Tambah Meja' }}</x-button>
                </div>
            </form>
        </x-modal>
    @endif

    {{-- Detail & Action Modal --}}
    @if($viewingTable)
        <x-modal :open="true" title="Meja {{ $viewingTable->number }}" close="closeDetails">
            <div class="space-y-6">
                {{-- Table Info Section --}}
                <div class="flex items-center justify-between p-4 rounded-xl {{ $viewingTable->status === 'occupied' ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                    <div>
                        <p class="text-xs font-bold uppercase opacity-70 tracking-widest">Status Meja</p>
                        <p class="text-lg font-black uppercase">{{ $viewingTable->status === 'occupied' ? 'Sedang Digunakan' : 'Meja Kosong' }}</p>
                    </div>
                    <button wire:click="toggleStatus({{ $viewingTable->id }})" class="px-4 py-2 bg-white rounded-lg shadow-sm text-sm font-bold hover:bg-zinc-50 transition-colors">
                        Ubah Jadi {{ $viewingTable->status === 'available' ? 'Terisi' : 'Kosong' }}
                    </button>
                </div>

                {{-- Customer Info (If occupied) --}}
                @php $currentOrder = $viewingTable->orders->first(); @endphp
                @if($currentOrder)
                    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-200 dark:border-zinc-800">
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-3">Informasi Pelanggan</h3>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($currentOrder->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-zinc-900 dark:text-white">{{ $currentOrder->user->name ?? 'Guest' }}</p>
                                <p class="text-xs text-zinc-500 font-mono">Order #{{ $currentOrder->order_number }}</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                            <span class="text-xs font-bold text-zinc-500 uppercase">Tagihan Aktif:</span>
                            <span class="text-base font-black text-emerald-600"><x-currency :value="$currentOrder->total" /></span>
                        </div>
                    </div>
                @endif

                {{-- Management Actions --}}
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 grid grid-cols-2 gap-3">
                    <x-button variant="ghost" wire:click="generateQrCode({{ $viewingTable->id }})" class="w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        QR Code
                    </x-button>
                    <x-button variant="ghost" wire:click="edit({{ $viewingTable->id }})" class="w-full">
                        Edit Data Meja
                    </x-button>
                    <button wire:click="delete({{ $viewingTable->id }})" wire:confirm="Hapus meja ini?" class="col-span-2 text-xs text-rose-600 font-bold hover:text-rose-700 py-2 transition-colors">
                        Hapus Meja Selamanya
                    </button>
                </div>
            </div>
        </x-modal>
    @endif

    {{-- QR Code Modal --}}
    @if($showQrCode)
        <x-modal :open="$showQrCode" title="QR Code - Meja {{ $selectedTableNumber }}" close="closeQrCode">
            <div class="flex flex-col items-center justify-center p-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-zinc-100 w-full max-w-sm flex items-center justify-center">
                    {!! $selectedTableQrCode !!}
                </div>
                <p class="mt-6 text-center text-sm text-zinc-500">Scan untuk memesan langsung dari Meja {{ $selectedTableNumber }}.</p>
                <div class="mt-4 w-full text-center">
                    <x-button type="button" onclick="window.print()" variant="primary" class="mx-auto">Cetak QR Code</x-button>
                </div>
            </div>
        </x-modal>
    @endif
</div>
