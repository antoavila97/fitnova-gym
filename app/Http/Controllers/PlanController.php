<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $planes = Plan::withCount('membresias')->orderBy('precio')->get();

        return view('planes.index', compact('planes'));
    }

    public function create()
    {
        return view('planes.create');
    }

    public function store(StorePlanRequest $request)
    {
        Plan::create(array_merge($request->validated(), ['activo' => $request->boolean('activo')]));

        return redirect()->route('planes.index')->with('success', 'Plan creado correctamente.');
    }

    public function edit(Plan $plane)
    {
        return view('planes.edit', compact('plane'));
    }

    public function update(UpdatePlanRequest $request, Plan $plane)
    {
        $plane->update(array_merge($request->validated(), ['activo' => $request->boolean('activo')]));

        return redirect()->route('planes.index')->with('success', 'Plan actualizado correctamente.');
    }

    public function destroy(Plan $plane)
    {
        if ($plane->membresias()->exists()) {
            return back()->with('error', 'No se puede eliminar: el plan tiene membresías asociadas.');
        }

        $plane->delete();

        return redirect()->route('planes.index')->with('success', 'Plan eliminado.');
    }
}
