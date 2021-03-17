<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\ProductController;

Route::get('/products/get/{id?}',
    [ProductController::class, 'get'])->name('products.get');

Route::post('/products/post',
    [ProductController::class, 'post'])->name('products.post');

Route::put('/products/put',
    [ProductController::class, 'put'])->name('products.put');

Route::delete('/products/delete/{pass}/{id?}',
    [ProductController::class, 'delete'])->name('products.delete');
