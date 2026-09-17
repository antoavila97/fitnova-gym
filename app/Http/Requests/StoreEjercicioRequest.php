<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEjercicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'series' => ['required', 'integer', 'between:1,20'],
            'repeticiones' => ['required', 'integer', 'between:1,100'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'orden' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
