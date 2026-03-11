<?php

use App\Models\Order;
use App\Models\User;
use Livewire\Livewire;

test('admin can view settings page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.settings.index'))
        ->assertStatus(200)
        ->assertSee('Pengaturan Akun');
});

test('admin can update profile', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Settings\UpdateProfile::class)
        ->set('name', 'Nama Baru')
        ->set('email', 'baru@restoran.com')
        ->call('updateProfile')
        ->assertHasNoErrors();

    $admin->refresh();
    expect($admin->name)->toBe('Nama Baru');
    expect($admin->email)->toBe('baru@restoran.com');
});

test('admin can update password', function () {
    $admin = User::factory()->admin()->create([
        'password' => bcrypt('old-password'),
    ]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Settings\UpdatePassword::class)
        ->set('current_password', 'old-password')
        ->set('password', 'new-secure-password')
        ->set('password_confirmation', 'new-secure-password')
        ->call('updatePassword')
        ->assertHasNoErrors();
});

test('admin cannot update password with wrong current password', function () {
    $admin = User::factory()->admin()->create([
        'password' => bcrypt('correct-password'),
    ]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Settings\UpdatePassword::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword')
        ->assertHasErrors('current_password');
});

test('admin can view order receipt', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->done()->create();

    $this->actingAs($admin)
        ->get(route('admin.orders.receipt', $order))
        ->assertStatus(200)
        ->assertSee($order->order_number)
        ->assertSee('Bukti Transaksi');
});
