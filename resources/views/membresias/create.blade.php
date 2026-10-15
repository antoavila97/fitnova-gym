<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Asignar membresía</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('membresias.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="socio_id" value="Socio" />
                <select id="socio_id" name="socio_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Seleccionar socio...</option>
                    @foreach ($socios as $socio)
                        <option value="{{ $socio->id }}" @selected(old('socio_id', $socioSeleccionado ?? '') == $socio->id)>{{ $socio->name }} — {{ $socio->email }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('socio_id')" />
            </div>

            <div>
                <x-input-label for="plan_id" value="Plan" />
                <select id="plan_id" name="plan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Seleccionar plan...</option>
                    @foreach ($planes as $plan)
                        <option value="{{ $plan->id }}" @selected(old('plan_id') == $plan->id)>
                            {{ $plan->nombre }} — Bs. {{ number_format($plan->precio, 2, ',', '.') }} ({{ $plan->duracion_meses }} mes{{ $plan->duracion_meses === 1 ? '' : 'es' }})
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('plan_id')" />
            </div>

            <div>
                <x-input-label for="fecha_inicio" value="Fecha de inicio" />
                <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio', now()->toDateString())" required />
                <x-input-error class="mt-2" :messages="$errors->get('fecha_inicio')" />
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Asignar membresía</x-primary-button>
                <a href="{{ route('membresias.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>