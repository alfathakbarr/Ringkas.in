<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UrlController::class, 'index'])->name('urls.index');
Route::get('/create', [UrlController::class, 'create'])->name('urls.create');
Route::post('/store', [UrlController::class, 'store'])->name('urls.store');
Route::delete('/{id}', [UrlController::class, 'destroy'])->name('urls.destroy');

// Redirect short URL to original URL
Route::get('/{id}', [UrlController::class, 'show'])->name('urls.show');

