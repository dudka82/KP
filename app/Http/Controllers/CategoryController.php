<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
public function index()
    {
        $pendingCategories = Category::where('status', 'pending')->get();
        $approvedCategories = Category::where('status', 'approved')->get();
        
        return view('categories.index', compact('pendingCategories', 'approvedCategories'));
    }
    
    public function create()
    {
        return view('categories.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        
        $validated['status'] = 'pending';
        $validated['user_id'] = auth()->id();
        
        Category::create($validated);
        
        return redirect()->route('dashboard')->with('success', 'Категория отправлена на модерацию!');
    }
    
    public function approve(Category $category)
    {
        $category->update(['status' => 'approved']);
        return back()->with('success', 'Категория одобрена!');
    }
    
    public function reject(Category $category)
    {
        $category->update(['status' => 'rejected']);
        return back()->with('success', 'Категория отклонена!');
    }
}