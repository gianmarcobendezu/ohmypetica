<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class Services extends Component
{
    public $name;
    public $services;

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $this->services = Service::all();
    }

    public function addService()
    {
        $this->validate([
            'name' => 'required|unique:services,name|max:255',
        ]);

        Service::create(['name' => $this->name]);

        $this->name = ''; // Limpiar el input
        $this->loadServices(); // Recargar la lista
        session()->flash('message', 'Servicio agregado exitosamente.');
    }

    public function deleteService($id)
    {
        Service::findOrFail($id)->delete();
        $this->loadServices(); // Recargar la lista
        session()->flash('message', 'Servicio eliminado exitosamente.');
    }

    public function render()
    {
        return view('livewire.services')->layout('layouts.app');
    }
}
