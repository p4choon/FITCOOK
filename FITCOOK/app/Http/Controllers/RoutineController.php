<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use Auth;

class RoutineController extends Controller
{
    public function index()
    {
        $routines = Auth::user()->routines;
        return view('routines.index', compact('routines'));
    }

    public function create()
    {
        return view('routines.create');
    }

    public function store(Request $request)
    {
        $routine = new Routine($request->all());
        Auth::user()->routines()->save($routine);
        return redirect()->route('routines.show', $routine);
    }

    public function show(Routine $routine)
    {
        return view('routines.show', compact('routine'));
    }

    public function edit(Routine $routine)
    {
        return view('routines.edit', compact('routine'));
    }

    public function update(Request $request, Routine $routine)
    {
        $routine->update($request->all());
        return redirect()->route('routines.show', $routine);
    }

    public function destroy(Routine $routine)
    {
        $routine->delete();
        return redirect()->route('routines.index');
    }
}
