<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Familia;
use App\Garantia;
use App\Marca;
use App\Subfamilia;
use App\Categoria;
use App\Motivo;
use App\Servicios;
use App\TipoCambio;
use App\Unidad_medida;
use App\Validez;
class ApiController extends Controller
{
    public function getProductos()
    {
        $producto = DB::table('productos')
            ->select(
                '*',
                'productos.id as prod_id',
                'productos.nombre as prod_nomnre',
                'marcas.nombre as nombre_marca',
                'familias.descripcion as familia_desc',
                'tipo_afectacion.informacion as afectacion_info',
                'estado.nombre as estado_nom'
            )
            ->join('familias', 'productos.familia_id', '=', 'familias.id')
            ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
            ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
            ->join('estado', 'productos.estado_id', '=', 'estado.id')
            ->get();
        return DataTables($producto)->toJson();
    }

    public function getGarantiaIngreso()
    {
        $garantia_ingreso_q = DB::table('garantia_guia_ingreso')
            ->select('*', 'garantia_guia_ingreso.id as gar_ing_id', 'garantia_guia_ingreso.created_at as gar_ing_ct_at', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_ingreso.estado as estado_ga_ing')
            ->orderby('garantia_guia_ingreso.id', 'DESC')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')

            ->get();
        return Datatables($garantia_ingreso_q)->toJson();;
    }

    public function getGarantiaIngresoGuias()
    {
        $garantia_ingreso_q = DB::table('garantia_guia_ingreso')
            ->select('*', 'garantia_guia_ingreso.id as gar_ing_id', 'garantia_guia_ingreso.created_at as gar_ing_ct_at', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_ingreso.estado as estado_ga_ing')
            ->where('garantia_guia_ingreso.estado', '!=', 0)
            ->where('garantia_guia_ingreso.egresado', 0)
            ->orderby('garantia_guia_ingreso.id', 'DESC')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')

            ->get();
        return Datatables($garantia_ingreso_q)->toJson();
    }

    public function getGarantiaEgresoGuias()
    {
        $garantia_egre_q = DB::table('garantia_guia_egreso')
            ->select('*', 'garantia_guia_egreso.id as egreso_id', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_egreso.estado as esta_egre')
            ->where('garantia_guia_egreso.estado', '!=', 0)
            ->where('garantia_guia_egreso.informe_tecnico', 0)
            ->orderby('garantia_guia_ingreso.id', 'DESC')
            ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')

            ->get();
        return Datatables($garantia_egre_q)->toJson();
    }

    public function getGarantiaEgreso()
    {
        $garantia_egre_q = DB::table('garantia_guia_egreso')
            ->select('*', 'garantia_guia_egreso.id as egreso_id', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_egreso.estado as esta_egre')
            ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')
            ->get();
        return Datatables($garantia_egre_q)->toJson();
    }

    public function getInformeTecnico()
    {
        $inform_tec = DB::table('garantia_informe_tecnico')
            ->select('*', 'garantia_informe_tecnico.id as inf_tec_id', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_informe_tecnico.estado as esta_egre')
            ->join('garantia_guia_egreso', 'garantia_informe_tecnico.garantia_egreso_id', '=', 'garantia_guia_egreso.id')
            ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')
            ->get();
        return Datatables($inform_tec)->toJson();
    }


    public function getClientes()
    {
        $cliente = Cliente::query();
        return Datatables($cliente)
            ->toJson();
    }
    //* CONFIGURACION GENERAL
    public function getFamilias(Request $request)
    {

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'codigo',
            1 => 'descripcion',
            2 => 'ubicacion',
            3  => 'subfamilia_count',
            4 => 'id',
            5 => 'estado',
        ];

        $query = Familia::orderBy('created_at', 'asc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('descripcion', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $familias = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        //$familias = Familia::get();
        foreach ($familias as $value) {
            $subfamilia_count = Subfamilia::where('id_familia', $value->id)->count();
            $json['data'][] = [
                $value->codigo,
                $value->descripcion,
                $value->ubicacion,
                $subfamilia_count,
                $value->id,
                $value->estado,
            ];
        }
        return response()->json($json);
    }

    public function getGarantias(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'descripcion',
        ];

        $query = Garantia::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('descripcion', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $garantias = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($garantias as $value) {
            $json['data'][] = [
                $value->descripcion,
                $value->estado,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function getMarcas(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'nombre',
            1 => 'abreviatura',
            2 => 'telefono',
            3 => 'descripcion',
            4 => 'imagen',
            5 => 'estado'
        ];

        $query = Marca::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('nombre', 'like', '%'. $filter . '%' );
                $q->orWhere('abreviatura', 'like', '%' . $filter . '%');
                $q->orWhere('telefono', 'like', '%' . $filter . '%');
                $q->orWhere('descripcion', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $marcas = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];


        foreach ($marcas as $value) {
            $json['data'][] = [
                $value->nombre,
                $value->abreviatura,
                $value->telefono,
                $value->descripcion,
                $value->imagen,
                $value->estado,
                $value->id,
                $value->nombre_empresa
            ];
        }
        return response()->json($json);
    }

    public function getMotivos(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'nombre',
        ];

        $query = Motivo::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('nombre', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $motivos = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];


        //$motivos = Motivo::get();
        foreach ($motivos as $value) {
            $json['data'][] = [
                $value->nombre,
                $value->updated_at,
            ];
        }
        return response()->json($json);
    }

    public function getTipoCambio(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'compra',
            1 => 'venta',
            2 => 'paralelo'
        ];

        $query = TipoCambio::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('moneda', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $tipo_cambio = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        //$tipo_cambio = TipoCambio::get();
        foreach ($tipo_cambio as $value) {
            $json['data'][] = [
                $value->compra,
                $value->venta,
                $value->paralelo,
                $value->created_at,
            ];
        }
        return response()->json($json);
    }

    public function getCategorias(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'codigo',
            1 => 'descripcion',
        ];

        $query = Categoria::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('codigo', 'like', '%'. $filter . '%' );
                $q->orWhere('descripcion', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $categoria = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($categoria as $value) {
            $json['data'][] = [
                $value->codigo,
                $value->descripcion,
                $value->estado,
                $value->id,

            ];
        }
        return response()->json($json);
    }

    public function getUnidadMedida(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'simbolo',
            1 => 'medida',
            2 => 'unidad',
        ];

        $query = Unidad_medida::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('simbolo', 'like', '%'. $filter . '%' );
                $q->where('unidad', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $unidad_medida = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];


        //$unidad_medida = Unidad_medida::get();
        foreach ($unidad_medida as $value) {
            $json['data'][] = [
                $value->simbolo,
                $value->medida,
                $value->unidad,
                //$value->created_at,
                //$value->updated_at,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function getValidez(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'descripcion',
        ];

        $query = Validez::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('descripcion', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $validez = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($validez as $value) {
            $json['data'][] = [
                $value->descripcion,
                $value->estado,
                $value->id,
            ];
        }
        return response()->json($json);
    }
    //* Servicios
    public function getServicios(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $estado = $request->get('estado_anular');
        $sortColumns = [
            0 => 'id',
            1 => 'codigo_servicio',
            2 => 'codigo_original',
            3 => 'nombre',
            4 => 'familia'
        ];

        $query = Servicios::query();
        
        if ($estado !== null) {
            $query->where('estado_anular', $estado);
        }

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('nombre', 'like', '%'. $filter . '%' );
                $q->orWhere('codigo_servicio', 'like', '%'. $filter . '%' );
                $q->orWhere('codigo_original', 'like', '%'. $filter . '%' );
            });
        }

    
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $servicios = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $servicios->transform(function ($servicio){
                $servicio->familia = $servicio->familia->descripcion;
            return $servicio;
        });

        foreach ($servicios as $value) {
            $json['data'][] = [
                $value->id,
                $value->codigo_servicio,
                $value->codigo_original,
                $value->nombre,
                $value->familia,
                $value->id,
            ];
        }
        return response()->json($json);
    }

}
