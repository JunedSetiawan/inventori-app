 <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;

    // create route for users
    Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('can:view-user');
    Route::group(['middleware' => ['can:manage-user', 'auth']], function () {
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    ?>