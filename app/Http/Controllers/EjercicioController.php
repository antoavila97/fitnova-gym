<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEjercicioRequest;
use App\Models\Ejercicio;
use App\Models\Rutina;

class EjercicioController extends Controller
{
    public function store(StoreEjercicioRequest $request, Rutina $rutina)
    {
        $rutina->ejercicios()->create($request->validated());

        return back()->with('success', 'Ejercicio agregado a la rutina.');
    }

    public function update(StoreEjercicioRequest $request, Rutina $rutina, Ejercicio $ejercicio)
    {
        $ejercicio->update($request->validated());

        return back()->with('success', 'Ejercicio actualizado.');
    }

    public function destroy(Rutina $rutina, Ejercicio $ejercicio)
    {
        $ejercicio->delete();

        return back()->with('success', 'Ejercicio eliminado.');
    }
}
