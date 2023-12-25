 <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Apps\InventoriController;

    // create route for inventory
    Route::get('/inventory', [InventoriController::class, 'index'])->name('inventory.index');
    Route::group(['middleware' => ['can:view-inventory']], function () {
        Route::get('/inventory/create', [InventoriController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [InventoriController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{inventori}/edit', [InventoriController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{inventori}', [InventoriController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{inventori}', [InventoriController::class, 'destroy'])->name('inventory.destroy');
    });

    ?>