<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AuthController,
    CategoryController,
    ItemController,
    UserController,
    LendingController
};

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return (Auth::user()->role == 'admin')
            ? view('admin.dashboard')
            : view('staff.dashboard');
    })->name('dashboard');

    // CATEGORIES
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // ITEMS
    Route::prefix('items')->name('items.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ItemController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ItemController::class, 'update'])->name('update');
        Route::get('/export', [ItemController::class, 'export'])->name('export');
        Route::delete('/delete/{id}', [ItemController::class, 'destroy'])->name('destroy');

        Route::get('/lending/{id}', [ItemController::class, 'lendingDetail'])->name('lending.detail');
    });

    // LENDING
    Route::prefix('lendings')->name('lendings.')->group(function () {
        Route::get('/', [LendingController::class, 'index'])->name('index');
        Route::get('/create', [LendingController::class, 'create'])->name('create');
        Route::post('/store', [LendingController::class, 'store'])->name('store');
        Route::post('/return/{id}', [LendingController::class, 'returnItem'])->name('return');
        Route::delete('/delete/{id}', [LendingController::class, 'destroy'])->name('destroy');
        Route::get('/export', [LendingController::class, 'export'])->name('export');
    });

    Route::middleware('auth')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/admin', [UserController::class, 'indexAdmin'])->name('admin');
            Route::get('/staff', [UserController::class, 'indexStaff'])->name('staff');

            Route::get('/admin/export', [UserController::class, 'exportAdmin'])->name('admin.export');
            Route::get('/staff/export', [UserController::class, 'exportStaff'])->name('staff.export');

            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');

            Route::patch('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('reset_password');
        });
    });
});
