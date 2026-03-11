<?php

namespace App\Livewire\Public;

use App\Services\CartService;
use Livewire\Component;

class AddToCart extends Component
{
    public int $menuItemId;

    public function add(CartService $cart): void
    {
        $cart->add($this->menuItemId);
        $this->dispatch('item-added', id: $this->menuItemId);
        $this->dispatch('cart-updated');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.public.add-to-cart');
    }
}
