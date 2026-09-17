<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
            <a href="{{ route('reportes.pagos_csv') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                Exportar pagos (CSV)
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Ingresos por mes (últimos 12 meses)</h3>
                <canvas id="gIngresos" data-labels='@json(array_keys($ingresosPorMes->toArray()))' data-values='@json(array_values($ingresosPorMes->toArray()))'></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Vencimientos de membresías (próximos 6 meses)</h3>
                <canvas id="gVencimientos" data-labels='@json(array_keys($vencimientosPorMes->toArray()))' data-values='@json(array_values($vencimientosPorMes->toArray()))'></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Socios por plan</h3>
                <canvas id="gPlanes" data-labels='@json(array_keys($sociosPorPlan->toArray()))' data-values='@json(array_values($sociosPorPlan->toArray()))'></canvas>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Pagos por método</h3>
                <div class="space-y-3">
                    @forelse ($pagometodo as $pm)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm capitalize text-gray-600">{{ $pm->metodo }}</span>
                            <span class="text-sm font-semibold text-gray-800">${{ number_format($pm->monto, 2, ',', '.') }} <span class="text-gray-400 text-xs">({{ $pm->total }} pagos)</span></span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Sin datos.</p>
                    @endforelse
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-semibold text-gray-800 mb-4">Clases con más asistencia</h3>
                <div class="space-y-3">
                    @forelse ($asistenciasPorClase as $clase)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-600">{{ $clase->nombre }}</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $clase->asistencias_count }} asistencias</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Sin asistencias registradas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function hacerGrafico(id, tipo, datos, etiqueta = null) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    const labels = JSON.parse(el.dataset.labels);
                    const values = JSON.parse(el.dataset.values);
                    new Chart(el, {
                        type: tipo,
                        data: {
                            labels,
                            datasets: [{
                                label: etiqueta,
                                data: values,
                                backgroundColor: tipo === 'doughnut' ? ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#06b6d4', '#a855f7'] : '#6366f1',
                                borderRadius: 6,
                            }],
                        },
                        options: { responsive: true, plugins: { legend: { display: tipo === 'doughnut' } }, scales: tipo === 'doughnut' ? {} : { y: { beginAtZero: true } } },
                    });
                }

                hacerGrafico('gIngresos', 'bar', null, 'Ingresos ($)');
                hacerGrafico('gVencimientos', 'bar', null, 'Membresías');
                hacerGrafico('gPlanes', 'doughnut', null);
            });
        </script>
    @endpush
</x-app-layout>