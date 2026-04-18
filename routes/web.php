<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;


Route::get('/', [NewsController::class, 'index'])->name('home');
Route::get('/berita/{slug}', [NewsController::class, 'detail'])->name('news.detail');
Route::get('/kategori/{slug}', [NewsController::class, 'category'])->name('news.category');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('categories', CategoryController::class);
});