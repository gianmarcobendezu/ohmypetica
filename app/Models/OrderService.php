<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{

    protected $fillable = [
        'order_id',
        'service',
        'rate',
        'observation',
        'service_datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
