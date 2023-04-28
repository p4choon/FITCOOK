<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return response()->json($ingredients, 200);
    }

    public function show(Ingredient $ingredient)
    {
        return response()->json($ingredient, 200);
    }

    public function store(Request $request)
    {
        $ingredient = Ingredient::create($request->all());
        return response()->json($ingredient, 201);
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $ingredient->update($request->all());
        return response()->json($ingredient, 200);
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return response()->json(null, 204);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
