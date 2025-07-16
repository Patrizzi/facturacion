<?php

namespace App\Http\Controllers;

use App\Boleta;
use App\Boleta_m;
use App\ComprobantesPagos;
use App\ComprobantesPagosDetalle;
use App\Cuotas_credito;
use App\Facturacion;
use App\Facturacion_m;
use App\Igv;
use App\Moneda;
use App\NotaVenta;
use Exception;
use Illuminate\Http\Request;

class ReporteController extends Controller
{

    public function index(Request $request) {

        $filtroTipo = $request->get('filtro', ['todos']);
        $filtroEstado = $request->get('estado', ['todos']);

        $filtroTipo = is_array($filtroTipo) ? $filtroTipo : [$filtroTipo];
        $filtroEstado = is_array($filtroEstado) ? $filtroEstado : [$filtroEstado];

        $comprobantes = collect();

        if (in_array('todos', $filtroTipo) || in_array('facturas', $filtroTipo)) {
            $facturas = Facturacion::where('f_electronica', 1)->get();
            $comprobantes = $comprobantes->concat($facturas);
        }

        if (in_array('todos', $filtroTipo) || in_array('facturas_manuales', $filtroTipo)) {
            $facturasM = Facturacion_m::where('f_electronica', 1)->get();
            $comprobantes = $comprobantes->concat($facturasM);
        }

        if (in_array('todos', $filtroTipo) || in_array('boletas', $filtroTipo)) {
            $boletas = Boleta::where('b_electronica', 1)->get();
            $comprobantes = $comprobantes->concat($boletas);
        }

        if (in_array('todos', $filtroTipo) || in_array('boletas_manuales', $filtroTipo)) {
            $boletasM = Boleta_m::where('b_electronica', 1)->get();
            $comprobantes = $comprobantes->concat($boletasM);
        }

        if (in_array('todos', $filtroTipo) || in_array('notas_venta', $filtroTipo)) {
            $notasVentas = NotaVenta::get();
            $comprobantes = $comprobantes->concat($notasVentas);
        }

        foreach ($comprobantes as $compro) {
            $this->procesarComprobante($compro);
        }

        if (!in_array('todos', $filtroEstado)) {
            $comprobantes = $comprobantes->filter(function ($compro) use ($filtroEstado) {
                return in_array((string)$compro->estado_pago, $filtroEstado);
            });
        }

        return view('reportes.index', [
            'comprobantes' => $comprobantes
        ]);
    }

    private function procesarComprobante($compro) {
        $tipoMoneda = $this->getTipoMoneda($compro);
        $compro->cliente_nombre = $compro->cliente->nombre;
        $compro->nro_documento = $compro->cliente->numero_documento;
        $compro->estado = $this->obtenerEstadoPago($compro->estado_pago);
        $compro->forma_pago_nombre = optional($compro->forma_pago)->nombre;
        $compro->importe_total =  $tipoMoneda . number_format($this->calcularImporteTotal($compro), 2);
        $compro->subTotal = $tipoMoneda . number_format($this->getSubTotal($compro), 2);
        $compro->igv = $tipoMoneda . number_format($this->getIgv($compro), 2);


        if ($compro instanceof Facturacion) {

            $this->procesarFactura($compro);
            $this->procesarComprobantePago($compro, 'factuacion_id');

        } elseif ($compro instanceof Facturacion_m) {

            $this->procesarFacturaM($compro);
            $this->procesarComprobantePago($compro, 'factuacion_m_id');

        } elseif ($compro instanceof Boleta) {

            $this->procesarBoleta($compro);
            $this->procesarComprobantePago($compro, 'boleta_id');

        } elseif ($compro instanceof Boleta_m) {

            $this->procesarBoletaM($compro);
            $this->procesarComprobantePago($compro, 'boleta_m_id');

        } else {

            $this->procesarNotaVenta($compro);
            $this->procesarComprobantePago($compro, 'nota_venta_id');

        }
    }

    private function procesarFactura($compro) {
        $compro->codigo = 'Factura – ' . $compro->codigo_fac;
    }

    private function procesarFacturaM($compro) {
        $compro->codigo = 'Factura M. – ' . $compro->codigo_fac;
    }

    private function procesarBoleta($compro) {
        $compro->codigo = 'Boleta – ' . $compro->codigo_boleta;
    }

    private function procesarBoletaM($compro) {
        $compro->codigo = 'Boleta M. – ' . $compro->codigo_boleta;
    }

    private function procesarNotaVenta($compro) {
        $compro->codigo = 'Nota Venta – ' . $compro->cod_nota_venta;
    }

    private function obtenerEstadoPago($estadoPago) {
        $estados = [
            0 => 'Sin pago',
            1 => 'Adelantado',
            2 => 'Pagado'
        ];

        return $estados[$estadoPago] ?? 'Desconocido';
    }

    private function procesarComprobantePago($compro, $id) {
        $comprobantePago = ComprobantesPagos::where($id, $compro->id)->orderBy('id', 'desc')->first();
        $tipoMoneda = $this->getTipoMoneda($compro);

        if (!$comprobantePago) {
            $compro->bancos = 'No pagado';
            $compro->pagos = 'No pagado';
            $compro->fecha_pago = 'No pagado';
            $compro->saldo = $tipoMoneda . number_format($this->calcularImporteTotal($compro), 2);
            return;
        }

        $detalle = ComprobantesPagosDetalle::where('comprobante_pago_id', $comprobantePago->id)->orderBy('id', 'desc')->first();

        // nombre del banco
        $compro->bancos = $detalle->bancos_input ?? 'Efectivo';

        // nro  operacion
        if ($detalle && $detalle->tipo_pago === 'efectivo') {
            $compro->nro_operacion = 'En efectivo';
        } else {
            $compro->nro_operacion = $detalle->numero_input ?? 'No definido';
        }

        // pagado
        $comprobantesPagosTotal = ComprobantesPagos::where($id, $compro->id)->sum('monto_pago');
        $compro->pagos = $tipoMoneda . number_format($comprobantesPagosTotal, 2);

        // saldo(Importe total - lo que ya pagó)
        $getImporteTotal = $this->calcularImporteTotal($compro);
        $resulImporSald = $getImporteTotal - $comprobantesPagosTotal;
        $compro->saldo = $tipoMoneda . number_format($resulImporSald, 2);

        // fecha de pago
        $compro->fecha_pago = $comprobantePago->fecha_registro;

    }

    private function calcularImporteTotal($compro) {
        $igv = Igv::first();

        if ($compro instanceof Facturacion || $compro instanceof Facturacion_m) {

            $subTotal = $compro->op_gravada + $compro->op_inafecta + $compro->op_exonerada;
            $subTotalGravado = $compro->op_gravada;
            $igv_p = round($subTotalGravado, 2) * $igv->igv_total / 100;
            $importeTotal = round($subTotal, 2)+round($igv_p, 2);

            return $importeTotal;

        }

        if ($compro instanceof Boleta || $compro instanceof Boleta_m) {

            $subTotal = $compro->op_gravada + $compro->op_inafecta + $compro->op_exonerada;
            $subTotalGravado = $compro->op_gravada;
            $igv_p = round($subTotalGravado, 2) * $igv->igv_total / 100;
            $importeTotal = round($subTotal, 2)+round($igv_p, 2);

            return $importeTotal;

        }

        return 0.00;
    }

    private function getSubTotal($compro) {

        if($compro instanceof Facturacion || $compro instanceof Facturacion_m) {
            return $compro->op_gravada + $compro->op_inafecta + $compro->op_exonerada;
        }

        if($compro instanceof Boleta || $compro instanceof Boleta_m) {
            return $compro->op_gravada + $compro->op_inafecta + $compro->op_exonerada;
        }

    }

    private function getIgv($compro) {
        $igv = Igv::first();

        if($compro instanceof Facturacion || $compro instanceof Facturacion_m) {
            $subTotalGravado = $compro->op_gravada;
            $igv = round($subTotalGravado, 2) * $igv->igv_total / 100;

            return $igv;
        }

        if($compro instanceof Boleta || $compro instanceof Boleta_m) {
            $subTotalGravado = $compro->op_gravada;
            $igv = round($subTotalGravado, 2) * $igv->igv_total / 100;

            return $igv;
        }

    }

    private function getTipoMoneda($compro) {

        if ($compro instanceof Facturacion || $compro instanceof Facturacion_m || $compro instanceof Boleta || $compro instanceof Boleta_m) {
            $tipoMoneda = Moneda::where('id', $compro->moneda_id)->first();

            return $tipoMoneda->simbolo;
        }
    }
}
