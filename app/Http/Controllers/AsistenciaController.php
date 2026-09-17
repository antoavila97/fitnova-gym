<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Clase;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function reservar(Request $request, Clase $clase)
    {
        if ($clase->fecha->isPast()) {
            return back()->with('error', 'No puedes reservar una clase ya pasada.');
        }

        if ($clase->asistencias()->where('socio_id', $request->user()->id)->exists()) {
            return back()->with('error', 'Ya estás inscripto en esta clase.');
        }

        if (! $clase->tieneCupo()) {
            return back()->with('error', 'La clase alcanzó su cupo máximo.');
        }

        Asistencia::create([
            'clase_id' => $clase->id,
            'socio_id' => $request->user()->id,
            'fecha' => $clase->fecha,
            'asistio' => false,
        ]);

        return back()->with('success', 'Te inscribiste en la clase correctamente.');
    }

    public function cancelar(Request $request, Clase $clase)
    {
        $clase->asistencias()->where('socio_id', $request->user()->id)->delete();

        return back()->with('success', 'Inscripción cancelada.');
    }

    public function cambiarEstado(Request $request, Asistencia $asistencia)
    {
        $asistencia->update([
            'asistio' => $request->boolean('asistio'),
        ]);

        return back()->with('success', 'Asistencia actualizada.');
    }
}
