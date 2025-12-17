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
use App\Boleta;
use App\Boleta_m;
use App\ComprobantesPagosDetalle;
use App\ComprobantesPagosRegistros;
use App\Cuotas_credito;
use App\Facturacion;
use App\Facturacion_m;
use App\GarantiaGuiaEgreso;
use App\GarantiaGuiaIngreso;
use App\GarantiaInformeTecnico;
use App\Moneda;
use App\Personal;
use App\Provedor;
use App\Servicio;
use Carbon\Carbon;
use Exception;
use Greenter\Model\Sale\Cuota;

class ApiController extends Controller
{
    public function getProductos()
    {
        $user = Auth::user();
        if (!$user) {
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
        if (!$user) {
            return redirect('/');
        }
        $garantia_ingreso_q = DB::table('garantia_guia_ingreso')
            ->select('*', 'garantia_guia_ingreso.id as gar_ing_id', 'garantia_guia_ingreso.created_at as gar_ing_ct_at', 'marcas.nombre as nombre_marca', 'clientes.nombre as cliente_nom', 'personal.nombres as personal_as', 'garantia_guia_ingreso.estado as estado_ga_ing')
            ->orderby('garantia_guia_ingreso.id', 'DESC')
            ->join('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
            ->join('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
            ->join('personal', 'garantia_guia_ingreso.personal_lab_id', '=', 'personal.id')

            ->get();
        return Datatables($garantia_ingreso_q)->toJson();
    }

    public function getGarantiaIngresoGuias()
    {
        $user = Auth::user();
        if ($user == null) {
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
        if (!$user) {
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
        if (!$user) {
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
        if (!$user) {
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
        if (!$user) {
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('descripcion', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('descripcion', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%');
                $q->orWhere('tipo', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('fecha', 'like', '%' . $filter . '%');
                $q->orWhere('compra', 'like', '%' . $filter . '%');
                $q->orWhere('venta', 'like', '%' . $filter . '%');
                $q->orWhere('paralelo', 'like', '%' . $filter . '%');
            });
        }
        // return $date_filter;
        if (!empty($date_filter)) {

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
        $tipo_cambios->transform(function ($tipo_cambio) {
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('codigo', 'like', '%' . $filter . '%');
                $q->orWhere('descripcion', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('simbolo', 'like', '%' . $filter . '%');
                $q->orWhere('medida', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('descripcion', 'like', '%' . $filter . '%');
                $q->orWhere('tipo', 'like', '%' . $filter . '%');
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

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('descripcion', 'like', '%' . $filter . '%');
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
    public function getServicios(Request $request)
    {
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
            4 => 'catogoria',
            5 => 'familia',
            6 => 'id'
        ];

        // $query = Servicios::query()->orderBy('created_at', 'desc');
        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Servicios::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Servicios::orderBy('id', 'desc');
        }
        if ($estado !== null) {
            $query->where('estado_anular', $estado);
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%');
                $q->orWhere('codigo_servicio', 'like', '%' . $filter . '%');
                $q->orWhere('codigo_original', 'like', '%' . $filter . '%');
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

        $servicios->transform(function ($servicio) {
            $servicio->familia = $servicio->familia->descripcion;
            $servicio->fecha_creacion = $servicio->fecha_creacion;
            // $moneda_nacional = Moneda::where('tipo', 'nacional')->first();
            // $moneda_extranjera = Moneda::where('tipo', 'extranjera')->first();
            $servicio->precio_nacional_float = $servicio->precio_nacional;
            $servicio->precio_extranjero_float = $servicio->precio_extranjero;
            $servicio->precio_nacional = $servicio->calcularPrecios()['precio_nacional'];
            $servicio->precio_extranjero = $servicio->calcularPrecios()['precio_extranjero'];

            return $servicio;
        });

        foreach ($servicios as $value) {
            $json['data'][] = [
                $value->id,
                $value->codigo_servicio,
                $value->codigo_original,
                $value->nombre,
                $value->familia,
                $value->precio_nacional,
                $value->precio_extranjero,
                $value->estado_anular,
                $value->id,
                $value,
            ];
        }
        return response()->json($json);
    }

    public function getProductosTable(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $estado = $request->get('estado_producto');

        $sortColumns = [
            0 => 'id',
            1 => 'codigo_producto',
            2 => 'nombre',
            3 => 'marca',
            4 => 'unidad'
        ];


        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Producto::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Producto::orderBy('id', 'desc');
        }

        if ($estado !== null) {
            $query->where('estado_id', $estado);
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_producto', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_original', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();

        $sortColumnName = isset($sortColumns[$order[0]['column']]) ? $sortColumns[$order[0]['column']] : 'id';
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $productos = $query->get();

        $productos->transform(function ($product) {
            $product->familia = $product->familia_i_producto->descripcion ?? 'N/A';
            $product->marca = $product->marcas_i_producto->nombre ?? 'N/A';
            $product->afectacion = $product->tipo_afec_i_producto->informacion ?? 'N/A';
            $product->unidad = $product->unidad_i_producto->medida ?? 'N/A';

            if ($product->estado_id == 1 || $product->estado_id == 3) {
                $product->estado = 'Activo';
            } elseif ($product->estado_id == 2) {
                $product->estado = 'Inactivo';
            }

            $product->precios = $product->calcularPrecios();

            return $product;
        });

        $json = [
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($productos as $value) {
            // cantidad de columnas
            $json['data'][] = [
                $value->id,              // => 0 - id producto
                $value->codigo_producto, // => 1 - codigo
                $value->nombre,          // => 2 - nombre
                $value->marca,           // => 3 - marca
                $value->unidad,          // => 4 - unidad
                $value->estado,          // => 5 - estado
                $value->precios,     // => 6 - precio
                $value->stock ?? 0,      // => 7 - stock
                $value              // => 8 - botones
            ];
        }

        return response()->json($json);
    }
    // dsd
    // ds
    // d
    // dssd






    // sss
    public function getGarantiaIngresoTable(Request $request)
    {
        // 🟢 1. Nueva opción: devolver todos los IDs filtrados
        if ($request->has('get_all_ids')) {
            $query = GarantiaGuiaIngreso::query();

            // Rango de fechas
            if ($request->has('daterange') && $request->daterange) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            // Marca
            if ($request->filled('marca')) {
                $query->where('marca_id', $request->marca);
            }

            // Egreso (similar a procesado en egreso)
            if (!is_null($request->egreso) && $request->egreso !== '') {
                switch ($request->egreso) {
                    case 0:
                        $query->where('egresado', 0)
                            ->where('estado', 1);
                        break;
                    case 3:
                        $query->where('egresado', 0)
                            ->where('estado', 2);
                        break;
                    default:
                        $query->where('egresado', $request->egreso);
                        break;
                }
            }

            // Búsqueda global
            if ($request->filled('value')) {
                $filter = $request->value;
                $query->where(function ($q) use ($filter) {
                    $q->where('orden_servicio', 'like', '%' . $filter . '%');
                    $q->orWhere('motivo', 'like', '%' . $filter . '%');
                    $q->orWhere('asunto', 'like', '%' . $filter . '%');
                    $q->orWhereHas('clientes_i', function ($q2) use ($filter) {
                        $q2->where('nombre', 'like', '%' . $filter . '%');
                    });
                    $q->orWhereHas('marcas_i', function ($q3) use ($filter) {
                        $q3->where('nombre', 'like', '%' . $filter . '%');
                    });
                });
            }

            $allIds = $query->pluck('id')->toArray();

            return response()->json([
                'all_ids' => $allIds,
                'total'   => count($allIds),
            ]);
        }

        // 🟢 2. Caso normal: DataTables paginado
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $egreso = $request->get('egreso');

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
        $daterange = explode(' - ', $request->daterange);
        $startDate = Carbon::createFromFormat('d/m/Y', $daterange[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $daterange[1])->endOfDay();

        $query = GarantiaGuiaIngreso::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('orden_servicio', 'like', '%' . $filter . '%');
                $q->orWhere('motivo', 'like', '%' . $filter . '%');
                $q->orWhere('asunto', 'like', '%' . $filter . '%');
                $q->orWhereHas('clientes_i', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%');
                });
                $q->orWhereHas('marcas_i', function ($q3) use ($filter) {
                    $q3->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        if (!is_null($egreso)) {
            switch ($egreso) {
                case 0:
                    $query->where('egresado', 0)
                        ->where('estado', 1);
                    break;
                case 3:
                    $query->where('egresado', 0)
                        ->where('estado', 2);
                    break;
                default:
                    $query->where('egresado', $egreso);
                    break;
            }
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

        $guia_ingreso->transform(function ($g_ingreso) {
            $g_ingreso->fecha = Carbon::parse($g_ingreso->fecha)->format('d/m/Y');
            return $g_ingreso;
        });

        foreach ($guia_ingreso as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->codigo_interno,
                // $value->motivo,
                // $value->asunto,
                $value->nombre_equipo,
                $value->marcas_i->nombre,
                $value->numero_serie,
                $value->clientes_i->nombre,
                $value->clientes_i->numero_documento,
                $value->fecha,
                $value->id,
                $value->estado,
                $value->egresado,
            ];
        }

        return response()->json($json);
    }

    public function getGarantiaEgresoTable(Request $request)
    {
        // 🟢 1. Nueva opción: devolver todos los IDs filtrados
        if ($request->has('get_all_ids')) {
            $query = GarantiaGuiaEgreso::query();

            // Rango de fechas
            if ($request->has('daterange') && $request->daterange) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            // Marca
            if ($request->filled('marca')) {
                $marca = $request->marca;
                $query->whereHas('garantia_ingreso_i', function ($q) use ($marca) {
                    $q->where('marca_id', $marca);
                });
            }

            // Procesado
            if (!is_null($request->procesado) && $request->procesado !== '') {
                if ($request->procesado == 0) {
                    $query->where('informe_tecnico', 0);
                } elseif ($request->procesado == 1) {
                    $query->where('informe_tecnico', 1);
                }
            }

            // Búsqueda global
            if ($request->filled('value')) {
                $filter = $request->value;
                $query->where(function ($q) use ($filter) {
                    $q->orWhereHas('garantia_ingreso_i', function ($sub) use ($filter) {
                        $sub->where('orden_servicio', 'like', '%' . $filter . '%')
                            ->orWhere('motivo', 'like', '%' . $filter . '%')
                            ->orWhere('asunto', 'like', '%' . $filter . '%')
                            ->orWhereHas('clientes_i', function ($q2) use ($filter) {
                                $q2->where('nombre', 'like', '%' . $filter . '%');
                            })
                            ->orWhereHas('marcas_i', function ($q3) use ($filter) {
                                $q3->where('nombre', 'like', '%' . $filter . '%');
                            });
                    });
                });
            }

            $allIds = $query->pluck('id')->toArray();

            return response()->json([
                'all_ids' => $allIds,
                'total'   => count($allIds),
            ]);
        }

        // 🟢 2. Caso normal: DataTables paginado
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $procesado = $request->get('procesado');

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
        $daterange = explode(' - ', $request->daterange);
        $startDate = Carbon::createFromFormat('d/m/Y', $daterange[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', $daterange[1])->endOfDay();

        $query = GarantiaGuiaEgreso::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->orWhereHas('garantia_ingreso_i', function ($sub) use ($filter) {
                    $sub->where('orden_servicio', 'like', '%' . $filter . '%')
                        ->orWhere('motivo', 'like', '%' . $filter . '%')
                        ->orWhere('asunto', 'like', '%' . $filter . '%')
                        ->orWhereHas('clientes_i', function ($q2) use ($filter) {
                            $q2->where('nombre', 'like', '%' . $filter . '%');
                        })
                        ->orWhereHas('marcas_i', function ($q3) use ($filter) {
                            $q3->where('nombre', 'like', '%' . $filter . '%');
                        });
                });
            });
        }

        if (!is_null($procesado)) {
            if ($procesado == 0) {
                $query->where('informe_tecnico', 0);
            } elseif ($procesado == 1) {
                $query->where('informe_tecnico', 1);
            }
        }

        if ($marca !== null) {
            $query->whereHas('garantia_ingreso_i', function ($q) use ($marca) {
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

        $guia_egreso->transform(function ($g_egreso) {
            $g_egreso->fecha = Carbon::parse($g_egreso->fecha)->format('d/m/Y');
            $g_egreso->cod_interno = $g_egreso->garantia_ingreso_i->codigo_interno;
            $g_egreso->equipo = $g_egreso->garantia_ingreso_i->nombre_equipo;
            $g_egreso->marca = $g_egreso->garantia_ingreso_i->marcas_i->nombre;
            $g_egreso->serie = $g_egreso->garantia_ingreso_i->numero_serie;
            $g_egreso->cliente = $g_egreso->garantia_ingreso_i->clientes_i->nombre;
            $g_egreso->ruc = $g_egreso->garantia_ingreso_i->clientes_i->numero_documento;

            return $g_egreso;
        });

        foreach ($guia_egreso as $value) {
            $json['data'][] = [
                $value->id, // [0]
                $value->id, // [1]
                $value->cod_interno, // [2]
                $value->equipo, // [3]
                $value->marca, // [4]
                $value->serie, // [5]
                $value->cliente, // [6]
                $value->ruc, // [7]
                $value->fecha, // [8]
                $value->id, // [9]
                $value->informe_tecnico, // [10]
            ];
        }

        return response()->json($json);
    }


    public function getGarantiaInformeTecnicoTable(Request $request)
    {
        // 🟢 1. Nueva opción: devolver todos los IDs filtrados
        if ($request->has('get_all_ids')) {
            $query = GarantiaInformeTecnico::query()
                ->with([
                    'garantia_egreso_i.garantia_ingreso_i.marcas_i',
                    'garantia_egreso_i.garantia_ingreso_i.clientes_i'
                ]);

            // Rango de fechas
            if ($request->has('daterange') && $request->daterange) {
                $dates = explode(' - ', $request->daterange);
                if (count($dates) == 2) {
                    $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                    $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            // Marca
            if ($request->filled('marca')) {
                $marca = $request->marca;
                $query->whereHas('garantia_egreso_i.garantia_ingreso_i', function ($q) use ($marca) {
                    $q->where('marca_id', $marca);
                });
            }

            // Búsqueda global
            if ($request->filled('value')) {
                $filter = $request->value;
                $query->where(function ($q) use ($filter) {
                    $q->orWhereHas('garantia_egreso_i.garantia_ingreso_i', function ($sub) use ($filter) {
                        $sub->where('orden_servicio', 'like', '%' . $filter . '%')
                            ->orWhere('motivo', 'like', '%' . $filter . '%')
                            ->orWhere('asunto', 'like', '%' . $filter . '%')
                            ->orWhereHas('clientes_i', function ($q2) use ($filter) {
                                $q2->where('nombre', 'like', '%' . $filter . '%');
                            })
                            ->orWhereHas('marcas_i', function ($q3) use ($filter) {
                                $q3->where('nombre', 'like', '%' . $filter . '%');
                            });
                    });
                });
            }

            $allIds = $query->pluck('id')->toArray();

            return response()->json([
                'all_ids' => $allIds,
                'total'   => count($allIds),
            ]);
        }

        // 🟢 2. Caso normal: DataTables paginado
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');

        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'garantia_egreso_i.garantia_ingreso_i.orden_servicio',
            3 => 'garantia_egreso_i.garantia_ingreso_i.marcas_i.nombre',
            4 => 'fecha',
            5 => 'garantia_egreso_i.garantia_ingreso_i.motivo',
            6 => 'garantia_egreso_i.garantia_ingreso_i.asunto',
            7 => 'garantia_egreso_i.garantia_ingreso_i.clientes_i.nombre',
            8 => 'id',
            9 => 'informe_tecnico',
        ];

        $marca = $request->marca;
        $daterange = $request->daterange;

        $query = GarantiaInformeTecnico::query()
            ->with([
                'garantia_egreso_i.garantia_ingreso_i.marcas_i',
                'garantia_egreso_i.garantia_ingreso_i.clientes_i'
            ]);

        // Filtro por rango de fechas
        if (!empty($daterange)) {
            $dates = explode(' - ', $daterange);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Filtro por texto general
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->orWhereHas('garantia_egreso_i.garantia_ingreso_i', function ($sub) use ($filter) {
                    $sub->where('orden_servicio', 'like', '%' . $filter . '%')
                        ->orWhere('motivo', 'like', '%' . $filter . '%')
                        ->orWhere('asunto', 'like', '%' . $filter . '%')
                        ->orWhereHas('clientes_i', function ($q2) use ($filter) {
                            $q2->where('nombre', 'like', '%' . $filter . '%');
                        })
                        ->orWhereHas('marcas_i', function ($q3) use ($filter) {
                            $q3->where('nombre', 'like', '%' . $filter . '%');
                        });
                });
            });
        }

        // Filtro por marca
        if (!empty($marca)) {
            $query->whereHas('garantia_egreso_i.garantia_ingreso_i', function ($q) use ($marca) {
                $q->where('marca_id', $marca);
            });
        }

        // Total sin paginación (para DataTables)
        $recordsTotal = $query->count();

        // Ordenamiento
        $columnIndex = $order[0]['column'] ?? 0;
        $dir = $order[0]['dir'] ?? 'asc';
        $sortColumnName = $sortColumns[$columnIndex] ?? 'id';

        // Aplicar ordenamiento
        if (str_contains($sortColumnName, '.')) {
            // Para ordenar por relaciones, necesitamos hacer join
            $parts = explode('.', $sortColumnName);
            $relation = implode('.', array_slice($parts, 0, -1));
            $column = end($parts);

            $query->join('garantia_guia_egreso', 'garantia_informe_tecnico.garantia_egreso_id', '=', 'garantia_guia_egreso.id')
                ->join('garantia_guia_ingreso', 'garantia_guia_egreso.garantia_ingreso_id', '=', 'garantia_guia_ingreso.id')
                ->leftJoin('marcas', 'garantia_guia_ingreso.marca_id', '=', 'marcas.id')
                ->leftJoin('clientes', 'garantia_guia_ingreso.cliente_id', '=', 'clientes.id')
                ->orderBy($column, $dir);
        } else {
            $query->orderBy($sortColumnName, $dir);
        }

        // Paginación
        $query->skip($start)->take($length);

        $informe_tecnico = $query->get();

        // Preparar respuesta
        $json = [
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        // Formatear datos
        foreach ($informe_tecnico as $value) {
            $json['data'][] = [
                $value->id, // [0]
                $value->id, // [1]
                $value->garantia_egreso_i->garantia_ingreso_i->codigo_interno ?? '', // [2]
                $value->garantia_egreso_i->garantia_ingreso_i->nombre_equipo ?? '', // [3]
                $value->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre ?? '', // [4]
                $value->garantia_egreso_i->garantia_ingreso_i->numero_serie ?? '', // [5]
                $value->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre ?? '', // [6]
                $value->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento ?? '', // [7]
                Carbon::parse($value->fecha)->format('d/m/Y'), // [8]
                $value->id, // [9]
                // $value->informe_tecnico ?? '', // [10]
                // $value->egresado, // Añadido para la columna 11 que se usa en el frontend [11]
            ];
        }

        return response()->json($json);
    }
    public function getPersonalTable(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'nombres',
            3 => 'numero_documento',
            4 => 'email',
            5 => 'celular',
            6 => 'datos_laborales.fecha_vinculacion',
            7 => 'datos_laborales.categoria_ocupacional',
            8 => 'estado',
            9 => 'id',
        ];
        $estado = $request->estado;
        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Personal::whereBetween('created_at', [$startDate, $endDate]);
        } else {
            $query = Personal::query();
        }

        if ($estado == 1) {
            $query->where('estado_trabajador_laboral', 'Activo'); // Activo
        }
        if ($estado == 0) {
            $query->where('estado_trabajador_laboral', 'Desactivo'); // Desactivado
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombres', 'like', '%' . $filter . '%');
                $q->orWhere('apellidos', 'like', '%' . $filter . '%');
                $q->orWhere('numero_documento', 'like', '%' . $filter . '%');
                $q->orWhere('email', 'like', '%' . $filter . '%');
                $q->orWhere('celular', 'like', '%' . $filter . '%');
                $q->orWhere('email', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnIndex = $order[1]['column'] ?? null;
        $sortDir = $order[1]['dir'] ?? 'desc';

        if (isset($sortColumnIndex) && isset($sortColumns[$sortColumnIndex])) {
            $sortColumnName = $sortColumns[$sortColumnIndex];
            $query->orderBy($sortColumnName, $sortDir);
        } else {
            // Orden por defecto si no se especifica orden válido
            $query->orderBy('created_at', 'desc');
        }
        $query->with('datos_laborales')
            ->where('id', '!=', 1)
            ->skip($start)
            ->take($length);

        $personal = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        // $personal->transform(function ($g_egreso) {
        //     $g_egreso->fecha = Carbon::parse($g_egreso->fecha)->format('d/m/Y');
        //     return $g_egreso;
        // });
        // return $personal;
        foreach ($personal as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->full_name,
                $value->numero_documento,
                $value->email,
                $value->celular,
                $value->datos_laborales->fecha_vinculacion,
                $value->datos_laborales->categoria_ocupacional ?? 'Sin Categoria',
                $value->id,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function getProveedorTable(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'ruc',
            3 => 'empresa',
            4 => 'direccion',
            5 => 'telefono',
            6 => 'correo',
            7 => 'contacto_nombre',
            8 => 'estado',
            9 => 'id',
        ];

        $estado = $request->estado;

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Provedor::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');
        } else {
            $query = Provedor::orderBy('created_at', 'desc');
        }

        // if($estado == 1){
        //     $query->where('estado_trabajador_laboral', 'Activo'); // Activo
        // }
        // if($estado == 0){
        //     $query->where('estado_trabajador_laboral', 'Desactivo'); // Desactivado
        // }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('ruc', 'like', '%' . $filter . '%');
                $q->orWhere('empresa', 'like', '%' . $filter . '%');
                $q->orWhere('direccion', 'like', '%' . $filter . '%');
                $q->orWhere('telefonos', 'like', '%' . $filter . '%');
                $q->orWhere('telefonos', 'like', '%' . $filter . '%');
                $q->orWhere('email', 'like', '%' . $filter . '%');
                $q->orWhere('contacto_provedor', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $proveedor = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($proveedor as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->ruc,
                $value->empresa,
                $value->direccion,
                $value->telefonos,
                $value->email,
                $value->contacto_provedor ?? 'Sin Contacto',
                $value->id,
                $value->estado,
            ];
        }
        return response()->json($json);
    }

    public function getCantidadPrecioProductTable(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'ruc',
            3 => 'empresa',
            4 => 'direccion',
            5 => 'telefono',
            6 => 'correo',
            7 => 'contacto_nombre',
            8 => 'estado',
            9 => 'id',
        ];

        // $estado = $request->estado;

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Stock_producto::whereBetween('created_at', [$startDate, $endDate])->orderBy('producto_id', 'desc');
        } else {
            $query = Stock_producto::orderBy('producto_id', 'desc');
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                // Filtro en la tabla productos
                $q->whereHas('producto', function ($q2) use ($filter) {
                    $q2->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('codigo_producto', 'like', '%' . $filter . '%')
                        ->orWhere('garantia', 'like', '%' . $filter . '%');
                })
                    // Filtro en la tabla marcas
                    ->orWhereHas('producto.marcas_i_producto', function ($q3) use ($filter) {
                        $q3->where('nombre', 'like', '%' . $filter . '%');
                    })
                    // Filtro en columnas propias de stock_precio
                    ->orWhere('stock', 'like', '%' . $filter . '%');
                // ->orWhere('precio_nac', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $stock_precio = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $stock_precio->transform(function ($stocl_p) {
            // $stocl_p->fecha = Carbon::parse($stocl_p->fecha)->format('d-m-Y');
            $stocl_p->precio_nac = $stocl_p->producto->calcularPrecios()['precio_nacional'];
            $stocl_p->precio_ex = $stocl_p->producto->calcularPrecios()['precio_extranjero'];
            $stocl_p->precio_nac_igv = $stocl_p->producto->calcularPrecios()['precio_nacional_igv'];
            $stocl_p->precio_ex_igv = $stocl_p->producto->calcularPrecios()['precio_extranjero_igv'];
            if ($stocl_p->stock == "0") {
                $stocl_p->stock = "SIN STOCK";
            }
            // $stocl_p->precio_nac =
            return $stocl_p;
        });

        // $productos_finales[] = [
        //     'id' => $stock_precio->producto->id,
        //     'nombre' => $stock_precio->producto->nombre,
        //     'codigo' => $stock_precio->producto->codigo_producto,
        //     'stock' => $stock_precio->stock,
        //     'precio_nacional' => $stock_precio->precio_nac,
        //     'precio_extranjero' => $stock_precio->precio_ex,
        //     'marca' => $stock_precio->producto->marca ?? '',
        //     'garantia' => $stock_precio->producto->garantia ?? 'Sin Garantia',
        // ];
        foreach ($stock_precio as $value) {
            $json['data'][] = [
                $value->producto->id,
                $value->producto->id,
                $value->producto->codigo_producto,
                $value->producto->nombre,
                $value->producto->marca ?? 'Sin Marca',
                $value->producto->garantia ?? 'Sin Garantía',
                $value->stock,
                $value->precio_nac,
                $value->precio_nac_igv,
                $value->precio_ex,
                $value->precio_ex_igv,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function getCantidadPrecioServiceTable(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'ruc',
            3 => 'empresa',
            4 => 'direccion',
            5 => 'telefono',
            6 => 'correo',
            7 => 'contacto_nombre',
            8 => 'estado',
            9 => 'id',
        ];

        $estado = $request->estado;

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Servicios::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Servicios::orderBy('id', 'desc');
        }
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_servicio', 'like', '%' . $filter . '%')
                    ->orWhereHas('marca', function ($q) use ($filter) {
                        $q->where('nombre', 'like', '%' . $filter . '%');
                    });
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

        $servicios->transform(function ($servicio) {
            // $stocl_p->fecha = Carbon::parse($stocl_p->fecha)->format('d-m-Y');
            $servicio->precio_nac = $servicio->calcularPrecios()['precio_nacional'];
            $servicio->precio_ex = $servicio->calcularPrecios()['precio_extranjero'];
            $servicio->precio_nac_igv = $servicio->calcularPrecios()['precio_nacional_igv'];
            $servicio->precio_ex_igv = $servicio->calcularPrecios()['precio_extranjero_igv'];
            // if ($servicio->stock == "0") {
            //     $servicio->stock = "SIN STOCK";
            // }
            // $servicio->precio_nac =
            return $servicio;
        });
        foreach ($servicios as $value) {
            $json['data'][] = [
                $value->id,
                $value->id,
                $value->codigo_servicio,
                $value->nombre,
                $value->marca->nombre ?? 'Sin Marca',
                // $value->garantia->nombre ?? 'Sin Garantía',
                // $value->stock ?? '100',
                $value->precio_nac,
                $value->precio_nac_igv,
                $value->precio_ex,
                $value->precio_ex_igv,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function get_cuotas_credito_table(Request $request)
    {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $documento = $request->get('tipo_documento');
        $id_documento = $request->get('id_documento');
        $sortColumns = [
            0 => 'id',
            1 => 'n_cuota',
            2 => 'estado',
            3 => 'monto',
            4 => 'saldo',
            5 => 'fecha_vencimiento',
            6 => 'id'
        ];

        switch ($documento) {
            case 'factura':
                $query = Cuotas_credito::where('facturacion_id', $id_documento);
                $factura = Facturacion::find($id_documento);
                $tipo_cambio = $factura->cambio;
                $moneda_comprobante = $factura->moneda;
                break;
            case 'factura_manual':
                $query = Cuotas_credito::where('facturacion_m_id', $id_documento);
                $factura_m = Facturacion_m::find($id_documento);
                $tipo_cambio = $factura_m->cambio;
                $moneda_comprobante = $factura_m->moneda;
                break;
            case 'boleta':
                $query = Cuotas_credito::where('boleta_id', $id_documento);
                $boleta = Boleta::find($id_documento);
                $tipo_cambio = $boleta->cambio;
                $moneda_comprobante = $boleta->moneda;
                break;
            case 'boleta_manual':
                $query = Cuotas_credito::where('boleta_m_id', $id_documento);
                $boleta_m = Boleta_m::find($id_documento);
                $tipo_cambio = $boleta_m->cambio;
                $moneda_comprobante = $boleta_m->moneda;
                break;
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $cuotas_credito = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $cuotas_credito->transform(function ($comprobante) use ($tipo_cambio, $moneda_comprobante) {
            $pagado = Cuotas_credito::monto_pagado_convertido_cuota($comprobante->id, $moneda_comprobante->id, $tipo_cambio);
            $restante = Cuotas_credito::restante_pago_convertido_cuota($comprobante->id, $moneda_comprobante->id);
            $comprobante->fecha_pago = Carbon::parse($comprobante->fecha_pago)->format('d-m-Y');
            $comprobante->monto_total =  $moneda_comprobante->simbolo . ' ' . number_format(round($comprobante->monto, 2), 2);
            $comprobante->pagado = $pagado;
            $comprobante->restante = $restante['moneda'] . ' ' . number_format($restante['saldo_pendiente'],2);
            // $comprobante->tipo_cambio = $comprobante->tipo_cambio;
            return $comprobante;
        });

        foreach ($cuotas_credito as $data) {
            $json['data'][] = [
                $data->numero_cuota,
                $data->estado,
                $data->monto_total,
                $data->pagado['prin'],
                $data->pagado['sec'],
                $data->restante,
                $data->fecha_pago ?? "- - -",
                $data->id,
            ];
        }
        return response()->json($json);
    }

    public function get_detalle_pago_cuota_table(Request $request)
    {
        // $cuota = Cuotas_credito::findOrFail($request->id_cuota);

        // if ($cuota->estado != 0) {
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $documento = $request->get('tipo_documento');
        $id_documento = $request->get('id_documento');
        $sortColumns = [
            0 => 'id',
            1 => 'tipo_pago', //Completo o adelanto
            2 => 'monto',
            3 => 'metodo_pago',
            4 => 'pagado_por',
            5 => 'fecha_pago ',
            6 => 'id'
        ];
        $registros = ComprobantesPagosRegistros::where('id_cuota_credito', $request->id_cuota)->get();
        $ids = $registros->pluck('id');
        $query = ComprobantesPagosDetalle::whereIn('comprobante_pago_reg_id', $ids);
        // dd($query);
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $detalle_pagos = $query->get();

        $detalle_pagos->transform(function ($detalle) use ($request) {
            // $detalle->tipo_pago =  $detalle->forma_pago.' '.ucwords($detalle->tipo_pago);
            $detalle->tipo_pago =  ucwords($detalle->tipo_pago);
            $cuota = Cuotas_credito::findOrFail($request->id_cuota);
            $moneda_pago = $detalle->moneda->simbolo ?? $cuota->moneda_comprobante;

            $precio = $detalle->montos_input;
            $precio_principal = $detalle->precio_principal;

            $precio_secundario = $moneda_pago . ' ' . number_format($precio, 2) ?? 0.00;

            $detalle->monto_pago = $detalle->precio_principal . ' - ' . $detalle->precio_secundario;

            $fecha = $detalle->fechas_inputs;
            $detalle->fecha_pago = Carbon::parse($fecha)->format('d-m-Y');
            return $detalle;
        });

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        foreach ($detalle_pagos as $data) {
            $json['data'][] = [
                $data->id,
                $data->forma_pago,
                $data->monto_pagado_format,
                $data->tipo_pago,
                $data->persona_input ?? "-- -- --",
                // $data->emisor ?? "-- -- --",
                $data->fecha_pago ?? "-- -- --",
                $data->id,
            ];
        }
        return response()->json($json);
    }
}
