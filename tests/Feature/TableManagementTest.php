<?php

use App\Models\Table;
use App\Models\User;
use Livewire\Livewire;

test('admin can view tables page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.tables.index'))
        ->assertStatus(200);
});

test('admin can create a new table', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Tables::class)
        ->set('number', 'VIP-1')
        ->set('capacity', 6)
        ->set('status', 'available')
        ->call('store')
        ->assertHasNoErrors()
        ->assertSee('Meja berhasil ditambahkan.');

    $this->assertDatabaseHas('tables', [
        'number' => 'VIP-1',
        'capacity' => 6,
        'status' => 'available',
    ]);
});

test('admin can generate qr code for a table', function () {
    $admin = User::factory()->admin()->create();
    $table = Table::factory()->create(['number' => 'Meja-5']);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Tables::class)
        ->call('generateQrCode', $table->id)
        ->assertSet('showQrCode', true)
        ->assertSet('selectedTableNumber', 'Meja-5')
        ->assertSee('svg'); // Ensure SVG is generated
});

test('checkout form auto selects table from session', function () {
    $table = Table::factory()->create(['number' => 'Meja-10']);

    // Simulate query parameter visit saving to session
    session(['table_id' => $table->id]);

    $customer = User::factory()->create();
    Livewire::actingAs($customer)
        ->test(\App\Livewire\Public\CheckoutForm::class)
        ->assertSet('table_id', $table->id)
        ->assertSet('type', 'dine_in');
});
