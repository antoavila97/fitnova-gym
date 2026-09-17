<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    protected $model = Pago::class;

    public function definition(): array
    {
        $membresia = Membresia::inRandomOrder()->first() ?? Membresia::factory()->create();
        $fecha = $membresia->fecha_inicio;

        return [
            'membresia_id' => $membresia->id,
            'socio_id' => $membresia->socio_id,
            'monto' => $membresia->plan->precio,
            'fecha_pago' => Carbon::parse($fecha)->format('Y-m-d'),
            'metodo' => fake()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'concepto' => fake()->optional()->randomElement([
                'Cuota mensual', 'Renovación de membresía', 'Pago inicial', 'Plan anual',
            ]),
        ];
    }
}