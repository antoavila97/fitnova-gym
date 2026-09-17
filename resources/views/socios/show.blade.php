<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $socio->name }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('socios.edit', $socio) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Editar</a>
                <a href="{{ route('membresias.create', ['socio_id' => $socio->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition">Asignar membresía</a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Datos personales</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <div><dt class="text-gray-500">Email</dt><dd class="font-medium text-gray-800">{{ $socio->email }}</dd></div>
                <div><dt class="text-gray-500">Documento</dt><dd class="font-medium text-gray-800">{{ $socio->documento ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Teléfono</dt><dd class="font-medium text-gray-800">{{ $socio->telefono ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Nacimiento</dt><dd class="font-medium text-gray-800">{{ $socio->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</dd></div>
            </dl>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-800 mb-3">Membresías</h3>
                <div class="space-y-2">
                    @forelse ($socio->membresias as $membresia)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div>
                                <p class="font-medium text-gray-800">{{ $membresia->plan->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $membresia->fecha_inicio->format('d/m/Y') }} → {{ $membresia->fecha_fin->format('d/m/Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $membresia->estado === 'activa' ? 'bg-green-100 text-green-700' : ($membresia->estado === 'vencida' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500') }}">
                                {{ ucfirst($membresia->estado) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Sin membresías registradas.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-800 mb-3">Rutinas asignadas</h3>
                <div class="space-y-2">
                    @forelse ($socio->rutinasAsignadas as $rutina)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <div>
                                <p class="font-medium text-gray-800">{{ $rutina->titulo }}</p>
                                <p class="text-xs text-gray-500">Por {{ $rutina->entrenador->name }} · {{ $rutina->fecha_asignacion->format('d/m/Y') }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $rutina->estado === 'activa' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($rutina->estado) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Sin rutinas asignadas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-3">Historial de pagos</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Concepto</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Método</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 uppercase">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($socio->pagos as $pago)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm">{{ $pago->concepto ?? '—' }}</td>
                                <td class="px-4 py-2 text-sm capitalize">{{ $pago->metodo }}</td>
                                <td class="px-4 py-2 text-sm font-medium text-green-600">${{ number_format($pago->monto, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-sm text-gray-400">Sin pagos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>