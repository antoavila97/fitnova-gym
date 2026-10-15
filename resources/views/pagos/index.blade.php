<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pagos</h2>
            @if (auth()->user()->esAdmin())
                <a href="{{ route('pagos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                    + Registrar pago
                </a>
            @endif
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <p class="text-sm text-gray-500">Total recaudado (histórico):
                <span class="font-semibold text-gray-800">Bs. {{ number_format($totalIngresos, 2, ',', '.') }}</span>
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @if (! $esSocio)<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Socio</th>@endif
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Concepto</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Método</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Monto (Bs.)</th>
                        @if (auth()->user()->esAdmin())<th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>@endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($pagos as $pago)
                        <tr>
                            @if (! $esSocio)
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-800">{{ $pago->socio->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $pago->socio->email }}</p>
                                </td>
                            @endif
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $pago->membresia->plan->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pago->concepto ?? 'Cuota de membresía' }}</td>
                            <td class="px-6 py-4 text-sm capitalize text-gray-600">{{ $pago->metodo }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-600">Bs. {{ number_format($pago->monto, 2, ',', '.') }}</td>
                            @if (auth()->user()->esAdmin())
                                <td class="px-6 py-4 text-sm">
                                    <form class="inline" method="POST" action="{{ route('pagos.destroy', $pago) }}" onsubmit="return confirm('¿Eliminar este pago?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $esSocio ? 5 : (auth()->user()->esAdmin() ? 7 : 6) }}" class="px-6 py-8 text-center text-sm text-gray-400">No hay pagos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pagos instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pagos->links() }}
            </div>
        @endif
    </div>
</x-app-layout>