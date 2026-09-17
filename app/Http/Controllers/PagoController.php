<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePagoRequest;
use App\Models\Membresia;
use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->esSocio()) {
            $pagos = $request->user()->pagos()->with('membresia.plan')->latest()->paginate(15);
            $esSocio = true;
        } else {
            $pagos = Pago::with(['socio', 'membresia.plan'])->latest()->paginate(15);
            $esSocio = false;
        }

        $totalIngresos = Pago::sum('monto');

        return view('pagos.index', compact('pagos', 'esSocio', 'totalIngresos'));
    }

    public function create(Request $request)
    {
        $membresias = Membresia::with(['socio', 'plan'])
            ->orderByDesc('fecha_fin')
            ->get();

        $membresiaSeleccionada = $request->query('membresia_id');

        return view('pagos.create', compact('membresias', 'membresiaSeleccionada'));
    }

    public function store(StorePagoRequest $request)
    {
        $membresia = Membresia::with('plan')->findOrFail($request->membresia_id);

        Pago::create([
            'membresia_id' => $membresia->id,
            'socio_id' => $membresia->socio_id,
            'monto' => $request->monto,
            'fecha_pago' => $request->fecha_pago,
            'metodo' => $request->metodo,
            'concepto' => $request->concepto,
        ]);

        if ($membresia->estaVencida()) {
            $membresia->update(['estado' => 'activa']);
        }

        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();

        return redirect()->route('pagos.index')->with('success', 'Pago eliminado.');
    }
}
