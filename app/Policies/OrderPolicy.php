<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $user->email == $order->customer_email;
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determina si el usuario puede pagar la orden.
     *
     * @param  \App\User  $user Usuario.
     * @param  \App\Models\Order  $order Orden.
     * @return mixed
     */
    public function payment(User $user, Order $order)
    {
        return $user->email == $order->customer_email;
    }
}
