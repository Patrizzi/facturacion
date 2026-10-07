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

        $producto = Producto::with(['marcas_i_producto'])->where('codigo_producto', $codigoProducto)->first();

        // Buscar serie si existe con carga ansiosa de la cadena de suministro
        $serie = null;
        if (!empty($serialProducto)) {
            $serie = class_exists('\App\SerieProducto')
                ? SerieProducto::with([
                    'lote.kardexEntradaRegistro.kardex_entrada.provedor',
                    'lote.proveedor'
                ])->where('numero_serie', $serialProducto)->first()
                : null;
        }

        $fechaCompra = $serie && $serie->fecha_venta ? $serie->fecha_venta : Carbon::now()->subMonths(2)->toDateString();
        $mesesGarantia = $producto->garantia ?? 12;
        $vigencia = $this->garantiaService->calcularVigencia($fechaCompra, $mesesGarantia);

        // Trazabilidad dinámica de la cadena de suministro mediante Eloquent ORM
        $lote = $serie ? $serie->lote : ($producto ? Lote::with(['kardexEntradaRegistro.kardex_entrada.provedor', 'proveedor'])->where('producto_id', $producto->id)->latest()->first() : null);
        $kardexRegistro = $lote ? $lote->kardexEntradaRegistro : null;
        $kardexEntrada = $kardexRegistro ? ($kardexRegistro->kardex_entrada ?? $kardexRegistro->kardex_entrada_reg_id) : null;
        $proveedor = ($kardexEntrada && $kardexEntrada->provedor) ? $kardexEntrada->provedor : ($lote ? $lote->proveedor : null);

        $codProv = $proveedor ? ($proveedor->ruc ?? ('P-' . str_pad((string)$proveedor->id, 4, '0', STR_PAD_LEFT))) : ($lote && $lote->proveedor_id ? 'P-' . str_pad((string)$lote->proveedor_id, 4, '0', STR_PAD_LEFT) : 'S/P');
        $nomProv = $proveedor ? $proveedor->empresa : ($lote->proveedor_nombre ?? 'Proveedor No Registrado');
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
                'num_lote' => optional($lote)->lote ?? 'L-001',
                'cod_interno' => $producto->codigo_producto ?? '3242',
                'marca' => optional($producto->marcas_i_producto)->nombre ?? 'Marca Oficial',
                'producto' => $producto->nombre ?? 'Producto General'
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
                    'codigo' => $producto->codigo_producto ?? $codigoProducto,
                    'marca' => optional($producto->marcas_i_producto)->nombre ?? '--',
                    'producto' => $producto->nombre ?? '--',
                    'fecha_venta' => $vigencia['fecha_compra'],
                    'fecha_venc_garantia' => $vigencia['fecha_vencimiento'],
                    'estado_garantia' => $vigencia['estado']
                ]
            ]
        ]);
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

        $producto = Producto::where('codigo_producto', $codigoProducto)->first();
        $mesesGarantia = $producto->garantia ?? 12;

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
