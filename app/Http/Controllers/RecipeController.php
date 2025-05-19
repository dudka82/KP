<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::where('status', 'approved')->paginate(10);
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'cooking_time' => 'required|integer',
            'difficulty' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer',
            'image_url' => 'nullable|url',
        ]);

        $recipe = Recipe::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'cooking_time' => $request->cooking_time,
            'difficulty' => $request->difficulty,
            'servings' => $request->servings,
            'image_url' => $request->image_url,
            'status' => auth()->user()->isAdmin() ? 'approved' : 'pending',
        ]);

        return redirect()->route('recipes.show', $recipe);
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $this->authorize('update', $recipe);
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $this->authorize('update', $recipe);

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'cooking_time' => 'required|integer',
            'difficulty' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer',
            'image_url' => 'nullable|url',
        ]);

        $recipe->update($request->all());
        return redirect()->route('recipes.show', $recipe);
    }

    public function destroy(Recipe $recipe)
    {
        $this->authorize('delete', $recipe);
        $recipe->delete();
        return redirect()->route('recipes.index');
    }
}