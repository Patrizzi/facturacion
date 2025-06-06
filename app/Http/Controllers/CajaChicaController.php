<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\Transaccion;
use App\TipoTransaccion;
use App\Personal;
use App\TransaccionDetalle;
use App\IngresoEgresoTransaccion;
use App\SaldoTransaccion;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function depositoStore() {
        #angel
    }
    public function pagostore(Request $request)
    {
        try {
            // Validaciones
            $request->validate([
                'nombres' => 'string|max:255',
                'dni' => 'string|max:20',
                'descripcion' => 'string|max:255',
                'metodo_pago' => 'required|string|in:Yape,Plin,Transferencia,Efectivo',
                'monto' => 'required|numeric|min:0.01',
                'nro_operacion' => 'nullable|string|max:100',
                'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'observaciones' => 'nullable'
            ]);

            // Verificar que hay una caja activa
            $cajaActiva = Caja::where('estado', 1)->first();
            if (!$cajaActiva) {
                return redirect()->route('caja_chica')->with('error', 'No hay una caja activa disponible');
            }

            // Generar número de pago secuencial
            $ultimaTransaccion = Transaccion::latest()->first();
            $numeroSecuencial = $ultimaTransaccion ?
                (int)$ultimaTransaccion->nro_pago + 1 : 1;
            $nroPago = str_pad($numeroSecuencial, 5, '0', STR_PAD_LEFT);

            // Verificar que existe el tipo de transacción
            $tipoTransaccion = TipoTransaccion::find($request->tipo_transaccion_id);
            if (!$tipoTransaccion) {
                return redirect()->route('caja_chica')->with('error', 'Tipo de transacción no encontrado');
            }

            // Procesar comprobante si existe
            $nombreComprobante = null;
            if ($request->hasFile('comprobante')) {
                $archivo = $request->file('comprobante');
                $nombreComprobante = time() . '_' . $archivo->getClientOriginalName();
                $archivo->storeAs('comprobantes', $nombreComprobante, 'public');
            }

            DB::beginTransaction();

            // Crear transacción principal
            $transaccion = Transaccion::create([
                'nro_pago' => $nroPago,
                'nombres' => $request->nombres,
                'dni' => $request->dni,
                'descripcion' => $request->descripcion,
                'observaciones' => $request->observaciones,
                'monto' => $request->monto,
                'anulado' => false,
                'fecha' => now()->toDateString(),
                'caja_id' => $cajaActiva->id,
                'tipo_transaccion_id' => $request->tipo_transaccion_id
            ]);

            // Crear detalle de transacción
            $detalleData = [
                'metodo_pago' => $request->metodo_pago,
                'transaccion_id' => $transaccion->id,
                'nro_operacion' => null,
                'comprobante' => null
            ];

            // Solo agregar nro_operacion y comprobante si no es efectivo
            if ($request->metodo_pago !== 'Efectivo') {
                $detalleData['nro_operacion'] = $request->nro_operacion;
                $detalleData['comprobante'] = $nombreComprobante;
            }

            TransaccionDetalle::create($detalleData);

            // Crear registro de egreso
            IngresoEgresoTransaccion::create([
                'transaccion_id' => $transaccion->id,
                'monto' => $request->monto,
                'tipo' => 'egreso',
                'fecha' => now()->toDateString()
            ]);

            // Actualizar saldo actual
            $ultimoSaldo = SaldoTransaccion::latest()->first();
            $saldoAnterior = $ultimoSaldo ? $ultimoSaldo->saldo_actual : 0;
            $nuevoSaldo = $saldoAnterior - $request->monto;

            SaldoTransaccion::create([
                'fecha' => now()->toDateString(),
                'saldo_actual' => $nuevoSaldo,
                'transaccion_id' => $transaccion->id
            ]);

            DB::commit();

            return redirect()->route('caja_chica')->with('success', 'Pago registrado exitosamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('caja_chica')->with('error', 'Error de validación: ' . implode(', ', array_flatten($e->errors())));

        } catch (Exception $e) {
            DB::rollBack();

            // Eliminar archivo subido si existe
            if (isset($nombreComprobante)) {
                Storage::disk('public')->delete('comprobantes/' . $nombreComprobante);
            }

            return redirect()->route('caja_chica')->with('error', 'Error interno del servidor: ' . $e->getMessage());
        }
    }

    public function filtrarFecha() {
        #pedro
    }

}