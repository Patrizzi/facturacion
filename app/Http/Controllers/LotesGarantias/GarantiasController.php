<?php

declare(strict_types=1);

namespace App\Http\Controllers\LotesGarantias;

use App\Boleta_registro;
use App\Facturacion;
use App\Facturacion_registro;
use App\Http\Controllers\Controller;
use App\NotaVentaRegistro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GarantiasController extends Controller
{
    public function buscarPorComprobante(Request $request): JsonResponse
    {
        $numeroComprobante = trim((string) $request->input('numero_comprobante', ''));
        $numeroSerie = trim((string) $request->input('numero_serie', ''));

        if ($numeroComprobante === '' || $numeroSerie === '') {
            return response()->json([
                'success' => false,
                'message' => 'Debe indicar el comprobante y la serie a consultar.',
            ], 422);
        }

        $factura = Facturacion::where('codigo_fac', $numeroComprobante)->first();
        if (! $factura) {
            return response()->json([
                'success' => false,
                'message' => 'El comprobante no existe o no corresponde a una factura válida.',
            ], 404);
        }

        $registro = Facturacion_registro::query()
            ->with(['factura_ids', 'producto'])
            ->where('facturacion_id', $factura->id)
            ->where('numero_serie', $numeroSerie)
            ->first();

        if (! $registro) {
            $registro = Boleta_registro::query()
                ->with(['boleta_i', 'producto'])
                ->where('boleta_id', $factura->id)
                ->where('numero_serie', $numeroSerie)
                ->first();
        }

        if (! $registro) {
            $registro = NotaVentaRegistro::query()
                ->where('numero_serie', $numeroSerie)
                ->first();
        }

        if (! $registro) {
            return response()->json([
                'success' => false,
                'message' => 'La serie ingresada no corresponde al comprobante proporcionado.',
            ], 422);
        }

        $fechaInicio = $registro->fecha_venta ?? $factura->fecha_emision ?? $factura->created_at ?? now();
        $mesesCobertura = $registro->garantia_meses ?? $registro->producto->garantia_meses ?? 12;
        $fechaVencimiento = Carbon::parse($fechaInicio)->addMonths((int) $mesesCobertura)->endOfDay();
        $estado = Carbon::now()->lte($fechaVencimiento) ? 'VIGENTE' : 'EXPIRADA';

        return response()->json([
            'success' => true,
            'estado' => $estado,
            'fecha_vencimiento' => $fechaVencimiento->toDateString(),
            'numero_serie' => $registro->numero_serie,
            'message' => $estado === 'VIGENTE'
                ? 'La garantía está vigente para la serie consultada.'
                : 'La garantía ha expirado para la serie consultada.',
        ]);
    }
}
