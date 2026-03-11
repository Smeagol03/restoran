<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manajemen Meja</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Kelola meja dan cetak QR Code pesanan.</p>
        </div>
        <button wire:click="create" class="px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 text-sm font-bold rounded-lg hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">
            + Tambah Meja
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 text-sm text-red-700 bg-red-100 dark:bg-red-900/30 dark:text-red-400 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form Tambah/Edit Meja --}}
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
                    <x-label for="status" value="Status" />
                    <x-select id="status" wire:model="status">
                        <option value="available">Tersedia (Available)</option>
                        <option value="occupied">Terisi (Occupied)</option>
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

    {{-- QR Code Modal --}}
    @if($showQrCode)
        <x-modal :open="$showQrCode" title="QR Code - Meja {{ $selectedTableNumber }}" close="closeQrCode">
            <div class="flex flex-col items-center justify-center p-4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800 w-full max-w-sm flex items-center justify-center">
                    {!! $selectedTableQrCode !!}
                </div>
                
                <p class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    Scan QR Code ini untuk memesan langsung dari <strong>Meja {{ $selectedTableNumber }}</strong>.
                </p>

                <div class="mt-4 w-full text-center">
                    <p class="text-xs text-zinc-400 mb-2 truncate px-4">{{ $selectedTableUrl }}</p>
                    <button type="button" onclick="window.print()" class="px-4 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-sm hover:bg-orange-700 transition flex items-center gap-2 mx-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak QR Code
                    </button>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <x-button type="button" variant="ghost" wire:click="closeQrCode">Tutup</x-button>
            </div>
        </x-modal>
    @endif

    {{-- Tables List --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] font-bold tracking-wider relative border-b border-zinc-200 dark:border-zinc-800">
                    <tr>
                        <th class="px-6 py-4">Meja</th>
                        <th class="px-6 py-4">Kapasitas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                    @forelse($tables as $table)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-zinc-900 dark:text-white text-base">Meja {{ $table->number }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                {{ $table->capacity }} Orang
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="toggleStatus({{ $table->id }})" class="px-2 py-1 rounded text-xs font-bold {{ $table->status === 'available' ? 'bg-emerald-100 text-emerald-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $table->status === 'available' ? 'Tersedia' : 'Terisi' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <button wire:click="generateQrCode({{ $table->id }})" class="px-3 py-1 rounded bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 text-xs font-bold hover:bg-zinc-800 dark:hover:bg-white transition flex items-center gap-1.5 focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    Generate QR
                                </button>
                                <button wire:click="edit({{ $table->id }})" class="px-2 py-1 rounded bg-blue-100 text-xs font-bold text-blue-600 hover:text-blue-700">Edit</button>
                                <button wire:click="delete({{ $table->id }})" wire:confirm="Yakin ingin menghapus meja ini?" class="px-2 py-1 rounded bg-red-100 text-xs font-bold text-red-600 hover:text-red-700">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-zinc-500">
                                Belum ada data meja.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tables->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $tables->links() }}
            </div>
        @endif
    </div>
</div>
