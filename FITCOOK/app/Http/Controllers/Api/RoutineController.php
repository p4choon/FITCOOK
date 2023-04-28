<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Routine;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::all();
        // $routines = Auth::user()->routines()->with('exercises')->get();
        return response()->json(['routines' => $routines], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'exercises' => 'required|array',
            'exercises.*.id' => 'required|integer|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.repetitions' => 'required|integer|min:1',
            'exercises.*.rest_time' => 'nullable|integer|min:0',
            'exercises.*.tips' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $routine = new Routine;
        $routine->user_id = Auth::id();
        $routine->title = $request->title;
        $routine->description = $request->description;
        $routine->save();

        $routine->exercises()->sync($request->exercises);

        return response()->json(['routine' => $routine->load('exercises')], 201);
    }

    public function show($id)
    {
        $routine = Auth::user()->routines()->with('exercises')->find($id);

        if (!$routine) {
            return response()->json(['error' => 'Routine not found'], 404);
        }

        return response()->json(['routine' => $routine], 200);
    }

    public function update(Request $request, $id)
    {
        $routine = Auth::user()->routines()->find($id);

        if (!$routine) {
            return response()->json(['error' => 'Routine not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string|max:1000',
            'exercises' => 'array',
            'exercises.*.id' => 'required_with:exercises|integer|exists:exercises,id',
            'exercises.*.sets' => 'required_with:exercises|integer|min:1',
            'exercises.*.repetitions' => 'required_with:exercises|integer|min:1',
            'exercises.*.rest_time' => 'nullable|integer|min:0',
            'exercises.*.tips' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->has('title')) {
            $routine->title = $request->title;
        }

        if ($request->has('description')) {
            $routine->description = $request->description;
        }

        if ($request->has('exercises')) {
            $routine->exercises()->sync($request->exercises);
        }
        $routine->save();

        return response()->json(['routine' => $routine->load('exercises')], 200);
    }
    
    public function destroy($id)
    {
        $routine = Auth::user()->routines()->find($id);
    
        if (!$routine) {
            return response()->json(['error' => 'Routine not found'], 404);
        }
    
        $routine->exercises()->detach();
        $routine->delete();
    
        return response()->json(['message' => 'Routine deleted successfully'], 200);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}