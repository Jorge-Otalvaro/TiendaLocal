<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price'
    ];

    /**
    * Accesor para el el precio formateado.
    *
    * @return string Nombre.
    */
    public function getTotalFormatAttribute()
    {
        return '$'.number_format($this->price, 2, ',', '.');
    }
}
