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

//todo
Route::get('logout',[AuthController::class,"logout"])->name('logout');

Route::middleware('auth')->get('products',[ProductController::class,"index"])->name('products');
Route::middleware('auth')->get('products-package',[ProductPackageController::class,"index"])->name('products.package');
Route::middleware('auth')->get('create-package',[ProductPackageController::class,"create"])->name('package.create');
Route::middleware('auth')->post('store-package',[ProductPackageController::class,"store"])->name('package.store');


// Route::get('search',[ProductController::class,"searchProducts"])->name('products.search');
Route::get('products-create',[ProductController::class,"create"])->name('products.create');
Route::post('products-store',[ProductController::class,"store"])->name('products.store');

Route::middleware('product')->group(function () {
    
    Route::delete('destroy/{id}',[ProductController::class,"destroy"])->name('products.destroy');
    Route::get('show/{id}',[ProductController::class,"show"])->name('products.show');
    
    
    Route::get('edit/{id}',[ProductController::class,"edit"])->name('products.edit');
    Route::put('edit/{id}',[ProductController::class,"update"])->name('products.update');
});

Route::get('show-package/{id}',[ProductPackageController::class,"show"])->name('package.show');
Route::delete('delete-package/{id}',[ProductPackageController::class,"destroy"])->name('package.delete');

Route::get('edit-package/{id}',[ProductPackageController::class,"edit"])->name('package.edit');
Route::put('edit-package/{id}',[ProductPackageController::class,"update"])->name('package.update');

// Route::prefix('categories')->name('categories.')->group(function () {
//     Route::get('/', [CategoryController::class, 'cIndex'])->name('index');
//     Route::get('/create', [CategoryController::class, 'cCreate'])->name('create');
//     Route::post('/store', [CategoryController::class, 'cStore'])->name('store');
//     Route::get('/{categoryId}/edit', [CategoryController::class, 'cEdit'])->name('edit');
//     Route::put('/{categoryId}/update', [CategoryController::class, 'cUpdate'])->name('update');
//     Route::delete('/{categoryId}/destroy', [CategoryController::class, 'cDestroy'])->name('destroy');
// });

