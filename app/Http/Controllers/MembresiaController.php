<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembresiaRequest;
use App\Models\Membresia;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->esSocio()) {
            $membresias = $request->user()->membresias()->with('plan')->latest()->get();

            return view('membresias.index', ['membresias' => $membresias, 'esSocio' => true]);
        }

        $membresias = Membresia::with(['socio', 'plan'])
            ->orderByDesc('fecha_fin')
            ->paginate(15);

        return view('membresias.index', ['membresias' => $membresias, 'esSocio' => false]);
    }

    public function create(Request $request)
    {
        $socios = User::where('role', 'socio')->orderBy('name')->get();
        $planes = Plan::where('activo', true)->get();
        $socioSeleccionado = $request->query('socio_id');

        return view('membresias.create', compact('socios', 'planes', 'socioSeleccionado'));
    }

    public function store(StoreMembresiaRequest $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        Membresia::create([
            'socio_id' => $request->socio_id,
            'plan_id' => $plan->id,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => Carbon::parse($request->fecha_inicio)->addMonths($plan->duracion_meses),
            'estado' => 'activa',
        ]);

        return redirect()->route('membresias.index')
            ->with('success', 'Membresía asignada correctamente.');
    }

    public function destroy(Membresia $membresia)
    {
        $membresia->delete();

        return redirect()->route('membresias.index')->with('success', 'Membresía eliminada.');
    }
}
