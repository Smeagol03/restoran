<?php

namespace App\Livewire\Admin\Settings;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UpdatePassword extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('password-updated', 'Password berhasil diperbarui.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.settings.update-password');
    }
}
