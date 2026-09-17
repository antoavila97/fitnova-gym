<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->randomElement([
                'Plan Básico', 'Plan Premium', 'Plan Full', 'Plan Anual', 'Plan Semanal', 'Plan Dúo',
            ]),
            'descripcion' => fake()->optional()->sentence(),
            'precio' => fake()->randomFloat(2, 100, 500),
            'duracion_meses' => fake()->randomElement([1, 1, 1, 3, 6, 12]),
            'activo' => true,
        ];
    }
}