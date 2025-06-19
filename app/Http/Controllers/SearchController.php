<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class SearchController extends Controller
{
public function index()
{
    $recipes = Recipe::with(['category', 'ingredients'])->where('status', 'approved')->get();
    $categories = Category::all();
    $ingredients = Ingredient::all();
    
    return view('search', compact('recipes', 'categories', 'ingredients'));
}
}