<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Transaction;
use App\Strategies\Pay\Context;
use App\Strategies\Pay\PlaceToPay;
use App\Strategies\Pay\Test;


class PaymentObserver
{
    /**
     * @var array $paymentMethodsEnable Metodos de pagos habilitados.
     */
    private static $paymentMethodsEnable=[
        "place_to_pay" => PlaceToPay::class,
        "test" => Test::class,
    ];

    private function createStrategy(string $typePay)
    {
        try {
            if (isset(self::$paymentMethodsEnable[$typePay])) {
                if ($typePay == "place_to_pay") {
                    return Context::create(
                        new self::$paymentMethodsEnable[$typePay](
                            resolve('Dnetix\Redirection\PlacetoPay'),
                            new Transaction()
                        )
                    );
                }
    
                return Context::create(new self::$paymentMethodsEnable[$typePay]);
            }
        } catch (\Dnetix\Redirection\Exceptions\PlacetoPayException $e) {
            \Log::info($e->getMessage());
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
        return false;
    }

    public static function pay(string $typePay, Order $order)
    {
        if ($data = $this->createStrategy($typePay)) {
            return $data->pay($order);
        }

        return false;
    }

    public function getInfoPay(Transaction $transaction)
    {
        if ($data = $this->createStrategy($transaction->gateway)) {
            return $data->getInfoPay($transaction);
        }

        return false;
    }
    
}
