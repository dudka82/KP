<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller{
public function account()
{
    $user = Auth::user();
    
    return view('dashboard', [
        'favoriteRecipes' => $user->favoriteRecipes()->get(),
        'createdRecipes' => $user->recipes()->where('status','approved')->get(),
        'ratingsCount' => $user->ratings()->count(),
        'commentsCount' => $user->comments()->count()
    ]);
}
}