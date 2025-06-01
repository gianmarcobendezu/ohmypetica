<?php 
namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;

class OrderIndex extends Component
{
    public $orders;
    public $search;
    public $selectedOrder = null;
    public $showModal = false;


    public function mount()
    {
        $this->orders = Order::with('clinicalHistory')->latest()->get();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = \App\Models\Order::with(['services', 'items', 'clinicalHistory'])->findOrFail($orderId);
        $this->showModal = true;
    }

    public function updated($name, $value)
    {
        if ($name === 'search') {
            logger("🔍 Buscando: {$value}");
            $this->orders = Order::where('customer_name', 'like', '%' . $this->search . '%')
            ->get();
        }
    }

    public function render()
    {
        return view('livewire.orders.order-index')->layout('layouts.app');
    }
}