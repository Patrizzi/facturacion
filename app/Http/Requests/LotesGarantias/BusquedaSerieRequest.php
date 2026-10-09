<?php

declare(strict_types=1);

namespace App\Http\Requests\LotesGarantias;

use Illuminate\Foundation\Http\FormRequest;

class BusquedaSerieRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtiene las reglas de validación aplicables a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'numero_serie'    => ['nullable', 'string', 'max:50', 'required_without:codigo_producto'],
            'codigo_producto' => ['nullable', 'string', 'max:50', 'required_without:numero_serie'],
        ];
    }

    /**
     * Obtiene los mensajes personalizados de validación en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'numero_serie.required_without'    => 'El número de serie es obligatorio si no ingresa el código de producto.',
            'codigo_producto.required_without' => 'El código de producto es obligatorio si no ingresa el número de serie.',
            'numero_serie.string'              => 'El formato del número de serie debe ser una cadena de texto.',
            'codigo_producto.string'           => 'El formato del código de producto debe ser una cadena de texto.',
            'numero_serie.max'                 => 'El número de serie no puede superar los 50 caracteres.',
            'codigo_producto.max'              => 'El código de producto no puede superar los 50 caracteres.',
        ];
    }
}
