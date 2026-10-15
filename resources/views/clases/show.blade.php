<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $clase->nombre }} — Asistentes</h2>
            <a href="{{ route('clases.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">Volver</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                <div><dt class="text-gray-500">Fecha</dt><dd class="font-medium text-gray-800">{{ $clase->fecha->format('d/m/Y') }} · {{ $clase->hora->format('H:i') }} hs</dd></div>
                <div><dt class="text-gray-500">Entrenador</dt><dd class="font-medium text-gray-800">{{ $clase->entrenador->name }}</dd></div>
                <div><dt class="text-gray-500">Inscriptos</dt><dd class="font-medium text-gray-800">{{ $clase->asistencias->count() }}/{{ $clase->cupo }}</dd></div>
                <div><dt class="text-gray-500">Presentes</dt><dd class="font-medium text-gray-800">{{ $clase->asistencias->where('asistio', true)->count() }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Socio</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Asistió</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($clase->asistencias as $asistencia)
                        <tr>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $asistencia->socio->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $asistencia->socio->email }}</td>
                            <td class="px-6 py-3">
                                <form method="POST" action="{{ route('asistencias.estado', $asistencia) }}" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="asistio" value="{{ $asistencia->asistio ? 0 : 1 }}">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $asistencia->asistio ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $asistencia->asistio ? 'Presente' : 'Ausente' }}
                                    </span>
                                    @if (auth()->user()->esAdmin() || auth()->user()->esEntrenador())
                                        <button class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                            {{ $asistencia->asistio ? 'Marcar ausente' : 'Marcar presente' }}
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">Todavía no hay socios inscriptos en esta clase.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>