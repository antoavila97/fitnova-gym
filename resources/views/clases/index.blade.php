<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clases</h2>
            @if (! $esSocio)
                <a href="{{ route('clases.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                    + Nueva clase
                </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Clase</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Entrenador</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha y hora</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Cupo</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($clases as $clase)
                        @php
                            $inscriptos = $clase->asistencias_count;
                            $yaInscripto = $esSocio && $clase->asistencias->isNotEmpty();
                        @endphp
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800">{{ $clase->nombre }}</p>
                                <p class="text-xs text-gray-500 max-w-xs truncate">{{ $clase->descripcion }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $clase->entrenador->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $clase->fecha->format('d/m/Y') }} · {{ $clase->hora->format('H:i') }} hs
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $inscriptos >= $clase->cupo ? 'bg-red-100 text-red-700' : 'bg-indigo-50 text-indigo-700' }}">
                                    {{ $inscriptos }}/{{ $clase->cupo }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-3">
                                @if ($esSocio)
                                    @if ($yaInscripto)
                                        <form class="inline" method="POST" action="{{ route('clases.cancelar', $clase) }}" onsubmit="return confirm('¿Cancelar tu inscripción?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800 font-medium">Cancelar inscripción</button>
                                        </form>
                                    @elseif (! $clase->fecha->isPast() && $inscriptos < $clase->cupo)
                                        <form class="inline" method="POST" action="{{ route('clases.reservar', $clase) }}">
                                            @csrf
                                            <button class="text-indigo-600 hover:text-indigo-800 font-medium">Inscribirme</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">{{ $clase->fecha->isPast() ? 'Clase finalizada' : 'Sin cupo' }}</span>
                                    @endif
                                @else
                                    <a href="{{ route('clases.show', $clase) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Asistentes</a>
                                    <a href="{{ route('clases.edit', $clase) }}" class="text-gray-600 hover:text-gray-800 font-medium">Editar</a>
                                    <form class="inline" method="POST" action="{{ route('clases.destroy', $clase) }}" onsubmit="return confirm('¿Eliminar esta clase?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">No hay clases registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($clases instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $clases->links() }}
            </div>
        @endif
    </div>
</x-app-layout>