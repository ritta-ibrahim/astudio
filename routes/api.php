<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('orders')->group(function () {
    Route::post('/create', [OrderController::class, 'create']);
    Route::get('/{order}/history', [OrderController::class, 'history']);
    Route::put('/{order}/update', [OrderController::class, 'update']);
    Route::put('/{order}/approve', [OrderController::class, 'approve']);
    Route::get('/{order}/check', [OrderController::class, 'check']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::get('/', [OrderController::class, 'index']);
});

Route::prefix('items')->group(function () {
    Route::post('/create', [ItemController::class, 'create']);
    Route::get('/', [ItemController::class, 'index']);
});
