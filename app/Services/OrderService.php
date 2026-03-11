<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Create a new order from cart items.
     */
    public function createFromCart(array $data, array $cartItems): Order
    {
        return DB::transaction(function () use ($data, $cartItems) {
            $subtotal = collect($cartItems)->sum('subtotal');
            $deliveryFee = ($data['type'] === OrderType::Delivery->value) ? 10000 : 0; // Example flat fee
            $total = $subtotal + $deliveryFee;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->generateOrderNumber(),
                'type' => $data['type'],
                'status' => OrderStatus::Pending,
                'table_id' => $data['table_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $order;
        });
    }

    /**
     * Generate a unique order number.
     */
    protected function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));

        return "ORD-{$date}-{$random}";
    }

    /**
     * Format the WhatsApp message for the order.
     */
    public function formatWhatsAppMessage(Order $order): string
    {
        $order->load('items.menuItem', 'table');

        $message = "*PESANAN BARU - {$order->order_number}*\n";
        $message .= "--------------------------------\n";
        $message .= "*Detail Pelanggan:*\n";
        $message .= 'Nama: '.auth()->user()->name."\n";
        $message .= 'Tipe: '.$order->type->label()."\n";

        if ($order->type === OrderType::DineIn && $order->table) {
            $message .= 'Meja: '.$order->table->number."\n";
        }

        $message .= "--------------------------------\n";
        $message .= "*Daftar Pesanan:*\n";

        foreach ($order->items as $item) {
            $message .= "- {$item->menuItem->name} (x{$item->quantity}) : Rp ".number_format($item->subtotal, 0, ',', '.')."\n";
        }

        $message .= "--------------------------------\n";
        $message .= '*Total Bayar: Rp '.number_format($order->total, 0, ',', '.')."*\n";

        if ($order->notes) {
            $message .= "\n*Catatan:* {$order->notes}\n";
        }

        $message .= "\nMohon segera diproses ya, terima kasih!";

        return $message;
    }

    /**
     * Get the WhatsApp redirect URL.
     */
    public function getWhatsAppUrl(Order $order): string
    {
        $phone = config('app.admin_phone', '6281234567890'); // Default or from config
        $text = urlencode($this->formatWhatsAppMessage($order));

        return "https://wa.me/{$phone}?text={$text}";
    }
}
