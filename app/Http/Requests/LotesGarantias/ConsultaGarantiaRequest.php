<?php

declare(strict_types=1);

namespace App\Http\Requests\LotesGarantias;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaGarantiaRequest extends FormRequest
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
     * Prepara y normaliza los datos antes de ejecutar la validación.
     */
    protected function prepareForValidation(): void
    {
        // Soporte retrocompatible para alias de parámetros enviados desde la vista
        if ($this->has('serial_producto') && !$this->filled('numero_serie')) {
            $this->merge(['numero_serie' => $this->input('serial_producto')]);
        }

        if ($this->has('num_documento') && !$this->filled('numero_factura')) {
            $this->merge(['numero_factura' => $this->input('num_documento')]);
        }
    }

    /**
     * Obtiene las reglas de validación aplicables a la solicitud.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'codigo_producto' => ['nullable', 'string', 'max:50', 'required_without:numero_serie'],
            'numero_serie'    => ['nullable', 'string', 'max:50', 'required_without:codigo_producto'],
            'serial_producto' => ['nullable', 'string', 'max:50'],
            'numero_factura'  => ['nullable', 'string', 'max:50', 'required_without:guia_remision'],
            'guia_remision'   => ['nullable', 'string', 'max:50', 'required_without:numero_factura'],
            'num_documento'   => ['nullable', 'string', 'max:50'],
            'tipo_documento'  => ['nullable', 'string', 'max:30'],
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
            'codigo_producto.required_without' => 'Debe ingresar el código de producto si no especifica el número de serie.',
            'numero_serie.required_without'    => 'Debe ingresar el número de serie si no especifica el código de producto.',
            'numero_factura.required_without'  => 'Debe proporcionar al menos un comprobante válido: número de factura o guía de remisión.',
            'guia_remision.required_without'   => 'Debe proporcionar al menos un comprobante válido: guía de remisión o número de factura.',
            'codigo_producto.max'              => 'El código de producto no puede exceder los 50 caracteres.',
            'numero_serie.max'                 => 'El número de serie no puede exceder los 50 caracteres.',
            'numero_factura.max'               => 'El número de factura no puede exceder los 50 caracteres.',
            'guia_remision.max'                => 'La guía de remisión no puede exceder los 50 caracteres.',
        ];
    }
}
