<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
protected $fillable = ['recipe_id', 'step_number', 'description','image_url'];

public function recipe()
{
    return $this->belongsTo(Recipe::class);
}
}