<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SearchController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/best', [HomeController::class, 'topRecipes']);    
Route::get('/favorite', [FavoriteController::class, 'favoriteRecipes']);
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function() {
    // Основной маршрут dashboard
    Route::get('/dashboard', [AccountController::class, 'account'])->name('dashboard');
    
    // Другие защищенные маршруты можно добавить здесь
});

Route::get('/search', [SearchController::class, 'index'], function () {
    return view('search');
})->middleware(['auth', 'verified'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//recipes
Route::middleware(['auth'])->group(function () {
    // Для обычных пользователей
    Route::resource('recipes', RecipeController::class)->only(['create', 'store']);
    
    // Для администраторов
Route::middleware(['admin'])->group(function () {
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes/{recipe}/approve', [RecipeController::class, 'approve'])->name('recipes.approve');
    Route::post('/recipes/{recipe}/reject', [RecipeController::class, 'reject'])->name('recipes.reject');
});
});
// Просмотр рецепта
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
Route::delete('/recipes/{recipe}', [RecipeController::class,'destroy'])->name('recipes.destroy');

// Работа с избранным
Route::post('/recipes/{recipe}/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/recipes/{recipe}/favorites', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
Route::post('/recipes/{recipe}/toggle-favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Оценка рецепта
Route::post('/recipes/{recipe}/rate', [RatingController::class, 'store'])->name('recipes.rate');

// Комментарии
Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
//categories
Route::middleware(['auth'])->group(function () {
    // Для обычных пользователей
    Route::resource('categories', CategoryController::class)->only(['create', 'store']);
    
    Route::delete('/categories/{category}', [CategoryController::class,'destroy'])->name('categories.destroy');
    // Для администраторов
    Route::middleware(['admin'])->group(function () {
        Route::get('/categories', [RecipeController::class, 'index'])->name('categories.index');
        Route::post('/categories/{category}/approve', [CategoryController::class, 'approve'])->name('categories.approve');
        Route::post('/categories/{category}/reject', [CategoryController::class, 'reject'])->name('categories.reject');
    });
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
});
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/pending', [AdminController::class, 'pendingRecipes'])->name('admin.pending');
//     Route::post('/admin/approve/{recipe}', [AdminController::class, 'approveRecipe'])->name('admin.approve');
//     Route::post('/admin/reject/{recipe}', [AdminController::class, 'rejectRecipe'])->name('admin.reject');
// });

// // Избранное
// Route::post('/recipes/{recipe}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
// Route::delete('/recipes/{recipe}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// // Комментарии
// Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
// Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// // Оценки
// Route::post('/recipes/{recipe}/ratings', [RatingController::class, 'store'])->name('ratings.store');

require __DIR__.'/auth.php';
