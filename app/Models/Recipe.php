<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'cooking_time',
        'difficulty',
        'servings',
        'image_url',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}   
    public function ratings()
{
    return $this->hasMany(Rating::class);
}  
public function averageRating()
{
    return $this->ratings()->avg('rating') ?? 0;
}
public function ratingsCount()
{
    return $this->ratings()->count();
} 
public function ingredients()
{
    return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                ->withPivot('amount')
                ->withTimestamps();
}   
public function steps()
{
    return $this->hasMany(Step::class)->orderBy('step_number');
}
}