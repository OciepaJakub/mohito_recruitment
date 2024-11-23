<?php

use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\RecipeViewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [RecipeViewController::class, 'index'])->name('home');
Route::get('/ulubione', [RecipeViewController::class, 'favorites'])->name('recipe.favorites');
Route::get('/{recipe:slug}', [RecipeViewController::class, 'single'])->name('recipe.single');
Route::post('/store-comment/{recipe:slug}', [CommentController::class, 'store'])->middleware('throttle:10,1')->name('recipe.comment.store');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
