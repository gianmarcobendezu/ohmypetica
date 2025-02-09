<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalHistoryPhoto extends Model
{
    //
    protected $fillable = ['clinical_history_id', 'photo_path'];

    public function clinicalHistory()
    {
        return $this->belongsTo(ClinicalHistory::class);
    }
}
