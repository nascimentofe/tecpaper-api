<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\ProductController;

Route::namespace('Api')->group(function (){
    Route::get('/products', [ProductController::class, 'get']);
    Route::post('/products', [ProductController::class, 'post']);
});
