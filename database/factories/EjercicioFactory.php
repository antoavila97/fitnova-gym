<?php

namespace Database\Factories;

use App\Models\Ejercicio;
use App\Models\Rutina;
use Illuminate\Database\Eloquent\Factories\Factory;

class EjercicioFactory extends Factory
{
    protected $model = Ejercicio::class;

    public function definition(): array
    {
        return [
            'rutina_id' => Rutina::inRandomOrder()->first()?->id ?? Rutina::factory(),
            'nombre' => fake()->randomElement([
                'Press de banca', 'Sentadilla', 'Peso muerto', 'Dominadas', 'Press militar',
                'Curl de bíceps', 'Remo con barra', 'Zancadas', 'Plancha', 'Carrera en cinta',
            ]),
            'descripcion' => fake()->optional()->sentence(),
            'series' => fake()->numberBetween(3, 5),
            'repeticiones' => fake()->numberBetween(6, 15),
            'peso' => fake()->optional()->randomFloat(2, 5, 120),
            'orden' => fake()->numberBetween(1, 10),
        ];
    }
}
