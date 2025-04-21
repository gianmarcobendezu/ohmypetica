<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'clinical_history_id',
        'customer_name',
        'customer_phone',
        'total',
        'payment_method',
        'order_datetime',
        'observation'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    

    public function services()
    {
        return $this->hasMany(OrderService::class);
    }

    public function clinicalHistory()
    {
        return $this->belongsTo(ClinicalHistory::class);
    }
}
