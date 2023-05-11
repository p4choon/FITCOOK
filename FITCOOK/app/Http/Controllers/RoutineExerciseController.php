<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Routine;
use App\Models\RoutineExercise;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Routine::all();
        return response()->json($routines);
    }

    public function store(Request $request)
    {
        // $routine = new Routine();
        // $routine->title = $request->title;
        // $routine->description = $request->description;
        // $routine->save();

        // $exercises = $request->exercises;
        // foreach ($exercises as $exercise) {
        //     $routineExercise = new RoutineExercise();
        //     $routineExercise->name = $exercise['name'];
        //     $routineExercise->sets = $exercise['sets'];
        //     $routineExercise->repetitions = $exercise['repetitions'];
        //     $routineExercise->rest_time = $exercise['rest_time'];
        //     $routineExercise->tips = $exercise['tips'];
        //     $routineExercise->routine_id = $routine->id;
        //     $routineExercise->save();
        // }

        // return response()->json($routine, 201);

        $routine = ExerciseRoutine::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
    
        foreach ($request->exercises as $exercise) {
            $routineExercise = new RoutineExercise();
            $routineExercise->title = $exercise['name'];
            $routineExercise->sets = $exercise['sets'];
            $routineExercise->repetitions = $exercise['repetitions'];
            $routineExercise->rest_time = $exercise['rest_time'];
            $routineExercise->tips = $exercise['tips'];
            $routineExercise->routine_id = $routine->id;
            $routineExercise->save();
        }
    
        return response()->json(['message' => 'Routine created successfully.']);
    }

    public function show($id)
    {
        $routine = Routine::findOrFail($id);
        return response()->json($routine);
    }

    public function update(Request $request, $id)
    {
        $routine = Routine::findOrFail($id);
        $routine->title = $request->title;
        $routine->description = $request->description;
        $routine->save();

        $exercises = $request->exercises;
        foreach ($exercises as $exercise) {
            $routineExercise = RoutineExercise::findOrFail($exercise['id']);
            $routineExercise->name = $exercise['name'];
            $routineExercise->sets = $exercise['sets'];
            $routineExercise->repetitions = $exercise['repetitions'];
            $routineExercise->rest_time = $exercise['rest_time'];
            $routineExercise->tips = $exercise['tips'];
            $routineExercise->routine_id = $routine->id;
            $routineExercise->save();
        }

        return response()->json($routine);
    }

    public function destroy($id)
    {
        $routine = Routine::findOrFail($id);
        $routine->delete();

        return response()->json(null, 204);
    }
}
