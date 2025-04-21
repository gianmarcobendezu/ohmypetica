<?php 
namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;

class OrderIndex extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('clinicalHistory')->latest()->get();
    }

    public function render()
    {
        return view('livewire.orders.order-index')->layout('layouts.app');
    }
}