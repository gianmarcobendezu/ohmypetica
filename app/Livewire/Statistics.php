<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Statistic;
use App\Models\Service;
use App\Models\ClinicalHistory;
use App\Models\ClinicalHistoryDetail;
use Carbon\Carbon;


class Statistics extends Component
{

    public $name;
    public $statistics;
    public $totalSales;
    public $services;
    public $totalServices;
    public $totalBañoServices;
    public $totalMascotas;

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



    }

    public function render()
    {
        return view('livewire.statistics')->layout('layouts.app');;
    }

}