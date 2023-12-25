<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apps\SalesController;


Route::get('/sales', [SalesController::class, 'index'])->name('sales.index')->middleware('can:view-sales', 'auth');
Route::get('/sales/{sales}', [SalesController::class, 'show'])->name('sales.show')->middleware('can:view-sales', 'auth');

Route::group(['middleware' => ['can:manage-sales', 'auth']], function () {
    Route::get('/sale/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sale', [SalesController::class, 'store'])->name('sales.store');
    Route::get('/sale/{sales}/edit', [SalesController::class, 'edit'])->name('sales.edit');
    Route::put('/sale/{sales}', [SalesController::class, 'update'])->name('sales.update');
    Route::delete('/sale/{sales}', [SalesController::class, 'destroy'])->name('sales.destroy');

    Route::get('sales/history', [SalesController::class, 'history'])->name('sales.history');
});
