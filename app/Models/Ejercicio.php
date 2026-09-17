<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ejercicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'rutina_id',
        'nombre',
        'descripcion',
        'series',
        'repeticiones',
        'peso',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'peso' => 'decimal:2',
            'series' => 'integer',
            'repeticiones' => 'integer',
            'orden' => 'integer',
        ];
    }

    public function rutina(): BelongsTo
    {
        return $this->belongsTo(Rutina::class);
    }
}
