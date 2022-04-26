<?php

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Vista principal 
Route::get('/', [ProductController::class, 'index']);

// Generar nuevos productos 
Route::get('/news-products', function () {
	Artisan::call('db:seed --class=ProductSeeder');
	Alert::success('Products updated', 'Products updated successfully');
	return redirect('/')->with('success', 'Products updated successfully');
})->name('new-products');

// 
Route::get('/checkout/{id}', 
	[ProductController::class, 'formCheckout']
)->name('checkout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//
// Route::get('/orders-list', function () {
//     return view('orders/orders-lists');
// })->middleware(['auth'])->name('orders');


// Auth::routes([
//     'reset' => false,
//     'confirm' => false,
//     'verify' => false,
// ]);

Route::resource('orders', OrderController::class)->only([
    'index', 'store', 'show'
]);

require __DIR__.'/auth.php';
