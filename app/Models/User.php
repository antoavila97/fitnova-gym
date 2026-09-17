<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telefono',
        'documento',
        'fecha_nacimiento',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
        ];
    }

    public function esAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function esEntrenador(): bool
    {
        return $this->role === 'entrenador';
    }

    public function esSocio(): bool
    {
        return $this->role === 'socio';
    }

    public function membresias()
    {
        return $this->hasMany(Membresia::class, 'socio_id');
    }

    public function membresiaActiva()
    {
        return $this->hasOne(Membresia::class, 'socio_id')
            ->where('estado', 'activa')
            ->latestOfMany();
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'socio_id');
    }

    public function rutinasAsignadas()
    {
        return $this->hasMany(Rutina::class, 'socio_id');
    }

    public function rutinasComoEntrenador()
    {
        return $this->hasMany(Rutina::class, 'entrenador_id');
    }

    public function clasesImpartidas()
    {
        return $this->hasMany(Clase::class, 'entrenador_id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'socio_id');
    }
}
