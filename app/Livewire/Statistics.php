<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Statistic;
use App\Models\Service;
use App\Models\ClinicalHistory;
use App\Models\ClinicalHistoryDetail;
use App\Models\Order;
use Carbon\Carbon;
use DB;

class Statistics extends Component
{

    public $name;
    public $statistics;
    public $totalSales;
    public $services;
    public $totalServices;
    public $totalBañoServices;
    public $totalMascotas;
    public $totalSalesOrders;
    public $totalItemSales = 0;

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Obtener los servicios del mes actual y calcular la suma del campo 'rate'
        $this->totalSales = ClinicalHistoryDetail::whereBetween('service_datetime', [$startOfMonth, $endOfMonth])
            ->get();

        $this->services = ClinicalHistoryDetail::whereBetween('service_datetime', [$startOfMonth, $endOfMonth])
            ->get();

        $this->totalBañoServices = ClinicalHistoryDetail::where('service', 'like', '%baño%')
            ->whereBetween('service_datetime', [$startOfMonth, $endOfMonth])
            ->count();
    
        // Obtener el total de mascotas del mes (contando las historias clínicas creadas este mes)
        $this->totalMascotas = ClinicalHistory::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Calcular el total de ventas del mes actual sumando los valores de 'rate'
        $totalSales = $this->totalSales->sum('rate');

        // Puedes agregar la suma al resultado de alguna forma, por ejemplo, en una variable
        $this->totalSales = $totalSales;

        $this->totalServices = $this->services->count();
        
        $this->totalSalesOrders = Order::whereBetween('order_datetime', [$startOfMonth, $endOfMonth])
            ->get();

        $totalSalesOrders = $this->totalSalesOrders->sum('total');
        $this->totalSalesOrders=$totalSalesOrders;

         // 🔢 Total de ventas por ítems (desde order_items)
            $totalSalesItems = DB::table('order_items')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereBetween('orders.order_datetime', [$startOfMonth, $endOfMonth])
            ->sum('order_items.subtotal');

        // Puedes guardar este resultado en una variable pública
        $this->totalItemSales = $totalSalesItems;

    }

    public function render()
    {
        return view('livewire.statistics')->layout('layouts.app');;
    }

}