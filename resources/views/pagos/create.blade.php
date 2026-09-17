<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar pago</h2>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('pagos.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="membresia_id" value="Membresía / Socio" />
                <select id="membresia_id" name="membresia_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Seleccionar membresía...</option>
                    @foreach ($membresias as $membresia)
                        <option value="{{ $membresia->id }}" data-monto="{{ $membresia->plan->precio }}" @selected(old('membresia_id', $membresiaSeleccionada ?? '') == $membresia->id)>
                            {{ $membresia->socio->name }} — {{ $membresia->plan->nombre }} (${{ number_format($membresia->plan->precio, 2, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('membresia_id')" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="monto" value="Monto ($)" />
                    <x-text-input id="monto" name="monto" type="number" step="0.01" min="0.01" class="mt-1 block w-full" :value="old('monto')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('monto')" />
                </div>
                <div>
                    <x-input-label for="fecha_pago" value="Fecha de pago" />
                    <x-text-input id="fecha_pago" name="fecha_pago" type="date" class="mt-1 block w-full" :value="old('fecha_pago', now()->toDateString())" required />
                    <x-input-error class="mt-2" :messages="$errors->get('fecha_pago')" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="metodo" value="Método de pago" />
                    <select id="metodo" name="metodo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="tarjeta" @selected(old('metodo') === 'tarjeta')>Tarjeta</option>
                        <option value="transferencia" @selected(old('metodo') === 'transferencia')>Transferencia</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('metodo')" />
                </div>
                <div>
                    <x-input-label for="concepto" value="Concepto" />
                    <x-text-input id="concepto" name="concepto" type="text" class="mt-1 block w-full" :value="old('concepto', 'Cuota de membresía')" />
                    <x-input-error class="mt-2" :messages="$errors->get('concepto')" />
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <x-primary-button>Registrar pago</x-primary-button>
                <a href="{{ route('pagos.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            const selectMembresia = document.getElementById('membresia_id');
            const monto = document.getElementById('monto');

            document.addEventListener('DOMContentLoaded', () => {
                if (selectMembresia.value && !monto.value) {
                    monto.value = selectMembresia.selectedOptions[0].dataset.monto;
                }
            });

            selectMembresia.addEventListener('change', () => {
                monto.value = selectMembresia.selectedOptions[0]?.dataset.monto ?? '';
            });
        </script>
    @endpush
</x-app-layout>