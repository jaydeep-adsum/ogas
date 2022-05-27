<?php

use App\Http\Controllers\CafeteriaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FellowshipController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TextBookController;
use App\Http\Controllers\YearController;
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
});
