<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
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

// Route::get('/',[AuthController::class,"index"]);
// Route::get('login',[AuthController::class,"index"])->name('login');
Route::get('register',[AuthController::class,"register"])->name('register');
Route::post('post-register',[AuthController::class,"postRegister"])->name('register.post');

Route::get('admin-login',[AuthController::class,"Adminlogin"])->name('admin.login');
Route::post('admin-login',[AuthController::class,"Adminlogin"])->name('admin.dashboard');

Route::get('user-login',[AuthController::class,"Userlogin"])->name('user.login');
Route::post('user-login',[AuthController::class,"Userlogin"])->name('user.home');

Route::get('logout',[AuthController::class,"logout"])->name('logout');


// Route::put('edit-package/{id}',[PackageController::class,"update"])->name('package.update');

Route::prefix('products')->name('products.')->middleware(['authenrole:admin'])->group(function () {
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

Route::prefix('packages')->name('packages.')->middleware(['authenrole:admin'])->group(function () {
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

Route::prefix('users')->name('users.')->middleware(['authenrole:admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');

    Route::middleware(['user'])->group(function () {
        Route::get('/{usersId}/edit',[UserController::class,"edit"])->name('edit');
        Route::put('/{usersId}/update',[UserController::class,"update"])->name('update');
    });
});

Route::prefix('orders')->name('orders.')->middleware(['authenrole:admin'])->group(function () {
    Route::get('/', [OrderController::class, 'orders'])->name('index');
    Route::middleware(['order'])->delete('/{orderId}/destroy', [OrderController::class, 'destroy'])->name('destroy');
    Route::middleware(['order'])->get('/{orderId}/show', [OrderController::class, 'show'])->name('show');
});

Route::get('/', [OrderController::class, 'index'])->name('index');
Route::prefix('home')->name('home.')->middleware(['authenrole:web'])->group(function () {
    Route::post('/payment', [OrderController::class, 'payment'])->name('payment');
});

