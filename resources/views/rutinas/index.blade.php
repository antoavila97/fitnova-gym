<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rutinas</h2>
            @if (! $esSocio)
                <a href="{{ route('rutinas.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                    + Nueva rutina
                </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                        @if (! $esSocio)<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Socio</th>@endif
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Entrenador</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ejercicios</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($rutinas as $rutina)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $rutina->titulo }}</td>
                            @if (! $esSocio)
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $rutina->socio->name }}</td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $rutina->entrenador->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700">{{ $rutina->ejercicios_count ?? $rutina->ejercicios->count() }} ejercicios</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $rutina->estado === 'activa' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($rutina->estado) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                <a href="{{ route('rutinas.show', $rutina) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                @if (! $esSocio)
                                    <a href="{{ route('rutinas.edit', $rutina) }}" class="text-gray-600 hover:text-gray-800 font-medium">Editar</a>
                                    <form class="inline" method="POST" action="{{ route('rutinas.destroy', $rutina) }}" onsubmit="return confirm('¿Eliminar esta rutina?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $esSocio ? 5 : 6 }}" class="px-6 py-8 text-center text-sm text-gray-400">
                                {{ $esSocio ? 'Aún no tenés rutinas asignadas.' : 'No hay rutinas registradas.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($rutinas instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $rutinas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>