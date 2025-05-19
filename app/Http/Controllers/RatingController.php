<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate(['rating' => 'required|integer|between:1,5']);
        
        Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'recipe_id' => $recipe->id],
            ['rating' => $request->rating]
        );
        
        return back()->with('success', 'Оценка сохранена!');
    }
}