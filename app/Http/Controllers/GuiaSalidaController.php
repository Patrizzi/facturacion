<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use App\Personal;
use Illuminate\Support\Facades\DB;


class GuiaSalidaController extends Controller{

    public function index(){
        $id = 35;

        // Buscar cliente
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return redirect()->back()->with('error', 'Cliente no encontrado.');
        }

        // Obtener ingresos de garantía del cliente
        $datos_ingreso = GarantiaGuiaIngreso::where('cliente_id', $id)->get();

        if ($datos_ingreso->isNotEmpty()) {
            $personalIds = $datos_ingreso->pluck('personal_lab_id')->filter();
            $ingresoIds = $datos_ingreso->pluck('id')->filter();

            $personal = $personalIds->isNotEmpty()
                ? Personal::whereIn('id', $personalIds)->get()
                : collect();

            $datos_salida = $ingresoIds->isNotEmpty()
                ? GarantiaGuiaEgreso::whereIn('garantia_ingreso_id', $ingresoIds)->get()
                : collect();
        } else {
            $personal = collect();
            $datos_salida = collect();
        }

        // Obtener registros con relaciones corregidas
        $registros = GarantiaGuiaEgreso::with([
            'garantia_ingreso_i:id,cliente_id,personal_lab_id,motivo,fecha,orden_servicio,estado,egresado,nombre_equipo,numero_serie,codigo_interno,created_at,updated_at',
            'garantia_ingreso_i.clientes_i:id,nombre,direccion,email,telefono,celular,empresa,numero_documento',
            'personal_laborales:id,nombres'
        ])
        ->whereHas('garantia_ingreso_i', function ($query) use ($id) {
            $query->where('cliente_id', $id);
        })
        ->get();

        // Verificar si hay registros
        if ($registros->isEmpty()) {
            return redirect()->back()->with('warning', 'No se encontraron registros de garantía para este cliente.');
        }

        return view('servicio.guiasalida', compact('registros', 'cliente', 'datos_ingreso', 'datos_salida', 'personal'));
    }


    // public function index()
    // {
    //     $id = 35;

    //     $cliente = Cliente::find($id);
    //     if (!$cliente) {
    //         return redirect()->back()->with('error', 'Cliente no encontrado.');
    //     }
    //     $datos_ingreso = GarantiaGuiaIngreso::where('cliente_id', $id)->get();

    //     if ($datos_ingreso->isNotEmpty()) {
    //         $personal = Personal::whereIn('id', $datos_ingreso->pluck('personal_lab_id'))->get();
    //         $datos_salida = GarantiaGuiaEgreso::whereIn('garantia_ingreso_id', $datos_ingreso->pluck('id'))->get();
    //     } else {
    //         $personal = collect();
    //         $datos_salida = collect();
    //     }

    //     $registros = GarantiaGuiaEgreso::with([
    //         'garantia_ingreso_i:id,cliente_id,personal_lab_id,motivo,fecha,orden_servicio,estado,egresado,nombre_equipo,numero_serie,codigo_interno,created_at,updated_at',
    //         'clientes_i:id,nombre,direccion,email,telefono,celular,empresa,numero_documento',
    //         'personal_laborales:id,nombres'
    //     ])
    //     ->whereHas('garantia_ingreso_i', function ($query) use ($id) {
    //         $query->where('cliente_id', $id);
    //     })
    //     ->get();




    //     if ($registros->isEmpty()) {
    //         return redirect()->back()->with('warning', 'No se encontraron registros de garantía para este cliente.');
    //     }

    //     return view('servicio.guiasalida', compact('registros', 'cliente', 'datos_ingreso', 'datos_salida', 'personal'));
    // }

}

        // $registros = DB::table('garantia_guia_ingreso')
        //     ->leftJoin('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
        //     ->leftJoin('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')
        //     ->leftJoin('garantia_guia_egreso', 'garantia_guia_ingreso.id', '=', 'garantia_guia_egreso.garantia_ingreso_id')
        //     ->where('garantia_guia_ingreso.cliente_id', $id)
        //     ->select(
        //         'garantia_guia_ingreso.id as ingreso_id',
        //         'garantia_guia_ingreso.motivo',
        //         'garantia_guia_ingreso.fecha',
        //         'garantia_guia_ingreso.orden_servicio',
        //         'garantia_guia_ingreso.estado',
        //         'garantia_guia_ingreso.egresado',
        //         'garantia_guia_ingreso.asunto',
        //         'garantia_guia_ingreso.nombre_equipo',
        //         'garantia_guia_ingreso.numero_serie',
        //         'garantia_guia_ingreso.codigo_interno',
        //         'garantia_guia_ingreso.fecha_compra',
        //         'garantia_guia_ingreso.descripcion_problema',
        //         'garantia_guia_ingreso.revision_diagnostico',
        //         'garantia_guia_ingreso.estetica',
        //         'garantia_guia_ingreso.marca_id',
        //         'garantia_guia_ingreso.contacto_cliente_id',
        //         'garantia_guia_ingreso.created_at as ingreso_creado',
        //         'garantia_guia_ingreso.updated_at as ingreso_actualizado',

        //         'garantia_guia_egreso.id as egreso_id',
        //         'garantia_guia_egreso.fecha as egreso_fecha',
        //         'garantia_guia_egreso.orden_servicio as egreso_orden',
        //         'garantia_guia_egreso.estado as egreso_estado',
        //         'garantia_guia_egreso.egresado as egreso_egresado',
        //         'garantia_guia_egreso.informe_tecnico',
        //         'garantia_guia_egreso.descripcion_problema as egreso_problema',
        //         'garantia_guia_egreso.diagnostico_solucion',
        //         'garantia_guia_egreso.recomendaciones',
        //         'garantia_guia_egreso.created_at as egreso_creado',
        //         'garantia_guia_egreso.updated_at as egreso_actualizado',

        //         'clientes.id as cliente_id',
        //         'clientes.nombre as cliente_nombre',
        //         'clientes.direccion as cliente_direccion',
        //         'clientes.email as cliente_email',
        //         'clientes.telefono as cliente_telefono',
        //         'clientes.celular as cliente_celular',
        //         'clientes.empresa as cliente_empresa',
        //         'clientes.numero_documento as cliente_numero_documento',

        //         'personal.nombres as tecnico_nombre'
        //     )->get();
