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


class OrderController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth')->only('index');
        $this->middleware('auth')->except('store');
    }

    public function index()
    {
    	$orders = Order::latest()->where('customer_email', Auth::user()->email)->paginate(8);

        return view('orders/orders-lists', compact('orders'))
        ->with('i', (request()->input('page', 1) - 1) * 8);
    }

    /**
     * Store a new Order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$request->validate([
    		'name' => ['required', 'string', 'max:80'],
    		'mobile' => ['required', 'numeric', 'min:10'],
	        'email' => ['required', 'string', 'email', 'max:120'],
            'product' => ['required', 'exists:App\Models\Product,id']
        ]);    	

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

	        // toast('Hola,'. $user->name .' Tu usuario ha sido Creado, y las credenciales fueron enviadas al correo','success');   

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

        return redirect('/orders');
    }
}
