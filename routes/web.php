<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OperationCategoryController;
use App\Http\Controllers\PurchaseTransactionController;

// Halaman utama dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Produk
Route::prefix('products')->middleware('auth')->group(function () {
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/list', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Toko dan kategori
Route::resource('stores', StoreController::class)->middleware('auth');
Route::resource('categories', CategoryController::class)->middleware('auth');
Route::resource('purchases', PurchaseTransactionController::class)->middleware('auth');

// Operasional
Route::resource('operations', OperationController::class)->middleware('auth');
Route::prefix('operations/categories')->name('operations.categories.')->middleware('auth')->group(function () {
    Route::get('/list', [OperationCategoryController::class, 'index'])->name('list');
    Route::get('/create', [OperationCategoryController::class, 'create'])->name('create');
    Route::post('/', [OperationCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [OperationCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OperationCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [OperationCategoryController::class, 'destroy'])->name('destroy');
});

Route::get('/transactions/report', [TransactionController::class, 'report'])->name('transactions.report')->middleware('auth');
Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export')->middleware('auth');

// Transaksi
Route::resource('transactions', TransactionController::class)->middleware('auth');

Auth::routes();
