<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;

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

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/datatables', [CategoryController::class, 'datatables'])->name('categories.datatables');
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories/save', [CategoryController::class, 'store']);
    Route::get('/categories/edit/{slug}', [CategoryController::class, 'edit']);
    Route::put('/categories/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete']);
    Route::get('/categories/ajax/search', [CategoryController::class, 'search']);
    // Books Routes
    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/datatables', [BookController::class, 'datatables'])->name('books.datatables');
    Route::get('/book/create', [BookController::class, 'create']);
    Route::post('/book/save', [BookController::class, 'store']);
    Route::get('/book/edit/{slug}', [BookController::class, 'edit']);
    Route::patch('/book/update', [BookController::class, 'update']);
    Route::delete('/book/delete', [BookController::class, 'delete']);

    // Order Routes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/datatables', [OrderController::class, 'datatables'])->name('orders.datatables');
    Route::get('/order/create', [OrderController::class, 'create']);
    Route::post('/order/save', [OrderController::class, 'store']);
    Route::get('/order/edit/{id}', [OrderController::class, 'edit']);
    Route::get('/order/detail/{id}', [OrderController::class, 'detail']);
    Route::patch('/order/update', [OrderController::class, 'update']);
    Route::delete('/order/delete', [OrderController::class, 'delete']);
});
