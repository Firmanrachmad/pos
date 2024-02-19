<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

// Orders
Route::get('/orders', function () {
    return view('orders');
});

// Products
Route::get('/products', function () {
    return view('products');
});

// Products
Route::get('/categories', function () {
    return view('categories');
});



