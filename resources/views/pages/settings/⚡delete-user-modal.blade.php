<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    public bool $showModal = false;

    protected $listeners = ['open-modal' => 'handleOpenModal'];

    public function handleOpenModal(string $name): void
    {
        if ($name === 'confirm-user-deletion') {
            $this->showModal = true;
        }
    }

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('password');
        $this->resetErrorBag();
    }
}; ?>

<div>
    @if($showModal || $errors->isNotEmpty())
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data @keydown.escape.window="$wire.closeModal()">
            <div class="fixed inset-0 bg-black/50" @click="$wire.closeModal()"></div>
            <div class="relative w-full max-w-lg rounded-xl bg-white p-6 shadow-xl dark:bg-zinc-800 space-y-6">
                <form method="POST" wire:submit="deleteUser" class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ __('Are you sure you want to delete your account?') }}</h3>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>
                    </div>

                    <x-input wire:model="password" :label="__('Password')" type="password" name="password" />

                    <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                        <x-button variant="filled" type="button" wire:click="closeModal">{{ __('Cancel') }}</x-button>
                        <x-button variant="danger" type="submit" data-test="confirm-delete-user-button">{{ __('Delete account') }}</x-button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
