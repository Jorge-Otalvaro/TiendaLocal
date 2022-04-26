<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'status',
        'product_id'
    ];

    /**
     * Get the cliente associated with the Factura.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
