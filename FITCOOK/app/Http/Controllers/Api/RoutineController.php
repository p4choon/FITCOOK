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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|string',
            'duration' => 'required|integer|min:1',
            'muscle_groups' => 'required|string',
            'exercises' => 'required|array|min:1',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.repetitions' => 'required|integer|min:1',
            'exercises.*.rest_time' => 'required|integer|min:1',
            'exercises.*.tips' => 'nullable|string'
        ]);
    
        $routine = new Routine;
        $routine->title = $validatedData['title'];
        $routine->description = $validatedData['description'];
        $routine->level = $validatedData['level'];
        $routine->duration = $validatedData['duration'];
        $routine->muscle_groups = $validatedData['muscle_groups'];
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

        return response()->json(['routine' => $routine], 200);
    }

    // public function show(Routine $routine)
    // {
    //     $routine->load('exercises');
    //     return view('routines.show', compact('routine'));
    // }

    // public function edit(Routine $routine)
    // {
    //     $exercises = Exercise::all();
    //     $routine->load('exercises');
    //     return view('routines.edit', compact('routine', 'exercises'));
    // }

    public function update(Request $request, $id)
    {
        $routine = Routine::find($id);
        if ($routine){
            if ($request->input('title')){
                $routine->title=$request->input('title');
            }
            if ($request->input('description')){
                $routine->description=$request->input('description');
            }
            if ($request->input('level')){
                $routine->level=$request->input('level');
            }
            if ($request->input('duration')){
                $routine->duration=$request->input('duration');
            }
            if ($request->input('muscle_groups')){
                $routine->muscle_groups=$request->input('muscle_groups');
            }
            $routine->save();

            return response()->json([
                'success' => true,
                'data'    => $routine
            ], 201);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error, rutina no encontrada'
            ], 404);
        }
    }

    public function destroy($id)
    {
        
        $routine = Routine::find($id);
        if($routine){
            $routine->delete();
            return response()->json([
                'success' => true,
                'data'    => $routine
            ], 201);
        } else{
            return response()->json([
                'success'  => false,
                'message' => 'Error, ejercicio no encontrado'
            ], 404);
        }
        
    }

    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
}