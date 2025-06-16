<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Recipe;

class FavoriteController extends Controller
{
 public function store(Request $request)
    {
        $request->validate([
            'recipe_id' => 'required|exists:recipes,id'
        ]);
        
        $favorite = Favorite::firstOrCreate([
            'user_id' => auth()->id(),
            'recipe_id' => $request->recipe_id
        ]);
        
        return response()->json(['success' => true]);
    }

public function show(Recipe $recipe)
{
    $isFavorite = auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists();
    
    return view('recipes.show', [
        'recipe' => $recipe,
        'isFavorite' => $isFavorite
    ]);
}

    public function destroy(Recipe $recipe)
    {
        Favorite::where([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe->id,
        ])->delete();
        return back()->with('success', 'Рецепт удален из избранного.');
    }

    public function toggle(Request $request, Recipe $recipe)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    $favorite = $user->favorites()->where('recipe_id', $recipe->id)->first();

    if ($favorite) {
        $favorite->delete();
        return back()->with('success', 'Рецепт удален из избранного');
    } else {
        $user->favorites()->create(['recipe_id' => $recipe->id]);
        return back()->with('success', 'Рецепт добавлен в избранное');
    }
}
}