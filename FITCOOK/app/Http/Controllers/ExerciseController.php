<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all();

        return view('exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'muscle_groups' => 'required',
            'video_url' => 'required',
        ]);

        Exercise::create($validatedData);

        return redirect()->route('exercises.index');
    }

    public function edit(Exercise $exercise)
    {
        return view('exercises.edit', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'level' => 'required',
            'muscle_groups' => 'required',
            'video_url' => 'required',
        ]);

        $exercise->update($validatedData);

        return redirect()->route('exercises.index');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();

        return redirect()->route('exercises.index');
    }
}

