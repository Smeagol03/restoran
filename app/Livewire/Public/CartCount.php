<?php

namespace App\Livewire\Public;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCount extends Component
{
    public int $count = 0;

    public function mount(CartService $cartService): void
    {
        $this->count = $cartService->getCount();
    }

    #[On('item-added')]
    #[On('cart-updated')]
    public function updateCount(CartService $cartService): void
    {
        $this->count = $cartService->getCount();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.public.cart-count');
    }
}
