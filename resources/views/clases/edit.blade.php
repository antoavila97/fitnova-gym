<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar clase: {{ $clase->nombre }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('clases.update', $clase) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="nombre" value="Nombre de la clase" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $clase->nombre)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
            </div>

            <div>
                <x-input-label for="descripcion" value="Descripción" />
                <textarea id="descripcion" name="descripcion" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $clase->descripcion) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
            </div>

            <div>
                <x-input-label for="entrenador_id" value="Entrenador a cargo" />
                <select id="entrenador_id" name="entrenador_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    @foreach ($entrenadores as $entrenador)
                        <option value="{{ $entrenador->id }}" @selected(old('entrenador_id', $clase->entrenador_id) == $entrenador->id)>{{ $entrenador->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('entrenador_id')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <x-input-label for="fecha" value="Fecha" />
                    <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full" :value="old('fecha', $clase->fecha->format('Y-m-d'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                </div>
                <div>
                    <x-input-label for="hora" value="Hora" />
                    <x-text-input id="hora" name="hora" type="time" class="mt-1 block w-full" :value="old('hora', $clase->hora->format('H:i'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('hora')" />
                </div>
                <div>
                    <x-input-label for="cupo" value="Cupo máximo" />
                    <x-text-input id="cupo" name="cupo" type="number" min="1" max="200" class="mt-1 block w-full" :value="old('cupo', $clase->cupo)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('cupo')" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Actualizar clase</x-primary-button>
                <a href="{{ route('clases.show', $clase) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>