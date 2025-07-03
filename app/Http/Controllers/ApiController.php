<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Producto;
use App\Stock_producto;
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
use App\Alarma;
use App\AlarmasRecordatorios;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function getProductos()
    {
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
        $user = Auth::user();
        if(!$user){
            return redirect('/');
        }
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
            0 => 'nombre',
            1 => 'tipo',
        ];

        $query = Motivo::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('nombre', 'like', '%'. $filter . '%' );
                $q->orWhere('tipo', 'like', '%'. $filter . '%' );
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
                $value->tipo,
                $value->estado,
                $value->id,
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
        $date_filter = $request->get('date_filter');
        $sortColumns = [
            0 => 'compra',
            1 => 'venta',
            2 => 'paralelo',
            3 => 'fecha'
        ];

        $query = TipoCambio::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('fecha', 'like', '%'. $filter . '%' );
                $q->orWhere('compra', 'like', '%'. $filter . '%' );
                $q->orWhere('venta', 'like', '%'. $filter . '%' );
                $q->orWhere('paralelo', 'like', '%'. $filter . '%' );
            });
        }
        // return $date_filter;
        if(!empty($date_filter)){

            // Separar las fechas
            $start2 = explode(' - ', $date_filter)[0];
            $end2 = explode(' - ', $date_filter)[1];

            // return $start2. " - " . $end2;
            // Formatear las fechas correctamente (por si vienen con tiempo)
            $start3 = Carbon::createFromFormat('d/m/Y', $start2)->startOfDay();
            $end3 = Carbon::createFromFormat('d/m/Y', $end2)->startOfDay();

            // Agregar al query
            $query->whereBetween('created_at', [$start3, $end3]);
        }
        // return "sin filter date";

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $tipo_cambios = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $tipo_cambios->transform(function ($tipo_cambio){
            $tipo_cambio->fecha = Carbon::parse($tipo_cambio->fecha)->format('d-m-Y');
            return $tipo_cambio;
        });
        //$tipo_cambio = TipoCambio::get();
        foreach ($tipo_cambios as $value) {
            $json['data'][] = [
                $value->id,
                $value->compra,
                $value->venta,
                $value->paralelo,
                $value->fecha,
                $value->id
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
                $q->orWhere('medida', 'like', '%'. $filter . '%' );
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

    public function getAlarma(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'descripcion',
            1 => 'tipo',
            2 => 'alarma',

        ];

        $query = AlarmasRecordatorios::orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('descripcion', 'like', '%'. $filter . '%' );
                $q->orWhere('tipo', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $alarma = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];


        foreach ($alarma as $value) {
            $json['data'][] = [
                $value->descripcion,
                $value->tipo,
                $value->alarma,
                $value->estado,
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

    public function getProductosTable(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $estado = $request->get('estado');
        $sortColumns = [
            0 => 'id',
            1 => 'codigo_servicio',
            2 => 'codigo_original',
            3 => 'nombre',
            4 => 'familia'
        ];

        $query = Producto::query();

        // 1 -> activo | 2 -> inactivo | 3 -> anulado //* FALTA CAMBIAR ESTO EN EL FRONT
        if ($estado == 1) {
            $query->where('estado_anular', 1)->where('estado_id', 1); //Sin Anular
        } elseif ($estado == 2) {
            $query->where('estado_id', 2); // Anulado
        } elseif ($estado == 3) {
            $query->where('estado_anular', 0);
        }

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('nombre', 'like', '%'. $filter . '%' );
                $q->orWhere('codigo_producto', 'like', '%'. $filter . '%' );
                $q->orWhere('codigo_original', 'like', '%'. $filter . '%' );
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $productos = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $productos->transform(function ($product){
                $product->familia = $product->familia_i_producto->descripcion;
                $product->marca = $product->marcas_i_producto->nombre;
                $product->afectacion = $product->tipo_afec_i_producto->informacion;
            return $product;
        });

        foreach ($productos as $value) {
            $json['data'][] = [
                $value->id,
                $value->nombre,
                $value->codigo_producto,
                $value->codigo_original,
                $value->familia,
                $value->marca,
                $value->afectacion,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function getGarantiaIngresoTable(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'orden_servicio',
            3 => 'motivo',
            4 => 'asunto',
            5 => 'clientes_i.nombre',
            6 => 'marcas_i.nombre',
            7 => 'fecha',
            8 => 'id',
            9 => 'estado',
            10 => 'egresado',
        ];

        $marca = $request->marca;
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = GarantiaGuiaIngreso::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if(!empty($filter)){
            $query->where(function($q) use ($filter){
                $q->where('orden_servicio', 'like', '%'. $filter . '%' );
                $q->orWhere('motivo', 'like', '%'. $filter . '%' );
                $q->orWhereHas('clientes_i', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
                $q->orWhereHas('marcas_i', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }
        if ($marca !== null) {
            $query->where('marca_id', $marca);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $guia_ingreso = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $guia_ingreso->transform(function ($g_ingreso){
                $g_ingreso->fecha = Carbon::parse($g_ingreso->fecha)->format('d/m/Y');
            return $g_ingreso;
        });

        foreach ($guia_ingreso as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->orden_servicio,
                $value->motivo,
                $value->asunto,
                $value->clientes_i->nombre,
                $value->marcas_i->nombre,
                $value->fecha,
                $value->id,
                $value->estado,
                $value->egresado,
            ];
        }
        return response()->json($json);
    }
    public function getGarantiaEgresoTable(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'orden_servicio',
            3 => 'marcas_i.nombre',
            4 => 'fecha',
            5 => 'motivo',
            6 => 'asunto',
            7 => 'clientes_i.nombre',
            8 => 'id',
            9 => 'informe_tecnico',
        ];

        $marca = $request->marca;
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = GarantiaGuiaEgreso::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function($q) use ($filter) {
                $q->orWhereHas('garantia_ingreso_i', function($sub) use ($filter) {
                    $sub->where('orden_servicio', 'like', '%' . $filter . '%');
                    $sub->orWhere('motivo', 'like', '%' . $filter . '%');
                    $sub->orWhere('asunto', 'like', '%' . $filter . '%');
                    $sub->orWhereHas('clientes_i', function ($q2) use ($filter) {
                        $q2->where('nombre', 'like', '%' . $filter . '%');
                    });
                    $sub->orWhereHas('marcas_i', function ($q3) use ($filter) {
                        $q3->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            });
        }
        if ($marca !== null) {
            $query->whereHas('garantia_ingreso_i', function($q) use ($marca) {
                $q->where('marca_id', $marca);
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $guia_egreso = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $guia_egreso->transform(function ($g_egreso){
                $g_egreso->fecha = Carbon::parse($g_egreso->fecha)->format('d/m/Y');
            return $g_egreso;
        });

        foreach ($guia_egreso as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->garantia_ingreso_i->orden_servicio,
                $value->garantia_ingreso_i->marcas_i->nombre,
                $value->fecha,
                $value->garantia_ingreso_i->motivo,
                $value->garantia_ingreso_i->asunto,
                $value->garantia_ingreso_i->clientes_i->nombre,
                $value->id,
                $value->informe_tecnico,
            ];
        }
        return response()->json($json);
    }

    public function getGarantiaInformeTecnicoTable(Request $request){
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'orden_servicio',
            3 => 'marcas_i.nombre',
            4 => 'fecha',
            5 => 'motivo',
            6 => 'asunto',
            7 => 'clientes_i.nombre',
            8 => 'id',
            9 => 'informe_tecnico',
        ];

        $marca = $request->marca;
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = GarantiaGuiaEgreso::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function($q) use ($filter) {
                $q->orWhereHas('garantia_ingreso_i', function($sub) use ($filter) {
                    $sub->where('orden_servicio', 'like', '%' . $filter . '%');
                    $sub->orWhere('motivo', 'like', '%' . $filter . '%');
                    $sub->orWhere('asunto', 'like', '%' . $filter . '%');
                    $sub->orWhereHas('clientes_i', function ($q2) use ($filter) {
                        $q2->where('nombre', 'like', '%' . $filter . '%');
                    });
                    $sub->orWhereHas('marcas_i', function ($q3) use ($filter) {
                        $q3->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            });
        }
        if ($marca !== null) {
            $query->whereHas('garantia_ingreso_i', function($q) use ($marca) {
                $q->where('marca_id', $marca);
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $guia_egreso = $query->get();

            $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $guia_egreso->transform(function ($g_egreso){
                $g_egreso->fecha = Carbon::parse($g_egreso->fecha)->format('d/m/Y');
            return $g_egreso;
        });

        foreach ($guia_egreso as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->garantia_ingreso_i->orden_servicio,
                $value->garantia_ingreso_i->marcas_i->nombre,
                $value->fecha,
                $value->garantia_ingreso_i->motivo,
                $value->garantia_ingreso_i->asunto,
                $value->garantia_ingreso_i->clientes_i->nombre,
                $value->id,
                $value->informe_tecnico,
            ];
        }
        return response()->json($json);
    }
}
