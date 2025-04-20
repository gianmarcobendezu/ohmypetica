<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryComponent extends Component
{
    public $name, $categoryId;
    public $editMode = false;
    public $categories;
    public $idestado = 1;

    // En rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'idestado' => 'required|integer',
    ];
    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = Category::orderBy('id', 'desc')->get();
    }

    public function saveCategory()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'idestado' => $this->idestado,
        ]);

        $this->resetInput();
        session()->flash('message', 'Categoría creada.');
        $this->loadCategories();
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->name = $category->name;
        $this->idestado = $category->idestado;
        $this->categoryId = $category->id;
        $this->editMode = true;
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->categoryId);
        $category->update([
            'name' => $this->name,
            'idestado' => $this->idestado,
        ]);

        $this->resetInput();
        session()->flash('message', 'Categoría actualizada.');
        $this->loadCategories();
    }

    public function deleteCategory($id)
    {
        Category::destroy($id);
        session()->flash('message', 'Categoría eliminada.');
        $this->loadCategories();
    }

    public function resetInput()
    {
        $this->reset(['name', 'categoryId', 'editMode', 'idestado']);

    }

    public function render()
    {
        return view('livewire.category-component')->layout('layouts.app');
    }
}
