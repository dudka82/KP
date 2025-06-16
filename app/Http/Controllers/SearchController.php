<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
   public function index()
    {
        $recipes = Recipe::all(); 
        return view('search', compact('recipes'));
    }
}