<?php

use App\Http\Controllers\ViewController;
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
    return view('pages.dashboard');
});

Route::get('customers', [ViewController::class, 'customer']);
Route::get('categories', [ViewController::class, 'category']);
Route::get('products', [ViewController::class, 'product']);
Route::get('pos', [ViewController::class, 'pos']);
Route::get('transactions', [ViewController::class, 'transaction']);
Route::get('payments', [ViewController::class, 'payment']);
Route::get('reports', [ViewController::class, 'reporting']);



