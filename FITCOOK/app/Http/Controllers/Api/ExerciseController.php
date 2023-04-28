<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();
        return response()->json($exercises, 200);
    }

    public function show(Exercise $exercise)
    {
        return response()->json($exercise, 200);
    }

    public function store(Request $request)
    {
        $exercise = Exercise::create($request->all());
        return response()->json($exercise, 201);
    }

    public function update(Request $request, Exercise $exercise)
    {
        $exercise->update($request->all());
        return response()->json($exercise, 200);
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return response()->json(null, 204);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}
