<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\PurchaseController;

Route::group(['middleware' => ['can:view-purchase', 'auth']], function () {
    Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');
});


Route::group(['middleware' => ['can:manage-purchase', 'auth']], function () {
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

    Route::get('purchases/history', [PurchaseController::class, 'history'])->name('purchase.history');
});
