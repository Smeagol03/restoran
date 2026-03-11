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
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
            <h2 class="text-lg font-bold mb-4 text-zinc-900 dark:text-white">
                {{ $isEditing ? 'Edit Menu' : 'Tambah Menu Baru' }}
            </h2>
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama Menu</label>
                        <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Kategori</label>
                        <select wire:model="category_id" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Harga (Rp)</label>
                        <input type="number" wire:model="price" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
                        @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Waktu Persiapan (Menit)</label>
                        <input type="number" wire:model="preparation_time" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
                        @error('preparation_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_available" class="rounded border-zinc-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Tersedia</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="rounded border-zinc-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Menu Unggulan</span>
                    </label>
                </div>

                <div class="flex gap-3">
                    <x-button type="submit" variant="primary">Simpan</x-button>
                    <x-button type="button" variant="ghost" wire:click="cancel">Batal</x-button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-800">
            <input type="text" wire:model.live="search" placeholder="Cari menu..." class="w-full md:w-64 rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
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
                        <td class="px-6 py-4 font-medium">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <button wire:click="toggleAvailability({{ $item->id }})" class="px-2 py-1 rounded text-xs font-bold {{ $item->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->is_available ? 'Tersedia' : 'Habis' }}
                            </button>
                        </td>
                        <td class="px-6 py-4 flex gap-3">
                            <button wire:click="edit({{ $item->id }})" class="text-blue-600 hover:text-blue-700">Edit</button>
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Hapus menu ini?" class="text-red-600 hover:text-red-700">Hapus</button>
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
