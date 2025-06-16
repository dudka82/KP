<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Step;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $pendingRecipes = Recipe::where('status', 'pending')->get();
        $approvedRecipes = Recipe::where('status', 'approved')->get();
         $recipes = Recipe::where('status', 'approved')->get(); 
        return view('recipes.index', compact('pendingRecipes', 'approvedRecipes'));
        return view('index', compact('recipes')); 
    }
    
    public function create()
    {
         $categories = Category::all();
    $allIngredients = Ingredient::all(); 
    
    return view('recipes.create', compact('categories', 'allIngredients'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cooking_time' => 'required|integer|min:1',
            'difficulty' => 'required|in:easy,medium,hard',
            'servings' => 'required|integer|min:1',
            'image_url' => 'nullable|url',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.id' => 'required|exists:ingredients,id',
            'ingredients.*.amount' => 'required|string|max:50',
        ]);
        
        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->id();
        
   $recipe = Recipe::create($validated);
        
 $ingredientsData = [];
    foreach ($request->ingredients as $ingredient) {
        $ingredientsData[$ingredient['id']] = ['amount' => $ingredient['amount']];
    }
    
    // Добавляем ингредиенты через таблицу recipe_ingredients
    $recipe->ingredients()->sync($ingredientsData);
    
    // Добавляем шаги приготовления
    foreach ($request->steps as $stepNumber => $step) {
        $recipe->steps()->create([
            'step_number' => $stepNumber + 1,
            'description' => $step['description']
        ]);
    }
    
    return redirect()->route('recipes.index')->with('success', 'Рецепт отправлен на модерацию');
    }

 public function show(Recipe $recipe)
{
    $isFavorite = auth()->check() ? auth()->user()->favorites()->where('recipe_id', $recipe->id)->exists() : false;
    $userRating = auth()->check() ? $recipe->ratings()->where('user_id', auth()->id())->first() : null;
    
    return view('recipes.show', [
        'recipe' => $recipe->load(['category', 'user', 'comments.user', 'ratings']),
        'isFavorite' => $isFavorite,
        'userRating' => $userRating
    ]);
}
    
    public function approve(Recipe $recipe)
    {
        $recipe->update(['status' => 'approved']);
        return back()->with('success', 'Рецепт одобрен!');
    }
    
    public function reject(Recipe $recipe)
    {
        $recipe->update(['status' => 'rejected']);
        return back()->with('success', 'Рецепт отклонен!');
    }
}