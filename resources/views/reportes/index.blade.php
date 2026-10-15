<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('reportes.pdf') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Reporte General (PDF)
                </a>
                <a href="{{ route('reportes.pagos_pdf') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-rose-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-500 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Reporte Pagos (PDF)
                </a>
                <a href="{{ route('reportes.pagos_csv') }}" class="inline-flex items-center px-3 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition">
                    CSV
                </a>
            </div>
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
                            <span class="text-sm font-semibold text-gray-800">Bs. {{ number_format($pm->monto, 2, ',', '.') }} <span class="text-gray-400 text-xs">({{ $pm->total }} pagos)</span></span>
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

                hacerGrafico('gIngresos', 'bar', null, 'Ingresos (Bs.)');
                hacerGrafico('gVencimientos', 'bar', null, 'Membresías');
                hacerGrafico('gPlanes', 'doughnut', null);
            });
        </script>
    @endpush
</x-app-layout>