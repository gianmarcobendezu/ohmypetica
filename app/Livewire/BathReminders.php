<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClinicalHistoryDetail;
use Carbon\Carbon;

class BathReminders extends Component
{
    public $bathReminders = [];

    public function mount()
    {
        $this->loadBathReminders();
    }

    public function loadBathReminders()
    {
        $this->bathReminders = ClinicalHistoryDetail::where('clinical_history_details.service', 'LIKE', '%baño%') // Filtra solo los baños
        ->leftJoin('clinical_histories', 'clinical_histories.id', '=', 'clinical_history_details.clinical_history_id') // Corrección del JOIN
        ->select('clinical_history_details.clinical_history_id', 'clinical_history_details.service_datetime', 'clinical_histories.pet_name') // Selecciona los datos correctos
        ->where('clinical_history_details.idestado', '<>',0) // Selecciona los datos correctos
        ->where('clinical_histories.status', '<>',0) // Selecciona los datos correctos

        ->orderBy('clinical_history_details.service_datetime', 'desc') // Ordena por fecha descendente (último baño primero)
        ->get()
        ->groupBy('clinical_history_id') // Agrupa por historia clínica (una por mascota)
        ->map(function ($baths) {
            $lastBath = $baths->first(); // Obtiene el último baño registrado
            $daysSinceLastBath = Carbon::parse($lastBath->service_datetime)->diffInDays(Carbon::now()); // Usa service_datetime

            return [
                'pet_name' => $lastBath->pet_name,
                'last_bath_date' => Carbon::parse($lastBath->service_datetime)->format('d/m/Y'), // Usa service_datetime
                'days_since_last_bath' => (int) $daysSinceLastBath,
                'needs_reminder' => $daysSinceLastBath > 20, // Si han pasado más de 20 días, activar alerta
            ];
        })->values();
    }

    public function render()
    {
        return view('livewire.bath-reminders')->layout('layouts.app');
    }
}
