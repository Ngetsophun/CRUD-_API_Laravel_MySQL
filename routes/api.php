<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('student',[StudentController::class,'index']);
Route::post('/chat/send', [ChatController::class, 'sendMessage']);
Route::post('/chat/mark-seen', [ChatController::class, 'markAsSeen']);
Route::get('/chat/messages', [ChatController::class, 'getMessages']);

Route::prefix('api/chat')->group(function () {
    Route::post('/send', [ChatController::class, 'sendMessage']);
    Route::get('/history/{recipientId}', [ChatController::class, 'getChatHistory']);
    Route::put('/mark-seen/{messageId}', [ChatController::class, 'markMessageSeen']);
});

Route::get('/product', [ProductController::class, 'get_product']);
Route::get('/product/{id}', [ProductController::class, 'getProductWithDetails']);
Route::post('/product', [ProductController::class, 'insert_product']);
Route::put('/product/{id}', [ProductController::class, 'update_product']);
Route::delete('/product/{id}', [ProductController::class, 'delete_product']);


Route::get('/product_detail',[ProductDetailController::class,'get_product_detail']);
Route::delete('/product_detail/{id}',[ProductDetailController::class,'deleteProductDetails']);


Route::post('/orders', [OrderController::class, 'placeOrder']); 
Route::get('/orders', [OrderController::class, 'getOrders']); 
Route::get('/orders/{id}', [OrderController::class, 'getOrderById']); 

