<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Artisan;

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
 
Route::get('/', [ProductController::class, 'index']);

Route::get('/news-products', function () {
	Artisan::call('db:seed --class=ProductSeeder');
	return redirect('/')->with('success', 'Products updated successfully');
})->name('new-products');

Route::get('/checkout/{id}', 
	[ProductController::class, 'formCheckout']
)->middleware(['auth'])->name('checkout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
