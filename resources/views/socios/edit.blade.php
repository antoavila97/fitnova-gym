<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar socio: {{ $socio->name }}</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('socios.update', $socio) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="name" value="Nombre completo" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $socio->name)" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $socio->email)" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="password" value="Contraseña (dejar vacío para no cambiar)" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar contraseña" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="documento" value="Documento" />
                    <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento', $socio->documento)" />
                    <x-input-error class="mt-2" :messages="$errors->get('documento')" />
                </div>
                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $socio->telefono)" />
                    <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                </div>
            </div>

            <div>
                <x-input-label for="fecha_nacimiento" value="Fecha de nacimiento" />
                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento', $socio->fecha_nacimiento?->format('Y-m-d'))" />
                <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Actualizar socio</x-primary-button>
                <a href="{{ route('socios.show', $socio) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>