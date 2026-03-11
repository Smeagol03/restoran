<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Kategori Menu</h1>
        @if(!$isCreating && !$isEditing)
            <x-button variant="primary" wire:click="create">Tambah Kategori</x-button>
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
                {{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
            </h2>
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nama Kategori</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Deskripsi</label>
                    <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-orange-500"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-3">
                    <x-button type="submit" variant="primary">Simpan</x-button>
                    <x-button type="button" variant="ghost" wire:click="cancel">Batal</x-button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Jumlah Menu</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse($categories as $category)
                    <tr class="text-zinc-900 dark:text-zinc-300">
                        <td class="px-6 py-4 font-semibold">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-zinc-500">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $category->menu_items_count ?? $category->menuItems()->count() }}</td>
                        <td class="px-6 py-4 flex gap-3">
                            <button wire:click="edit({{ $category->id }})" class="text-blue-600 hover:text-blue-700">Edit</button>
                            <button wire:click="delete({{ $category->id }})" wire:confirm="Yakin ingin menghapus kategori ini?" class="text-red-600 hover:text-red-700">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-zinc-500">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
