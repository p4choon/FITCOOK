<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Routine;
use App\Models\RoutineExercise;
use Illuminate\Http\Request;

class RoutineExerciseController extends Controller
{
    public function index()
    {
        $routinesEx = RoutineExercise::all();
        return response()->json(['routines' => $routinesEx], 200);
    }

    public function update(Request $request, $id)
    {
        $routineEx = RoutineExercise::find($id);
        if (!$routineEx){
            return response()->json([
                'success'  => false,
                'message' => 'Error, rutina no encontrada'
            ], 404);
        }
        
        $sets = $request->input('sets');
        $repetitions = $request->input('repetitions');
        $rest_time = $request->input('rest_time');
        $tips = $request->input('tips');

        if (!$sets && !$repetitions && !$rest_time && !$tips){
            return response()->json([
                'success'  => false,
                'message' => 'Error, no se especificó ningún campo para actualizar'
            ], 400);
        }

        if ($sets){
            $routineEx->sets=$sets;
        }
        if ($repetitions){
            $routineEx->repetitions=$repetitions;
        }
        if ($rest_time){
            $routineEx->rest_time=$rest_time;
        }
        if ($tips){
            $routineEx->tips=$tips;
        }
        $routineEx->save();

        return response()->json([
            'success' => true,
            'data'    => $routineEx
        ], 201);
    }


    public function destroy($id)
    {
        $routineEx = RoutineExercise::find($id);
        if($routineEx){
            $routineEx->delete();
            return response()->json([
                'success' => true,
                'data'    => $routineEx
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
