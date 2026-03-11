<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
    <div class="mb-6">
        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Informasi Profil</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Perbarui nama dan alamat email akun Anda.</p>
    </div>

    @if (session()->has('profile-updated'))
        <div class="mb-4 p-3 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('profile-updated') }}
        </div>
    @endif

    <form wire:submit.prevent="updateProfile" class="space-y-5 max-w-xl">
        <div>
            <x-label for="name" value="Nama Lengkap" />
            <x-input type="text" id="name" wire:model="name" placeholder="Nama Anda" />
            <x-error :messages="$errors->get('name')" />
        </div>
        <div>
            <x-label for="email" value="Alamat Email" />
            <x-input type="email" id="email" wire:model="email" placeholder="email@contoh.com" />
            <x-error :messages="$errors->get('email')" />
        </div>
        <div class="flex items-center gap-4 pt-2">
            <x-button type="submit" variant="primary">
                <span wire:loading.remove wire:target="updateProfile">Simpan Profil</span>
                <span wire:loading wire:target="updateProfile">Menyimpan...</span>
            </x-button>
        </div>
    </form>
</div>
