<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MiddlewareController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::prefix('/menu')->middleware(['admin'])->group(function(){
    Route::get('/', [MenuController::class, 'list'])->name('menu.list');
    Route::get('/data', [MenuController::class, 'data'])->name('menu.data');
    Route::get('/add', [MenuController::class, 'add'])->name('menu.add');
    Route::get('/edit/{menuId}', [MenuController::class, 'editMenu'])->name('menu.edit');
    Route::post('/update/{menuId}', [MenuController::class, 'updateMenu'])->name('menu.update');
    Route::post('/delete/{menuId}', [MenuController::class, 'deleteMenu'])->name('menu.delete');
    Route::post('/insert', [MenuController::class, 'insert'])->name('menu.insert_new');
});

Route::prefix('/user')->middleware(['admin'])->group(function(){
    Route::get('/', [UserController::class, 'list'])->name('user.list');
    Route::get('/data', [UserController::class, 'data'])->name('user.data');
    Route::get('/edit/{userId}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/update/{userId}', [UserController::class, 'update'])->name('user.update');
    Route::post('/delete/{userId}', [UserController::class, 'delete'])->name('user.delete');
});

Route::prefix('/seat')->middleware(['admin'])->group(function(){
    Route::get('/', [SeatController::class, 'list'])->name('seat.list');
    Route::get('/data', [SeatController::class, 'data'])->name('seat.data');
    Route::get('/add', [SeatController::class, 'add'])->name('seat.add');
    Route::post('/insert', [SeatController::class, 'insert'])->name('seat.insert_new');
    Route::get('/edit/{id}', [SeatController::class, 'edit'])->name('seat.edit');
    Route::post('/update/{id}', [SeatController::class, 'update'])->name('seat.update');
    Route::post('/delete/{id}', [SeatController::class, 'delete'])->name('seat.delete');
});

Route::prefix('/transaction')->middleware(['manager'])->group(function(){
    Route::get('/', [TransactionController::class, 'list'])->name('transaction.list');
    Route::get('/data', [TransactionController::class, 'data'])->name('transaction.data');
    Route::get('/add', [TransactionController::class, 'add'])->name('transaction.add');
    Route::post('/insert', [TransactionController::class, 'insert'])->name('transaction.insert_new');
    Route::get('/detail/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
    Route::get('/{id}', [TransactionController::class, 'detailpage'])->name('transaction.detailpage');
});

Route::post('/newtransaction', [TransactionController::class, 'newinsert'])->name('transaction.newinsert');
Route::get('/payments', [TransactionController::class, 'paymentPage'])->name('transaction.paymentPage');
Route::post('/payment/{id}', [TransactionController::class, 'payment'])->name('transaction.payment');

Route::prefix('/cashier')->middleware(['cashier'])->group(function(){
    Route::get('/', [CashierController::class, 'index'])->name('cashier');
    Route::get('/data', [CashierController::class, 'data'])->name('cashier.data');
    Route::get('/total/{id}', [CashierController::class, 'getTotal'])->name('cashier.total');
});