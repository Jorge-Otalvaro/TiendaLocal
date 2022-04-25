<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function __construct()
    {
        
    }

    public function index()
    {
    	$products = Product::all();

        return view('welcome', compact('products'));
    }

    public function formCheckout($request)
    {
    	$product = Product::find($request);

        return view('form-checkout', compact('product'));
    }
}
