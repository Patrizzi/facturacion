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
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Dotenv\Exception\ValidationException;
use PDF;

class CajaChicaController extends Controller
{
    public function index() {

        $deposito = TipoTransaccion::where('nombre', 'Depósito')->first();
        $tipoTransacciones = TipoTransaccion::whereIn('nombre', ['Personal', 'Caja'])->get();
        $saldoActual = SaldoTransaccion::latest()->first();
        $caja = Caja::latest()->first();
        $personales = Personal::get();
        $transacciones = collect();

        $ingresos = IngresoEgresoTransaccion::where('tipo', 'ingreso')->get();
        $egresos = IngresoEgresoTransaccion::where('tipo', 'egreso')->get();

        if ($caja) {
            $transacciones = Transaccion::with(['tipoTransaccion', 'transaccionDetalle'])->where('caja_id', $caja->id)->latest()->get();
        }
        // return $caja;

        return view('consulta.tesoreria.caja_chica', [
            'deposito' => $deposito,
            'tipoTransacciones' => $tipoTransacciones,
            'saldoActual' => $saldoActual,
            'caja' => $caja,
            'transacciones' => $transacciones,
            'personales' => $personales,
            'ingresos' => $ingresos,
            'egresos' => $egresos
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
                return redirect()->back()->with('warning', 'Ya hay una caja abierta para esta semana.');
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
                'metodo_pago' => 'required|string|in:Yape,Plin,Transferencia,Efectivo',
                'nro_operacion' => 'nullable|string|max:100',
                'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'tipo_transaccion_id' => 'required|exists:tipo_transacciones,id',
            ]);

            // Usar transacción de base de datos para consistencia
            return DB::transaction(function () use ($request, $validated) {
                $caja = Caja::where('estado', 1)->latest()->first();

                if (!$caja) {
                    return back()->with('error', 'No hay una caja activa disponible.');
                }

                // Verificar si la caja activa corresponde a la semana actual
                $fechaActual = now();
                $semanaActual = $fechaActual->week;
                $anioActual = $fechaActual->year;

                if ($caja->semana != $semanaActual || $caja->anio != $anioActual) {
                    return back()->with('warning',
                        'La caja está abierta para una semana anterior. Debe cerrarla antes de realizar transacciones.'
                    );
                }

                // Corregir la generación del número de pago
                $ultimaTransaccion = Transaccion::lockForUpdate()->latest()->first();
                $nroPagoUltimo = $ultimaTransaccion ? $ultimaTransaccion->nro_pago : '0000';
                $nroPagoNuevo = str_pad((int)$nroPagoUltimo + 1, 5, '0', STR_PAD_LEFT);

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
                // Procesar comprobante si existe
                $nombreComprobante = null;
                if ($request->hasFile('comprobante')) {
                    $archivo = $request->file('comprobante');
                    $nombreComprobante = time() . '_' . $archivo->getClientOriginalName();
                    $archivo->storeAs('comprobantes', $nombreComprobante, 'public');
                }

                $detalleData = [
                    'metodo_pago' => $validated['metodo_pago'],
                    'transaccion_id' => $transaccion->id,
                    'nro_operacion' => null,
                    'comprobante' => null
                ];

                // Solo agregar nro_operacion y comprobante si no es efectivo
                if ($validated['metodo_pago'] !== 'Efectivo') {
                    $detalleData['nro_operacion'] = $validated['nro_operacion'];
                    $detalleData['comprobante'] = $nombreComprobante;
                }

                TransaccionDetalle::create($detalleData);
                // Obtener saldo actual con lock para evitar condiciones de carrera
                $ultimoSaldo = SaldoTransaccion::lockForUpdate()->latest()->first();
                $saldoActual = $ultimoSaldo ? (float)$ultimoSaldo->saldo_actual : 0;

                // Para depósitos SIEMPRE sumamos el monto (es una recarga de dinero)
                $nuevoSaldo = $saldoActual + $validated['monto'];

                // Verificar el tipo de transacción para logging
                $tipoTransaccion = TipoTransaccion::find($validated['tipo_transaccion_id']);

                // Crear registro de ingreso (siempre para depósitos)
                IngresoEgresoTransaccion::create([
                    'transaccion_id' => $transaccion->id,
                    'monto' => $validated['monto'],
                    'tipo' => 'Ingreso',
                    'fecha' => now()->toDateString(),
                ]);

                // Crear registro de saldo con el nuevo saldo acumulado
                SaldoTransaccion::create([
                    'fecha' => now()->toDateString(),
                    'saldo_actual' => $nuevoSaldo,
                    'transaccion_id' => $transaccion->id,
                ]);

                return back()->with('success', 'Depósito registrado correctamente.');
            });

        } catch (Exception $e) {
            return back()->with('error', 'Ocurrió un error al registrar el depósito. Por favor, intenta de nuevo.');
        }
    }

    public function pagoStore(Request $request){
    try {
        // Validaciones
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'dni' => 'required|string|max:20',
            'descripcion' => 'nullable|string|max:255',
            'tipo_transaccion_id' => 'required|exists:tipo_transacciones,id',
            'metodo_pago' => 'required|string|in:Yape,Plin,Transferencia,Efectivo',
            'monto' => 'required|numeric|min:0.01',
            'nro_operacion' => 'nullable|string|max:100',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'observaciones' => 'nullable|string'
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // Verificar que hay una caja activa
            $cajaActiva = Caja::where('estado', 1)->first();
            if (!$cajaActiva) {
                return redirect()->route('caja_chica.index')->with('error', 'No hay una caja activa disponible');
            }

            // Obtener semana y año actual
            $fechaActual = now();
            $semanaActual = $fechaActual->week;
            $anioActual = $fechaActual->year;

            // Verificar si la caja activa corresponde a la semana actual
            if ($cajaActiva->semana != $semanaActual || $cajaActiva->anio != $anioActual) {
                return redirect()->back()->with('warning',
                    'Debe cerrar la caja actual antes de realizar transacciones en la semana presente.');
            }

            // Generar número de pago secuencial con lock
            $ultimaTransaccion = Transaccion::lockForUpdate()->latest()->first();
            $numeroSecuencial = $ultimaTransaccion ? (int)$ultimaTransaccion->nro_pago + 1 : 1;
            $nroPago = str_pad($numeroSecuencial, 5, '0', STR_PAD_LEFT);

            // Verificar que existe el tipo de transacción
            $tipoTransaccion = TipoTransaccion::find($validated['tipo_transaccion_id']);
            if (!$tipoTransaccion) {
                return redirect()->route('caja_chica.index')->with('error', 'Tipo de transacción no encontrado');
            }

            // Procesar comprobante si existe
            $nombreComprobante = null;
            if ($request->hasFile('comprobante')) {
                $archivo = $request->file('comprobante');
                $nombreComprobante = time() . '_' . $archivo->getClientOriginalName();
                $archivo->storeAs('comprobantes', $nombreComprobante, 'public');
            }

            // Crear transacción principal
            $transaccion = Transaccion::create([
                'nro_pago' => $nroPago,
                'nombres' => $validated['nombres'],
                'dni' => $validated['dni'],
                'descripcion' => $validated['descripcion'],
                'observaciones' => $validated['observaciones'],
                'monto' => $validated['monto'],
                'anulado' => false,
                'fecha' => now()->toDateString(),
                'caja_id' => $cajaActiva->id,
                'tipo_transaccion_id' => $validated['tipo_transaccion_id']
            ]);

            // Crear detalle de transacción
            $detalleData = [
                'metodo_pago' => $validated['metodo_pago'],
                'transaccion_id' => $transaccion->id,
                'nro_operacion' => null,
                'comprobante' => null
            ];

            // Solo agregar nro_operacion y comprobante si no es efectivo
            if ($validated['metodo_pago'] !== 'Efectivo') {
                $detalleData['nro_operacion'] = $validated['nro_operacion'];
                $detalleData['comprobante'] = $nombreComprobante;
            }

            TransaccionDetalle::create($detalleData);

            // Crear registro de egreso
            IngresoEgresoTransaccion::create([
                'transaccion_id' => $transaccion->id,
                'monto' => $validated['monto'],
                'tipo' => 'Egreso',
                'fecha' => now()->toDateString()
            ]);

            // Actualizar saldo actual con lock
            $ultimoSaldo = SaldoTransaccion::lockForUpdate()->latest()->first();
            $saldoAnterior = $ultimoSaldo ? (float)$ultimoSaldo->saldo_actual : 0;
            $nuevoSaldo = $saldoAnterior - $validated['monto'];

            // Verificar que no quede saldo negativo
            if ($nuevoSaldo < 0) {
                return redirect()->back()->with('warning', 'Saldo insuficiente. Saldo actual: S/ ' . number_format($saldoAnterior, 2));
            }

            SaldoTransaccion::create([
                'fecha' => now()->toDateString(),
                'saldo_actual' => $nuevoSaldo,
                'transaccion_id' => $transaccion->id
            ]);

            return redirect()->route('caja_chica.index')->with('success', 'Pago registrado exitosamente');
        });

    } catch (Exception $e) {
        // Eliminar archivo subido si existe
        if (isset($nombreComprobante)) {
            Storage::disk('public')->delete('comprobantes/' . $nombreComprobante);
        }

        return redirect()->route('caja_chica.index')->with('error', 'Ha ocurrido un error. Por favor, inténtelo más tarde. Si el problema persiste, comuníquese con el equipo de soporte.');
    }
}

    public function generarPdfTransaccion($id)
    {
        try {
            // Buscar la transacción con sus relaciones
            $transaccion = Transaccion::with(['tipoTransaccion', 'transaccionDetalle'])
                                    ->findOrFail($id);

            // Determinar el tipo de transacción para usar la vista correcta
            $tipoTransaccion = strtolower($transaccion->tipoTransaccion->nombre);

            if ($tipoTransaccion == 'caja' || $tipoTransaccion == 'personal') {
                // Es un PAGO
                return $this->generarPdfPago($transaccion);
            } else {
                // Es un DEPÓSITO
                return $this->generarPdfDeposito($transaccion);
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    private function generarPdfPago($transaccion)
    {
        $data = [
            'transaccion' => $transaccion,
            'fecha' => $transaccion->fecha,
            'nombres' => $transaccion->nombres,
            'dni' => $transaccion->dni,
            'descripcion' => $transaccion->descripcion,
            'metodo_pago' => $transaccion->transaccionDetalle->metodo_pago ?? '',
            'tipo_transaccion' => $transaccion->tipoTransaccion->nombre,
            'nro_operacion' => $transaccion->transaccionDetalle->nro_operacion ?? '',
            'monto' => $transaccion->monto,
            'comprobante' => $transaccion->transaccionDetalle->comprobante ?? '',
            'observaciones' => $transaccion->observaciones,
            'titulo' => 'Comprobante de Pago'
        ];

        $pdf = PDF::loadView('consulta.tesoreria.pdf-pago', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'pago_' . $transaccion->nro_pago . '_' . date('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

    private function generarPdfDeposito($transaccion)
    {
        $data = [
            'transaccion' => $transaccion,
            'fecha' => $transaccion->fecha,
            'nombres' => $transaccion->nombres,
            'dni' => $transaccion->dni,
            'descripcion' => $transaccion->descripcion,
            'metodo_pago' => $transaccion->transaccionDetalle->metodo_pago ?? '',
            'tipo_transaccion' => $transaccion->tipoTransaccion->nombre,
            'nro_operacion' => $transaccion->transaccionDetalle->nro_operacion ?? '',
            'monto' => $transaccion->monto,
            'comprobante' => $transaccion->transaccionDetalle->comprobante ?? '',
            'observaciones' => $transaccion->observaciones,
            'titulo' => 'Comprobante de Depósito'
        ];

        $pdf = PDF::loadView('consulta.tesoreria.pdf-deposito', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'deposito_' . $transaccion->nro_pago . '_' . date('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }

}
