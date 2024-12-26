<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\TransactionsController;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Category
Route::get('category', [CategoryController::class, 'index']);
Route::post('add-category', [CategoryController::class, 'store']);
Route::put('edit-category/{id}', [CategoryController::class, 'update']);
Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

// Product
Route::get('product', [ProductController::class, 'index']);
Route::post('add-product', [ProductController::class, 'store']);
Route::put('edit-product/{id}', [ProductController::class, 'update']);
Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);

// Transactions
Route::post('checkout', [TransactionsController::class, 'checkout']);
Route::get('show-detail/{id}', [TransactionDetailController::class, 'show']);