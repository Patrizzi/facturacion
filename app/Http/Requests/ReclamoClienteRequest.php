<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReclamoClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_serie' => ['required', 'string', 'min:3', 'max:100', 'exists:series_productos,numero_serie'],
            'tipo_falla' => ['required', 'string', 'in:defecto de fabrica,daño físico,derrame de líquidos,manipulación no autorizada,falla eléctrica,desgaste'],
            'descripcion' => ['required', 'string', 'min:20', 'max:2000'],
            'condiciones_uso' => ['nullable', 'array'],
            'evidencias' => ['nullable', 'array', 'max:5'],
            'evidencias.*' => ['file', 'max:10240', 'mimes:jpg,jpeg,png,webp,mp4,mov', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.exists' => 'El número de serie no existe en el sistema.',
            'descripcion.required' => 'La descripción del reclamo es obligatoria.',
            'descripcion.min' => 'La descripción debe tener al menos 20 caracteres.',
            'tipo_falla.in' => 'El tipo de falla seleccionado no es válido.',
            'evidencias.max' => 'Solo se permiten hasta 5 evidencias multimedia.',
            'evidencias.*.max' => 'Cada evidencia debe pesar como máximo 10 MB.',
            'evidencias.*.mimes' => 'Los formatos permitidos son JPG, JPEG, PNG, WEBP, MP4 y MOV.',
        ];
    }
}
