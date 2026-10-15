<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pagos — FitNova Gym</title>
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
            border-bottom: 2px solid #e11d48;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header table {
            width: 100%;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #881337;
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

        .summary-box {
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        .summary-box table {
            width: 100%;
        }
        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: 600;
            color: #9f1239;
        }
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #881337;
        }

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
            padding: 7px 8px;
            border-bottom: 1.5px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 8.5px;
            letter-spacing: 0.3px;
        }
        table.data-table td {
            padding: 6px 8px;
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
        .badge-method {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8.5px;
            font-weight: 500;
            text-transform: capitalize;
            background-color: #f3f4f6;
            color: #374151;
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
                    <div class="header-subtitle">Libro Diario y Reporte Detallado de Pagos</div>
                </td>
                <td style="width: 40%;" class="header-meta">
                    <div><strong>Fecha de emisión:</strong> {{ now()->format('d/m/Y H:i') }}</div>
                    <div><strong>Generado por:</strong> {{ auth()->user()->name ?? 'Administrador' }}</div>
                    <div><strong>Moneda oficial:</strong> Bolivianos (Bs.)</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Caja de resumen -->
    <div class="summary-box">
        <table>
            <tr>
                <td style="width: 50%;">
                    <div class="summary-label">Total Comprobantes Emitidos</div>
                    <div class="summary-value">{{ $pagos->count() }} pagos</div>
                </td>
                <td style="width: 50%; text-align: right;">
                    <div class="summary-label">Monto Total Recaudado</div>
                    <div class="summary-value">Bs. {{ number_format($totalRecaudado, 2, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabla detallada -->
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 6%;">#</th>
                <th style="width: 12%;">Fecha</th>
                <th style="width: 26%;">Socio</th>
                <th style="width: 18%;">Plan</th>
                <th style="width: 14%;">Método</th>
                <th class="text-right" style="width: 14%;">Monto (Bs.)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pagos as $pago)
                <tr>
                    <td class="text-center" style="color: #64748b;">{{ $pago->id }}</td>
                    <td>{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $pago->socio->name }}</strong><br>
                        <span style="font-size: 8.5px; color: #6b7280;">{{ $pago->socio->email }}</span>
                    </td>
                    <td>{{ $pago->membresia?->plan?->nombre ?? 'Sin plan' }}</td>
                    <td>
                        <span class="badge-method">{{ $pago->metodo }}</span>
                    </td>
                    <td class="text-right" style="font-weight: bold; color: #15803d;">
                        Bs. {{ number_format($pago->monto, 2, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 16px;">No hay pagos registrados en el sistema.</td>
                </tr>
            @endforelse
            <tr style="background-color: #f1f5f9; font-weight: bold; font-size: 11px;">
                <td colspan="5" style="text-align: right; padding: 8px;">TOTAL GENERAL RECAUDADO:</td>
                <td class="text-right" style="color: #15803d; padding: 8px;">
                    Bs. {{ number_format($totalRecaudado, 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        FitNova Gym — Comprobante oficial de recaudaciones · Expresado en Bolivianos (Bs.) · Documento emitido para auditoría y control interno
    </div>

</body>
</html>
