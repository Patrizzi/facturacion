<?php

declare(strict_types=1);

namespace App\Http\Controllers\LotesGarantias;

use App\Boleta_registro;
use App\Facturacion;
use App\Facturacion_registro;
use App\Guia_remision;
use App\Http\Controllers\Controller;
use App\Http\Requests\LotesGarantias\ConsultaGarantiaRequest;
use App\Lote;
use App\NotaVentaRegistro;
use App\Producto;
use App\SerieProducto;
use App\Services\GarantiaService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GarantiasController extends Controller
{
    protected $garantiaService;

    public function __construct(GarantiaService $garantiaService)
    {
        $this->garantiaService = $garantiaService;
    }

    /**
     * Endpoint para Consulta de Garantía de Producto
     */
    public function ajaxGarantiaProducto(ConsultaGarantiaRequest $request): JsonResponse
    {
        // La validación ya pasó automáticamente mediante ConsultaGarantiaRequest
        $codigoProducto = trim((string) $request->input('codigo_producto'));
        $serialProducto = trim((string) ($request->input('serial_producto') ?? $request->input('numero_serie')));

        $producto = null;
        if (!empty($codigoProducto)) {
            $producto = Producto::with(['marcas_i_producto'])->where('codigo_producto', $codigoProducto)->first();
        }

        // Buscar serie si existe con carga ansiosa de la cadena de suministro
        $serie = null;
        if (!empty($serialProducto)) {
            $serie = class_exists('\App\SerieProducto')
                ? SerieProducto::with([
                    'lote.kardexEntradaRegistro.kardex_entrada.provedor',
                    'lote.proveedor',
                    'producto',
                    'facturacionRegistro.factura_ids',
                    'boletaRegistro.boleta_i',
                    'boletaRegistroAgrupado.boleta_i',
                    'notaVentaRegistro.notaVenta',
                ])->where('numero_serie', $serialProducto)->first()
                : null;

            // Si no se proporcionó código de producto pero la serie lo tiene, asociarlo
            if (!$producto && $serie && !empty($serie->codigo_producto)) {
                $producto = Producto::with(['marcas_i_producto'])->where('codigo_producto', $serie->codigo_producto)->first();
            }
        }

        $lote = $serie ? $serie->lote : ($producto ? Lote::with(['kardexEntradaRegistro.kardex_entrada.provedor', 'proveedor'])->where('producto_id', $producto->id)->latest()->first() : null);
        $kardexRegistro = $lote ? $lote->kardexEntradaRegistro : null;
        $kardexEntrada = $kardexRegistro ? $kardexRegistro->kardex_entrada : null;
        $fechaCompra = $kardexEntrada && $kardexEntrada->fecha_compra
            ? Carbon::parse($kardexEntrada->fecha_compra)
            : null;
        $mesesGarantiaCompra = (int) (optional($kardexRegistro)->garantia_compra_meses ?? 0);
        $vencimientoCompra = $fechaCompra && $mesesGarantiaCompra > 0
            ? (clone $fechaCompra)->addMonths($mesesGarantiaCompra)
            : null;
        $factura = $serie && $serie->facturacionRegistro ? $serie->facturacionRegistro->factura_ids : null;
        $boleta = $serie && $serie->detalle_boleta ? $serie->detalle_boleta->boleta_i : null;
        $notaVenta = $serie && $serie->notaVentaRegistro ? $serie->notaVentaRegistro->notaVenta : null;
        $fechaVentaRaw = $factura
            ? ($factura->getOriginal('fecha_emision') ?: $factura->created_at)
            : ($boleta
                ? ($boleta->getOriginal('fecha_emision') ?: $boleta->created_at)
                : ($notaVenta ? ($notaVenta->getOriginal('fecha_emision') ?: $notaVenta->created_at) : null));
        $fechaVenta = $fechaVentaRaw ? Carbon::parse($fechaVentaRaw) : null;
        $garantiaVenta = optional($serie ? $serie->producto : $producto)->garantia;
        $mesesGarantiaVenta = $this->mesesGarantia($garantiaVenta);
        $vencimientoVenta = $fechaVenta && $mesesGarantiaVenta
            ? (clone $fechaVenta)->addMonths($mesesGarantiaVenta)
            : null;
        $estadoGarantiaVenta = $vencimientoVenta
            ? (Carbon::today()->lte($vencimientoVenta) ? 'Vigente' : 'Fuera de tiempo')
            : 'Sin datos';
        $vigencia = [
            'fecha_compra' => $fechaCompra ? $fechaCompra->format('Y-m-d') : '--',
            'fecha_vencimiento' => $vencimientoCompra ? $vencimientoCompra->format('Y-m-d') : '--',
            'tiempo_garantia' => $mesesGarantiaCompra > 0 ? $mesesGarantiaCompra . ' meses' : '--',
            'estado' => $estadoGarantiaVenta,
        ];

        // Trazabilidad dinámica de la cadena de suministro mediante Eloquent ORM
        $proveedor = ($kardexEntrada && $kardexEntrada->provedor) ? $kardexEntrada->provedor : ($lote ? $lote->proveedor : null);

        $codProv = $proveedor ? ($proveedor->ruc ?? ('P-' . str_pad((string)$proveedor->id, 4, '0', STR_PAD_LEFT))) : ($lote && $lote->proveedor_id ? 'P-' . str_pad((string)$lote->proveedor_id, 4, '0', STR_PAD_LEFT) : 'S/P');
        $nomProv = $proveedor ? $proveedor->empresa : ($lote ? ($lote->proveedor_nombre ?? 'Proveedor No Registrado') : 'Proveedor No Registrado');
        $numGuia = $kardexEntrada ? ($kardexEntrada->codigo_guia ?? 'S/G') : 'S/G';
        $numFactura = $kardexEntrada ? ($kardexEntrada->factura ?? 'S/F') : 'S/F';
        $guiaRemision = $kardexEntrada ? ($kardexEntrada->guia_remision ?? 'S/G') : 'S/G';

        return response()->json([
            'success' => true,
            'garantia' => [
                'fecha_compra' => $vigencia['fecha_compra'],
                'fecha_vencimiento' => $vigencia['fecha_vencimiento'],
                'tiempo_total' => $vigencia['tiempo_garantia']
            ],
            'producto' => [
                'num_lote' => optional($lote)->lote ?? optional($serie)->codigo_lote ?? '--',
                'cod_interno' => optional($producto)->codigo_producto ?? optional($serie)->codigo_producto ?? '--',
                'marca' => optional(optional($producto)->marcas_i_producto)->nombre ?? '--',
                'producto' => optional($producto)->nombre ?? '--'
            ],
            'proveedor' => [
                'cod_prov' => $codProv,
                'nom_prov' => $nomProv,
                'num_guia' => $numGuia,
                'num_factura' => $numFactura,
                'guia_remision' => $guiaRemision,
                'estado_garantia' => $vigencia['estado']
            ],
            'resumen_tabla' => [
                [
                    'serie' => $serialProducto ?: 'S/N',
                    'codigo' => optional($producto)->codigo_producto ?? ($codigoProducto ?: ($serialProducto ?: 'S/N')),
                    'marca' => optional(optional($producto)->marcas_i_producto)->nombre ?? '--',
                    'producto' => optional($producto)->nombre ?? '--',
                    'fecha_venta' => $fechaVenta ? $fechaVenta->format('Y-m-d') : '--',
                    'fecha_venc_garantia' => $vencimientoVenta ? $vencimientoVenta->format('Y-m-d') : '--',
                    'estado_garantia' => $estadoGarantiaVenta
                ]
            ]
        ]);
    }

    private function mesesGarantia($garantia): ?int
    {
        if ($garantia === null || trim((string) $garantia) === '' || preg_match('/(\d+)/', (string) $garantia, $coincidencia) !== 1) {
            return null;
        }

        $cantidad = (int) $coincidencia[1];
        $texto = mb_strtolower((string) $garantia);
        if (strpos($texto, 'año') !== false || strpos($texto, 'ano') !== false || strpos($texto, 'year') !== false) {
            $cantidad *= 12;
        } elseif (strpos($texto, 'día') !== false || strpos($texto, 'dia') !== false || strpos($texto, 'day') !== false) {
            $cantidad = (int) ceil($cantidad / 30);
        } elseif (strpos($texto, 'semana') !== false || strpos($texto, 'week') !== false) {
            $cantidad = (int) ceil($cantidad / 4);
        }

        return $cantidad > 0 ? $cantidad : null;
    }

    /**
     * Endpoint para Consulta de Garantía de Cliente (Sección Corta)
     */
    public function ajaxGarantiaCliente(Request $request): JsonResponse
    {
        $tipoDoc = $request->get('tipo_documento', 'factura');
        $numDoc = trim($request->get('num_documento'));
        $codigoProducto = trim($request->get('codigo_producto'));

        if (empty($numDoc)) {
            return response()->json(['success' => false, 'message' => 'Ingrese el número de comprobante.'], 422);
        }

        $fechaVenta = null;

        if ($tipoDoc === 'factura') {
            $factura = Facturacion::where('codigo_fac', 'LIKE', "%{$numDoc}%")
                ->orWhere('id', $numDoc)
                ->first();

            if (!$factura) {
                return response()->json(['success' => false, 'message' => 'No se encontró registro de compra con ese número de factura.'], 404);
            }

            $fechaVenta = Carbon::parse($factura->created_at)->format('Y-m-d');

            if (!empty($codigoProducto)) {
                $itemFactura = Facturacion_registro::where('facturacion_id', $factura->id)
                    ->whereHas('producto', function ($q) use ($codigoProducto) {
                        $q->where('codigo_producto', $codigoProducto);
                    })->first();

                if (!$itemFactura) {
                    return response()->json(['success' => false, 'message' => 'El código de producto no corresponde a la factura ingresada.'], 422);
                }
            }
        } elseif ($tipoDoc === 'guia') {
            $guia = Guia_remision::where('codigo_guia', 'LIKE', "%{$numDoc}%")->first();
            if (!$guia) {
                return response()->json(['success' => false, 'message' => 'No se encontró la guía de remisión especificada.'], 404);
            }
            $fechaVenta = Carbon::parse($guia->created_at)->format('Y-m-d');
        }

        $producto = !empty($codigoProducto) ? Producto::where('codigo_producto', $codigoProducto)->first() : null;
        $mesesGarantia = (int)(optional($producto)->garantia ?? 12);
        if ($mesesGarantia <= 0) {
            $mesesGarantia = 12;
        }

        $vigencia = $this->garantiaService->calcularVigencia($fechaVenta, $mesesGarantia);

        return response()->json([
            'success' => true,
            'valido' => true,
            'fecha_venta' => $fechaVenta,
            'garantia' => [
                'fecha_vencimiento' => $vigencia['fecha_vencimiento'],
                'tiempo_garantia' => $vigencia['tiempo_garantia'],
                'tiempo_transcurrido' => $vigencia['garantia_transcurrida'],
                'estado' => $vigencia['estado'],
                'es_vigente' => $vigencia['es_vigente']
            ]
        ]);
    }

    /**
     * Valida y busca el estado de garantía de una serie a partir de un comprobante emitido.
     */
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
