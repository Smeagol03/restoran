<?php

use App\Models\Order;
use App\Models\User;
use Livewire\Livewire;

test('admins can search orders by number', function () {
    $admin = User::factory()->admin()->create();
    $order1 = Order::factory()->create(['order_number' => 'ORD-001']);
    $order2 = Order::factory()->create(['order_number' => 'ORD-002']);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Orders::class)
        ->set('search', '001')
        ->assertSee('ORD-001')
        ->assertDontSee('ORD-002');
});

test('admins can search orders by customer name', function () {
    $admin = User::factory()->admin()->create();
    $customer1 = User::factory()->create(['name' => 'Budi Santoso']);
    $customer2 = User::factory()->create(['name' => 'Siti Aminah']);

    $order1 = Order::factory()->for($customer1)->create();
    $order2 = Order::factory()->for($customer2)->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Orders::class)
        ->set('search', 'Budi')
        ->assertSee('Budi Santoso')
        ->assertDontSee('Siti Aminah');
});

test('admins can search orders by customer email', function () {
    $admin = User::factory()->admin()->create();
    $customer1 = User::factory()->create(['email' => 'budi@example.com']);
    $customer2 = User::factory()->create(['email' => 'siti@example.com']);

    $order1 = Order::factory()->for($customer1)->create();
    $order2 = Order::factory()->for($customer2)->create();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Admin\Orders::class)
        ->set('search', 'budi@')
        ->assertSee($order1->order_number)
        ->assertDontSee($order2->order_number);
});
