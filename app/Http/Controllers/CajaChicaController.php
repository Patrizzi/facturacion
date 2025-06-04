<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;

class CajaChicaController extends Controller
{
    public function index() {
        #pedro
    }

    public function abrirCaja() {
        #misael
    }

    public function cerrarCaja() {
        #misael
    }

    public function depositoStore(Request $request) {
        try {
            $validated = $request->validate([
                'nombres' => 'nullable|string|max:255',
                'dni' => 'nullable|string|max:255',
                'descripcion' => 'nullable|string|max:255',
                'observaciones' => 'nullable|string',
                'monto' => 'required|numeric|min:0',
                'tipo_transaccion_id' => 'nullable|exists:tipo_transacciones,id',
            ]);

            $caja = Cajas::where('estado', 1)->latest()->first();

            if (!$caja) {
                return back()->with('error', 'No hay una caja activa disponible.');
            }

            $nroPagoUltimo = Transaccion::latest()->first()?->nro_pago ?? '0000';
            $nroPagoNuevo = str_pad((int)$nroPagoUltimo + 1, 4, '0', STR_PAD_LEFT);

            $transaccion = Transaccion::create([
                'nro_pago' => $nroPagoNuevo,
                'nombres' => $validated['nombres'] ?? null,
                'dni' => $validated['dni'] ?? null,
                'descripcion' => $validated['descripcion'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'monto' => $validated['monto'],
                'fecha' => now()->toDateString(),
                'caja_id' => $caja->id,
                'tipo_transaccion_id' => $validated['tipo_transaccion_id'] ?? null,
            ]);

            $tipoTransaccion = TipoTransaccion::find($validated['tipo_transaccion_id']);
            $saldoActual = (float)(SaldoTransaccion::latest()->first()?->saldo_actual ?? 0);
            $nuevoSaldo = $saldoActual;

            if ($tipoTransaccion && strtolower($tipoTransaccion->nombre) === 'deposito') {
                $nuevoSaldo += $validated['monto'];

                IngresoEgresoTransaccion::create([
                    'transaccion_id' => $transaccion->id,
                    'monto' => $validated['monto'],
                    'tipo' => 'ingreso',
                    'fecha' => now()->toDateString(),
                ]);
            }

            SaldoTransaccion::create([
                'fecha' => now()->toDateString(),
                'saldo_actual' => $nuevoSaldo,
                'transaccion_id' => $transaccion->id,
            ]);

            return back()->with('success', 'Depósito registrado correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al registrar el depósito.');
        }
    }

    public function pagoStore() {
        #fernando
    }

    public function filtrarFecha() {
        #pedro
    }

}
