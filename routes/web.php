<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationCategoryController;
use App\Http\Controllers\PurchaseTransactionController;

// Halaman utama dashboard
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');



// Produk
Route::prefix('products')->group(function () {
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/list', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}/destroy', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Toko dan kategori
Route::resource('stores', StoreController::class);
Route::resource('categories', CategoryController::class);
Route::resource('purchases', PurchaseTransactionController::class);

// Operasional
Route::resource('operations', OperationController::class);
// Route::resource('operations/categories', OperationCategoryController::class)->except(['index']);
Route::prefix('operations/categories')->name('operations.categories.')->group(function () {
    Route::get('/list', [OperationCategoryController::class, 'index'])->name('list');
    Route::get('/create', [OperationCategoryController::class, 'create'])->name('create');
    Route::post('/', [OperationCategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [OperationCategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [OperationCategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [OperationCategoryController::class, 'destroy'])->name('destroy');
});

Route::get('/transactions/report', [TransactionController::class, 'report'])->name('transactions.report');
Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');


// Transaksi
Route::resource('transactions', TransactionController::class);
