<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Rutina;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->esSocio()) {
            return $this->dashboardSocio($user);
        }

        return $this->dashboardGestion($user);
    }

    private function dashboardSocio(User $user)
    {
        $membresia = $user->membresiaActiva;
        $proximasClases = $user->asistencias()
            ->with('clase.entrenador')
            ->whereHas('clase', fn ($q) => $q->where('fecha', '>=', now()->toDateString()))
            ->orderBy('clases.fecha')
            ->get();

        return view('dashboard', [
            'registros' => (object) [
                'membresia' => $membresia,
                'pagosCount' => $user->pagos()->count(),
                'pagosTotal' => $user->pagos()->sum('monto'),
                'rutinasCount' => $user->rutinasAsignadas()->where('estado', 'activa')->count(),
                'clasesProximas' => $proximasClases->count(),
            ],
            'proximasClases' => $proximasClases,
            'ultimosPagos' => $user->pagos()->with('membresia.plan')->latest()->take(5)->get(),
        ]);
    }

    private function dashboardGestion(User $user)
    {
        $hoy = now()->toDateString();
        $primerDiaMes = now()->startOfMonth()->toDateString();

        $ingresosMes = Pago::where('fecha_pago', '>=', $primerDiaMes)->sum('monto');
        $socios = User::where('role', 'socio');
        $sociosActivos = $socios->whereHas('membresias', fn ($q) => $q->where('estado', 'activa'))->count();
        $morosos = Membresia::whereDate('fecha_fin', '<', $hoy)
            ->whereIn('id', fn ($q) => $q->select(DB::raw('MAX(id)'))->from('membresias')->groupBy('socio_id'))
            ->with(['socio', 'plan'])
            ->orderByDesc('fecha_fin')
            ->take(8)
            ->get();

        $ingresosPorMes = Pago::selectRaw("DATE_FORMAT(fecha_pago, '%Y-%m') as mes, SUM(monto) as total")
            ->where('fecha_pago', '>=', now()->subMonths(5)->startOfMonth()->toDateString())
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        $sociosPorPlan = Plan::withCount(['membresias as socios' => fn ($q) => $q->where('estado', 'activa')])
            ->get()
            ->pluck('socios', 'nombre');

        $ultimosPagos = Pago::with(['socio', 'membresia.plan'])->latest()->take(8)->get();

        $clasesProximas = Clase::with('entrenador')
            ->where('fecha', '>=', $hoy)
            ->orderBy('fecha')
            ->orderBy('hora')
            ->take(8)
            ->get();

        return view('dashboard', [
            'registros' => (object) [
                'sociosActivos' => $sociosActivos,
                'sociosTotales' => User::where('role', 'socio')->count(),
                'ingresosMes' => $ingresosMes,
                'pagosMes' => Pago::where('fecha_pago', '>=', $primerDiaMes)->count(),
                'morososCount' => $morosos->count(),
                'rutinasActivas' => Rutina::where('estado', 'activa')->count(),
                'clasesHoy' => Clase::where('fecha', $hoy)->count(),
                'proximasClases' => $clasesProximas->count(),
            ],
            'morosos' => $morosos,
            'ingresosPorMes' => $ingresosPorMes,
            'sociosPorPlan' => $sociosPorPlan,
            'ultimosPagos' => $ultimosPagos,
            'clasesProximas' => $clasesProximas,
        ]);
    }
}
