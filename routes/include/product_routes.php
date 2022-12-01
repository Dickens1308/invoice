<?php

use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/*
 * Customer Manipulation Routes
 * GET, POST, PUT & DELETE
 */
Route::controller(CustomerController::class)->prefix('products/')->middleware('auth.jwt')->group(
    function () {
        Route::get('', 'index');
        Route::get('filter', 'filter');
        Route::post('', 'store');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    }
);

