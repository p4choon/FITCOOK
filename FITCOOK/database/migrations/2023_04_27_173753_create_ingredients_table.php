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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('calories');
            $table->float('fat');
            $table->float('saturated_fat');
            $table->float('polyunsaturated_fat');
            $table->float('monounsaturated_fat');
            $table->float('trans_fat');
            $table->integer('cholesterol');
            $table->integer('sodium');
            $table->integer('potassium');
            $table->integer('carbohydrates');
            $table->integer('fiber');
            $table->integer('sugar');
            $table->integer('protein');
            $table->integer('vitamin_a');
            $table->integer('vitamin_c');
            $table->integer('calcium');
            $table->integer('iron');
            $table->timestamps();
        });

        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->float('quantity');
            $table->string('unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
        Schema::dropIfExists('ingredients');
    }
};
