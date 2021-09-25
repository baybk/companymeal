<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\UserController;
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

Route::post('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('get-me', [PassportController::class, 'details']);
    Route::resource('users', UserController::class);
});

Route::get('user', [PassportController::class, 'details']);

Route::group([
    'prefix' => 'orders',
    'as' => 'orders.'
], function () {
    Route::post('', [OrderController::class, 'store'])->name('store');
});
