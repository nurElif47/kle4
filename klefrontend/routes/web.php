<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\tokenMiddleware;
use Illuminate\Support\Facades\Auth;


// Product rotaları (sadece giriş yapmış kullanıcılar erişebilir)
Route::middleware(tokenMiddleware::class)->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index'); //bu eklendi
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::resource('products', ProductController::class);
});

// Login ve Register sayfaları sadece misafirlere açık olacak.
Route::middleware('guest')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');


    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});



    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


// Ana sayfa
Route::get('/', function () {
    return redirect()->route('products.index');
});

