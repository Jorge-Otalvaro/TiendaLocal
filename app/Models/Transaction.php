<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',  
        'uuid',      
        'status',
        'reference',
        'url',
        'gateway',
        'requestId'
    ];

    /**
    * Relacion con la orden.
    *
    * @return Relacion.
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
    * Relacion con los estados.
    *
    * @return Relacion.
    */
    public function transaction_status()
    {
        return $this->hasMany(TransactionStatu::class);
    }

    /**
     * Almacena un nuevo registro.
     *
     * @param  array $data Datos para almacenar la transaccion.
     * @return Transaction|false Modelo con la transaccion nueva o un estado false si hay algun error.
     */
    public function store($data)
    {
        try {
            return self::create($data);
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }
    }

    /**
     * Adjunta estados a las transacciones.
     *
     * @param  array $data Datos para almacenar la transaccion.
     * @return Transaction|false Modelo con la transaccion nueva o un estado false si hay algun error.
     */
    public function attachStates($states)
    {
        try {
            return $this->transaction_status()->createMany($states);
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }
    }

    /**
     * Obtiene una transaccion por el uuid requerido.
     *
     * @param string $uuid Uuid de la transaccion a buscar.
     * @return Transaction Modelo.
     */
    public function getByUuid($uuid)
    {
        return $this->with(
            [
                "transaction_status" => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'order'
            ]
        )->where("uuid", $uuid)->first();
    }

    /**
     * Actualiza una transaccion.
     *
     * @param  array $data Datos para actualizar la transaccion.
     * @return Transaction|false Modelo con la transaccion.
     */
    public function edit($data)
    {
        try {
            return $this->fill($data)->save();
        } catch (\Illuminate\Database\QueryException $exception) {
            return false;
        }
    }
    
    /**
     * Actualiza la orden de una transaccion.
     *
     * @param  array $data Datos para actualizar la orden de la transaccion.
     * @return Order|false Modelo con la transaccion.
     */
    public function updateOrder($data)
    {
        try {           
            return $this->order->fill($data)->save();

        } catch (\Illuminate\Database\QueryException $exception) {            
            return false;
        }
    }

    /**
     * Obtiene todas las transacciones por estado.
     *
     * @param array $status Estados de las transacciones a buscar.
     * @return Collection Coleccion con los Modelos.
     */
    public static function getByStatus(array $status)
    {
        return self::with(
            [
                "transaction_status" => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'order'
            ]
        )->whereIn('status', $status)
            ->whereNotNull('requestId')
            ->get();
    }
}
