<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::middleware(['auth', 'verified', 'role:customer'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/orders/{order}', function (\App\Models\Order $order) {
        return view('public.orders.show', ['order' => $order]);
    })->name('orders.show');

    Route::view('/checkout', 'public.checkout')->name('checkout');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:admin,kasir'])->group(function () {
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
    Route::view('/', 'admin.dashboard')->name('dashboard');
    Route::get('/orders', function () {
        return view('admin.orders.index');
    })->name('orders.index');
    Route::get('/menu', function () {
        return view('admin.menu.index');
    })->name('menu.index');
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');
});

require __DIR__.'/settings.php';
