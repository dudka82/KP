<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    Recipe::class => RecipePolicy::class,
    Comment::class => CommentPolicy::class,
];
}
