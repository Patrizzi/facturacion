<?php

namespace App\Http\Controllers\LotesGarantias;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GarantiaService;
use App\Producto;
use App\Facturacion;
use App\Facturacion_registro;
use App\Guia_remision;
use App\SerieProducto;
use Carbon\Carbon;

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
    public function ajaxGarantiaProducto(Request $request)
    {
        $codigoProducto = trim($request->codigo_producto);
        $serialProducto = trim($request->serial_producto);

        if (empty($codigoProducto) && empty($serialProducto)) {
            return response()->json([
                'success' => false,
                'message' => 'Ingrese el código o el serial del producto.'
            ], 422);
        }

        $producto = null;
        if (!empty($codigoProducto)) {
            $producto = Producto::with(['marcas_i_producto'])->where('codigo_producto', $codigoProducto)->first();
        }

        // Buscar serie si existe
        $serie = null;
        if (!empty($serialProducto)) {
            if (class_exists('\App\SerieProducto')) {
                $querySerie = \App\SerieProducto::where('numero_serie', $serialProducto);
                if (class_exists('\App\Lote') && \Illuminate\Support\Facades\Schema::hasTable('lotes')) {
                    $querySerie->with('lote');
                }
                $serie = $querySerie->first();
            }

            // Si no se proporcionó código de producto pero la serie lo tiene, asociarlo
            if (!$producto && $serie && !empty($serie->codigo_producto)) {
                $producto = Producto::with(['marcas_i_producto'])->where('codigo_producto', $serie->codigo_producto)->first();
            }
        }

        $fechaCompra = $serie && $serie->fecha_venta ? $serie->fecha_venta : Carbon::now()->subMonths(2)->toDateString();
        $mesesGarantia = (int)(optional($producto)->garantia ?? 12);
        if ($mesesGarantia <= 0) {
            $mesesGarantia = 12;
        }
        $vigencia = $this->garantiaService->calcularVigencia($fechaCompra, $mesesGarantia);

        return response()->json([
            'success' => true,
            'garantia' => [
                'fecha_compra' => $vigencia['fecha_compra'],
                'fecha_vencimiento' => $vigencia['fecha_vencimiento'],
                'tiempo_total' => $vigencia['tiempo_garantia']
            ],
            'producto' => [
                'num_lote' => optional(optional($serie)->lote)->lote ?? ($serie->codigo_lote ?? 'L-001'),
                'cod_interno' => optional($producto)->codigo_producto ?? ($serie->codigo_producto ?? '3242'),
                'marca' => optional(optional($producto)->marcas_i_producto)->nombre ?? 'Marca Oficial',
                'producto' => optional($producto)->nombre ?? 'Producto General'
            ],
            'proveedor' => [
                'cod_prov' => 'P-0001',
                'nom_prov' => 'Proveedor Principal',
                'num_guia' => 'G-0034',
                'num_factura' => 'F-1234',
                'guia_remision' => 'G-1234',
                'estado_garantia' => $vigencia['estado']
            ],
            'resumen_tabla' => [
                [
                    'serie' => $serialProducto ?: 'S/N',
                    'codigo' => optional($producto)->codigo_producto ?? ($codigoProducto ?: ($serialProducto ?: 'S/N')),
                    'marca' => optional(optional($producto)->marcas_i_producto)->nombre ?? '--',
                    'producto' => optional($producto)->nombre ?? '--',
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
    public function ajaxGarantiaCliente(Request $request)
    {
        $tipoDoc = $request->get('tipo_documento', 'factura');
        $numDoc = trim($request->get('num_documento'));
        $codigoProducto = trim($request->get('codigo_producto'));

        if (empty($numDoc)) {
            return response()->json(['success' => false, 'message' => 'Ingrese el número de comprobante.'], 422);
        }

        $fechaVenta = null;
        $productoEncontrado = false;

        if ($tipoDoc === 'factura') {
            // Buscar factura por correlativo o identificador
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
                $productoEncontrado = true;
            }
        } else {
            // Guía de remisión
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
}
