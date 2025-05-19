<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class AdminController extends Controller
{
    public function pendingRecipes()
    {
        $recipes = Recipe::where('status', 'pending')->paginate(10);
        return view('admin.pending', compact('recipes'));
    }

    public function approveRecipe(Recipe $recipe)
    {
        $recipe->update(['status' => 'approved']);
        return back()->with('success', 'Рецепт одобрен!');
    }

    public function rejectRecipe(Recipe $recipe)
    {
        $recipe->update(['status' => 'rejected']);
        return back()->with('success', 'Рецепт отклонен.');
    }
}