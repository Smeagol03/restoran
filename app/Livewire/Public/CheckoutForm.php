<?php

namespace App\Livewire\Public;

use App\Enums\OrderType;
use App\Models\Table;
use App\Services\CartService;
use App\Services\OrderService;
use Livewire\Component;

class CheckoutForm extends Component
{
    public string $type = 'dine_in';

    public ?int $table_id = null;

    public ?string $notes = null;

    public function mount()
    {
        if (session()->has('table_id')) {
            $this->table_id = session('table_id');
            $this->type = \App\Enums\OrderType::DineIn->value;
        }
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:'.OrderType::DineIn->value.','.OrderType::Delivery->value],
            'table_id' => ['required_if:type,'.OrderType::DineIn->value, 'nullable', 'exists:tables,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function checkout(CartService $cart, OrderService $orderService)
    {
        $this->validate();

        $items = $cart->getItems()->toArray();

        if (empty($items)) {
            $this->addError('cart', 'Keranjang belanja Anda kosong.');

            return;
        }

        $order = $orderService->createFromCart([
            'type' => $this->type,
            'table_id' => $this->table_id,
            'notes' => $this->notes,
        ], $items);

        $whatsappUrl = $orderService->getWhatsAppUrl($order);

        $cart->clear();

        $this->dispatch('cart-updated');

        // Membuka WA di tab baru dan mengarahkan halaman saat ini ke Home
        $this->js("window.open('$whatsappUrl', '_blank')");

        return redirect()->route('dashboard');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.public.checkout-form', [
            'tables' => \App\Models\Table::orderBy('number')->get(),
        ]);
    }
}
