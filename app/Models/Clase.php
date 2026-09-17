<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clase extends Model
{
    use HasFactory;
    protected $fillable = [
        'entrenador_id',
        'nombre',
        'descripcion',
        'fecha',
        'hora',
        'cupo',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'hora' => 'datetime:H:i',
            'cupo' => 'integer',
        ];
    }

    public function entrenador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }

    public function inscriptos(): int
    {
        return $this->asistencias()->count();
    }

    public function tieneCupo(): bool
    {
        return $this->inscriptos() < $this->cupo;
    }
}