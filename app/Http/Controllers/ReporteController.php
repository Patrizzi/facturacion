<?php

namespace App\Http\Controllers;

use App\ComprobantesPagos;
use Exception;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index() {

        $comprobantes = ComprobantesPagos::with([
            'comprobantePagoRegistro',
            'comprobantePagoDetalle',
            'facturacion.cliente',
            'facturacionM.cliente',
            'boleta.cliente',
            'boletaM.cliente',
            'notaVenta.cliente'
            ])->orderBy('created_at', 'desc')->get();

        // return $comprobantes;

        return view('reportes.index', [
            'comprobantes' => $comprobantes
        ]);
    }
}
