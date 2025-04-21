<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderService;
use App\Models\Inventory;
use App\Models\ClinicalHistory;
use Illuminate\Support\Carbon;
use App\Models\ClinicalHistoryDetail;


class OrderCreate extends Component
{
    public $clinical_history_id;
    public $customer_name;
    public $customer_phone;
    public $payment_method;
    public $order_datetime;
    public $observation;

    public $services = [];
    public $items = [];

    public $inventories;
    public $histories;

    public function mount()
    {
        $this->order_datetime = now()->format('Y-m-d\TH:i');
        $this->services = [['service' => '', 'rate' => '', 'observation' => '', 'service_datetime' => now()->format('Y-m-d\TH:i')]];
        $this->items = [['inventory_id' => '', 'quantity' => 1, 'unit_price' => '', 'subtotal' => 0]];
        $this->inventories = Inventory::where('quantity', '>', 0)->get();
        $this->histories = ClinicalHistory::all();
    }
    /*
        public function updatedItems($value, $name)
    {
        $this->recalculateItems();
    }*/

    public function updatedItems($value, $name)
    {
        // $name será algo como "items.0.inventory_id" o "items.1.quantity"
        $this->updateItemRow($name);
    }

    public function updateItemRow($name)
{
    // Extraer el índice: "items.0.inventory_id" → 0
    preg_match('/items\.(\d+)\./', $name, $matches);
    $index = $matches[1] ?? null;

    if ($index === null || !isset($this->items[$index])) return;

    $inventory = Inventory::find($this->items[$index]['inventory_id']);

    if ($inventory) {
        $this->items[$index]['unit_price'] = $inventory->price;
    }

    $quantity = (float) ($this->items[$index]['quantity'] ?? 0);
    $unit_price = (float) ($this->items[$index]['unit_price'] ?? 0);

    $this->items[$index]['subtotal'] = $quantity * $unit_price;
}


    public function addItem()
    {
        $this->items[] = ['inventory_id' => '', 'quantity' => 1, 'unit_price' => '', 'subtotal' => 0];
    }

    public function addService()
    {
        $this->services[] = ['service' => '', 'rate' => '', 'observation' => '', 'service_datetime' => now()->format('Y-m-d\TH:i')];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function getTotalProperty()
{
    $itemsTotal = collect($this->items)->sum(function ($item) {
        return (float) $item['subtotal'];
    });

    $servicesTotal = collect($this->services)->sum(function ($service) {
        return (float) $service['rate'];
    });

    return $itemsTotal + $servicesTotal;
}

    public function save()
    {
        $this->validate([
            'payment_method' => 'required',
            'order_datetime' => 'required|date',
        ]);

        $order = Order::create([
            'clinical_history_id' => $this->clinical_history_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'total' => $this->total,
            'payment_method' => $this->payment_method,
            'order_datetime' => $this->order_datetime,
            'observation' => $this->observation
        ]);

        foreach ($this->items as $item) {
            if (!$item['inventory_id']) continue;

            OrderItem::create([
                'order_id' => $order->id,
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        foreach ($this->services as $service) {
            if (!$service['service']) continue;

            OrderService::create([
                'order_id' => $order->id,
                'service' => $service['service'],
                'rate' => $service['rate'],
                'observation' => $service['observation'],
                'service_datetime' => $service['service_datetime'],
            ]);


            if ($this->clinical_history_id) {
                ClinicalHistoryDetail::create([
                    'clinical_history_id' => $this->clinical_history_id,
                    'service' => $service['service'],
                    'rate' => $service['rate'],
                    'observation' => $service['observation'],
                    'service_datetime' => $service['service_datetime'],
                    'payment_method' => $this->payment_method,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }



        session()->flash('success', 'Orden registrada exitosamente.');
        return redirect()->route('orders.index');
    }

    public function render()
    {
        return view('livewire.orders.order-create')->layout('layouts.app');
    }
}