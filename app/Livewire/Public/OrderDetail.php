<?php

namespace App\Livewire\Public;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        // Authorization: ensure the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $this->order = $order;
    }

    public function render(): \Illuminate\View\View
    {
        // Refresh the order to get the latest status
        $this->order->refresh();
        $this->order->load(['items.menuItem', 'table']);

        return view('livewire.public.order-detail', [
            'timelineSteps' => OrderStatus::timelineSteps(),
            'currentPosition' => $this->order->statusTimelinePosition,
        ]);
    }
}
