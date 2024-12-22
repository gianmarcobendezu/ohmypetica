<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalHistoryDetail extends Model
{
    //
    protected $fillable = [
        'clinical_history_id',
        'service',
        'rate',
        'payment_method',
        'service_datetime',
        'observation',
    ];

    public function clinicalHistory()
    {
        return $this->belongsTo(ClinicalHistory::class);
    }

}
