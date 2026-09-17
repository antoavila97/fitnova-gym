<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRutinaRequest;
use App\Http\Requests\UpdateRutinaRequest;
use App\Models\Rutina;
use App\Models\User;
use Illuminate\Http\Request;

class RutinaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->esSocio()) {
            $rutinas = $request->user()->rutinasAsignadas()->with(['entrenador', 'ejercicios'])->latest()->get();
            $esSocio = true;
        } else {
            $rutinas = Rutina::with(['socio', 'entrenador', 'ejercicios'])
                ->withCount('ejercicios')
                ->latest()
                ->paginate(15);
            $esSocio = false;
        }

        return view('rutinas.index', compact('rutinas', 'esSocio'));
    }

    public function create()
    {
        $socios = User::where('role', 'socio')->orderBy('name')->get();

        return view('rutinas.create', compact('socios'));
    }

    public function store(StoreRutinaRequest $request)
    {
        Rutina::create(array_merge($request->validated(), [
            'entrenador_id' => $request->user()->id,
        ]));

        return redirect()->route('rutinas.index')->with('success', 'Rutina asignada correctamente.');
    }

    public function show(Rutina $rutina)
    {
        $rutina->load(['entrenador', 'socio', 'ejercicios']);

        return view('rutinas.show', compact('rutina'));
    }

    public function edit(Rutina $rutina)
    {
        $socios = User::where('role', 'socio')->orderBy('name')->get();

        return view('rutinas.edit', compact('rutina', 'socios'));
    }

    public function update(UpdateRutinaRequest $request, Rutina $rutina)
    {
        $rutina->update($request->validated());

        return redirect()->route('rutinas.show', $rutina)->with('success', 'Rutina actualizada.');
    }

    public function destroy(Rutina $rutina)
    {
        $rutina->delete();

        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada.');
    }
}
