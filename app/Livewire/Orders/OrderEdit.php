<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\ClinicalHistory;
use App\Models\OrderItem;
use App\Models\OrderService;
use Livewire\Component;
use Carbon\Carbon;

class OrderEdit extends Component
{
    public $order;
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

    public $search = '';
    public $filteredInventories = [];

    public function mount(Order $order)
    {
        $this->order = $order->load(['items.inventory', 'services', 'clinicalHistory']);

        $this->clinical_history_id = $order->clinical_history_id;
        $this->customer_name = $order->customer_name;
        $this->customer_phone = $order->customer_phone;
        $this->payment_method = $order->payment_method;
        $this->order_datetime = Carbon::parse($order->order_datetime)->format('Y-m-d\TH:i');
        $this->observation = $order->observation;

        $this->items = $order->items->map(function ($item) {
            return [
                'inventory_id' => $item->inventory_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'subtotal' => $item->subtotal,
                'product_name' => $item->inventory->description ?? '',
                'observation' => '',
            ];
        })->toArray();

        $this->services = $order->services->map(function ($service) {
            return [
                'service' => $service->service,
                'rate' => $service->rate,
                'observation' => $service->observation,
                'service_datetime' => Carbon::parse($service->service_datetime)->format('Y-m-d\TH:i'),
            ];
        })->toArray();

        $this->histories = ClinicalHistory::all();
        $this->filterInventories();
    }

    public function filterInventories()
    {
        $this->filteredInventories = Inventory::where('quantity', '>', 0)
            ->where('description', 'like', '%' . $this->search . '%')
            ->get();
    }

    public function updated($name, $value)
    {
        if ($name === 'search') {
            $this->filterInventories();
        }
    }

    public function selectProduct($inventoryId)
    {
        foreach ($this->items as $item) {
            if ($item['inventory_id'] == $inventoryId) {
                return;
            }
        }

        $inventory = Inventory::find($inventoryId);
        if (!$inventory) return;

        $this->items[] = [
            'inventory_id' => $inventory->id,
            'quantity' => 1,
            'unit_price' => $inventory->price,
            'subtotal' => $inventory->price,
            'product_name' => $inventory->description,
            'observation' => ''
        ];
    }

    public function updateItemRow($index)
    {
        if (!isset($this->items[$index]['inventory_id'])) return;

        $inventory = Inventory::find($this->items[$index]['inventory_id']);
        if ($inventory) {
            $this->items[$index]['unit_price'] = $inventory->price;
            $this->items[$index]['product_name'] = $inventory->description;
        }

        $quantity = (float) ($this->items[$index]['quantity'] ?? 0);
        $price = (float) ($this->items[$index]['unit_price'] ?? 0);

        $this->items[$index]['subtotal'] = $quantity * $price;
    }

    public function recalculateSubtotal($index)
    {
        $quantity = (float) ($this->items[$index]['quantity'] ?? 0);
        $price = (float) ($this->items[$index]['unit_price'] ?? 0);
        $this->items[$index]['subtotal'] = $quantity * $price;
    }

    public function recalculateServiceRate($index)
    {
        $this->services[$index]['rate'] = (float) $this->services[$index]['rate'];
    }

    public function addItem()
    {
        $this->items[] = ['inventory_id' => '', 'quantity' => 1, 'unit_price' => '', 'subtotal' => 0, 'product_name' => '', 'observation' => ''];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function addService()
    {
        $this->services[] = ['service' => '', 'rate' => '', 'observation' => '', 'service_datetime' => now()->format('Y-m-d\TH:i')];
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function getTotalProperty()
    {
        $itemsTotal = collect($this->items)->sum(fn($item) => (float) $item['subtotal']);
        $servicesTotal = collect($this->services)->sum(fn($srv) => (float) $srv['rate']);
        return $itemsTotal + $servicesTotal;
    }

    public function update()
    {
        $this->validate([
            'payment_method' => 'required',
            'order_datetime' => 'required|date',
        ]);

        $this->order->update([
            'clinical_history_id' => $this->clinical_history_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'payment_method' => $this->payment_method,
            'order_datetime' => $this->order_datetime,
            'observation' => $this->observation,
            'total' => $this->total,
        ]);

        $this->order->items()->delete();
        $this->order->services()->delete();

        foreach ($this->items as $item) {
            if (!$item['inventory_id']) continue;

            $this->order->items()->create([
                'inventory_id' => $item['inventory_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        foreach ($this->services as $srv) {
            if (!$srv['service']) continue;

            $this->order->services()->create([
                'service' => $srv['service'],
                'rate' => $srv['rate'],
                'observation' => $srv['observation'],
                'service_datetime' => $srv['service_datetime'],
            ]);
        }

        session()->flash('success', 'Orden actualizada correctamente.');
        return redirect()->route('orders.index');
    }

    public function render()
    {
        return view('livewire.orders.order-edit')->layout('layouts.app');
    }
}