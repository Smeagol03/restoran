<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Manajemen Menu</h1>
        @if(!$isCreating && !$isEditing)
            <x-button variant="primary" wire:click="create">Tambah Menu</x-button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if($isCreating || $isEditing)
        <x-modal :open="$isCreating || $isEditing" title="{{ $isEditing ? 'Edit Menu' : 'Tambah Menu Baru' }}" close="cancel">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-label for="name" value="Nama Menu" />
                        <x-input type="text" id="name" wire:model="name" placeholder="Contoh: Nasi Goreng Spesial" />
                        <x-error :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-label for="category_id" value="Kategori" />
                        <x-select id="category_id" wire:model="category_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-select>
                        <x-error :messages="$errors->get('category_id')" />
                    </div>
                    <div>
                        <x-money-input label="Harga (Rp)" name="price" wire:model="price" placeholder="Contoh: 25.000" />
                    </div>
                    <div>
                        <x-label for="preparation_time" value="Waktu Persiapan (Menit)" />
                        <x-input type="number" id="preparation_time" wire:model="preparation_time" placeholder="Contoh: 15" />
                        <x-error :messages="$errors->get('preparation_time')" />
                    </div>
                </div>

                <div>
                    <x-label for="description" value="Deskripsi" />
                    <x-textarea id="description" wire:model="description" rows="3" placeholder="Jelaskan detail menu ini..."></x-textarea>
                    <x-error :messages="$errors->get('description')" />
                </div>

                <div class="flex flex-wrap gap-8 py-2">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <x-checkbox wire:model="is_available" class="size-5 focus:ring-offset-0" />
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300 group-hover:text-orange-600 transition-colors">Tersedia untuk Dipesan</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <x-checkbox wire:model="is_featured" class="size-5 focus:ring-offset-0" />
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300 group-hover:text-orange-600 transition-colors">Muncul sebagai Unggulan</span>
                    </label>
                </div>

                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">Simpan Menu</x-button>
                    <x-button type="button" variant="ghost" wire:click="cancel">Batal</x-button>
                </div>
            </form>
        </x-modal>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
            <div class="max-w-sm">
                <x-input type="text" wire:model.live="search" placeholder="Cari nama menu atau kategori..." />
            </div>
        </div>
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-3">Menu</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($menuItems as $item)
                    <tr class="text-zinc-900 dark:text-zinc-300">
                        <td class="px-6 py-4">
                            <div class="font-semibold">{{ $item->name }}</div>
                            @if($item->is_featured)
                                <span class="text-[10px] bg-yellow-100 text-yellow-700 px-1 rounded">Favorit</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $item->category->name }}</td>
                        <td class="px-6 py-4 font-medium"><x-currency :value="$item->price" /></td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleAvailability({{ $item->id }})" class="px-2 py-1 rounded text-xs font-bold {{ $item->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->is_available ? 'Tersedia' : 'Habis' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 flex gap-3">
                            <button wire:click="edit({{ $item->id }})" class="px-2 py-1 rounded bg-blue-100 text-xs font-bold text-blue-600 hover:text-blue-700">Edit</button>
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus menu ini?" class="px-2 py-1 rounded bg-red-100 text-xs font-bold text-red-600 hover:text-red-700">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-zinc-500">Menu tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $menuItems->links() }}
        </div>
    </div>
</div>
