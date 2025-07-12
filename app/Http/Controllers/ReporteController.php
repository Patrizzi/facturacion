<?php

namespace App\Http\Controllers;

use App\ComprobantesPagos;
use Exception;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request) {
        $filtro = $request->get('filtro', 'todos');
        $estado = $request->get('estado', []);
        $comprobantes = $this->getComprobantesFiltrados($filtro, $estado);

        return view('reportes.index', [
            'comprobantes' => $comprobantes,
            'filtro' => $filtro,
            'estado' => $estado
        ]);
    }

    private function getComprobantesFiltrados($filtro, $estado = []) {
        $query = ComprobantesPagos::with(['facturacion', 'facturacionM', 'boleta', 'boletaM', 'notaVenta'])
            ->orderBy('created_at', 'desc');

        $filtros = is_array($filtro) ? $filtro : [$filtro];

        if (!in_array('todos', $filtros)) {
            $query->where(function ($q) use ($filtros) {
                foreach ($filtros as $tipo) {
                    switch ($tipo) {
                        case 'facturas':
                            $q->orWhereNotNull('factuacion_id');
                            break;
                        case 'facturas_manuales':
                            $q->orWhereNotNull('factuacion_m_id');
                            break;
                        case 'boletas':
                            $q->orWhereNotNull('boleta_id');
                            break;
                        case 'boletas_manuales':
                            $q->orWhereNotNull('boleta_m_id');
                            break;
                        case 'notas_venta':
                            $q->orWhereNotNull('nota_venta_id');
                            break;
                    }
                }
            });
        }

        $comprobantes = $query->get();

        if (!empty($estado) && !in_array('todos', $estado)) {
            $comprobantes = $comprobantes->filter(function ($comprobante) use ($estado) {
                $estadoComprobante = $this->obtenerEstadoPago($comprobante);
                return in_array($estadoComprobante, $estado);
            });
        }

        return $this->agruparComprobantesPorDocumento($comprobantes);
    }

    private function obtenerEstadoPago($comprobante) {
        return optional($comprobante->facturacion)->estado_pago
            ?? optional($comprobante->facturacionM)->estado_pago
            ?? optional($comprobante->boleta)->estado_pago
            ?? optional($comprobante->boletaM)->estado_pago
            ?? optional($comprobante->notaVenta)->estado_pago;
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
