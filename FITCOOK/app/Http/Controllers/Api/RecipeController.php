<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        return response()->json(['recipes' => $recipes], 200);
    }

    public function show(Recipe $recipe)
    {
        return response()->json($recipe, 200);
    }

    public function store(Request $request)
    {
        $recipe = Recipe::create($request->all());
        return response()->json($recipe, 201);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $recipe->update($request->all());
        return response()->json($recipe, 200);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return response()->json(null, 204);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
