<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CommentAndRatingController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// Rutas para UserController
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Rutas para ProductController
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/list/{categoy}', [ProductController::class, 'showProductsByCategory']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);
Route::get('/products/search', [ProductController::class, 'search']);

// Rutas para CategoryController
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

// Rutas para CustomerController
Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{customer}', [CustomerController::class, 'show']);
Route::put('/customers/{customer}', [CustomerController::class, 'update']);
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);

// Rutas para OrderController
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{customer}', [ProductController::class, 'showOrderByCustomer']);
Route::get('/orders/{customer}/actual', [ProductController::class, 'showActualOrderByCustomer']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

// Rutas para OrderDetailController
Route::get('/order-details', [OrderDetailController::class, 'index']);
Route::post('/order-details', [OrderDetailController::class, 'store']);
Route::get('/order-details/{order}', [ProductController::class, 'showProductsByOrder']);
Route::get('/order-details/{orderDetail}', [OrderDetailController::class, 'show']);
Route::put('/order-details/{orderDetail}', [OrderDetailController::class, 'update']);
Route::delete('/order-details/{orderDetail}', [OrderDetailController::class, 'destroy']);

// Rutas para PaymentMethodController
Route::get('/payment-methods', [PaymentMethodController::class, 'index']);
Route::post('/payment-methods', [PaymentMethodController::class, 'store']);
Route::get('/payment-methods/{customer}', [PaymentMethodController::class, 'showPaymentMethodByCustomer']);
Route::get('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'show']);
Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update']);
Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy']);

// Rutas para CommentAndRatingController
Route::get('/comments-and-ratings', [CommentAndRatingController::class, 'index']);
Route::get('/comments-and-ratings/{product}', [CommentAndRatingController::class, 'getByProduct']);
Route::post('/comments-and-ratings', [CommentAndRatingController::class, 'store']);
Route::get('/comments-and-ratings/{commentAndRating}', [CommentAndRatingController::class, 'show']);
Route::put('/comments-and-ratings/{commentAndRating}', [CommentAndRatingController::class, 'update']);
Route::delete('/comments-and-ratings/{commentAndRating}', [CommentAndRatingController::class, 'destroy']);

// Rutas para ShipmentController
Route::get('/shipments', [ShipmentController::class, 'index']);
Route::post('/shipments', [ShipmentController::class, 'store']);
Route::get('/shipments/{shipment}', [ShipmentController::class, 'show']);
Route::put('/shipments/{shipment}', [ShipmentController::class, 'update']);
Route::delete('/shipments/{shipment}', [ShipmentController::class, 'destroy']);
