<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo socio</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('socios.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" value="Nombre completo" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div>
                <x-input-label for="password" value="Contraseña" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div>
                <x-input-label for="password_confirmation" value="Confirmar contraseña" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="documento" value="Documento" />
                    <x-text-input id="documento" name="documento" type="text" class="mt-1 block w-full" :value="old('documento')" />
                    <x-input-error class="mt-2" :messages="$errors->get('documento')" />
                </div>
                <div>
                    <x-input-label for="telefono" value="Teléfono" />
                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" />
                    <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
                </div>
            </div>

            <div>
                <x-input-label for="fecha_nacimiento" value="Fecha de nacimiento" />
                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento')" />
                <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Guardar socio</x-primary-button>
                <a href="{{ route('socios.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>