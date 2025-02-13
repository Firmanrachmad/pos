<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\TransactionsController;
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

// Customer
Route::get('customer', [CustomerController::class, 'index']);
Route::post('add-customer', [CustomerController::class, 'store']);
Route::put('edit-customer/{id}', [CustomerController::class, 'update']);
Route::delete('delete-customer/{id}', [CustomerController::class, 'destroy']);

// Transactions
Route::post('checkout', [TransactionsController::class, 'checkout']);
Route::get('show-detail/{id}', [TransactionDetailController::class, 'show']);
Route::get('transaction', [TransactionDetailController::class, 'index']);

// Payment
Route::post('pay/{id}', [PaymentController::class, 'pay']);
Route::get('payment', [PaymentController::class, 'index']);
Route::post('payment-history/{id}', [PaymentController::class, 'generateHistory']);

// Report & Invoice
Route::post('report', [ReportController::class, 'generateReport']);
Route::post('invoice', [InvoiceController::class, 'generateInvoice']);