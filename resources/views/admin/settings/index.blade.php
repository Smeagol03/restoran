<x-layouts.admin>
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Pengaturan Akun</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        <livewire:admin.settings.update-profile />
        <livewire:admin.settings.update-password />
    </div>
</x-layouts.admin>
