<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CommentController extends Controller
{
   public function store(Request $request, Recipe $recipe)
{
    $request->validate([
        'text' => 'required|string|max:300'
    ]);
    
    $comment = $recipe->comments()->create([
        'text' => $request->text, 
        'user_id' => auth()->id()
    ]);
    
    return back()->with('success', 'Комментарий добавлен!');
}

    public function destroy(Comment $comment)
    { 
        $comment->delete();      
        return back()->with('success', 'Комментарий удален');
    }
}