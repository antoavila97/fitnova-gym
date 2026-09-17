<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembresiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'socio_id' => ['required', 'exists:users,id'],
            'plan_id' => ['required', 'exists:planes,id'],
            'fecha_inicio' => ['required', 'date'],
        ];
    }
}
