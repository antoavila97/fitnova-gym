<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <span class="text-sm text-gray-500">{{ now()->isoFormat('dddd D [de] MMMM [de] YYYY') }}</span>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (auth()->user()->esSocio())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Membresía actual</p>
                    <p class="mt-1 text-lg font-semibold text-gray-800 break-words">
                        {{ $registros->membresia?->plan?->nombre ?? 'Sin membresía' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        @if ($registros->membresia)
                            Vence el {{ $registros->membresia->fecha_fin->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Pagos realizados</p>
                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $registros->pagosCount }}</p>
                    <p class="text-xs text-gray-400">Total: ${{ number_format($registros->pagosTotal, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Rutinas activas</p>
                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $registros->rutinasCount }}</p>
                    <p class="text-xs text-gray-400">Asignadas por tu entrenador</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Próximas clases</p>
                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $registros->clasesProximas }}</p>
                    <p class="text-xs text-gray-400">Inscripciones activas</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Mis próximas clases</h3>
                    @forelse ($proximasClases as $asistencia)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-800">{{ $asistencia->clase->nombre }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $asistencia->clase->fecha->format('d/m/Y') }} · {{ $asistencia->clase->hora->format('H:i') }} hs · {{ $asistencia->clase->entrenador->name }}
                                </p>
                            </div>
                            <form method="POST" action="{{ route('clases.cancelar', $asistencia->clase) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-600 hover:text-red-800 font-medium">Cancelar</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">No tenés clases próximas. <a href="{{ route('clases.index') }}" class="text-indigo-600 hover:underline">Ver clases</a></p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Últimos pagos</h3>
                    @forelse ($ultimosPagos as $pago)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-800">{{ $pago->concepto ?? 'Cuota de membresía' }}</p>
                                <p class="text-xs text-gray-500">{{ $pago->fecha_pago->format('d/m/Y') }} · {{ ucfirst($pago->metodo) }}</p>
                            </div>
                            <span class="text-sm font-semibold text-green-600">${{ number_format($pago->monto, 2, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Aún no hay pagos registrados.</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500 font-medium">Socios activos</p>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">{{ $registros->sociosActivos }}/{{ $registros->sociosTotales }}</span>
                    </div>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $registros->sociosActivos }}</p>
                    <p class="text-xs text-gray-400">Con membresía vigente</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Ingresos del mes</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">${{ number_format($registros->ingresosMes, 2, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">{{ $registros->pagosMes }} pagos registrados</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Membresías vencidas</p>
                    <p class="mt-2 text-2xl font-bold text-red-600">{{ $registros->morososCount }}</p>
                    <p class="text-xs text-gray-400">Requieren renovación</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <p class="text-sm text-gray-500 font-medium">Actividad</p>
                    <p class="mt-2 text-2xl font-bold text-gray-800">{{ $registros->clasesHoy }}</p>
                    <p class="text-xs text-gray-400">Clases hoy · {{ $registros->rutinasActivas }} rutinas activas</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Ingresos últimos 6 meses</h3>
                    <canvas id="graficoIngresos" data-labels='@json(array_keys($ingresosPorMes->toArray()))' data-values='@json(array_values($ingresosPorMes->toArray()))'></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-4">Socios por plan</h3>
                    <canvas id="graficoPlanes" data-labels='@json(array_keys($sociosPorPlan->toArray()))' data-values='@json(array_values($sociosPorPlan->toArray()))'></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-800">Membresías vencidas</h3>
                        <a href="{{ route('membresias.index') }}" class="text-xs text-indigo-600 hover:underline">Ver todas</a>
                    </div>
                    <div class="space-y-2">
                        @forelse ($morosos as $membresia)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $membresia->socio->name }}</p>
                                    <p class="text-xs text-gray-500">Vencida el {{ $membresia->fecha_fin->format('d/m/Y') }}</p>
                                </div>
                                <a href="{{ route('pagos.create', ['membresia_id' => $membresia->id]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Cobrar</a>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Sin membresías vencidas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h3 class="font-semibold text-gray-800 mb-3">Últimos pagos</h3>
                    <div class="space-y-2">
                        @forelse ($ultimosPagos as $pago)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $pago->socio->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $pago->concepto ?? 'Cuota' }} · {{ $pago->fecha_pago->format('d/m/Y') }}</p>
                                </div>
                                <span class="text-sm font-semibold text-green-600">${{ number_format($pago->monto, 2, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Sin pagos registrados.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        @if (! auth()->user()->esSocio())
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const labels1 = JSON.parse(document.getElementById('graficoIngresos').dataset.labels);
                    const values1 = JSON.parse(document.getElementById('graficoIngresos').dataset.values);

                    new Chart(document.getElementById('graficoIngresos'), {
                        type: 'bar',
                        data: {
                            labels: labels1,
                            datasets: [{ label: 'Ingresos ($)', data: values1, backgroundColor: '#6366f1', borderRadius: 6 }],
                        },
                        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } },
                    });

                    const labels2 = JSON.parse(document.getElementById('graficoPlanes').dataset.labels);
                    const values2 = JSON.parse(document.getElementById('graficoPlanes').dataset.values);

                    new Chart(document.getElementById('graficoPlanes'), {
                        type: 'doughnut',
                        data: {
                            labels: labels2,
                            datasets: [{ data: values2, backgroundColor: ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#06b6d4', '#a855f7'] }],
                        },
                        options: { responsive: true, plugins: { legend: { position: 'bottom' } } },
                    });
                });
            </script>
        @endif
    @endpush
</x-app-layout>