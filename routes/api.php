<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\ProductController;

Route::apiResource('products', ProductController::class);
