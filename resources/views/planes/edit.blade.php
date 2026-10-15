<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar plan: {{ $plane->nombre }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('planes.update', $plane) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="nombre" value="Nombre" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $plane->nombre)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
            </div>

            <div>
                <x-input-label for="descripcion" value="Descripción" />
                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion', $plane->descripcion) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="precio" value="Precio (Bs.)" />
                    <x-text-input id="precio" name="precio" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('precio', $plane->precio)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                </div>
                <div>
                    <x-input-label for="duracion_meses" value="Duración (meses)" />
                    <x-text-input id="duracion_meses" name="duracion_meses" type="number" min="1" max="24" class="mt-1 block w-full" :value="old('duracion_meses', $plane->duracion_meses)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('duracion_meses')" />
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="activo" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" @checked(old('activo', $plane->activo))>
                Plan activo (disponible para asignación)
            </label>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Actualizar plan</x-primary-button>
                <a href="{{ route('planes.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>