<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Route for handing loan request

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['auth'],
        // You can add another middlewares, all you have is to register them in kernel and create them by php artisan make:middleware
        'as' => 'admin.',
    ],
    function () {
        Route::get('/loans', [LoanController::class, 'index'])->name('loans');

        Route::get('/loans/{user_id/', [LoanController::class, 'userLoans'])->name('loan.user');
        Route::get('/loan/apply', [LoanController::class, 'apply'])->name('loan.apply');
        Route::get('/loan/update/{loan_id}', [LoanController::class, 'update'])->name('loan.update');
    },
);

Route::group(
    [
        'prefix' => 'end_user',
        'middleware' => ['auth'],
        // You can add another middlewares, all you have is to register them in kernel and create them by php artisan make:middleware
        'as' => 'user.',
    ],
    function () {
        Route::get('/loans/{user_id/', [LoanController::class, 'userLoans'])->name('loan.user');

        Route::get('/loan/apply', [LoanController::class, 'apply'])->name('loan.apply');
    },
);
