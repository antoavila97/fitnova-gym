<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte General — FitNova Gym</title>
    <style>
        @page {
            margin: 28px 32px 35px 32px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header table {
            width: 100%;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e1b4b;
            margin: 0;
        }
        .header-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-top: 3px;
        }
        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #4b5563;
        }
        .header-meta strong {
            color: #111827;
        }

        /* KPI Cards */
        .kpi-table {
            width: 100%;
            margin-bottom: 18px;
            border-spacing: 6px;
        }
        .kpi-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 12px;
            text-align: center;
        }
        .kpi-label {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 600;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .kpi-value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-top: 2px;
        }
        .kpi-value.green {
            color: #16a34a;
        }
        .kpi-value.red {
            color: #dc2626;
        }

        /* Section Headings */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #3730a3;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 3px solid #6366f1;
            padding-left: 8px;
            margin-top: 14px;
            margin-bottom: 8px;
        }

        /* Tables */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 10px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            text-align: left;
            padding: 6px 8px;
            border-bottom: 1.5px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 8.5px;
            letter-spacing: 0.3px;
        }
        table.data-table td {
            padding: 5.5px 8px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-green {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-red {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td style="width: 60%;">
                    <h1 class="header-title">💪 FitNova Gym</h1>
                    <div class="header-subtitle">Reporte General del Sistema y Métricas Operativas</div>
                </td>
                <td style="width: 40%;" class="header-meta">
                    <div><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y H:i') }}</div>
                    <div><strong>Generado por:</strong> {{ auth()->user()->name ?? 'Administrador' }}</div>
                    <div><strong>Moneda oficial:</strong> Bolivianos (Bs.)</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Resumen KPI -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-label">Total Socios</div>
                <div class="kpi-value">{{ $totalSocios }}</div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-label">Socios Activos</div>
                <div class="kpi-value green">{{ $sociosActivos }}</div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-label">Membresías Vencidas</div>
                <div class="kpi-value {{ $morososCount > 0 ? 'red' : '' }}">{{ $morososCount }}</div>
            </td>
            <td class="kpi-card" style="width: 25%;">
                <div class="kpi-label">Recaudación Total</div>
                <div class="kpi-value green">Bs. {{ number_format($totalIngresos, 2, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <!-- Recaudación por método -->
    <div class="section-title">1. Recaudación por Método de Pago</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Método de Pago</th>
                <th class="text-center">Transacciones</th>
                <th class="text-right">Total Recaudado (Bs.)</th>
                <th class="text-right">% del Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagometodo as $pm)
                <tr>
                    <td style="font-weight: 500; text-transform: capitalize;">{{ $pm->metodo }}</td>
                    <td class="text-center">{{ $pm->total }}</td>
                    <td class="text-right" style="font-weight: 600; color: #16a34a;">Bs. {{ number_format($pm->monto, 2, ',', '.') }}</td>
                    <td class="text-right">{{ $totalIngresos > 0 ? number_format(($pm->monto / $totalIngresos) * 100, 1) : 0 }}%</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Sin datos de pagos registrados.</td></tr>
            @endforelse
            <tr style="background-color: #f1f5f9; font-weight: bold;">
                <td>TOTAL GENERAL</td>
                <td class="text-center">{{ $pagometodo->sum('total') }}</td>
                <td class="text-right" style="color: #16a34a;">Bs. {{ number_format($totalIngresos, 2, ',', '.') }}</td>
                <td class="text-right">100.0%</td>
            </tr>
        </tbody>
    </table>

    <!-- Socios por plan -->
    <div class="section-title">2. Planes y Socios Activos</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Plan de Membresía</th>
                <th>Duración</th>
                <th class="text-right">Precio (Bs.)</th>
                <th class="text-center">Socios Activos</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sociosPorPlan as $plan)
                <tr>
                    <td style="font-weight: 600;">{{ $plan->nombre }}</td>
                    <td>{{ $plan->duracion_meses }} {{ $plan->duracion_meses === 1 ? 'mes' : 'meses' }}</td>
                    <td class="text-right" style="font-weight: 600;">Bs. {{ number_format($plan->precio, 2, ',', '.') }}</td>
                    <td class="text-center font-bold">{{ $plan->activas }}</td>
                    <td class="text-center">
                        <span class="badge {{ $plan->activo ? 'badge-green' : '' }}">{{ $plan->activo ? 'Activo' : 'Inactivo' }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay planes registrados.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Clases y asistencia -->
    <div class="section-title">3. Clases Grupales y Asistencia</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Clase</th>
                <th>Entrenador</th>
                <th>Fecha y Hora</th>
                <th class="text-center">Cupo</th>
                <th class="text-center">Inscritos / Asistencias</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asistenciasPorClase as $clase)
                <tr>
                    <td style="font-weight: 600;">{{ $clase->nombre }}</td>
                    <td>{{ $clase->entrenador?->name ?? 'No asignado' }}</td>
                    <td>{{ $clase->fecha->format('d/m/Y') }} a las {{ $clase->hora->format('H:i') }} hs</td>
                    <td class="text-center">{{ $clase->cupo }} personas</td>
                    <td class="text-center" style="font-weight: bold; color: #4338ca;">{{ $clase->asistencias_count }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay clases programadas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Membresías -->
    <div class="section-title">4. Estado de Membresías Registradas</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Socio</th>
                <th>Plan Asignado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Vencimiento</th>
                <th class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($membresias as $membresia)
                <tr>
                    <td>
                        <strong>{{ $membresia->socio->name }}</strong><br>
                        <span style="font-size: 8.5px; color: #6b7280;">{{ $membresia->socio->email }}</span>
                    </td>
                    <td>{{ $membresia->plan->nombre }}</td>
                    <td>{{ $membresia->fecha_inicio->format('d/m/Y') }}</td>
                    <td>{{ $membresia->fecha_fin->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="badge {{ $membresia->estado === 'activa' ? 'badge-green' : 'badge-red' }}">
                            {{ ucfirst($membresia->estado) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay membresías registradas.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        FitNova Gym — Sistema de Gestión de Gimnasio · Reporte generado automáticamente en formato PDF con montos en Bolivianos (Bs.)
    </div>

</body>
</html>
