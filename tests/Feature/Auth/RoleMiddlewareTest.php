<?php

use App\Models\User;

test('guests are redirected to login when accessing admin routes', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});

test('customer users cannot access admin routes', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin users can access admin routes', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertOk();
});

test('kasir users can access admin routes', function () {
    $user = User::factory()->kasir()->create();

    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    $response->assertOk();
});

test('customer users can access customer dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertOk();
});

test('admin users cannot access customer dashboard', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertForbidden();
});

test('kasir users cannot access customer dashboard', function () {
    $user = User::factory()->kasir()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertForbidden();
});
