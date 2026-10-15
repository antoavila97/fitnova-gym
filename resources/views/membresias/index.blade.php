<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Membresías</h2>
            @if (auth()->user()->esAdmin())
                <a href="{{ route('membresias.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                    + Asignar membresía
                </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @if (! $esSocio)<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Socio</th>@endif
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Inicio</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        @if (auth()->user()->esAdmin())<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>@endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($membresias as $membresia)
                        <tr>
                            @if (! $esSocio)
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $membresia->socio->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $membresia->socio->email }}</p>
                                </td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $membresia->plan->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $membresia->fecha_inicio->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm {{ $membresia->estaVencida() ? 'text-red-600 font-medium' : 'text-gray-600' }}">{{ $membresia->fecha_fin->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $membresia->estado === 'activa' ? 'bg-green-100 text-green-700' : ($membresia->estado === 'vencida' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500') }}">
                                    {{ ucfirst($membresia->estado) }}
                                </span>
                            </td>
                            @if (auth()->user()->esAdmin())
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('pagos.create', ['membresia_id' => $membresia->id]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Registrar pago</a>
                                    <form class="inline" method="POST" action="{{ route('membresias.destroy', $membresia) }}" onsubmit="return confirm('¿Eliminar esta membresía?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $esSocio ? 4 : (auth()->user()->esAdmin() ? 6 : 5) }}" class="px-6 py-8 text-center text-sm text-gray-400">
                                {{ $esSocio ? 'No tenés membresías registradas.' : 'No hay membresías registradas.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($membresias instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $membresias->links() }}
            </div>
        @endif
    </div>
</x-app-layout>