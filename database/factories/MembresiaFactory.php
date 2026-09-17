<?php

namespace Database\Factories;

use App\Models\Membresia;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembresiaFactory extends Factory
{
    protected $model = Membresia::class;

    public function definition(): array
    {
        $plan = Plan::inRandomOrder()->first() ?? Plan::factory()->create();
        $inicio = fake()->dateTimeBetween('-12 months', 'now');

        return [
            'socio_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'plan_id' => $plan->id,
            'fecha_inicio' => $inicio->format('Y-m-d'),
            'fecha_fin' => (clone $inicio)->modify("+{$plan->duracion_meses} months")->format('Y-m-d'),
            'estado' => fake()->randomElement(['activa', 'activa', 'vencida']),
        ];
    }
}
