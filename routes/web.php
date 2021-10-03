<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OrderController;
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
Route::get('verify-login', [LoginController::class, 'verifyLogin'])->name('verifyLogin');
Route::post('verify-login', [LoginController::class, 'postVerifyLogin'])->name('postVerifyLogin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register-team', [App\Http\Controllers\HomeController::class, 'registerAdminAndTeam'])->name('registerTeam');
Route::post('/register-team', [App\Http\Controllers\HomeController::class, 'postRegisterAdminAndTeam'])->name('postRegisterTeam');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::group([
        'prefix' => 'orders',
        'as' => 'orders.'
    ], function () {
        Route::get('', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminOrderController::class, 'show'])->name('show');
        Route::post('/{id}', [AdminOrderController::class, 'update'])->name('update');
    });

    Route::get('/edit-user/{id}', [AdminController::class, 'editUserBalance'])->name('editUserBalance');
    Route::post('/edit-user/{id}', [AdminController::class, 'postEditUserBalance'])->name('postEditUserBalance');
    Route::get('/random', [AdminController::class, 'randomDeliver'])->name('randomDeliver');

    Route::get('/orders2', [AdminController::class, 'orders2'])->name('orders2');
    Route::post('/orders2', [AdminController::class, 'postOrders2'])->name('postOrders2');

    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
});

Route::group([
    'prefix' => 'orders',
    'as' => 'orders.'
], function () {
    Route::post('', [OrderController::class, 'store'])->name('store');
});
