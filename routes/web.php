<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPackageController;
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


Route::put('edit-package/{id}',[ProductPackageController::class,"update"])->name('package.update');

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
    Route::get('/', [ProductPackageController::class, 'index'])->name('index');
    Route::get('/create',[ProductPackageController::class,"create"])->name('create');
    Route::post('/store',[ProductPackageController::class,"store"])->name('store');

    Route::middleware(['package'])->group(function () {
        Route::get('/{packagesId}/edit',[ProductPackageController::class,"edit"])->name('edit');
        Route::put('/{packagesId}/update',[ProductPackageController::class,"update"])->name('update');
        Route::delete('/{packagesId}/destroy',[ProductPackageController::class,"destroy"])->name('destroy');
        Route::get('/{packagesId}/show',[ProductPackageController::class,"show"])->name('show');
    });
});

