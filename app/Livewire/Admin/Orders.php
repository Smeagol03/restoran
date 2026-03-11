<?php

namespace App\Livewire\Admin;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    public string $search = '';

    public ?int $selectedOrderId = null;

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $orderId, string $status): void
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => $status]);
        session()->flash('message', "Status pesanan {$order->order_number} diperbarui ke {$status}.");
    }

    public function showDetails(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
    }

    public function closeDetails(): void
    {
        $this->selectedOrderId = null;
    }

    public function render(): \Illuminate\View\View
    {
        $query = Order::with(['user', 'items.menuItem', 'table'])->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%');
                    });
            });
        }

        return view('livewire.admin.orders', [
            'orders' => $query->paginate(15),
            'statuses' => OrderStatus::cases(),
            'selectedOrder' => $this->selectedOrderId ? Order::with(['items.menuItem', 'user', 'table'])->find($this->selectedOrderId) : null,
        ]);
    }
}
