<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Delete account') }}</h3>
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <x-button variant="danger" data-test="delete-user-button" @click="$dispatch('open-modal', { name: 'confirm-user-deletion' })">
        {{ __('Delete account') }}
    </x-button>

    <livewire:pages::settings.delete-user-modal />
</section>
