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
        <x-modal :open="$isCreating || $isEditing" title="{{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}" close="cancel">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-5">
                <div>
                    <x-label for="name" value="Nama Kategori" />
                    <x-input type="text" id="name" wire:model="name" placeholder="Masukkan nama kategori" />
                    <x-error :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-label for="description" value="Deskripsi" />
                    <x-textarea id="description" wire:model="description" rows="3" placeholder="Masukkan deskripsi kategori..."></x-textarea>
                    <x-error :messages="$errors->get('description')" />
                </div>
                <div class="flex gap-3 pt-2">
                    <x-button type="submit" variant="primary">Simpan</x-button>
                    <x-button type="button" variant="ghost" wire:click="cancel">Batal</x-button>
                </div>
            </form>
        </x-modal>
    @endif

    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-sm">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/30">
            <div class="max-w-sm">
                <x-input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kategori..." />
            </div>
        </div>
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
                            <button wire:click="edit({{ $category->id }})" class="px-2 py-1 rounded bg-blue-100 text-xs font-bold text-blue-600 hover:text-blue-700">Edit</button>
                            <button wire:click="delete({{ $category->id }})" wire:confirm="Yakin ingin menghapus kategori ini?" class="px-2 py-1 rounded bg-red-100 text-xs font-bold text-red-600 hover:text-red-700">Hapus</button>
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
