<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
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
Route::get('verify-login', [LoginController::class, 'verifyLogin'])->name('verifyLogin');
Route::post('verify-login', [LoginController::class, 'postVerifyLogin'])->name('postVerifyLogin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register-team', [App\Http\Controllers\HomeController::class, 'registerAdminAndTeam'])->name('registerTeam');
Route::post('/register-team', [App\Http\Controllers\HomeController::class, 'postRegisterAdminAndTeam'])->name('postRegisterTeam');

Route::prefix('admin')->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders', [AdminController::class, 'postOrders'])->name('admin.postOrders');

    Route::get('/edit-user/{id}', [AdminController::class, 'editUserBalance'])->name('admin.editUserBalance');
    Route::post('/edit-user/{id}', [AdminController::class, 'postEditUserBalance'])->name('admin.postEditUserBalance');
    Route::get('/random', [AdminController::class, 'randomDeliver'])->name('admin.randomDeliver');

    Route::get('/orders2', [AdminController::class, 'orders2'])->name('admin.orders2');
    Route::post('/orders2', [AdminController::class, 'postOrders2'])->name('admin.postOrders2');

    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::get('/sprints', [AdminController::class, 'listSprint'])->name('admin.listSprint');
    Route::get('/set-default-sprint/{sprintId}', [AdminController::class, 'setDefaultSprint'])->name('admin.setDefaultSprint');
    Route::get('/create-sprint', [AdminController::class, 'createSprint'])->name('admin.createSprint');
    Route::post('/create-sprint', [AdminController::class, 'postCreateSprint'])->name('admin.postCreateSprint');

    Route::get('/create-story', [AdminController::class, 'createStory'])->name('admin.createStory');
    Route::get('/list-story', [AdminController::class, 'listStory'])->name('admin.listStory');
    Route::post('/create-story', [AdminController::class, 'postCreateStory'])->name('admin.postCreateStory');

    Route::get('/create-task', [AdminController::class, 'createTask'])->name('admin.createTask');
    Route::post('/create-task', [AdminController::class, 'postCreateTask'])->name('admin.postCreateTask');
});
