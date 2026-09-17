<?php

namespace Database\Factories;

use App\Models\Rutina;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RutinaFactory extends Factory
{
    protected $model = Rutina::class;

    public function definition(): array
    {
        return [
            'entrenador_id' => User::where('role', 'entrenador')->inRandomOrder()->first()?->id ?? User::factory(),
            'socio_id' => User::where('role', 'socio')->inRandomOrder()->first()?->id ?? User::factory(),
            'titulo' => fake()->randomElement([
                'Rutina de fuerza', 'Rutina de hipertrofia', 'Rutina de definición',
                'Rutina full body', 'Rutina piernas', 'Rutina cardio',
            ]),
            'descripcion' => fake()->optional()->paragraph(),
            'fecha_asignacion' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'estado' => fake()->randomElement(['activa', 'activa', 'finalizada']),
        ];
    }
}
