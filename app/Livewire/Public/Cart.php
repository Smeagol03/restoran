<?php

namespace App\Livewire\Public;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public array $items = [];

    public float $subtotal = 0;

    public int $count = 0;

    public function mount(CartService $cart): void
    {
        $this->loadCart($cart);
    }

    #[On('cart-updated')]
    public function loadCart(CartService $cart): void
    {
        $this->items = $cart->getItems()->toArray();
        $this->subtotal = (float) $cart->getSubtotal();
        $this->count = (int) $cart->getCount();
    }

    public function increment(int $menuItemId, CartService $cart): void
    {
        $item = $this->items[$menuItemId] ?? null;
        if ($item) {
            $cart->update($menuItemId, $item['quantity'] + 1);
            $this->loadCart($cart);
        }
    }

    public function decrement(int $menuItemId, CartService $cart): void
    {
        $item = $this->items[$menuItemId] ?? null;
        if ($item && $item['quantity'] > 1) {
            $cart->update($menuItemId, $item['quantity'] - 1);
        } else {
            $cart->remove($menuItemId);
        }
        $this->loadCart($cart);
    }

    public function remove(int $menuItemId, CartService $cart): void
    {
        $cart->remove($menuItemId);
        $this->loadCart($cart);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.public.cart');
    }
}
