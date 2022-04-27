<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreOrderRequest;
use App\Observers\PaymentObserver;

class OrderController extends Controller
{
    /**
     * Modelo de orden.
     *
     * @var Order
     */
    protected $order;

    public function __construct(Order $order)
    {
        $this->middleware('auth')->except('store');
    	$this->middleware('auth')->only('index');
        $this->middleware('auth')->only('show');
        $this->middleware('auth')->only('payment');

        $this->order = $order;
    }


    /**
     * Ver todas las ordenes del usuario autenticado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$orders = Order::latest()->where('customer_email', Auth::user()->email)->paginate(8);

        return view('orders/orders-lists', compact('orders'))
        ->with('i', (request()->input('page', 1) - 1) * 8);
    }

    /**
     * Crear una orden.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $request->validated();

        $userAutenticate = Auth::check();

        if (!$userAutenticate) {

        	$request->validate([
	            'mobile' => ['unique:users'],
	            'email' => ['unique:users']
	        ]);

		   	$passwordNew = Str::random(10);

	        $user = User::create([
	            'name' => $request->name,
	            'mobile' => $request->mobile,
	            'email' => $request->email,
	            'password' => Hash::make($passwordNew),
	        ]);

	        Auth::login($user);
		}

        $productId = Product::find($request->product);

        $order = Order::create([
            'customer_name' => $request->name,
            'customer_mobile' => $request->mobile,
            'customer_email' => $request->email,
            'status' => 'CREATED',
            'product_id' => $productId->id,
        ]);

        toast('Order generated','success');

        if ($order) {
            return redirect()->route("orders.show", ['order' => $order->id]);
        } else {
            $errors = new \Illuminate\Support\MessageBag();
            $errors->add('msg_0', "Se genero un error almacenando la orden.");
            return back()->withInput()->withErrors($errors);
        }
    }

    /**
     * Muestra el detalle de una orden.
     *
     * @param  int  $idOrder Id de la orden.
     * @return \Illuminate\Http\Response
     */
    public function show($request)
    {
        $order = Order::where('customer_email', Auth::user()->email)->find($request);

        if (!$order) {
            toast('Order not exists','success');
            return redirect()->route("orders.index");
        }

        return view('orders/checkout', compact('order'));
    }

    /**
     * Iniciar un pago.
     *
     * @param  Order $order Modelo para pagar.
     * @return \Illuminate\Http\Response
     */
    public function payment(Order $order)
    {
        if ($order->status != 'CREATED') {
            return redirect()->route("orders.show", ['order' => $order->id]);
        }
        
        $transaction = $order->getLastTransaction();
        
        if (! $transaction || ($transaction->current_status != "PENDING" && $transaction->current_status != "CREATED")) {
            $response = PaymentObserver::pay('place_to_pay', $order);
            if (! $response) {
                return redirect()
                    ->route("orders.show", ['order' => $order->id])
                    ->withInput()
                    ->withErrors(new \Illuminate\Support\MessageBag([
                        'msg_0' => 'El metodo de pago no esta soportado.'
                    ]));
            }

            if (! $response->success) {
                return redirect()
                    ->route("orders.show", ['order' => $order->id])
                    ->withInput()
                    ->withErrors(new \Illuminate\Support\MessageBag([
                        'msg_0' => 'Se genero un error al crear la transacion.',
                        'msg_1' => $response->exception->getMessage()
                    ]));
            }
            return redirect($response->url);
        } else {
            if ($transaction->current_status != "CREATED") {
                return redirect()->route("orders.show", ['order' => $order->id]);
            }
            return redirect($transaction->url ?? "");
        }
    }
}
