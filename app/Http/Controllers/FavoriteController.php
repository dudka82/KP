<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;

class FavoriteController extends Controller
{
    public function store(Recipe $recipe)
    {
        Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe->id,
        ]);
        return back()->with('success', 'Рецепт добавлен в избранное!');
    }

    public function destroy(Recipe $recipe)
    {
        Favorite::where([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe->id,
        ])->delete();
        return back()->with('success', 'Рецепт удален из избранного.');
    }
}