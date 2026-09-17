<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Socios</h2>
            <a href="{{ route('socios.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none transition">
                + Nuevo socio
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <label for="buscar" class="sr-only">Buscar socio</label>
            <div class="relative">
                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <input id="buscar" type="text" value="{{ $termino }}" placeholder="Buscar por nombre, email o documento..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="tablaSocios">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Plan activo</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($socios as $socio)
                        <tr>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $socio->name }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $socio->email }}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">{{ $socio->documento ?? '—' }}</td>
                            <td class="px-6 py-3">
                                @if ($socio->membresiaActiva)
                                    <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">{{ $socio->membresiaActiva->plan->nombre }}</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">Sin membresía</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-sm space-x-3">
                                <a href="{{ route('socios.show', $socio) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                <a href="{{ route('socios.edit', $socio) }}" class="text-gray-600 hover:text-gray-800 font-medium">Editar</a>
                                <form class="inline" method="POST" action="{{ route('socios.destroy', $socio) }}" onsubmit="return confirm('¿Eliminar a {{ addslashes($socio->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">No hay socios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($socios instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $socios->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            const entrada = document.getElementById('buscar');
            const cuerpo = document.querySelector('#tablaSocios tbody');
            let temporizador;

            entrada.addEventListener('input', function () {
                clearTimeout(temporizador);
                temporizador = setTimeout(async () => {
                    const q = entrada.value.trim();
                    const url = q ? `/api/socios?q=${encodeURIComponent(q)}` : null;
                    const res = await fetch(url);
                    const datos = await res.json();
                    cuerpo.innerHTML = datos.map(s => `
                        <tr>
                            <td class="px-6 py-3 text-sm font-medium text-gray-800">${s.name}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">${s.email}</td>
                            <td class="px-6 py-3 text-sm text-gray-600">${s.documento ?? '—'}</td>
                            <td class="px-6 py-3">
                                ${s.plan_activo
                                    ? `<span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">${s.plan_activo}</span>`
                                    : `<span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">Sin membresía</span>`}
                            </td>
                            <td class="px-6 py-3 text-sm space-x-3">
                                <a href="/socios/${s.id}" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                <a href="/socios/${s.id}/edit" class="text-gray-600 hover:text-gray-800 font-medium">Editar</a>
                            </td>
                        </tr>
                    `).join('') || `<tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Sin resultados para "${q}"</td></tr>`;
                }, 300);
            });
        </script>
    @endpush
</x-app-layout>