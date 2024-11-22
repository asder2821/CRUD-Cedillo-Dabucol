<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CategoryController;

Route::get('/categories/view', [CategoryController::class, 'view'])->name('home');
Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/{id}/buy', [CategoryController::class, 'buy']);
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/create', [CategoryController::class, 'create']);
Route::post('categories/create', [CategoryController::class, 'store'])->name('categories.store');
Route::get('categories/{id}/edit', [CategoryController::class, 'edit']);
Route::put('categories/{id}/edit', [CategoryController::class, 'update']);
Route::get('categories/{id}/delete', [CategoryController::class, 'destroy']);






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
