<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

// Pages
Route::get('/', [UrlController::class, 'home'])->name('urls.home');
Route::get('/short-url', [UrlController::class, 'create'])->name('urls.create');
Route::get('/generate-qr', [UrlController::class, 'qr'])->name('urls.qr');
Route::get('/manage-links', [UrlController::class, 'index'])->name('urls.index');

// CRUD routes
Route::post('/store', [UrlController::class, 'store'])->name('urls.store');
Route::post('/manage-links', [UrlController::class, 'search'])->name('urls.search');
Route::delete('/delete/{id}', [UrlController::class, 'destroy'])->name('urls.destroy');
Route::post('/access/{code}', [UrlController::class, 'access'])->name('urls.access');

// wildcard harus paling bawah
Route::get('/{code}', [UrlController::class, 'show'])->name('urls.show');