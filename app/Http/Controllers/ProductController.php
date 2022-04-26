<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class ProductController extends Controller
{
	public function __construct()
    {
        
    }

    public function index()
    {
    	$products = Product::latest()->paginate(8);

        return view('welcome', compact('products'))
        ->with('i', (request()->input('page', 1) - 1) * 8);
    }

    public function formCheckout($request)
    {
    	$product = Product::find($request);

        return view('form-checkout', compact('product'));
    }
}
