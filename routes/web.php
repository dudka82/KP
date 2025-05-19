<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Рецепты
Route::resource('recipes', RecipeController::class);

// Админка
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pending', [AdminController::class, 'pendingRecipes'])->name('admin.pending');
    Route::post('/admin/approve/{recipe}', [AdminController::class, 'approveRecipe'])->name('admin.approve');
    Route::post('/admin/reject/{recipe}', [AdminController::class, 'rejectRecipe'])->name('admin.reject');
});

// Избранное
Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Комментарии
Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Оценки
Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])->name('ratings.store');

require __DIR__.'/auth.php';
