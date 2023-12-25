<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\PurchaseController;

Route::group(['middleware' => ['can:view-purchase']], function () {
    Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchase.show');
});


Route::group(['middleware' => ['can:manage-purchase']], function () {
    Route::get('/purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/purchase/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/purchase/{purchase}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{purchase}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

    Route::get('purchase/history', [PurchaseController::class, 'history'])->name('purchase.history');
});
