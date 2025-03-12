<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ExcelImportController;

// Example Routes
// Route::view('/', 'landing');
// Route::match(['get', 'post'], '/dashboard', function(){
//     return view('dashboard');
// });
Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Trang Dashboard - chỉ vào được khi đăng nhập
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::prefix('products')->group(function () {
        Route::get('/import', [ExcelImportController::class, 'showImportForm'])->name('products.import.form');
        Route::post('/import/preview', [ExcelImportController::class, 'previewImport'])->name('products.import.preview');
        Route::post('/import/process', [ExcelImportController::class, 'processImport'])->name('products.import.process');
        Route::get('/cart', [ProductController::class, 'showCartPage'])->name('products.showCartPage');
        Route::post('/search', [ProductController::class, 'search'])->name('products.search');

    });
    Route::resource('products', ProductController::class);

});

// Route::get('/user', function () {
//     return view('users.index');
// })->middleware('auth')->name('user.index');

// Route::resource('users', UserController::class)->middleware('auth');
// Route::resource('customers', CustomerController::class)->middleware('auth');
