<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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
    Route::get('/dashboard-chart-data', [DashboardController::class, 'dashboardChartData'])->name('dashboard.chart.data');
    Route::get('/income-chart-data', [DashboardController::class, 'incomeChartData'])->name('income.chart.data');
    Route::post('changePassword', [DashboardController::class,'changePassword'])->name('changePassword');

    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::get('customer/export', [CustomerController::class, 'export'])->name('customer.export');
    Route::get('customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('customer/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('customer/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');

    Route::get('driver', [DriverController::class, 'index'])->name('driver');
    Route::delete('driver/{driver}', [DriverController::class, 'destroy'])->name('driver.destroy');
    Route::get('driver/export', [DriverController::class, 'export'])->name('driver.export');
    Route::get('driver/{driver}/edit', [DriverController::class, 'edit'])->name('driver.edit');
    Route::post('driver/{driver}', [DriverController::class, 'update'])->name('driver.update');
    Route::get('driver/{driver}/accept', [DriverController::class, 'accept'])->name('driver.accept');
    Route::get('driver/{driver}/reject', [DriverController::class, 'reject'])->name('driver.reject');

    Route::resource('category', CategoryController::class);
    Route::resource('faq', FaqController::class);

    Route::get('orders', [OrderController::class, 'index'])->name('order');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('feedback', [ComplaintController::class, 'index'])->name('feedback');
    Route::delete('feedback/{feedback}', [ComplaintController::class, 'destroy'])->name('feedback.destroy');

    Route::get('products', [ProductController::class,'index'])->name('products');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});
