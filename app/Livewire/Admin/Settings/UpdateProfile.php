<?php

namespace App\Livewire\Admin\Settings;

use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateProfile extends Component
{
    public string $name = '';

    public string $email = '';

    public function mount(): void
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('profile-updated', 'Profil berhasil diperbarui.');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.settings.update-profile');
    }
}
