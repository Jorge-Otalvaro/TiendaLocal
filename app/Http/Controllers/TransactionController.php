<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\TransactionStatu;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Facades\App\Payment;

class TransactionController extends Controller
{
    /**
     * Modelo de transaccion.
     *
     * @var Transaction
     */
    protected $transaction;

    /**
     * Constructor de la clase.
     *
     * @param Transaction $transaction Modelo transaccion.
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Recibe el informe de un pago.
     *
     * @return \Illuminate\Http\Response
     */
    public function receive($gateway, $uuid, Request $request)
    {
        $transaction = $this->transaction->getByUuid($uuid);

        if ($transaction) {

            $response = $this->updateStatus($transaction);
            
            $return = redirect()
                ->route("orders.show", ['order' => $transaction->order->id])
                ->withInput();

            if ($response['success'] == false) {
                return $return->withErrors($response['data']);
            }

            return $return->with('update', $response['data']);

        } else {
            toast('Receipt not found','warning');
        }
    }

    /**
     * Recibe el informe de un pago.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateStatus(Transaction $transaction)
    {
        $response = Payment::getInfoPay($transaction);

        if (! $response) {
            return [
                'success' => false,
                'data' => new \Illuminate\Support\MessageBag([
                    'msg_0' => 'El metodo de pago no esta soportado.',
                ]),
            ];
        }
        
        if (! $response->success) {
            return [
                'success' => false,
                'data' => new \Illuminate\Support\MessageBag([
                    'msg_0' => 'Se genero un error al actualizar la transacion.',
                    'msg_1' => $response->exception->getMessage()
                ]),
            ];
        }

        return [
            'success' => true,
            'data' => $response->data,
        ];
    }
}
