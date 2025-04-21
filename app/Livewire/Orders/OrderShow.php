<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;


class OrderShow extends Component
{

    public $order;

    public function mount($id)
    {
        $this->order = Order::with(['services', 'items', 'clinicalHistory'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.orders.order-show')->layout('layouts.app');
    }

    
}
