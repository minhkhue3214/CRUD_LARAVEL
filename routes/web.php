<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PackageController;
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

Route::get('/',[AuthController::class,"index"]);
Route::get('login',[AuthController::class,"index"])->name('login');
Route::post('post-login',[AuthController::class,"postLogin"])->name('login.post');
Route::get('logout',[AuthController::class,"logout"])->name('logout');


Route::put('edit-package/{id}',[PackageController::class,"update"])->name('package.update');

Route::prefix('products')->name('products.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');

    Route::middleware(['product'])->group(function () {
        Route::get('/{productId}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{productId}/update', [ProductController::class, 'update'])->name('update');
        Route::delete('/{productId}/destroy',[ProductController::class,"destroy"])->name('destroy');
        Route::get('/{productId}/show',[ProductController::class,"show"])->name('show');
    });
    
});

Route::prefix('packages')->name('packages.')->middleware(['auth'])->group(function () {
    Route::get('/', [PackageController::class, 'index'])->name('index');
    Route::get('/create',[PackageController::class,"create"])->name('create');
    Route::post('/store',[PackageController::class,"store"])->name('store');

    Route::middleware(['package'])->group(function () {
        Route::get('/{packagesId}/edit',[PackageController::class,"edit"])->name('edit');
        Route::put('/{packagesId}/update',[PackageController::class,"update"])->name('update');
        Route::delete('/{packagesId}/destroy',[PackageController::class,"destroy"])->name('destroy');
        Route::get('/{packagesId}/show',[PackageController::class,"show"])->name('show');
    });
});

