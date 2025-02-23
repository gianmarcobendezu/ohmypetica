<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use Carbon\Carbon;
use App\Models\ClinicalHistoryDetail;

class BathReminderController extends Controller
{
    public function checkBathReminders()
    {
        $smsService = new SmsService();
        $ownerPhone = env('OWNER_PHONE');

        $bathReminders = ClinicalHistoryDetail::where('clinical_history_details.service', 'LIKE', '%baño%')
            ->leftJoin('clinical_histories', 'clinical_histories.id', '=', 'clinical_history_details.clinical_history_id')
            ->select('clinical_history_details.clinical_history_id', 'clinical_history_details.service_datetime', 'clinical_histories.pet_name')
            ->where('clinical_history_details.idestado', '<>', 0)
            ->where('clinical_histories.status', '<>', 0)
            ->orderBy('clinical_history_details.service_datetime', 'desc')
            ->get()
            ->groupBy('clinical_history_id')
            ->map(function ($baths) {
                $lastBath = $baths->first();
                $daysSinceLastBath = Carbon::parse($lastBath->service_datetime)->diffInDays(Carbon::now());

                return [
                    'pet_name' => $lastBath->pet_name,
                    'days_since_last_bath' => (int) $daysSinceLastBath,
                    'needs_reminder' => $daysSinceLastBath > 20,
                ];
            })
            ->filter(function ($bath) {
                return $bath['needs_reminder'];
            });

        $totalBathsPending = $bathReminders->count();

        //if ($totalBathsPending > 0) {
            $nombresMascotas = $bathReminders->pluck('pet_name')->implode(', ');
            $message = "📢 OhMyPetIca System: Tienes {$totalBathsPending} mascotas que necesitan baño: {$nombresMascotas}.";
            $smsService->sendSms($ownerPhone, $message);
        //}

        return response()->json(['message' => 'Revisión completada']);
    }
}