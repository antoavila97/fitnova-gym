<?php

namespace Database\Seeders;

use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Ejercicio;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Rutina;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ([Asistencia::class, Ejercicio::class, Rutina::class, Clase::class, Pago::class, Membresia::class, Plan::class, User::class] as $model) {
            $model::query()->delete();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $admin = User::factory()->admin()->create([
            'name' => 'Administrador FitNova',
            'email' => 'admin@fitnova.com',
            'password' => 'password',
        ]);

        $entrenadores = collect([
            ['name' => 'Lucas Torres', 'email' => 'entrenador@fitnova.com'],
            ['name' => 'María Fernández', 'email' => 'maria@fitnova.com'],
            ['name' => 'Jorge Rivas', 'email' => 'jorge@fitnova.com'],
        ])->map(fn (array $d) => User::factory()->entrenador()->create($d));

        $planes = Plan::factory()->createMany([
            ['nombre' => 'Plan Básico', 'precio' => 120, 'duracion_meses' => 1, 'descripcion' => 'Acceso a sala de musculación y máquinas.'],
            ['nombre' => 'Plan Full', 'precio' => 220, 'duracion_meses' => 1, 'descripcion' => 'Acceso total + clases grupales y pileta.'],
            ['nombre' => 'Plan Premium', 'precio' => 350, 'duracion_meses' => 1, 'descripcion' => 'Todo lo del Plan Full + rutinas personalizadas.'],
            ['nombre' => 'Plan Trimestral', 'precio' => 600, 'duracion_meses' => 3, 'descripcion' => 'Tres meses de Plan Full con 15% de descuento.'],
            ['nombre' => 'Plan Anual', 'precio' => 2100, 'duracion_meses' => 12, 'descripcion' => 'Un año completo de Plan Premium con beneficios.'],
            ['nombre' => 'Plan Dúo', 'precio' => 400, 'duracion_meses' => 1, 'descripcion' => 'Dos personas, segunda con 50% de descuento.'],
        ]);

        $socios = collect();
        User::factory()->socio()->count(28)->create()->each(function (User $socio) use ($planes, $socios) {
            $socios->push($socio);
            $plan = $planes->random();
            $inicio = fake()->dateTimeBetween('-11 months', 'now');

            $membresia = Membresia::factory()->create([
                'socio_id' => $socio->id,
                'plan_id' => $plan->id,
                'fecha_inicio' => $inicio->format('Y-m-d'),
                'fecha_fin' => (clone $inicio)->modify("+{$plan->duracion_meses} months")->format('Y-m-d'),
                'estado' => $inicio->modify("+{$plan->duracion_meses} months")->format('Y-m-d') < now()->toDateString()
                    ? 'vencida'
                    : 'activa',
            ]);

            Pago::create([
                'membresia_id' => $membresia->id,
                'socio_id' => $socio->id,
                'monto' => $plan->precio,
                'fecha_pago' => $inicio->format('Y-m-d'),
                'metodo' => fake()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
                'concepto' => 'Cuota de membresía',
            ]);
        });

        $socioDemo = User::factory()->socio()->create([
            'name' => 'Socio Demo',
            'email' => 'socio@fitnova.com',
            'password' => 'password',
        ]);
        $membresiaDemo = Membresia::factory()->create([
            'socio_id' => $socioDemo->id,
            'plan_id' => $planes->firstWhere('nombre', 'Plan Premium')->id,
            'fecha_inicio' => now()->toDateString(),
            'fecha_fin' => now()->addMonth()->toDateString(),
            'estado' => 'activa',
        ]);
        Pago::create([
            'membresia_id' => $membresiaDemo->id,
            'socio_id' => $socioDemo->id,
            'monto' => 350,
            'fecha_pago' => now()->toDateString(),
            'metodo' => 'tarjeta',
            'concepto' => 'Cuota de membresía',
        ]);

        $todosLosSocios = $socios->push($socioDemo);

        $todasRutinas = collect();
        $todosLosSocios->take(20)->each(function (User $socio) use ($entrenadores, $todasRutinas) {
            $rutina = Rutina::factory()->create([
                'entrenador_id' => $entrenadores->random()->id,
                'socio_id' => $socio->id,
            ]);
            $todasRutinas->push($rutina);
            Ejercicio::factory()->count(fake()->numberBetween(3, 6))->create([
                'rutina_id' => $rutina->id,
            ]);
        });

        $clases = Clase::factory()->count(18)->create([
            'entrenador_id' => $entrenadores->random()->id,
        ]);

        $clases->each(function (Clase $clase) use ($todosLosSocios) {
            $todosLosSocios->random(fake()->numberBetween(2, min($clase->cupo, 12)))->each(function (User $socio) use ($clase) {
                Asistencia::factory()->create([
                    'clase_id' => $clase->id,
                    'socio_id' => $socio->id,
                    'fecha' => $clase->fecha,
                ]);
            });
        });

        $this->command?->info('Seeders listos. Usuarios demo (password: password):');
        $this->command?->info("  Admin:   admin@fitnova.com ({$admin->name})");
        $this->command?->info("  Entrenador: entrenador@fitnova.com ({$entrenadores->first()->name})");
        $this->command?->info("  Socio:   socio@fitnova.com ({$socioDemo->name})");
    }
}
