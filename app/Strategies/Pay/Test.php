<?php
namespace App\Strategies\Pay;

use App\Strategies\Pay\Strategy;
use App\Models\Order;
use App\Models\Transaction;

class Test implements Strategy
{
    public function pay(Order $order)
    {
        return (object) [
            'success' => true,
            'url' => 'https://github.com/Jorge-Otalvaro/TiendaLocal',
        ];
    }
    
    public function getInfoPay(Transaction $transaction)
    {
        return (Object) [
            "success" => true,
            "data" => [
                "status" => 'CREATED',
                "message" => 'Pago creado.',
            ]
        ];
    }
}
