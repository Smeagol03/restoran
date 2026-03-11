<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
    <div class="mb-6">
        <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Ubah Password</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400">Pastikan akun Anda menggunakan password yang panjang dan acak agar lebih aman.</p>
    </div>

    @if (session()->has('password-updated'))
        <div class="mb-4 p-3 text-sm text-emerald-700 bg-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg">
            {{ session('password-updated') }}
        </div>
    @endif

    <form wire:submit.prevent="updatePassword" class="space-y-5 max-w-xl">
        <div>
            <x-label for="current_password" value="Password Saat Ini" />
            <x-input type="password" id="current_password" wire:model="current_password" placeholder="••••••••" />
            <x-error :messages="$errors->get('current_password')" />
        </div>
        <div>
            <x-label for="password" value="Password Baru" />
            <x-input type="password" id="password" wire:model="password" placeholder="••••••••" />
            <x-error :messages="$errors->get('password')" />
        </div>
        <div>
            <x-label for="password_confirmation" value="Konfirmasi Password Baru" />
            <x-input type="password" id="password_confirmation" wire:model="password_confirmation" placeholder="••••••••" />
            <x-error :messages="$errors->get('password_confirmation')" />
        </div>
        <div class="flex items-center gap-4 pt-2">
            <x-button type="submit" variant="primary">
                <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                <span wire:loading wire:target="updatePassword">Mengubah...</span>
            </x-button>
        </div>
    </form>
</div>
