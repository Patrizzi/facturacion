<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Http\Request;
use App\Transaccion;
use App\TipoTransaccion;
use App\Personal;
use App\TransaccionDetalle;
use App\IngresoEgresoTransaccion;
use App\SaldoTransaccion;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CajaChicaController extends Controller
{
    public function index() {

        $tipoTransaccion = TipoTransaccion::get();
        $saldoActual = SaldoTransaccion::latest()->first();
        $caja = Caja::latest()->first();
        $transacciones = Transaccion::where('caja_id', $caja->id);
        // return $caja;

        return view('consulta.venta.caja_chica', [
            'tipoTransaccion' => $tipoTransaccion,
            'saldoActual' => $saldoActual,
            'caja' => $caja,
            'transacciones' => $transacciones
        ]);

    }

    public function abrirCaja() {
        $semanaActual = now()->weekOfYear;
        $anioActual = now()->year;

        // Buscar si hay alguna caja abierta en cualquier semana y año
        $cajaAbierta = Caja::where('estado', 1)->first();

        if ($cajaAbierta) {
            if ($cajaAbierta->semana == $semanaActual && $cajaAbierta->anio == $anioActual) {
                // Caja abierta para la misma semana
                return redirect()->back()->with('error', 'Ya hay una caja abierta para esta semana.');
            }
        }

        // Buscar si ya existe caja para la semana actual (cerrada)
        $cajaSemanaActual = Caja::where('semana', $semanaActual)
                                ->where('anio', $anioActual)
                                ->first();

        if ($cajaSemanaActual) {
            // Si existe caja para esta semana, solo actualizar estado a abierto y fecha apertura
            $cajaSemanaActual->update([
                'estado' => 1,
                'fecha_apertura' => Carbon::now(),
                'fecha_cierre' => null,
            ]);

            return redirect()->back()->with('success', 'Caja reabierta exitosamente.');
        }

        // Si no existe caja para esta semana, crear nueva caja
        Caja::create([
            'semana' => $semanaActual,
            'anio' => $anioActual,
            'fecha_apertura' => Carbon::now(),
            'estado' => 1,
        ]);

        return redirect()->back()->with('success', 'Caja abierta exitosamente.');
    }


    public function cerrarCaja(){
        $cajaAbierta = Caja::where('estado', 1)->first();

        if (!$cajaAbierta) {
            return redirect()->back()->with('error', 'No hay ninguna caja abierta para cerrar.');
        }

        $cajaAbierta->update([
            'fecha_cierre' => Carbon::now(),
            'estado' => 0,
        ]);

        return redirect()->back()->with('success', 'Caja cerrada exitosamente.');
    }

    public function depositoStore(Request $request){

    try {
        $validated = $request->validate([
            'nombres' => 'nullable|string|max:255',
            'dni' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
            'monto' => 'required|numeric|min:0',
            'tipo_transaccion_id' => 'nullable|exists:tipo_transacciones,id',
        ]);

        // Usar transacción de base de datos para consistencia
        return DB::transaction(function () use ($validated) {
            $caja = Caja::where('estado', 1)->latest()->first();

            if (!$caja) {
                return back()->with('error', 'No hay una caja activa disponible.');
            }

            // Mejorar la generación del número de pago con lock
            $nroPagoUltimo = Transaccion::lockForUpdate()->latest()->first()->nro_pago ?? '0000';
            $nroPagoNuevo = str_pad((int)$nroPagoUltimo + 1, 4, '0', STR_PAD_LEFT);

            $transaccion = Transaccion::create([
                'nro_pago' => $nroPagoNuevo,
                'nombres' => $validated['nombres'],
                'dni' => $validated['dni'],
                'descripcion' => $validated['descripcion'],
                'observaciones' => $validated['observaciones'],
                'monto' => $validated['monto'],
                'fecha' => now()->toDateString(),
                'caja_id' => $caja->id,
                'tipo_transaccion_id' => $validated['tipo_transaccion_id'],
            ]);

            // Obtener saldo actual con lock para evitar condiciones de carrera
            $saldoActual = (float)(SaldoTransaccion::lockForUpdate()->latest()->first()->saldo_actual ?? 0);
            $nuevoSaldo = $saldoActual;

            // Verificar si es depósito y procesar
            if ($validated['tipo_transaccion_id']) {
                $tipoTransaccion = TipoTransaccion::find($validated['tipo_transaccion_id']);

                if ($tipoTransaccion && strtolower($tipoTransaccion->nombre) === 'deposito') {
                    $nuevoSaldo += $validated['monto'];

                    IngresoEgresoTransaccion::create([
                        'transaccion_id' => $transaccion->id,
                        'monto' => $validated['monto'],
                        'tipo' => 'ingreso',
                        'fecha' => now()->toDateString(),
                    ]);
                }
            }

            // Crear registro de saldo
            SaldoTransaccion::create([
                'fecha' => now()->toDateString(),
                'saldo_actual' => $nuevoSaldo,
                'transaccion_id' => $transaccion->id,
            ]);

            return back()->with('success', 'Depósito registrado correctamente.');
        });

    }  catch (Exception $e) {

        return back()->with('error', 'Ocurrió un error al registrar el depósito. Por favor, intenta de nuevo.');

    }
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
