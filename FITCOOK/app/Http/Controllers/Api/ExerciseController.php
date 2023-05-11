<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();
        return response()->json(['exercises' => $exercises], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'level' => 'required',
            'muscle_groups' => 'required',
            'video_url' => 'required',
            'miniature' => 'required'
        ]);

        $exercise = new Exercise;
        
        $exercise->user_id = $request->user_id;
        $exercise->title = $request->title;
        $exercise->description = $request->description;
        $exercise->level = $request->level;
        $exercise->muscle_groups = $request->muscle_groups;
        $exercise->video_url = $request->video_url;
        $exercise->miniature = $request->miniature;
        $exercise->save();

        return response()->json(['exercise' => $exercise], 200);
    }

    public function update(Request $request, $id)
    {
        $exercise = Exercise::find($id);
        if ($exercise){
            if ($request->input('title')){
                $exercise->title=$request->input('title');
            }
            if ($request->input('description')){
                $exercise->description=$request->input('description');
            }
            if ($request->input('level')){
                $exercise->level=$request->input('level');
            }
            if ($request->input('muscle_groups')){
                $exercise->muscle_groups=$request->input('muscle_groups');
            }
            if ($request->input('video_url')){
                $exercise->video_url=$request->input('video_url');
            }
            if ($request->input('miniature')){
                $exercise->miniature=$request->input('miniature');
            }
            $exercise->save();

            return response()->json([
                'success' => true,
                'data'    => $exercise
            ], 201);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error, ejercicio no encontrado'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $exercise = Exercise::find($id);
        if($exercise){
            $exercise->delete();
            return response()->json([
                'success' => true,
                'data'    => $exercise
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
