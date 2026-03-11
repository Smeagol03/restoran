<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $blueprint->string('order_number')->unique();
            $blueprint->string('type')->default(OrderType::DineIn->value);
            $blueprint->string('status')->default(OrderStatus::Pending->value);
            $blueprint->foreignId('table_id')->nullable()->constrained()->nullOnDelete();
            // delivery_address_id is currently nullable because MVP focuses on WhatsApp redirect
            $blueprint->foreignId('delivery_address_id')->nullable();
            $blueprint->text('notes')->nullable();
            $blueprint->decimal('subtotal', 15, 2);
            $blueprint->decimal('discount_amount', 15, 2)->default(0);
            $blueprint->decimal('delivery_fee', 15, 2)->default(0);
            $blueprint->decimal('total', 15, 2);
            $blueprint->foreignId('promo_id')->nullable();
            $blueprint->softDeletes();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
