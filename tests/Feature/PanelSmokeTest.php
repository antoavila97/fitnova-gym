<?php

namespace Tests\Feature;

use App\Models\Clase;
use App\Models\Membresia;
use App\Models\Pago;
use App\Models\Plan;
use App\Models\Rutina;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function seedBasico(): void
    {
        $admin = User::factory()->admin()->create();
        $entrenador = User::factory()->entrenador()->create();
        $socio = User::factory()->socio()->create();
        $plan = Plan::factory()->create();
        $membresia = Membresia::factory()->create([
            'socio_id' => $socio->id,
            'plan_id' => $plan->id,
        ]);

        $this->admin = $admin;
        $this->entrenador = $entrenador;
        $this->socio = $socio;
        $this->plan = $plan;
        $this->membresia = $membresia;
    }

    public function test_admin_puede_ver_todas_las_secciones(): void
    {
        $this->seedBasico();
        $user = $this->admin;

        $urls = [
            route('dashboard'),
            route('socios.index'),
            route('planes.index'),
            route('membresias.index'),
            route('pagos.index'),
            route('rutinas.index'),
            route('clases.index'),
            route('reportes.index'),
        ];

        foreach ($urls as $url) {
            $this->actingAs($user)->get($url)->assertOk();
        }
    }

    public function test_entrenador_puede_ver_secciones_de_gestion(): void
    {
        $this->seedBasico();

        foreach ([
            route('dashboard'),
            route('rutinas.index'),
            route('clases.index'),
            route('reportes.index'),
        ] as $url) {
            $this->actingAs($this->entrenador)->get($url)->assertOk();
        }

        $this->actingAs($this->entrenador)->get(route('socios.index'))->assertForbidden();
    }

    public function test_socio_puede_inscribirse_y_cancelar_clase(): void
    {
        $this->seedBasico();
        $clase = Clase::factory()->create(['entrenador_id' => $this->entrenador->id]);

        $this->actingAs($this->socio)
            ->post(route('clases.reservar', $clase))
            ->assertRedirect();

        $this->assertDatabaseHas('asistencias', [
            'clase_id' => $clase->id,
            'socio_id' => $this->socio->id,
        ]);

        $this->actingAs($this->socio)
            ->delete(route('clases.cancelar', $clase))
            ->assertRedirect();

        $this->assertDatabaseMissing('asistencias', [
            'clase_id' => $clase->id,
            'socio_id' => $this->socio->id,
        ]);
    }

    public function test_admin_puede_crear_socio_y_registrar_pago(): void
    {
        $this->seedBasico();

        $this->actingAs($this->admin)
            ->post(route('socios.store'), [
                'name' => 'Nuevo Socio',
                'email' => 'nuevo@fitnova.com',
                'password' => 'secret1234',
                'password_confirmation' => 'secret1234',
            ])
            ->assertRedirect(route('socios.index'));

        $this->assertDatabaseHas('users', ['email' => 'nuevo@fitnova.com', 'role' => 'socio']);

        $this->actingAs($this->admin)
            ->post(route('pagos.store'), [
                'membresia_id' => $this->membresia->id,
                'monto' => 150.00,
                'fecha_pago' => now()->toDateString(),
                'metodo' => 'efectivo',
                'concepto' => 'Cuota de membresía',
            ])
            ->assertRedirect(route('pagos.index'));

        $this->assertDatabaseHas('pagos', ['membresia_id' => $this->membresia->id, 'monto' => '150.00']);
    }

    public function test_validacion_rechaza_datos_invalidos(): void
    {
        $this->seedBasico();

        $this->actingAs($this->admin)
            ->post(route('socios.store'), [
                'name' => '',
                'email' => 'no-es-email',
                'password' => 'corta',
            ])
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }
}