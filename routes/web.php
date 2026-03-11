<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('/checkout', 'public.checkout')->name('checkout');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::get('/orders', function () { return view('admin.orders.index'); })->name('orders.index');
    Route::get('/menu', function () { return view('admin.menu.index'); })->name('menu.index');
    Route::get('/categories', function () { return view('admin.categories.index'); })->name('categories.index');
});

require __DIR__.'/settings.php';
