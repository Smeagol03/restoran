<?php

namespace App\Livewire\Public;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerOrders extends Component
{
    use WithPagination;

    public string $tab = 'active';

    public function updatingTab(): void
    {
        $this->resetPage();
    }

    public function render(): \Illuminate\View\View
    {
        $query = Order::query()
            ->forUser(auth()->id())
            ->with(['items.menuItem'])
            ->latest();

        $orders = match ($this->tab) {
            'completed' => $query->completed()->paginate(10),
            default => $query->active()->paginate(10),
        };

        $activeCount = Order::query()->forUser(auth()->id())->active()->count();
        $completedCount = Order::query()->forUser(auth()->id())->completed()->count();

        return view('livewire.public.customer-orders', [
            'orders' => $orders,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
        ]);
    }
}
