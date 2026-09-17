<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rutina extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrenador_id',
        'socio_id',
        'titulo',
        'descripcion',
        'fecha_asignacion',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_asignacion' => 'date',
        ];
    }

    public function entrenador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(User::class, 'socio_id');
    }

    public function ejercicios(): HasMany
    {
        return $this->hasMany(Ejercicio::class)->orderBy('orden');
    }
}
