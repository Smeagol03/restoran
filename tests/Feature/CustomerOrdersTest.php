<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Livewire\Livewire;

test('guests cannot access the orders dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('customers can see their orders on the dashboard', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create();
    OrderItem::factory()->for($order)->count(2)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Public\CustomerOrders::class)
        ->assertSee($order->order_number);
});

test('customers cannot see other users orders', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $otherOrder = Order::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Public\CustomerOrders::class)
        ->assertDontSee($otherOrder->order_number);
});

test('customers can switch between active and completed tabs', function () {
    $user = User::factory()->create();
    $activeOrder = Order::factory()->for($user)->preparing()->create();
    $doneOrder = Order::factory()->for($user)->done()->create();

    $component = Livewire::actingAs($user)
        ->test(\App\Livewire\Public\CustomerOrders::class);

    // Default tab is active
    $component->assertSee($activeOrder->order_number)
        ->assertDontSee($doneOrder->order_number);

    // Switch to completed
    $component->set('tab', 'completed')
        ->assertDontSee($activeOrder->order_number)
        ->assertSee($doneOrder->order_number);
});

test('customers can view their order detail', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->confirmed()->create();
    OrderItem::factory()->for($order)->count(3)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Public\OrderDetail::class, ['order' => $order])
        ->assertSee($order->order_number)
        ->assertSee('Dikonfirmasi');
});

test('customers cannot view another users order detail', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $order = Order::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test(\App\Livewire\Public\OrderDetail::class, ['order' => $order])
        ->assertForbidden();
});

test('order detail page route works for authenticated customers', function () {
    $user = User::factory()->create();
    $order = Order::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('orders.show', $order))
        ->assertOk();
});

test('order detail page denies other users', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $order = Order::factory()->for($otherUser)->create();

    $this->actingAs($user)
        ->get(route('orders.show', $order))
        ->assertForbidden();
});
