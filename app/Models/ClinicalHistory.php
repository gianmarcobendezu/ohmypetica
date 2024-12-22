<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalHistory extends Model
{
    //
    protected $fillable = [
        'pet_name', 'breed', 'birth_date', 'service', 
        'observation', 'owner_name', 'phone1', 'phone2', 
        'rate', 'payment_method','status'
    ];

    public function details()
    {
        return $this->hasMany(ClinicalHistoryDetail::class)->where('idestado', 1);
    }
}
