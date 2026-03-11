<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(20000, 500000);
        $deliveryFee = 0;
        $discountAmount = 0;

        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-'.now()->format('Ymd').'-'.strtoupper(Str::random(4)),
            'type' => OrderType::DineIn,
            'status' => OrderStatus::Pending,
            'table_id' => null,
            'delivery_address_id' => null,
            'notes' => null,
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'delivery_fee' => $deliveryFee,
            'total' => $subtotal - $discountAmount + $deliveryFee,
        ];
    }

    /**
     * Set the order status to confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Confirmed,
        ]);
    }

    /**
     * Set the order status to preparing.
     */
    public function preparing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Preparing,
        ]);
    }

    /**
     * Set the order status to ready.
     */
    public function ready(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Ready,
        ]);
    }

    /**
     * Set the order status to delivered.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Delivered,
        ]);
    }

    /**
     * Set the order status to done.
     */
    public function done(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Done,
        ]);
    }

    /**
     * Set the order status to cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::Cancelled,
        ]);
    }

    /**
     * Set the order type to delivery.
     */
    public function delivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => OrderType::Delivery,
            'delivery_fee' => 10000,
            'total' => ($attributes['subtotal'] ?? 50000) - ($attributes['discount_amount'] ?? 0) + 10000,
        ]);
    }
}
