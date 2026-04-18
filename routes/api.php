<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\NewsServices;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/news', [NewsServices::class, 'get']);

Route::get('/news', [NewsServices::class, 'get']);
Route::get('/news/{id}', [NewsServices::class, 'detail']);
Route::post('/news', [NewsServices::class, 'store']);        // ← POST tanpa /{id}
Route::put('/news/{id}', [NewsServices::class, 'update']);
Route::delete('/news/{id}', [NewsServices::class, 'destroy']);

use App\Http\Controllers\Api\CategoryServices;

Route::get('/categories', [CategoryServices::class, 'get']);
Route::get('/categories/{id}', [CategoryServices::class, 'detail']);
Route::post('/categories', [CategoryServices::class, 'store']);
Route::put('/categories/{id}', [CategoryServices::class, 'update']);
Route::delete('/categories/{id}', [CategoryServices::class, 'destroy']);