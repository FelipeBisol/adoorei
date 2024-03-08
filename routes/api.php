<?php

use Core\Product\Http\Controllers\ProductController;
use Core\Sale\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProductController::class)->group(function (){
    Route::get('/products', 'index')->name('get-all-products');
});

Route::controller(SaleController::class)->group(function (){
    Route::post('/sale', 'create')->name('create-sale');
    Route::get('/sales', 'all')->name('get-all-sales');
    Route::get('/sale/{id}', 'get')->name('get-sale');
    Route::put('/sale/{id}/cancel', 'delete')->name('cancel-sale');
    Route::post('/sale/{id}/add-product', 'addProduct')->name('add-product-sale');
});
