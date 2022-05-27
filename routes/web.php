<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect("/api-view", "public/swagger-ui");

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');
require __DIR__.'/auth.php';
Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::resource('category', CategoryController::class);
});
