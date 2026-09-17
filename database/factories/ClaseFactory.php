<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaseFactory extends Factory
{
    protected $model = Clase::class;

    public function definition(): array
    {
        return [
            'entrenador_id' => User::where('role', 'entrenador')->inRandomOrder()->first()?->id ?? User::factory(),
            'nombre' => fake()->randomElement([
                'CrossFit', 'Spinning', 'Yoga', 'Funcional', 'Zumba', 'Musculación guiada', 'Boxeo',
            ]),
            'descripcion' => fake()->optional()->sentence(),
            'fecha' => fake()->dateTimeBetween('-7 days', '+30 days')->format('Y-m-d'),
            'hora' => fake()->randomElement(['08:00', '10:00', '14:00', '16:00', '18:00', '20:00']) . ':00',
            'cupo' => fake()->numberBetween(8, 25),
        ];
    }
}