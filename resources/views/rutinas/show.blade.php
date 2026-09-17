<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $rutina->titulo }}</h2>
            <div class="flex gap-2">
                @if (! auth()->user()->esSocio())
                    <a href="{{ route('rutinas.edit', $rutina) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">Editar</a>
                @endif
                <a href="{{ route('rutinas.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-3">Detalles</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Socio</dt>
                    <dd class="font-medium text-gray-800">{{ $rutina->socio->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Entrenador</dt>
                    <dd class="font-medium text-gray-800">{{ $rutina->entrenador->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Asignada</dt>
                    <dd class="font-medium text-gray-800">{{ $rutina->fecha_asignacion->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Estado</dt>
                    <dd><span class="px-2 py-1 text-xs rounded-full {{ $rutina->estado === 'activa' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($rutina->estado) }}</span></dd>
                </div>
            </dl>

            @if ($rutina->descripcion)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Descripción</p>
                    <p class="text-sm text-gray-700">{{ $rutina->descripcion }}</p>
                </div>
            @endif
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Ejercicios ({{ $rutina->ejercicios->count() }})</h3>

            <div class="space-y-3">
                @forelse ($rutina->ejercicios as $ejercicio)
                    <div class="flex items-center justify-between border border-gray-200 rounded-lg p-3">
                        <div>
                            <p class="font-medium text-gray-800">{{ $ejercicio->nombre }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $ejercicio->series }} series × {{ $ejercicio->repeticiones }} rep.
                                @if ($ejercicio->peso) · {{ $ejercicio->peso }} kg @endif
                            </p>
                        </div>
                        @if (! auth()->user()->esSocio())
                            <form method="POST" action="{{ route('rutinas.ejercicios.destroy', [$rutina, $ejercicio]) }}" onsubmit="return confirm('¿Eliminar ejercicio?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 text-sm font-medium">Eliminar</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Esta rutina aún no tiene ejercicios.</p>
                @endforelse
            </div>

            @if (! auth()->user()->esSocio())
                <form method="POST" action="{{ route('rutinas.ejercicios.store', $rutina) }}" class="mt-6 pt-4 border-t border-gray-100">
                    @csrf
                    <p class="text-sm font-semibold text-gray-800 mb-3">Agregar ejercicio</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="sm:col-span-2">
                            <x-input-label for="nombre" value="Nombre" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required placeholder="Ej: Press de banca" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>
                        <div>
                            <x-input-label for="series" value="Series" />
                            <x-text-input id="series" name="series" type="number" min="1" max="20" class="mt-1 block w-full" :value="old('series', 3)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('series')" />
                        </div>
                        <div>
                            <x-input-label for="repeticiones" value="Repeticiones" />
                            <x-text-input id="repeticiones" name="repeticiones" type="number" min="1" max="100" class="mt-1 block w-full" :value="old('repeticiones', 12)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('repeticiones')" />
                        </div>
                        <div>
                            <x-input-label for="peso" value="Peso (kg, opcional)" />
                            <x-text-input id="peso" name="peso" type="number" step="0.5" min="0" class="mt-1 block w-full" :value="old('peso')" />
                            <x-input-error class="mt-2" :messages="$errors->get('peso')" />
                        </div>
                        <div>
                            <x-input-label for="orden" value="Orden" />
                            <x-text-input id="orden" name="orden" type="number" min="1" class="mt-1 block w-full" :value="old('orden', $rutina->ejercicios->count() + 1)" />
                            <x-input-error class="mt-2" :messages="$errors->get('orden')" />
                        </div>
                    </div>
                    <div class="mt-3">
                        <x-primary-button>Agregar ejercicio</x-primary-button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>