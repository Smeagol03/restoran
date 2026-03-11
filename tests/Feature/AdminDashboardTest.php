<?php

use App\Models\Order;
use App\Models\User;

test('admin dashboard renders sales analytics successfully', function () {
    $admin = User::factory()->admin()->create();

    // Create a dummy order to ensure sum calculation works
    Order::factory()->done()->create([
        'total' => 100000,
        'created_at' => now(),
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Tren Penjualan (7 Hari Terakhir)');
    $response->assertSee('salesChart'); // Canvas ID
});
