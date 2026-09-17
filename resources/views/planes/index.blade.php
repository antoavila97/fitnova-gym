<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Planes de membresía</h2>
            <a href="{{ route('planes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                + Nuevo plan
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Duración</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Socios activos</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($planes as $plan)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800">{{ $plan->nombre }}</p>
                                <p class="text-xs text-gray-500 max-w-xs truncate">{{ $plan->descripcion }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">${{ number_format($plan->precio, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->duracion_meses }} {{ $plan->duracion_meses === 1 ? 'mes' : 'meses' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $plan->membresias_count }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $plan->activo ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $plan->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="{{ route('planes.edit', $plan) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
                                <form class="inline" method="POST" action="{{ route('planes.destroy', $plan) }}" onsubmit="return confirm('¿Eliminar el plan {{ addslashes($plan->nombre) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-400">No hay planes creados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>