<?php

namespace App\Http\Controllers;

use App\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CajaChicaController extends Controller
{
    public function index() {
        #pedro
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
        } else {
            // Caja abierta para otra semana distinta, se permite crear nueva caja para la semana actual
            // Pero podrías también cerrarla automáticamente aquí, si quieres
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


 public function cerrarCaja(Request $request)
{
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

    public function depositoStore() {
        #angel
    }
    public function pagoStore() {
        #fernando
    }

    public function filtrarFecha() {
        #pedro
    }

}
