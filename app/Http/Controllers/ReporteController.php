<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Plan;
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

    public function exportarPagos(Request $request)
    {
        $pagos = Pago::with(['socio', 'membresia.plan'])->latest()->get();

        $csv = "\xEF\xBB\xBFid,socio,email,plan,concepto,metodo,monto,fecha\n";

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
