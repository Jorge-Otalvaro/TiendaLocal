<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\NewTransactionStatus;

class TransactionStatu extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'status',
        'data'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => NewTransactionStatus::class,
    ];

    /**
    * Relacion con la transaccion.
    *
    * @return Relacion.
    */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
