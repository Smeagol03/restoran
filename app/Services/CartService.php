<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected string $sessionKey = 'cart';

    /**
     * Get all items in the cart.
     */
    public function getItems(): Collection
    {
        return collect(Session::get($this->sessionKey, []));
    }

    /**
     * Add an item to the cart.
     */
    public function add(int $menuItemId, int $quantity = 1, ?string $notes = null): void
    {
        $cart = $this->getItems();
        $menuItem = MenuItem::findOrFail($menuItemId);

        if ($cart->has($menuItemId)) {
            $item = $cart->get($menuItemId);
            $item['quantity'] += $quantity;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $cart->put($menuItemId, $item);
        } else {
            $cart->put($menuItemId, [
                'menu_item_id' => $menuItemId,
                'name' => $menuItem->name,
                'unit_price' => (float) $menuItem->price,
                'quantity' => $quantity,
                'subtotal' => (float) $menuItem->price * $quantity,
                'notes' => $notes,
            ]);
        }

        Session::put($this->sessionKey, $cart->toArray());
    }

    /**
     * Update item quantity.
     */
    public function update(int $menuItemId, int $quantity): void
    {
        $cart = $this->getItems();

        if ($cart->has($menuItemId)) {
            if ($quantity <= 0) {
                $this->remove($menuItemId);

                return;
            }

            $item = $cart->get($menuItemId);
            $item['quantity'] = $quantity;
            $item['subtotal'] = $item['quantity'] * $item['unit_price'];
            $cart->put($menuItemId, $item);
            Session::put($this->sessionKey, $cart->toArray());
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $menuItemId): void
    {
        $cart = $this->getItems();
        $cart->forget($menuItemId);
        Session::put($this->sessionKey, $cart->toArray());
    }

    /**
     * Clear the cart.
     */
    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Get cart subtotal.
     */
    public function getSubtotal(): float
    {
        return $this->getItems()->sum('subtotal');
    }

    /**
     * Get total items count.
     */
    public function getCount(): int
    {
        return $this->getItems()->sum('quantity');
    }
}
