<?php

namespace App\Http\Controllers;

use App\ComprobantesPagos;
use Exception;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index() {
        $comprobantes = ComprobantesPagos::orderBy('created_at', 'desc')->get();
        $comprobantesAgrupados = $this->agruparComprobantesPorDocumento($comprobantes);

        return view('reportes.index', [
            'comprobantes' => $comprobantesAgrupados
        ]);
    }

    private function agruparComprobantesPorDocumento($comprobantes) {
        $agrupados = [];

        foreach ($comprobantes as $comprobante) {
            $key = $this->obtenerClaveAgrupacion($comprobante);

            if (!isset($agrupados[$key])) {
                $agrupados[$key] = $comprobante;
                $agrupados[$key]->monto_tot = $comprobante->monto_pago;
            } else {
                $agrupados[$key]->monto_tot += $comprobante->monto_pago;
            }
        }

        return collect(array_values($agrupados));
    }

    private function obtenerClaveAgrupacion($comprobante) {
        if (!is_null($comprobante->factuacion_id)) {
            return 'facturacion_id_' . $comprobante->factuacion_id;
        }

        if (!is_null($comprobante->factuacion_m_id)) {
            return 'facturacion_m_id_' . $comprobante->factuacion_m_id;
        }

        if (!is_null($comprobante->boleta_id)) {
            return 'boleta_id_' . $comprobante->boleta_id;
        }

        if (!is_null($comprobante->boleta_m_id)) {
            return 'boleta_m_id_' . $comprobante->boleta_m_id;
        }

        if (!is_null($comprobante->nota_venta_id)) {
            return 'nota_venta_id_' . $comprobante->nota_venta_id;
        }

        return 'sin_id_' . $comprobante->id;
    }
}
