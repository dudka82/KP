<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate(['text' => 'required|string|max:500']);
        
        Comment::create([
            'user_id' => auth()->id(),
            'recipe_id' => $recipe->id,
            'text' => $request->text,
        ]);
        
        return back()->with('success', 'Комментарий добавлен!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Комментарий удален.');
    }
}