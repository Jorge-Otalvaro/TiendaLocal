<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Artisan;

class ProductController extends Controller
{
    /**
     * Ver todos los productos 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$products = Product::latest()->paginate(8);
        return view('welcome', compact('products'))
        ->with('i', (request()->input('page', 1) - 1) * 8);
    }

    /**
     * Cargar nuevos productos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadProducts()
    {
        Artisan::call('db:seed --class=ProductSeeder');
        Alert::success('Products updated', 'Products updated successfully');
        return redirect('/');
    }

    /**
     * Vista donde el cliente proporciona los datos para generar una nueva orden 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function formCheckout($request)
    {
    	$product = Product::find($request);
        return view('form-checkout', compact('product'));
    }
}
