<?php

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
        Schema::create('order_items', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('order_id')->constrained()->cascadeOnDelete();
            $blueprint->foreignId('menu_item_id')->constrained()->restrictOnDelete();
            $blueprint->integer('quantity');
            $blueprint->decimal('unit_price', 15, 2);
            $blueprint->decimal('subtotal', 15, 2);
            $blueprint->text('notes')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
