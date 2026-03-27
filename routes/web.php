<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UrlController::class, 'home'])->name('urls.home');
Route::get('/short-url', [UrlController::class, 'create'])->name('urls.create');
Route::get('/generate-qr', [UrlController::class, 'qr'])->name('urls.qr');
Route::get('/manage-links', [UrlController::class, 'index'])->name('urls.index');
Route::post('/store', [UrlController::class, 'store'])->name('urls.store');
Route::delete('/{id}', [UrlController::class, 'destroy'])->name('urls.destroy');

// Redirect short URL to original URL
Route::get('/{id}', [UrlController::class, 'show'])->name('urls.show');

