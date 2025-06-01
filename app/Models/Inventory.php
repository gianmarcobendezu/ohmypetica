<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //

    protected $fillable = [
        'description',
        'quantity',
        'price',
        'unit',
        'image',
        'idcategoria',
        'idestado',
        'cost' 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'idcategoria');
    }
}
