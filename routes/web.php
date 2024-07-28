<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('orders',                        [OrderController::class, 'index'])->name('orders.index');
Route::get('orders/create',                 [OrderController::class, 'create'])->name('orders.create');
Route::post('orders',                       [OrderController::class, 'store'])->name('orders.store');
Route::get('orders/{order}',                [OrderController::class, 'show'])->name('orders.show');
Route::get('orders/{order}/edit',           [OrderController::class, 'edit'])->name('orders.edit');
Route::put('orders/{order}',                [OrderController::class, 'update'])->name('orders.update');
Route::delete('orders/{order}',             [OrderController::class, 'destroy'])->name('orders.destroy');
