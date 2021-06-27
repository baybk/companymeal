<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('logs', [LogController::class, 'getLogs'])->name('logs.getLogs');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders', [AdminController::class, 'postOrders'])->name('admin.postOrders');

    Route::get('/edit-user/{id}', [AdminController::class, 'editUserBalance'])->name('admin.editUserBalance');
    Route::post('/edit-user/{id}', [AdminController::class, 'postEditUserBalance'])->name('admin.postEditUserBalance');
    Route::get('/random', [AdminController::class, 'randomDeliver'])->name('admin.randomDeliver');

    Route::get('/orders2', [AdminController::class, 'orders2'])->name('admin.orders2');
    Route::post('/orders2', [AdminController::class, 'postOrders2'])->name('admin.postOrders2');
});
