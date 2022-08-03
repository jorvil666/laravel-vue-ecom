<?php

use App\Http\Controllers\CarritoTiendaController;
use App\Http\Controllers\PaymentPayPalController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductoTiendaController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [ProductoTiendaController::class, 'index']);
Route::get('/categorias', [ProductoTiendaController::class, 'obtenerCategorias']);

Auth::routes();

Route::post('/carrito', [CarritoTiendaController::class, 'store'])->name('carrito');
Route::get('/checkout', [CarritoTiendaController::class, 'index'])->name('checkout');
Route::get('/checkout/get/items', [CarritoTiendaController::class, 'getCartItemsForCheckout']);

Route::post('/process/user/payment', [CarritoTiendaController::class, 'procesarPago']);
Route::post('/aumentarODisminuir', [CarritoTiendaController::class, 'aumentarODisminuirCantidad']);
Route::post('/eliminarProducto', [CarritoTiendaController::class, 'eliminarProducto']);

Route::get('/paypal/pay', [PayPalController::class, 'payWithPayPal']);
Route::get('/paypal/status', [PayPalController::class, 'payPalStatus']);

//Route::get('/response', [PayPalController::class, 'paypalPaymentResponse']);

//Route::post('/payOrderPayPal', [PayPalController::class, 'payOrderPayPal']);


//Route::get('payWithPaypal',  [PaymentPayPalController::class, 'payWithPaypal']);

//Route::get('/checkout', array('as' => 'paywithpaypal','uses' => 'App\Http\Controllers\PaymentPayPalController@payWithPaypal',));
