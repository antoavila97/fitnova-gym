<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva rutina</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('rutinas.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="socio_id" value="Socio" />
                <select id="socio_id" name="socio_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Seleccionar socio...</option>
                    @foreach ($socios as $socio)
                        <option value="{{ $socio->id }}" @selected(old('socio_id') == $socio->id)>{{ $socio->name }} — {{ $socio->email }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('socio_id')" />
            </div>

            <div>
                <x-input-label for="titulo" value="Título de la rutina" />
                <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" :value="old('titulo')" required autofocus placeholder="Ej: Rutina de hipertrofia" />
                <x-input-error class="mt-2" :messages="$errors->get('titulo')" />
            </div>

            <div>
                <x-input-label for="descripcion" value="Descripción" />
                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('descripcion') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="fecha_asignacion" value="Fecha de asignación" />
                    <x-text-input id="fecha_asignacion" name="fecha_asignacion" type="date" class="mt-1 block w-full" :value="old('fecha_asignacion', now()->toDateString())" required />
                    <x-input-error class="mt-2" :messages="$errors->get('fecha_asignacion')" />
                </div>
                <div>
                    <x-input-label for="estado" value="Estado" />
                    <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="activa" @selected(old('estado', 'activa') === 'activa')>Activa</option>
                        <option value="finalizada" @selected(old('estado') === 'finalizada')>Finalizada</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('estado')" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Crear rutina</x-primary-button>
                <a href="{{ route('rutinas.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>