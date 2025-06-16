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
       public function best()
    {
        $recipes = Recipe::all(); 
        return view('welcome', compact('recipes'));
    }
}
