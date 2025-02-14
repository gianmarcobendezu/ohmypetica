<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClinicalHistoryDetail;

class Sales extends Component
{

    public $sales;

    public function mount()
    {
        $this->loadSales();
    }

    public function loadSales()
    {
        //$this->sales = ClinicalHistoryDetail::all();
        $this->sales = ClinicalHistoryDetail::where('idestado', '<>', 0)
        ->orderBy('id', 'desc')
        ->get();

    }

    public function render()
    {
        return view('livewire.sales')->layout('layouts.app');;
    }

}