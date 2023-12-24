<?php

use App\Http\Controllers\Apps\InventoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('splade')->group(function () {
    // Registers routes to support the interactive components...
    Route::spladeWithVueBridge();

    // Registers routes to support password confirmation in Form and Link components...
    Route::spladePasswordConfirmation();

    // Registers routes to support Table Bulk Actions and Exports...
    Route::spladeTable();

    // Registers routes to support async File Uploads with Filepond...
    Route::spladeUploads();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // create route for inventory
        Route::get('/inventory', [InventoriController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/create', [InventoriController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [InventoriController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{id}/edit', [InventoriController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{inventory:id}', [InventoriController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{inventory}', [InventoriController::class, 'destroy'])->name('inventory.destroy');
    });

    require __DIR__ . '/auth.php';
});
