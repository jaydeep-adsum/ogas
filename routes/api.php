<?php

use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('Api')->group(
    function () {
        Route::get('swagger', 'SwaggerController@listItem');
        Route::post('signup', [CustomerController::class, 'signup']);
        Route::post('login', [CustomerController::class, 'login']);

        Route::post('driver-signup', [DriverController::class, 'signup']);
        Route::post('driver-login', [DriverController::class, 'login']);

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('edit', [CustomerController::class, 'edit']);
            Route::post('driver-edit', [DriverController::class, 'edit']);

            Route::get('products', [ProductController::class, 'index']);
            Route::post('get-order', [OrderController::class, 'index']);
            Route::post('order', [OrderController::class, 'store']);
            Route::post('store-order-history', [OrderController::class, 'storeOrderHistory']);
            Route::post('order-history', [OrderController::class, 'orderHistory']);

            Route::get('all-complaints', [ComplaintController::class, 'index']);
            Route::post('complaint', [ComplaintController::class, 'store']);
        });
    }
);
