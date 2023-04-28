<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Auth;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Auth::user()->recipes;
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function store(Request $request)
    {
        $recipe = new Recipe($request->all());
        Auth::user()->recipes()->save($recipe);
        return redirect()->route('recipes.show', $recipe);
    }

    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request, Recipe $recipe)
    {
        $recipe->update($request->all());
        return redirect()->route('recipes.show', $recipe);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect()->route('recipes.index');
    }
}
