<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[AuthController::class,"index"])->name('login');
Route::get('login',[AuthController::class,"index"])->name('login');
Route::post('post-login',[AuthController::class,"postLogin"])->name('login.post');

Route::get('logout',[AuthController::class,"logout"])->name('logout');
Route::get('products',[ProductController::class,"index"])->name('products');

// Route::get('search',[ProductController::class,"searchProducts"])->name('products.search');

Route::get('products-create',[ProductController::class,"create"])->name('products.create');
Route::post('products-store',[ProductController::class,"store"])->name('products.store');

Route::get('products-store/{name}',[ProductController::class,"filter"])->name('products.filter');
Route::delete('destroy/{id}',[ProductController::class,"destroy"])->name('products.destroy');


Route::get('edit/{id}',[ProductController::class,"edit"])->name('products.edit');
Route::put('edit/{id}',[ProductController::class,"update"])->name('products.update');
