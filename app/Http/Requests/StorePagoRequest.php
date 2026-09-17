<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'membresia_id' => ['required', 'exists:membresias,id'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'fecha_pago' => ['required', 'date'],
            'metodo' => ['required', 'in:efectivo,tarjeta,transferencia'],
            'concepto' => ['nullable', 'string', 'max:255'],
        ];
    }
}
