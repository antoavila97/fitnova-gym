<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $ingresosPorMes = Pago::selectRaw("DATE_FORMAT(fecha_pago, '%Y-%m') as mes, SUM(monto) as total")
            ->where('fecha_pago', '>=', now()->subYears(1)->startOfMonth()->toDateString())
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $sociosPorPlan = Plan::withCount(['membresias as activas' => fn ($q) => $q->where('estado', 'activa')])
            ->get()
            ->pluck('activas', 'nombre');

        $pagometodo = Pago::selectRaw('metodo, COUNT(*) as total, SUM(monto) as monto')
            ->groupBy('metodo')
            ->get();

        $asistenciasPorClase = Clase::withCount('asistencias')
            ->orderByDesc('asistencias_count')
            ->take(10)
            ->get();

        $vencimientosPorMes = Membresia::where('estado', 'activa')
            ->selectRaw("DATE_FORMAT(fecha_fin, '%Y-%m') as mes, COUNT(*) as total")
            ->whereBetween('fecha_fin', [now()->toDateString(), now()->addMonths(6)->toDateString()])
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        return view('reportes.index', compact(
            'ingresosPorMes',
            'sociosPorPlan',
            'pagometodo',
            'asistenciasPorClase',
            'vencimientosPorMes',
        ));
    }

    public function exportarPdf()
    {
        $totalSocios = User::where('role', 'socio')->count();
        $sociosActivos = User::where('role', 'socio')
            ->whereHas('membresias', fn ($q) => $q->where('estado', 'activa'))
            ->count();

        $morososCount = Membresia::where('estado', 'vencida')
            ->orWhereDate('fecha_fin', '<', now()->toDateString())
            ->count();

        $totalIngresos = Pago::sum('monto');

        $pagometodo = Pago::selectRaw('metodo, COUNT(*) as total, SUM(monto) as monto')
            ->groupBy('metodo')
            ->get();

        $sociosPorPlan = Plan::withCount(['membresias as activas' => fn ($q) => $q->where('estado', 'activa')])
            ->get();

        $asistenciasPorClase = Clase::with('entrenador')
            ->withCount('asistencias')
            ->orderByDesc('asistencias_count')
            ->take(10)
            ->get();

        $membresias = Membresia::with(['socio', 'plan'])
            ->orderBy('fecha_fin')
            ->get();

        $pdf = Pdf::loadView('reportes.pdf', compact(
            'totalSocios',
            'sociosActivos',
            'morososCount',
            'totalIngresos',
            'pagometodo',
            'sociosPorPlan',
            'asistenciasPorClase',
            'membresias'
        ));

        return $pdf->download('reporte_general_fitnova_'.now()->format('Y-m-d').'.pdf');
    }

    public function exportarPagosPdf()
    {
        $pagos = Pago::with(['socio', 'membresia.plan'])->latest('fecha_pago')->get();
        $totalRecaudado = $pagos->sum('monto');

        $pdf = Pdf::loadView('reportes.pagos_pdf', compact('pagos', 'totalRecaudado'));

        return $pdf->download('reporte_pagos_fitnova_'.now()->format('Y-m-d').'.pdf');
    }

    public function exportarPagos(Request $request)
    {
        $pagos = Pago::with(['socio', 'membresia.plan'])->latest()->get();

        $csv = "\xEF\xBB\xBFid,socio,email,plan,concepto,metodo,monto_bs,fecha\n";

        foreach ($pagos as $pago) {
            $csv .= implode(',', [
                $pago->id,
                '"'.str_replace('"', '""', $pago->socio->name ?? '').'"',
                $pago->socio->email ?? '',
                '"'.str_replace('"', '""', $pago->membresia?->plan?->nombre ?? '').'"',
                '"'.str_replace('"', '""', $pago->concepto ?? '').'"',
                $pago->metodo,
                $pago->monto,
                $pago->fecha_pago->format('Y-m-d'),
            ])."\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="reporte_pagos_'.now()->format('Y-m-d').'.csv"');
    }
}
