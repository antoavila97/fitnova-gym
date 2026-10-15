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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ([Asistencia::class, Ejercicio::class, Rutina::class, Clase::class, Pago::class, Membresia::class, Plan::class, User::class] as $model) {
            $model::query()->delete();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $passwordHash = Hash::make('password');

        // 1. Usuarios administrativos y de staff
        $admin = User::create([
            'name' => 'Administrador FitNova',
            'email' => 'admin@fitnova.com',
            'password' => $passwordHash,
            'role' => 'admin',
            'telefono' => '+591 70011223',
            'documento' => '71400947',
            'fecha_nacimiento' => '1985-05-15',
            'email_verified_at' => now(),
        ]);

        $entrenador = User::create([
            'name' => 'Lucas Torres',
            'email' => 'entrenador@fitnova.com',
            'password' => $passwordHash,
            'role' => 'entrenador',
            'telefono' => '+591 70022334',
            'documento' => '72500112',
            'fecha_nacimiento' => '1990-08-20',
            'email_verified_at' => now(),
        ]);

        // 2. Exactamente 5 Socios (en Bs.)
        $sociosData = [
            [
                'name' => 'Socio Demo',
                'email' => 'socio@fitnova.com',
                'telefono' => '+591 71234567',
                'documento' => '10234567',
                'fecha_nacimiento' => '1995-03-12',
            ],
            [
                'name' => 'Carlos Mendoza',
                'email' => 'carlos@fitnova.com',
                'telefono' => '+591 72345678',
                'documento' => '10234568',
                'fecha_nacimiento' => '1992-07-25',
            ],
            [
                'name' => 'Valeria Gómez',
                'email' => 'valeria@fitnova.com',
                'telefono' => '+591 73456789',
                'documento' => '10234569',
                'fecha_nacimiento' => '1998-11-04',
            ],
            [
                'name' => 'Roberto Silva',
                'email' => 'roberto@fitnova.com',
                'telefono' => '+591 74567890',
                'documento' => '10234570',
                'fecha_nacimiento' => '1988-01-30',
            ],
            [
                'name' => 'Camila Rojas',
                'email' => 'camila@fitnova.com',
                'telefono' => '+591 75678901',
                'documento' => '10234571',
                'fecha_nacimiento' => '2000-09-18',
            ],
        ];

        $socios = collect();
        foreach ($sociosData as $data) {
            $socios->push(User::create(array_merge($data, [
                'password' => $passwordHash,
                'role' => 'socio',
                'email_verified_at' => now(),
            ])));
        }

        // 3. Exactamente 5 Planes (con precios en Bolivianos - Bs.)
        $planes = collect([
            Plan::create([
                'nombre' => 'Plan Básico',
                'precio' => 150.00,
                'duracion_meses' => 1,
                'descripcion' => 'Acceso libre a sala de musculación y máquinas.',
                'activo' => true,
            ]),
            Plan::create([
                'nombre' => 'Plan Full',
                'precio' => 250.00,
                'duracion_meses' => 1,
                'descripcion' => 'Musculación, cardio y todas las clases grupales.',
                'activo' => true,
            ]),
            Plan::create([
                'nombre' => 'Plan Premium',
                'precio' => 380.00,
                'duracion_meses' => 1,
                'descripcion' => 'Acceso completo, rutinas personalizadas y asesoría nutricional.',
                'activo' => true,
            ]),
            Plan::create([
                'nombre' => 'Plan Trimestral',
                'precio' => 700.00,
                'duracion_meses' => 3,
                'descripcion' => 'Tres meses de Plan Full con tarifa preferencial.',
                'activo' => true,
            ]),
            Plan::create([
                'nombre' => 'Plan Anual',
                'precio' => 2500.00,
                'duracion_meses' => 12,
                'descripcion' => 'Pase anual VIP con todos los beneficios incluidos.',
                'activo' => true,
            ]),
        ]);

        // 4. Exactamente 5 Membresías (1 para cada socio)
        $membresias = collect([
            // Socio Demo: Plan Premium, activa
            Membresia::create([
                'socio_id' => $socios[0]->id,
                'plan_id' => $planes[2]->id, // Plan Premium
                'fecha_inicio' => now()->startOfMonth()->toDateString(),
                'fecha_fin' => now()->startOfMonth()->addMonth()->toDateString(),
                'estado' => 'activa',
            ]),
            // Carlos Mendoza: Plan Full, activa
            Membresia::create([
                'socio_id' => $socios[1]->id,
                'plan_id' => $planes[1]->id, // Plan Full
                'fecha_inicio' => now()->startOfMonth()->toDateString(),
                'fecha_fin' => now()->startOfMonth()->addMonth()->toDateString(),
                'estado' => 'activa',
            ]),
            // Valeria Gómez: Plan Básico, activa
            Membresia::create([
                'socio_id' => $socios[2]->id,
                'plan_id' => $planes[0]->id, // Plan Básico
                'fecha_inicio' => now()->subDays(5)->toDateString(),
                'fecha_fin' => now()->subDays(5)->addMonth()->toDateString(),
                'estado' => 'activa',
            ]),
            // Roberto Silva: Plan Trimestral, activa
            Membresia::create([
                'socio_id' => $socios[3]->id,
                'plan_id' => $planes[3]->id, // Plan Trimestral
                'fecha_inicio' => now()->subDays(10)->toDateString(),
                'fecha_fin' => now()->subDays(10)->addMonths(3)->toDateString(),
                'estado' => 'activa',
            ]),
            // Camila Rojas: Plan Básico, vencida (para pruebas de morosos)
            Membresia::create([
                'socio_id' => $socios[4]->id,
                'plan_id' => $planes[0]->id, // Plan Básico
                'fecha_inicio' => now()->subMonths(2)->toDateString(),
                'fecha_fin' => now()->subMonth()->toDateString(),
                'estado' => 'vencida',
            ]),
        ]);

        // 5. Exactamente 5 Pagos (1 por membresía, con montos en Bolivianos - Bs.)
        $pagosData = [
            [
                'membresia_id' => $membresias[0]->id,
                'socio_id' => $socios[0]->id,
                'monto' => 380.00,
                'fecha_pago' => now()->subDays(2)->toDateString(),
                'metodo' => 'tarjeta',
                'concepto' => 'Cuota Plan Premium',
            ],
            [
                'membresia_id' => $membresias[1]->id,
                'socio_id' => $socios[1]->id,
                'monto' => 250.00,
                'fecha_pago' => now()->subDays(3)->toDateString(),
                'metodo' => 'efectivo',
                'concepto' => 'Cuota Plan Full',
            ],
            [
                'membresia_id' => $membresias[2]->id,
                'socio_id' => $socios[2]->id,
                'monto' => 150.00,
                'fecha_pago' => now()->subDays(5)->toDateString(),
                'metodo' => 'transferencia',
                'concepto' => 'Cuota Plan Básico',
            ],
            [
                'membresia_id' => $membresias[3]->id,
                'socio_id' => $socios[3]->id,
                'monto' => 700.00,
                'fecha_pago' => now()->subDays(10)->toDateString(),
                'metodo' => 'tarjeta',
                'concepto' => 'Cuota Plan Trimestral',
            ],
            [
                'membresia_id' => $membresias[4]->id,
                'socio_id' => $socios[4]->id,
                'monto' => 150.00,
                'fecha_pago' => now()->subMonths(2)->toDateString(),
                'metodo' => 'efectivo',
                'concepto' => 'Cuota Plan Básico',
            ],
        ];

        foreach ($pagosData as $pago) {
            Pago::create($pago);
        }

        // 6. Exactamente 5 Rutinas (1 para cada socio)
        $rutinasData = [
            [
                'socio_id' => $socios[0]->id,
                'titulo' => 'Hipertrofia de Torso y Brazos',
                'descripcion' => 'Enfocada en volumen muscular para pecho, espalda y bíceps.',
                'fecha_asignacion' => now()->subDays(4)->toDateString(),
                'estado' => 'activa',
                'ejercicios' => [
                    ['nombre' => 'Press banca plano', 'series' => 4, 'repeticiones' => 10, 'peso' => 60.00, 'orden' => 1, 'descripcion' => 'Descanso 90 seg entre series'],
                    ['nombre' => 'Dominadas asistidas', 'series' => 4, 'repeticiones' => 8, 'peso' => 20.00, 'orden' => 2, 'descripcion' => 'Agarre prono amplio'],
                    ['nombre' => 'Press militar mancuernas', 'series' => 3, 'repeticiones' => 12, 'peso' => 16.00, 'orden' => 3, 'descripcion' => 'Sentado con respaldo a 90 grados'],
                    ['nombre' => 'Curl bíceps banco Scott', 'series' => 3, 'repeticiones' => 12, 'peso' => 25.00, 'orden' => 4, 'descripcion' => 'Movimiento controlado al bajar'],
                ],
            ],
            [
                'socio_id' => $socios[1]->id,
                'titulo' => 'Acondicionamiento Físico General',
                'descripcion' => 'Rutina balanceada de fuerza y resistencia cardiovascular.',
                'fecha_asignacion' => now()->subDays(3)->toDateString(),
                'estado' => 'activa',
                'ejercicios' => [
                    ['nombre' => 'Sentadillas con barra', 'series' => 4, 'repeticiones' => 12, 'peso' => 50.00, 'orden' => 1, 'descripcion' => 'Bajar a 90 grados con espalda recta'],
                    ['nombre' => 'Flexiones de pecho', 'series' => 4, 'repeticiones' => 15, 'peso' => null, 'orden' => 2, 'descripcion' => 'Cadencia controlada'],
                    ['nombre' => 'Remo con polea baja', 'series' => 3, 'repeticiones' => 12, 'peso' => 40.00, 'orden' => 3, 'descripcion' => 'Espalda erguida, codos pegados'],
                    ['nombre' => 'Plancha abdominal', 'series' => 3, 'repeticiones' => 45, 'peso' => null, 'orden' => 4, 'descripcion' => 'Contracción isométrica 45 seg'],
                ],
            ],
            [
                'socio_id' => $socios[2]->id,
                'titulo' => 'Fuerza y Tonificación Piernas/Glúteos',
                'descripcion' => 'Trabajo específico de tren inferior y estabilidad del core.',
                'fecha_asignacion' => now()->subDays(5)->toDateString(),
                'estado' => 'activa',
                'ejercicios' => [
                    ['nombre' => 'Hip Thrust con barra', 'series' => 4, 'repeticiones' => 12, 'peso' => 45.00, 'orden' => 1, 'descripcion' => 'Pausa de 1 segundo arriba'],
                    ['nombre' => 'Prensa de piernas 45°', 'series' => 4, 'repeticiones' => 15, 'peso' => 80.00, 'orden' => 2, 'descripcion' => 'Sin bloquear rodillas al extender'],
                    ['nombre' => 'Zancadas con mancuernas', 'series' => 3, 'repeticiones' => 12, 'peso' => 10.00, 'orden' => 3, 'descripcion' => '12 repeticiones por pierna'],
                    ['nombre' => 'Elevación de talones', 'series' => 4, 'repeticiones' => 20, 'peso' => 30.00, 'orden' => 4, 'descripcion' => 'Enfoque en gemelos'],
                ],
            ],
            [
                'socio_id' => $socios[3]->id,
                'titulo' => 'Pérdida de Grasa y Definición',
                'descripcion' => 'Entrenamiento en circuito metabólico con intervalos de alta intensidad.',
                'fecha_asignacion' => now()->subDays(8)->toDateString(),
                'estado' => 'activa',
                'ejercicios' => [
                    ['nombre' => 'Kettlebell Swings', 'series' => 4, 'repeticiones' => 20, 'peso' => 16.00, 'orden' => 1, 'descripcion' => 'Empuje de cadera potente'],
                    ['nombre' => 'Burpees completos', 'series' => 3, 'repeticiones' => 15, 'peso' => null, 'orden' => 2, 'descripcion' => 'Máxima intensidad'],
                    ['nombre' => 'Mountain Climbers', 'series' => 4, 'repeticiones' => 30, 'peso' => null, 'orden' => 3, 'descripcion' => 'Ritmo constante'],
                    ['nombre' => 'Salto a la cuerda', 'series' => 5, 'repeticiones' => 60, 'peso' => null, 'orden' => 4, 'descripcion' => '60 saltos por serie'],
                ],
            ],
            [
                'socio_id' => $socios[4]->id,
                'titulo' => 'Movilidad Articular y Funcional',
                'descripcion' => 'Rehabilitación postural y fortalecimiento lumbar.',
                'fecha_asignacion' => now()->subMonths(2)->toDateString(),
                'estado' => 'finalizada',
                'ejercicios' => [
                    ['nombre' => 'Cat-Cow columna', 'series' => 3, 'repeticiones' => 12, 'peso' => null, 'orden' => 1, 'descripcion' => 'Respiración coordinada'],
                    ['nombre' => 'Puente de glúteos', 'series' => 3, 'repeticiones' => 15, 'peso' => null, 'orden' => 2, 'descripcion' => 'En colchoneta'],
                    ['nombre' => 'Bird-Dog funcional', 'series' => 3, 'repeticiones' => 10, 'peso' => null, 'orden' => 3, 'descripcion' => '10 repeticiones por lado'],
                ],
            ],
        ];

        foreach ($rutinasData as $rData) {
            $ejercicios = $rData['ejercicios'];
            unset($rData['ejercicios']);

            $rutina = Rutina::create(array_merge($rData, [
                'entrenador_id' => $entrenador->id,
            ]));

            foreach ($ejercicios as $ej) {
                Ejercicio::create(array_merge($ej, [
                    'rutina_id' => $rutina->id,
                ]));
            }
        }

        // 7. Exactamente 5 Clases
        $clasesData = [
            [
                'nombre' => 'Spinning Intensivo',
                'descripcion' => 'Sesión de ciclismo indoor de alta quema calórica con intervalos.',
                'fecha' => now()->addDay()->toDateString(),
                'hora' => '08:00:00',
                'cupo' => 15,
                'asistentes' => [$socios[0]->id, $socios[1]->id, $socios[2]->id],
            ],
            [
                'nombre' => 'CrossFit Funcional',
                'descripcion' => 'Entrenamiento de fuerza y acondicionamiento con ejercicios funcionales.',
                'fecha' => now()->addDays(2)->toDateString(),
                'hora' => '18:30:00',
                'cupo' => 12,
                'asistentes' => [$socios[0]->id, $socios[3]->id],
            ],
            [
                'nombre' => 'Yoga y Flexibilidad',
                'descripcion' => 'Posturas dinámicas, respiración consciente y relajación muscular.',
                'fecha' => now()->addDays(3)->toDateString(),
                'hora' => '09:00:00',
                'cupo' => 10,
                'asistentes' => [$socios[1]->id, $socios[2]->id],
            ],
            [
                'nombre' => 'Boxeo Cardio',
                'descripcion' => 'Técnica de golpeo, desplazamientos y resistencia cardiovascular.',
                'fecha' => now()->addDays(4)->toDateString(),
                'hora' => '19:00:00',
                'cupo' => 15,
                'asistentes' => [$socios[0]->id, $socios[3]->id, $socios[4]->id],
            ],
            [
                'nombre' => 'Pilates Mat Integral',
                'descripcion' => 'Control corporal, alineación y fortalecimiento del centro.',
                'fecha' => now()->addDays(5)->toDateString(),
                'hora' => '17:00:00',
                'cupo' => 12,
                'asistentes' => [$socios[2]->id, $socios[4]->id],
            ],
        ];

        foreach ($clasesData as $cData) {
            $asistentes = $cData['asistentes'];
            unset($cData['asistentes']);

            $clase = Clase::create(array_merge($cData, [
                'entrenador_id' => $entrenador->id,
            ]));

            foreach ($asistentes as $socioId) {
                Asistencia::create([
                    'clase_id' => $clase->id,
                    'socio_id' => $socioId,
                    'fecha' => $clase->fecha,
                    'asistio' => true,
                ]);
            }
        }

        $this->command?->info('Seeders completados con éxito:');
        $this->command?->info(' - 5 Socios (+ 1 Admin + 1 Entrenador)');
        $this->command?->info(' - 5 Planes (en Bs.)');
        $this->command?->info(' - 5 Membresías');
        $this->command?->info(' - 5 Pagos (en Bs.)');
        $this->command?->info(' - 5 Rutinas con ejercicios');
        $this->command?->info(' - 5 Clases con asistencias');
    }
}
