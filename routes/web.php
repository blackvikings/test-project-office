<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::resource('products', ProductController::class);
Route::get('add-product-images/{id}', [ProductImageController::class, 'index'])->name('add-images');
Route::post('upload-image', [ProductImageController::class, 'store'])->name('upload.image');
Route::delete('remove-image/{image}', [ProductImageController::class, 'destroy'])->name('image.destroy');
Route::delete('/delete-multiples', [ProductController::class, 'deleteMultiple'])->name('delete.multiple');
