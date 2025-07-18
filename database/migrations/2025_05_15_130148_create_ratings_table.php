<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('ratings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
    $table->tinyInteger('rating')->unsigned()->between(1, 5);
    $table->timestamps();
    
    $table->unique(['user_id', 'recipe_id']); // чтобы нельзя было добавить дважды
});
    }

    /**
  git init   * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('ratings');
    }
};
