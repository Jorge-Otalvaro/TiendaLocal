<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;

use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Route;

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
Route::get('/news-products', 
    [ProductController::class, 'loadProducts']
)->name('new-products');

// 
Route::get('/checkout/{id}', 
	[ProductController::class, 'formCheckout']
)->name('checkout');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');   

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(
    [
        'prefix' => 'orders', 
        'middleware' => ['auth'],
        'middleware' => ['verified'],
    ],
    function() {
        Route::get('/', [OrderController::class, 'index'])
            ->name('orders.index');        

            Route::get('/{order}', [OrderController::class, 'show'])
            ->where('order', '[0-9]+')
            ->name('orders.show');

        Route::get('{order}/pay', [OrderController::class, 'payment'])
            ->where('order', '[0-9]+')
            ->name('orders.payment');
    }
);

Route::group(
    [
        'prefix' => 'transactions', 
        'middleware' => ['auth'],
        'middleware' => ['verified'],
    ],
    function() {
        Route::get('/receive/{gateway}/{uuid}',
            [TransactionController::class, 'receive'])
            ->where('uuid', '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}')
            ->name('transactions.receive');        
    }
);

Route::get('/notification/unread/{id}', function ($id) {
    $notification = auth()->user()->notifications()->find($id);
    $notification->markAsRead();
    return redirect($notification->data['url']);
})->name('notification.unread');

require __DIR__.'/auth.php';
