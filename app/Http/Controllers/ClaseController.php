<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClaseRequest;
use App\Http\Requests\UpdateClaseRequest;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index(Request $request)
    {
        $esSocio = $request->user()->esSocio();

        $clases = Clase::with('entrenador')
            ->withCount('asistencias')
            ->with(['asistencias' => fn ($q) => $esSocio ? $q->where('socio_id', $request->user()->id) : $q])
            ->orderBy('fecha')
            ->orderBy('hora')
            ->paginate(15);

        return view('clases.index', compact('clases', 'esSocio'));
    }

    public function create()
    {
        $entrenadores = User::where('role', 'entrenador')->orderBy('name')->get();

        return view('clases.create', compact('entrenadores'));
    }

    public function show(Clase $clase)
    {
        $clase->load(['entrenador', 'asistencias.socio']);

        return view('clases.show', compact('clase'));
    }

    public function store(StoreClaseRequest $request)
    {
        Clase::create($request->validated());

        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function edit(Clase $clase)
    {
        $entrenadores = User::where('role', 'entrenador')->orderBy('name')->get();

        return view('clases.edit', compact('clase', 'entrenadores'));
    }

    public function update(UpdateClaseRequest $request, Clase $clase)
    {
        $clase->update($request->validated());

        return redirect()->route('clases.index')->with('success', 'Clase actualizada.');
    }

    public function destroy(Clase $clase)
    {
        $clase->delete();

        return redirect()->route('clases.index')->with('success', 'Clase eliminada.');
    }
}
