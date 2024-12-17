<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClinicalHistory;

class ClinicalHistoryComponent extends Component
{

    public $clinicalHistories;
    public $pet_name, $breed, $birth_date, $service, $observation, $owner_name, $phone1, $phone2, $rate, $payment_method;
    public $selected_id;
    public $isOpen = false;
    public $search;
    public $page = 1; // Ensure to handle pagination state


    protected $rules = [
        'pet_name' => 'required|string',
        'breed' => 'required|string',
        'birth_date' => 'required|date',
        'service' => 'required|string',
        'observation' => 'nullable|string',
        'owner_name' => 'required|string',
        'phone1' => 'required|string',
        'phone2' => 'nullable|string',
        'rate' => 'required|numeric',
        'payment_method' => 'required|string',
    ];

    public function render()
    {
        $this->clinicalHistories = ClinicalHistory::where('pet_name', 'like', '%'.$this->search.'%')
        ->get();

        return view('livewire.clinical-history');

    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }


    
    public function store()
    {
        $this->validate();

        ClinicalHistory::updateOrCreate(['id' => $this->selected_id], [
            'pet_name' => $this->pet_name,
            'breed' => $this->breed,
            'birth_date' => $this->birth_date,
            'service' => $this->service,
            'observation' => $this->observation,
            'owner_name' => $this->owner_name,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'rate' => $this->rate,
            'payment_method' => $this->payment_method,
        ]);
        
        session()->flash('message', 'Historia clínica guardada exitosamente.');


        $this->isOpen = false;
        $this->resetInputFields();
        $this->emit('closeModal');
        $this->emit('refreshList');
        //$this->emit('refreshComponent'); // Esto puede ser útil si estás utilizando un modal o una interfaz dinámica
        
    }

    public function edit($id)
    {
        $history = ClinicalHistory::findOrFail($id);
        $this->selected_id = $id;
        $this->pet_name = $history->pet_name;
        $this->breed = $history->breed;
        $this->birth_date = $history->birth_date;
        $this->service = $history->service;
        $this->observation = $history->observation;
        $this->owner_name = $history->owner_name;
        $this->phone1 = $history->phone1;
        $this->phone2 = $history->phone2;
        $this->rate = $history->rate;
        $this->payment_method = $history->payment_method;

        $this->isOpen = true;
    }

    public function delete($id)
    {
        ClinicalHistory::find($id)->delete();
    }

    private function resetInputFields()
    {
        $this->pet_name = '';
        $this->breed = '';
        $this->birth_date = '';
        $this->service = '';
        $this->observation = '';
        $this->owner_name = '';
        $this->phone1 = '';
        $this->phone2 = '';
        $this->rate = '';
        $this->payment_method = '';
        $this->selected_id = null;
    }

}
