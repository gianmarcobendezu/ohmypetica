<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Inventory;
use App\Models\ClinicalHistory;
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
            ];
        })->toArray();

        $this->services = $order->services->map(function ($service) {
            return [
                'service' => $service->service,
                'rate' => $service->rate,
                'observation' => $service->observation,

                'service_datetime' => Carbon::parse($service->service_datetime)->format('Y-m-d\TH:i')
            ];
        })->toArray();

        $this->inventories = Inventory::where('quantity', '>', 0)->get();
        $this->histories = ClinicalHistory::all();
    }

    public function updateItemRow($index)
    {
        if (!isset($this->items[$index]['inventory_id'])) return;

        $inventory = Inventory::find($this->items[$index]['inventory_id']);

        if ($inventory) {
            $this->items[$index]['unit_price'] = $inventory->price;
        }

        $quantity = (float) $this->items[$index]['quantity'] ?? 0;
        $price = (float) $this->items[$index]['unit_price'] ?? 0;

        $this->items[$index]['subtotal'] = $quantity * $price;
    }

    public function addItem()
    {
        $this->items[] = ['inventory_id' => '', 'quantity' => 1, 'unit_price' => '', 'subtotal' => 0];
    }
    public function getTotalProperty()
{
    $itemsTotal = collect($this->items)->sum(function($item) {
        return $item['subtotal'];  // Asumiendo que 'subtotal' está calculado correctamente.
    });

    $servicesTotal = collect($this->services)->sum(function($service) {
        return $service['rate'];  // Asumiendo que 'rate' es el precio del servicio.
    });

    return $itemsTotal + $servicesTotal;
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

    public function update()
    {

        $totalItems = 0;
        $totalServices = 0;

        $this->validate([
            'clinical_history_id' => 'nullable|exists:clinical_histories,id',
            'customer_name' => 'required',
            'customer_phone' => 'required',
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
        ]);

        // Eliminar antiguos
        $this->order->items()->delete();
        $this->order->services()->delete();

        // Reinsertar nuevos
        foreach ($this->items as $item) {
            $created = $this->order->items()->create($item);
            $totalItems += $created->subtotal;
        }

        foreach ($this->services as $service) {
            $created =  $this->order->services()->create($service);
            $totalServices += $created->rate;
        }

        $totalGeneral = $totalItems + $totalServices;

        $this->order->update([
            'total' => $totalGeneral
        ]);

        session()->flash('success', 'Orden actualizada correctamente.');
        return redirect()->route('orders.index');
    }

    public function render()
    {
        return view('livewire.orders.order-edit')->layout('layouts.app');
    }

}