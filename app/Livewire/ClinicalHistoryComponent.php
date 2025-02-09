<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClinicalHistory;
use App\Models\ClinicalHistoryDetail;

use App\Models\ClinicalHistoryPhoto;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class ClinicalHistoryComponent extends Component
{
    use WithFileUploads;
    public $photos = [];
    public $clinicalHistories;
    public $pet_name, $breed, $birth_date, $observation, $owner_name, $phone1, $phone2;
    public $selected_id;
    public $isOpen = false;
    public $searchTerm;
    public $page = 1; // Ensure to handle pagination state

    public $selectedHistory=null;
    public $showModal = false;
    public $confirmingDelete = false;
    public $deleteId = null;
    public $showModalPhotos=false;
    
    public $showDetailModal = false;
    public $service;
    public $rate;
    public $payment_method;
    public $service_datetime;
    public $observationdetail;
    public $clinicalHistoryId; // El id de la historia clínica seleccionada

    public $selectedPhotos = [];


    protected $rules = [
        'pet_name' => 'required|string',
        'breed' => 'required|string',
        'birth_date' => 'nullable|date',
        'observation' => 'nullable|string',
        'owner_name' => 'nullable|string',
        'phone1' => 'nullable|string',
        'phone2' => 'nullable|string'
    ];

    public function mount()
    {
        $this->showModal=false;
        $this->loadData();
    }

    public function openPhotoModal($historyId)
    {
        $this->selectedPhotos = ClinicalHistoryPhoto::where('clinical_history_id', $historyId)->get();
        $this->showModalPhotos = true;
        
    }

    public function loadData()
    {
        $this->clinicalHistories = ClinicalHistory::where('status', 1)->get();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true; // Activa el modal
    }

    public function updatedPhotos()
{
    if ($this->selectedHistory) {
        $historyId = $this->selectedHistory;
        $folderPath = "photos/{$historyId}"; // Carpeta específica para cada historia

        foreach ($this->photos as $photo) {
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs($folderPath, $filename, 'public');

            ClinicalHistoryPhoto::create([
                'clinical_history_id' => $historyId,
                'photo_path' => "{$folderPath}/{$filename}" // Guardamos la ruta relativa
            ]);
        }

        $this->photos = [];
        // session()->flash('message', 'Fotos subidas con éxito.');
    }
}

    public function deletePhoto($photoId)
    {
        $photo = ClinicalHistoryPhoto::findOrFail($photoId);
        $historyId=$photo->clinical_history_id;
        Storage::disk('public')->delete($historyId.'/'.$photo->photo_path);
        $photo->delete();
        
        // Recargar imágenes después de eliminar
        $this->selectedPhotos = ClinicalHistoryPhoto::where('clinical_history_id', $photo->clinical_history_id)->get();
    }

    public function render()
    {
        /*
        $this->clinicalHistories = ClinicalHistory::where('pet_name', 'like', '%'.$this->search.'%')
        ->get();

        return view('livewire.clinical-history')->layout("layouts.app");
        */
        $this->clinicalHistories = ClinicalHistory::with('photos')->where('status', 1)->get(); // Mostrar solo registros activos

        /*
        if ($this->search) {
            $clinicalHistories = $clinicalHistories
                ->where('pet_name', 'like', '%' . $this->search . '%')
                ->orWhere('service', 'like', '%' . $this->search . '%');
        }*/

        return view('livewire.clinical-history')->layout('layouts.app');

    }

    public function openDetailModal($id)
    {
        $this->clinicalHistoryId = $id;
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->resetForm(); // Reinicia el formulario si lo deseas
    }

    public function resetForm()
    {
        $this->service = '';
        $this->rate = '';
        $this->payment_method = '';
        $this->service_datetime = '';
        $this->observationdetail = '';
    }

    public function addDetail()
    {
        $this->validate([
            'service' => 'required|string|max:255',
            'rate' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'service_datetime' => 'required|date',
            'observation' => 'nullable|string',
        ]);

        // Crear el detalle de la historia clínica
        ClinicalHistoryDetail::create([
            'clinical_history_id' => $this->clinicalHistoryId,
            'service' => $this->service,
            'rate' => $this->rate,
            'payment_method' => $this->payment_method,
            'service_datetime' => $this->service_datetime,
            'observation' => $this->observationdetail,
        ]);

        // Cerrar el modal y resetear el formulario
        $this->closeDetailModal();

        session()->flash('message', 'Detalle agregado exitosamente.');
    }

    public function deleteService($serviceId)
    {
        $service = ClinicalHistoryDetail::find($serviceId);

        if ($service) {
            $service->idestado = 0; // Cambiar el estado a 0
            $service->save();
    
            session()->flash('message', 'Servicio eliminado correctamente.');
        } else {
            session()->flash('error', 'No se pudo encontrar el servicio.');
        }
    
        // Actualiza los detalles mostrados en el modal
        $this->selectedHistory->load('details');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isOpen = true;
    }

    public function showDetails($id)
    {
        //$this->selectedHistory = ClinicalHistory::find($id);
        $this->selectedHistory = ClinicalHistory::with('details')->find($id);

        $this->showModal = true; // Mostrar el modal
    }

    public function closeModal()
    {
        
        $this->showModal = false; // Cerrar el modal
        $this->selectedHistory = null;
    }

    
    public function store()
    {
        $this->validate();

        ClinicalHistory::updateOrCreate(['id' => $this->selected_id], [
            'pet_name' => $this->pet_name,
            'breed' => $this->breed,
            'birth_date' => $this->birth_date ?: null, // Si está vacío, guardamos como null
            'observation' => $this->observation,
            'owner_name' => $this->owner_name,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2
        ]);
        
        session()->flash('message', 'Historia clínica guardada exitosamente.');


        $this->isOpen = false;
        $this->resetInputFields();
        //$this->emit('closeModal');
        //$this->emit('refreshList');
        //$this->emit('refreshComponent'); // Esto puede ser útil si estás utilizando un modal o una interfaz dinámica
        
    }

    public function edit($id)
    {
        $history = ClinicalHistory::findOrFail($id);
        $this->selected_id = $id;
        $this->pet_name = $history->pet_name;
        $this->breed = $history->breed;
        $this->birth_date = $history->birth_date;
        $this->observation = $history->observation;
        $this->owner_name = $history->owner_name;
        $this->phone1 = $history->phone1;
        $this->phone2 = $history->phone2;
        
        $this->isOpen = true;
    }

    public function searchdata()
    {
        $this->clinicalHistories = ClinicalHistory::where('pet_name', 'like', '%'.$this->searchTerm.'%')
        ->get();

        return view('livewire.clinical-history')->layout("layouts.app");
    }

    public function delete($id)
    {
        //ClinicalHistory::find($id)->delete();
        $clinicalHistory = ClinicalHistory::find($id);
        if ($clinicalHistory) {
            $clinicalHistory->update(['status' => 0]); // Cambiar el estado a 0
        }

        $this->confirmingDelete = false; // Cierra el modal
        $this->deleteId = null; // Limpia el ID

        // Opcional: Emitir un mensaje de éxito para el usuario
        session()->flash('message', 'Registro eliminado correctamente.');
    }

    private function resetInputFields()
    {
        $this->pet_name = '';
        $this->breed = '';
        $this->birth_date = '';
        $this->observation = '';
        $this->owner_name = '';
        $this->phone1 = '';
        $this->phone2 = '';
        $this->selected_id = null;
    }

}
