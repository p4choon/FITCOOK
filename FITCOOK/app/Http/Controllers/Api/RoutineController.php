<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Routine;
use App\Models\Exercise;
use App\Models\RoutineExercise;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::all();
        return response()->json(['routines' => $routines], 200);
    }

    public function store(Request $request)
    {
        // $routine = new Routine();
        // $routine->title = $request->title;
        // $routine->description = $request->description;
        // $routine->user_id = auth()->user()->id;
        // $routine->save();

        // foreach ($request->exercises as $exercise) {
        //     $routine->exercises()->attach($exercise['id'], [
        //         'sets' => $exercise['sets'],
        //         'repetitions' => $exercise['repetitions'],
        //         'rest_time' => $exercise['rest_time'],
        //         'tips' => $exercise['tips']
        //     ]);
        // }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'exercises' => 'required|array|min:1',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.repetitions' => 'required|integer|min:1',
            'exercises.*.rest_time' => 'required|integer|min:1',
            'exercises.*.tips' => 'nullable|string'
        ]);
    
        $routine = new Routine;
        $routine->title = $validatedData['title'];
        $routine->description = $validatedData['description'];
        $routine->user_id = $request->user_id;
        $routine->save();

        foreach ($request->exercises as $exercise) {
            $routineEx = new RoutineExercise;
            $routineEx->routine_id = $routine->id;
            $routineEx->exercise_id = $exercise['id'];
            $routineEx->sets = $exercise['sets'];
            $routineEx->repetitions = $exercise['repetitions'];
            $routineEx->rest_time = $exercise['rest_time'];
            $routineEx->tips = $exercise['tips'];
            $routineEx->save();
        }
        

    }

    public function show(Routine $routine)
    {
        $routine->load('exercises');
        return view('routines.show', compact('routine'));
    }

    public function edit(Routine $routine)
    {
        $exercises = Exercise::all();
        $routine->load('exercises');
        return view('routines.edit', compact('routine', 'exercises'));
    }

    public function update(Request $request, Routine $routine)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.repetitions' => 'required|integer|min:1',
            'exercises.*.rest_time' => 'required|integer|min:1',
            'exercises.*.tips' => 'nullable|string|max:255',
        ]);

        $routine->title = $request->title;
        $routine->description = $request->description;
        $routine->save();

        $routine->exercises()->delete();

        foreach ($request->exercises as $exercise) {
            $routineExercise = new RoutineExercise();
            $routineExercise->routine_id = $routine->id;
            $routineExercise->exercise_id = $exercise['exercise_id'];
            $routineExercise->sets = $exercise['sets'];
            $routineExercise->repetitions = $exercise['repetitions'];
            $routineExercise->rest_time = $exercise['rest_time'];
            $routineExercise->tips = $exercise['tips'];
            $routineExercise->save();
        }

        return response()->json([
            'message' => 'Routine updated successfully',
            'routine' => $routine,
        ], 200);
    }

    public function destroy($id)
    {
        $routine = Routine::findOrFail($id);
        $routine->delete();

        return response()->json(['message' => 'La rutina ha sido eliminada exitosamente']);
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}