<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // 👈 Importa el trait

use App\Models\Inventory;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Inventories extends Component
{   

    use WithFileUploads; // 👈 Usa el trait aquí
    use WithPagination;
    public $categories;
    public $services;

  
    public $description, $quantity, $price, $unit, $image, $idestado, $inventoryId;
    public $idcategoria;
    public $inventories;
    public $editMode = false;

public function mount() {
    $this->loadInventories();
    $this->categories = Category::all();
}

public function loadInventories() {
    $this->inventories = Inventory::all();
}

public function addInventory() {
    $this->validate([
        'description' => 'required',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'unit' => 'required',
        'idestado' => 'required|integer',
        'image' => 'nullable|image|max:2048',
        
    ]);

    $imagePath = $this->image ? $this->image->store('inventories', 'public') : null;

    Inventory::create([
        'description' => $this->description,
        'quantity' => $this->quantity,
        'price' => $this->price,
        'unit' => $this->unit,
        'idestado' => $this->idestado,
        'image' => $imagePath,
        'idcategoria' => $this->idcategoria
    ]);

    $this->reset(['description', 'quantity', 'price', 'unit', 'idestado', 'image','idcategoria']);
    session()->flash('message', 'Inventario agregado correctamente.');
    $this->loadInventories();
}

public function editInventory($id) {
    $inventory = Inventory::findOrFail($id);
    $this->description = $inventory->description;
    $this->quantity = $inventory->quantity;
    $this->price = $inventory->price;
    $this->unit = $inventory->unit;
    $this->idestado = $inventory->idestado;
    $this->inventoryId = $id;
    $this->editMode = true;
    $this->idcategoria = $inventory->idcategoria;
}

public function updateInventory()
{
    $inventory = Inventory::findOrFail($this->inventoryId);

    $this->validate([
        'description' => 'required',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'unit' => 'required',
        'idestado' => 'required|integer',
        'image' => 'nullable|image|max:1024', // Agregado para la imagen
    ]);

    // Si se subió una nueva imagen
    if ($this->image) {
        // Eliminar imagen anterior si existe
        if ($inventory->image && Storage::disk('public')->exists($inventory->image)) {
            Storage::disk('public')->delete($inventory->image_path);
        }

        // Guardar la nueva imagen
        $path = $this->image->store('inventories', 'public');
        $inventory->image = $path;
    }

    // Actualizar campos restantes
    $inventory->update([
        'description' => $this->description,
        'quantity' => $this->quantity,
        'price' => $this->price,
        'unit' => $this->unit,
        'idestado' => $this->idestado,
        'image' => $inventory->image, // aseguramos que se guarde lo nuevo si hay
        'idcategoria' => $this->idcategoria

    ]);

    $this->reset(['description', 'quantity', 'price', 'unit', 'idestado', 'image', 'editMode', 'inventoryId','idcategoria']);
    session()->flash('message', 'Inventario actualizado.');
    $this->loadInventories();
}

public function deleteInventory($id) {
    $inventory = Inventory::findOrFail($id);
    if ($inventory->image) {
        Storage::disk('public')->delete($inventory->image);
    }
    $inventory->delete();
    session()->flash('message', 'Inventario eliminado.');
    $this->loadInventories();
}

/*
    public function loadInventory()
    {
        $this->services = Inventory::where('idestado', '<>', 0)
        ->orderBy('id', 'desc')
        ->get();

    }

 */

    public function render()
    {
        return view('livewire.inventory')->layout('layouts.app');;
    }

}