<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function index()
    {
        $recipes = Recipe::all(); 
        return view('index', compact('recipes'));
    }
public function topRecipes()
{
    $topRatedRecipes = Recipe::with(['ratings'])
    ->where('status','approved')
        ->withAvg('ratings as average_rating', 'rating')
        ->orderByDesc('average_rating')
        ->take(10)
        ->get();

    return view('welcome', compact('topRatedRecipes'));
}
}
