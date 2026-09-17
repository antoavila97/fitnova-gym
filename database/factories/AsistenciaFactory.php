<?php

namespace Database\Factories;

use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsistenciaFactory extends Factory
{
    protected $model = Asistencia::class;

    public function definition(): array
    {
        $clase = Clase::inRandomOrder()->first() ?? Clase::factory()->create();

        return [
            'clase_id' => $clase->id,
            'socio_id' => User::where('role', 'socio')->inRandomOrder()->first()?->id ?? User::factory(),
            'fecha' => $clase->fecha,
            'asistio' => fake()->boolean(80),
        ];
    }
}
