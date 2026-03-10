<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav aria-label="{{ __('Settings') }}" class="space-y-1">
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('profile.edit') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>{{ __('Profile') }}</a>
            <a href="{{ route('user-password.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('user-password.edit') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>{{ __('Password') }}</a>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <a href="{{ route('two-factor.show') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('two-factor.show') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>{{ __('Two-factor auth') }}</a>
            @endif
            <a href="{{ route('appearance.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('appearance.edit') ? 'bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-white' : 'text-zinc-600 hover:bg-zinc-50 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-white' }}" wire:navigate>{{ __('Appearance') }}</a>
        </nav>
    </div>

    <hr class="md:hidden border-zinc-200 dark:border-zinc-700 w-full" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $heading ?? '' }}</h2>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
