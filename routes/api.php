<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PropertyController;
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


Route::get('properties', [PropertyController::class, 'index'])->name('api.properties.index');
Route::get('properties/{property}', [PropertyController::class, 'show'])->name('api.properties.show');
Route::post('properties', [PropertyController::class, 'store'])->name('api.properties.store');
Route::put('properties/{property}', [PropertyController::class, 'update'])->name('api.properties.update');
Route::delete('properties/{property}', [PropertyController::class, 'destroy'])->name('api.properties.destroy');

Route::get('products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('products/{product}', [ProductController::class, 'show'])->name('api.products.show');
Route::post('products', [ProductController::class, 'store'])->name('api.products.store');
Route::put('products/{product}', [ProductController::class, 'update'])->name('api.products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('api.products.destroy');
