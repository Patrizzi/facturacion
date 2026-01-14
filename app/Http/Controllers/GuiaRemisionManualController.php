<?php

namespace App\Http\Controllers;

use App\GuiaRemisionManual;
use App\GuiaRemisionMRegistros;
use App\Almacen;
use App\Codigo_guia_almacen;
use App\Kardex_entrada;
use App\Empresa;
use App\Cliente;
use App\MotivoTraslado;
use App\Vehiculo;
use App\TransportePublico;
use App\Personal;
use App\Producto;
use App\Stock_almacen;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class GuiaRemisionManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $user_login = auth()->user();
        $guia_remision = GuiaRemisionManual::all();
        $almacen = Almacen::where('estado',0)->get();
        $almacen_primero = Almacen::where('estado',0)->first();
        $conteo_almacen = Almacen::where('estado',0)->count();
        $vehiculo = Vehiculo::where('estado_activo', 1)->get();
        $transporte_publico = TransportePublico::where('estado', 0)->get();
        if(count($vehiculo) == 0 && count($transporte_publico) == 0){
            $valor_error = 1;
            $message = "Para crear una Guia de Remision agrege un Vehiculo, ya sea Publico o Privado ";
        }else{
            $valor_error = 0;
            $message = "";
        }
        return view('transaccion.venta.guia_remision.guia_manual.index',compact('guia_remision','almacen','conteo_almacen','almacen_primero','user_login','valor_error','message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //* GUIA REMISION MANUAL  COD GUIA
        $count_guias=GuiaRemisionManual::where('almacen_id',1)->count();
        if ( $count_guias == 0) {
            $cod_guia = Codigo_guia_almacen::where('serie_remision_m', 0)->first();
            if(isset($cod_guia)){
                $almacen_update = Codigo_guia_almacen::find($cod_guia->id);
                $almacen_update->serie_remision_m = 1;
                $almacen_update->cod_remision_m = 0;
                $almacen_update->save();
            }
        }
        // return $cod_guia;

        $empresa = Empresa::first();
        $clientes = Cliente::get();
        $almacen = Almacen::get();
        $motivo_traslado = MotivoTraslado::all();
        $vehiculo = Vehiculo::where('estado_activo',0)->get();
        $transporte_publico = TransportePublico::where('estado',0)->get();
        $personal = Personal::where('estado_trabajador_laboral','Activo')->where('id', '!=', 1)->where('licencia','!=', null)->get();
        $productos = Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $almacen_serie_remision= Codigo_guia_almacen::where('almacen_id','1')->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision_m','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO

        if ($almacen_serie_remision->cod_remision_m=='NN') {
            $agrupar_almacen=GuiaRemisionManual::where('almacen_id',$almacen_serie_remision->id)->get()->last();
            // return $agrupar_almacen;
            $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
            if($numero == 99999999){
                $ultima_serie = $almacen_codigo->serie_remision_m+1;
                $almacen_update = Codigo_guia_almacen::find($almacen_serie_remision->id);
                $almacen_update->serie_remision_m = $ultima_serie;
                $almacen_update->save();
                $numero = 00000000;
            }else{
                $ultima_serie = $almacen_serie_remision->serie_remision_m;
            }
        }else{
            $numero = $almacen_serie_remision->cod_remision_m;
            $ultima_serie = $almacen_serie_remision->serie_remision_m;
        }

        $numero++;
        $cantidad_sucursal=str_pad($ultima_serie, 2, "0", STR_PAD_LEFT);
        $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia='TA'.$cantidad_sucursal.'-'.$cantidad_registro;

        $fecha_hoy = Carbon::now();
        $fecha_1 = $fecha_hoy->format('Y-m-d');

        return view('transaccion.venta.guia_remision.guia_manual.create',compact('empresa','clientes','almacen','motivo_traslado','vehiculo','transporte_publico','personal','productos','codigo_guia','fecha_1'));
    }

    public function peso_ajax(Request $request){
        $article = $request->get('articulo');
        $id = explode(" | ",$article);

        $product = Producto::where('id',$id[0])->where('codigo_producto',$id[1])->where('codigo_original',$id[2])->first();

        $sep_esc = explode(' ',$product->peso);

        $peso_pr = $sep_esc[0];
        return $peso_pr;
    }
    public function almacen_remision_m(Request $request){
        $almacen = $request->get('almacen');
        $id_almacen = Almacen::where('id',$almacen)->first();
        $almacen_serie_remision= Codigo_guia_almacen::where('almacen_id',$id_almacen->id)->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision_m','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO

        $cod_guia_all = Codigo_guia_almacen::where('almacen_id', '!=' ,$id_almacen->id)->get();

        $last_numb=GuiaRemisionManual::where('almacen_id',$id_almacen->id)->latest()->first();
        // return $last_numb;
        if(!isset($last_numb) && !is_numeric($almacen_serie_remision->cod_remision_m)){
            $almacen_igual = Codigo_guia_almacen::find($id_almacen->id); //2
            $almacen_igual->cod_remision_m = 1;
            $almacen_igual->save();
        }
        foreach($cod_guia_all as $cod_gui){
            $serie_fac_m = $cod_gui->serie_remision_m;
            if($almacen_serie_remision->serie_remision_m == $serie_fac_m ){
                // $var[] = $cod_guia->serie_factura_m+1;
                $almacen_igual = Codigo_guia_almacen::find($id_almacen->id);
                $almacen_igual->serie_remision_m = $almacen_serie_remision->serie_remision_m+1;
                $almacen_igual->save();
            }else{
                // $var[] = 0;
            }
        }

        if ($almacen_serie_remision->cod_remision_m=='NN') {
            $agrupar_almacen=GuiaRemisionManual::where('almacen_id',$almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
            if($numero == 99999999){
                $ultima_serie = $almacen_codigo->serie_remision_m+1;
                $almacen_update = Codigo_guia_almacen::find($almacen_serie_remision->id);
                $almacen_update->serie_remision_m = $ultima_serie;
                $almacen_update->save();
                $numero = 00000000;
            }else{
                $ultima_serie = $almacen_serie_remision->serie_remision_m;
            }
        }else{
            $numero = $almacen_serie_remision->cod_remision_m;
            $ultima_serie = $almacen_serie_remision->serie_remision_m;
        }

        $numero++;
        $cantidad_sucursal=str_pad($ultima_serie, 2, "0", STR_PAD_LEFT);
        $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia='TA'.$cantidad_sucursal.'-'.$cantidad_registro;

        return $codigo_guia;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $almacen = $request->get('almacen');
        $cliente = $request->get('cliente');
        $motivo = $request->get('motivo_traslado');
        $fecha_emision = $request->get('fecha_emision');
        $fecha_entrega = $request->get('fecha_entrega');
        $tipo_transporte = $request->get('tipo_transporte');
        $observacion = $request->get('observacion');
        $articulos = $request->get('articulo');
        /* SERIE Y CORRELATIVO */
        $almacen_serie_remision= Codigo_guia_almacen::where('almacen_id',$almacen)->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision_m','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO

        if ($almacen_serie_remision->cod_remision_m=='NN') {
            $agrupar_almacen=GuiaRemisionManual::where('almacen_id',$almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
            if($numero == 99999999){
                $ultima_serie = $almacen_codigo->serie_remision_m+1;
                $almacen_update = Codigo_guia_almacen::find($almacen_serie_remision->id);
                $almacen_update->serie_remision_m = $ultima_serie;
                $almacen_update->save();
                $numero = 00000000;
            }else{
                $ultima_serie = $almacen_serie_remision->serie_remision_m;
            }
        }else{
            $numero = $almacen_serie_remision->cod_remision_m;
            $ultima_serie = $almacen_serie_remision->serie_remision_m;
        }

        $numero++;
        $cantidad_sucursal=str_pad($ultima_serie, 2, "0", STR_PAD_LEFT);
        $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia='TA'.$cantidad_sucursal.'-'.$cantidad_registro;

        /* separador de articulos */
        foreach($articulos as $art ){
            $sep_esc = explode(' ',$art);
            $prod_id[] = $sep_esc[0];
        }

        Cliente::cliente_update($cliente);
        /* Guardado en tabla  */
        $guia_remision_m = new GuiaRemisionManual();
        $guia_remision_m->cod_guia = $codigo_guia;
        $guia_remision_m->almacen_id = $almacen;
        $guia_remision_m->cliente_id = $cliente;
        $guia_remision_m->sucursal_cliente = $request->get('sucursal_cli');
        $guia_remision_m->cod_postal_cliente = $request->get('postal_input');
        $guia_remision_m->fecha_emision = Carbon::createFromFormat('Y-m-d', $fecha_emision)->format('d/m/Y');
        $guia_remision_m->fecha_entrega = $fecha_entrega;
        if ($tipo_transporte==1) {
            $guia_remision_m->vehiculo_publico=$request->get('vehiculo_publico');
        }elseif ($tipo_transporte==2) {
            $guia_remision_m->vehiculo_id=$request->get('vehiculo');
            $guia_remision_m->conductor_id=$request->get('conductor');
        }
        $guia_remision_m->tipo_transporte = $tipo_transporte;
        $guia_remision_m->tipo_transporte = $tipo_transporte;
        $guia_remision_m->observacion = $observacion;
        $guia_remision_m->motivo_traslado = $motivo;
        $guia_remision_m->estado_anulado = 0;
        $guia_remision_m->estado_registrado = 0;
        $guia_remision_m->g_electronica = 0;
        $guia_remision_m->user_id = auth()->user()->id;
        $guia_remision_m->save();
        /* cambio en almacen para NN*/
        $almacen=Codigo_guia_almacen::find($almacen_serie_remision->id);
        if(is_numeric($almacen->cod_remision_m)){
            $almacen->cod_remision_m='NN';
            $almacen->save();
        }
        /* Insercion en tabla remision regustros */
        $count_art = count($prod_id);

        for ($i=0; $i < $count_art ; $i++) {
            $remision_reg = new GuiaRemisionMRegistros();
            $remision_reg->guia_remision_m_id = $guia_remision_m->id;
            $remision_reg->producto_id = $prod_id[$i];
            $remision_reg->cantidad = $request->get('cantidad')[$i];
            $remision_reg->descripcion = $request->get('descripcion')[$i];
            $remision_reg->numero_serie = $request->get('serie')[$i];
            $remision_reg->peso = $request->get('peso')[$i];
            $remision_reg->estado = 1;
            $remision_reg->save();
        }
        return redirect()->route('guia_remision_manual.show',$guia_remision_m->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GuiaRemisionManual  $guiaRemisionManual
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::first();
        $guia_remision_m = GuiaRemisionManual::findOrFail($id);

        // Carga registros + producto (y sub-relaciones si las usas en la vista)
        $guia_remision_m_reg = GuiaRemisionMRegistros::with([
            'producto.marcas_i_producto',
            'producto.unidad_i_producto',
        ])->where('guia_remision_m_id', $guia_remision_m->id)->get();

        return view('transaccion.venta.guia_remision.guia_manual.show',
            compact('guia_remision_m','guia_remision_m_reg','empresa'));
    }

    public function pdf($id)
    {
        $empresa = Empresa::first();

        $guia_remision_m = GuiaRemisionManual::with([
            'almacen', 'cliente',
            'vehiculo', 'vehiculo_publicos',
            'personal', 'user_personal.personal',
        ])->findOrFail($id);

        $guia_remision_m_reg = GuiaRemisionMRegistros::with([
            'producto.marcas_i_producto',
            'producto.unidad_i_producto',
        ])->where('guia_remision_m_id', $guia_remision_m->id)->get();

        // variables que espera la vista PDF
        $i = 1;
        $tota = [];
        $textoQR = $this->generarTextoQRGuiaRemisionManual($guia_remision_m, $id);
        $qrCode  = $this->generarImagenQR($textoQR);

        $pdf = \PDF::loadView(
            'transaccion.venta.guia_remision.guia_manual.pdf',
            compact('empresa', 'guia_remision_m', 'guia_remision_m_reg', 'i', 'tota','textoQR','qrCode')
        );

        return $pdf->download('GRM - '.$guia_remision_m->cod_guia.'.pdf');
    }

    public function print($id)
    {
        $empresa = Empresa::first();
        $guia_remision_m = GuiaRemisionManual::find($id);
        $guia_remision_m_reg = GuiaRemisionMRegistros::where('guia_remision_m_id', $guia_remision_m->id)->get();
        $textoQR = $this->generarTextoQRGuiaRemisionManual($guia_remision_m, $id);
        $qrCode  = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.guia_remision.guia_manual.print',compact('guia_remision_m','guia_remision_m_reg','empresa','textoQR','qrCode'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GuiaRemisionManual  $guiaRemisionManual
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GuiaRemisionManual  $guiaRemisionManual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GuiaRemisionManual  $guiaRemisionManual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         try {
            if (!$request->filled('id_guia')) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID de guía no recibido'
                ], 400);
            }

            $guia_remision = GuiaRemisionManual::find($request->id_guia);
            if (!$guia_remision) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guía de remisión no encontrada'
                ], 404);
            }

            $guia_remision->estado_anulado = 1;
            $guia_remision->motivo_anulacion = $request->motivo;
            $guia_remision->g_electronica = 2;
            

            if (!$guia_remision->save()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se pudo anular la guía'
                ], 500);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Guía anulada correctamente',
                'guia_remision_m' => $guia_remision
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function registers(Request $request)
    {
        try {
            $draw   = (int) $request->input('draw', 0);
            $start  = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 10);

            $daterange = $request->get('daterange', date('01/m/Y').' - '.date('t/m/Y'));
            $filter    = $request->get('value');
            $estadoS   = $request->get('estado_s', null);
            $wantAll   = filter_var($request->get('get_all_ids', false), FILTER_VALIDATE_BOOLEAN);

            // Soporta separador " | " o " - "
            if (strpos($daterange, '|') !== false) {
                [$startStr, $endStr] = array_map('trim', explode('|', $daterange, 2));
            } else {
                [$startStr, $endStr] = array_map('trim', explode('-', $daterange, 2));
            }

            try {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startStr)->startOfDay();
                $endDate   = \Carbon\Carbon::createFromFormat('d/m/Y', $endStr)->endOfDay();
            } catch (\Throwable $e) {
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
            }

            $base = \App\GuiaRemisionManual::with('cliente')
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Filtro Estado SUNAT (0=Sin enviar, 1=Enviado, 2=Anulado)
            if ($estadoS !== null && $estadoS !== '') {
                switch ((int) $estadoS) {
                    case 0: // Sin enviar
                        $base->where('g_electronica', 0)->where('estado_anulado', 0);
                        break;
                    case 1: // Enviado
                        $base->where('g_electronica', 1);
                        break;
                    case 2: // Anulado
                        $base->where('estado_anulado', 1);
                        break;
                }
            }

            // Filtro de texto
            if (!empty($filter)) {
                $base->where(function ($q) use ($filter) {
                    $q->where('cod_guia', 'like', "%{$filter}%")
                    ->orWhere('fecha_emision', 'like', "%{$filter}%")
                    ->orWhereHas('cliente', function ($c) use ($filter) {
                        $c->where('nombre', 'like', "%{$filter}%")
                            ->orWhere('numero_documento', 'like', "%{$filter}%");
                    });
                });
            }

            // Si piden todos los IDs (selección masiva) o length = -1 → sin paginar
            if ($wantAll || (int) $length === -1) {
                $start  = 0;
                $length = PHP_INT_MAX;
            }

            $recordsTotal    = \App\GuiaRemisionManual::count();
            $recordsFiltered = (clone $base)->count();

            $items = (clone $base)
                ->orderBy('created_at', 'desc')
                ->skip($start)
                ->take($length)
                ->get();

            $data = [];
            foreach ($items as $gr) {
                $cli = optional($gr->cliente);

                // Fallback seguro si no existe/metodo no es estático:
                $estadoSunat = method_exists(\App\GuiaRemisionManual::class, 'estado_sunat')
                    ? (int) \App\GuiaRemisionManual::estado_sunat($gr->id)
                    : ($gr->g_electronica ? 1 : ($gr->estado_anulado ? 2 : 0));

                $data[] = [
                    $gr->id,                   // 0: ID (para "Ver" y checkbox)
                    $gr->id,                   // 1: ID visible
                    $gr->cod_guia,             // 2: Código
                    $cli->numero_documento,    // 3: RUC/DNI
                    $cli->nombre,              // 4: Cliente
                    $gr->fecha_emision,        // 5: Fecha Emisión
                    $gr->fecha_entrega,        // 6: Fecha Entrega
                    '',                        // 7: placeholder (la vista dibuja el botón)
                    $estadoSunat,              // 8: SUNAT (0/1/2)
                    99,                        // 9: Crédito (no aplica)
                    99,                        // 10: Débito  (no aplica)
                ];
            }

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);
        } catch (\Throwable $e) {
            // Devuelve siempre JSON válido para que DataTables no muestre el warning genérico
            \Log::error('registers() error GRM: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'draw'            => (int) $request->input('draw', 0),
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
                'error'           => $e->getMessage(),
            ], 200);
        }
    }



    public function exportarGuiasManual(Request $request)
    {
        if (ob_get_contents()) { ob_end_clean(); }

        if ($request->has('guia_ids') && !empty($request->input('guia_ids'))) {
            $guiaIds = $request->input('guia_ids');

            $guias = \App\GuiaRemisionManual::with(['cliente', 'vehiculo', 'personal'])
                ->whereIn('id', $guiaIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $daterange = $request->get('daterange', date('01/m/Y').' - '.date('t/m/Y'));
            $filter    = $request->get('value');

            if (strpos($daterange, '|') !== false) {
                [$startStr, $endStr] = array_map('trim', explode('|', $daterange));
            } else {
                [$startStr, $endStr] = array_map('trim', explode('-', $daterange));
            }

            try {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startStr)->startOfDay();
                $endDate   = \Carbon\Carbon::createFromFormat('d/m/Y', $endStr)->endOfDay();
            } catch (\Throwable $e) {
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
            }

            $query = \App\GuiaRemisionManual::with(['cliente', 'vehiculo', 'personal'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc');

            if (!empty($filter)) {
                $query->where(function ($q) use ($filter) {
                    $q->where('cod_guia', 'like', "%{$filter}%")
                    ->orWhere('fecha_emision', 'like', "%{$filter}%")
                    ->orWhereHas('cliente', function ($c) use ($filter) {
                        $c->where('nombre', 'like', "%{$filter}%")
                            ->orWhere('numero_documento', 'like', "%{$filter}%");
                    });
                });
            }

            $guias = $query->get();
        }

        $headers = [
            'Código','Cliente','Documento','Sucursal cliente','Cód. postal',
            'Fecha emisión','Fecha entrega','Tipo transporte','Vehículo público',
            'Vehículo (placa)','Conductor','Motivo traslado','Observación',
            'SUNAT','Estado','Ticket',
        ];

        $rows = [$headers];

        foreach ($guias as $gr) {
            $cliente       = optional($gr->cliente);
            $vehiculoPlaca = optional($gr->vehiculo)->placa;

            $conductorNombre = trim((optional($gr->personal)->nombres ?? '').' '.(optional($gr->personal)->apellidos ?? ''));
            $conductorNombre = $conductorNombre !== '' ? $conductorNombre : null;

            $tipoTransporte = [
                0 => 'Sin transporte',
                1 => 'Transporte público',
                2 => 'Transporte privado',
            ][$gr->tipo_transporte] ?? $gr->tipo_transporte;

            $sunat  = $gr->g_electronica ? 'Enviado' : 'Sin enviar';
            $estado = $gr->estado_anulado ? 'Anulado' : 'Activo';

            $rows[] = [
                $gr->cod_guia,
                $cliente->nombre,
                $cliente->numero_documento,
                $gr->sucursal_cliente,
                $gr->cod_postal_cliente,
                $gr->fecha_emision,
                $gr->fecha_entrega,
                $tipoTransporte,
                $gr->vehiculo_publico,
                $vehiculoPlaca,
                $conductorNombre,
                $gr->motivo_traslado,
                $gr->observacion,
                $sunat,
                $estado,
                $gr->ticket_guia_remision_sunat
                    ?? $gr->ticket_guia_remi_m_sunat
                    ?? null,
            ];
        }

        $export = new class($rows) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithEvents {
            private $rows;
            public function __construct($rows) { $this->rows = $rows; }
            public function array(): array { return $this->rows; }
            public function registerEvents(): array {
                return [
                    \Maatwebsite\Excel\Events\AfterSheet::class => function ($event) {
                        foreach (range('A', 'Z') as $col) {
                            $event->sheet->getColumnDimension($col)->setAutoSize(true);
                        }
                        foreach (range('A', 'Z') as $a) {
                            foreach (range('A', 'Z') as $b) {
                                $event->sheet->getColumnDimension($a.$b)->setAutoSize(true);
                            }
                        }
                    },
                ];
            }
        };

        $fecha = now('America/Lima')->format('d-m-Y');
        return \Maatwebsite\Excel\Facades\Excel::download($export, 'Guias de Remision Manual '.$fecha.'.xlsx');
    }

    public function printMultiple(Request $request)
    {
        // 1) Si viene el flag select_all, reconstruye la selección en el backend
        if ($request->boolean('select_all')) {
            $daterange = $request->get('daterange', date('01/m/Y').' - '.date('t/m/Y'));
            $filter    = $request->get('value');
            $estadoS   = $request->get('estado_s', null);

            // Soporta " | " o " - "
            if (strpos($daterange, '|') !== false) {
                [$startStr, $endStr] = array_map('trim', explode('|', $daterange, 2));
            } else {
                [$startStr, $endStr] = array_map('trim', explode('-', $daterange, 2));
            }

            try {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $startStr)->startOfDay();
                $endDate   = \Carbon\Carbon::createFromFormat('d/m/Y', $endStr)->endOfDay();
            } catch (\Throwable $e) {
                $startDate = now()->startOfMonth();
                $endDate   = now()->endOfMonth();
            }

            $base = \App\GuiaRemisionManual::with('cliente')
                ->whereBetween('created_at', [$startDate, $endDate]);

            // Estado SUNAT
            if ($estadoS !== null && $estadoS !== '') {
                switch ((int) $estadoS) {
                    case 0: // Sin enviar
                        $base->where('g_electronica', 0)->where('estado_anulado', 0);
                        break;
                    case 1: // Enviado
                        $base->where('g_electronica', 1);
                        break;
                    case 2: // Anulado
                        $base->where('estado_anulado', 1);
                        break;
                }
            }

            // Filtro de texto
            if (!empty($filter)) {
                $base->where(function ($q) use ($filter) {
                    $q->where('cod_guia', 'like', "%{$filter}%")
                    ->orWhere('fecha_emision', 'like', "%{$filter}%")
                    ->orWhereHas('cliente', function ($c) use ($filter) {
                        $c->where('nombre', 'like', "%{$filter}%")
                            ->orWhere('numero_documento', 'like', "%{$filter}%");
                    });
                });
            }

            // IDs a imprimir
            $ids = $base->pluck('id')->all();
        } else {
            // 2) Modo “IDs seleccionados” normal
            $ids = $request->input('guia_ids', []);
        }

        if (empty($ids)) {
            return back()->withErrors(['No se recibieron IDs']);
        }

        $guias = GuiaRemisionManual::whereIn('id', $ids)->get();

        if ($guias->isEmpty()) {
            return back()->withErrors(['Algunas guías seleccionadas no existen.']);
        }

        $registros = GuiaRemisionMRegistros::with(['producto.marcas_i_producto','producto.unidad_i_producto'])
            ->whereIn('guia_remision_m_id', $ids)
            ->orderBy('guia_remision_m_id')
            ->orderBy('id')
            ->get()
            ->groupBy('guia_remision_m_id');

        $empresa = Empresa::first();

        $guiasData = $guias->map(function ($g) use ($registros) {
            $textoQR = $this->generarTextoQRGuiaRemisionManual($g, $g->id);
            $qrCode  = $this->generarImagenQR($textoQR);

            return [
                'guia'      => $g,
                'registros' => $registros[$g->id] ?? collect(),
                'qrCode'    => $qrCode,
            ];
        });

        return view('transaccion.comprobantes.guia_remision_manual.print_multiple',
            compact('guiasData','empresa')
        );
    }

    public function downloadMultiplePDFs(Request $request)
    {
        $ids = collect($request->input('guia_ids', []))
            ->filter()->map(fn($v) => (int)$v)->unique()->values();

        if ($request->boolean('select_all')) {
            $q = GuiaRemisionManual::query();
            if ($r = $request->get('daterange')) {
                if (strpos($r, '|') !== false) {
                    [$iniStr, $finStr] = array_map('trim', explode('|', $r, 2));
                } else {
                    [$iniStr, $finStr] = array_map('trim', explode('-', $r, 2));
                }
                try {
                    $ini = \Carbon\Carbon::createFromFormat('d/m/Y', $iniStr)->startOfDay();
                    $fin = \Carbon\Carbon::createFromFormat('d/m/Y', $finStr)->endOfDay();
                } catch (\Throwable $e) {
                    $ini = now()->startOfMonth();
                    $fin = now()->endOfMonth();
                }
                $q->whereBetween('created_at', [$ini, $fin]);
            }
            if ($request->filled('estado_s')) {
                switch ((int)$request->input('estado_s')) {
                    case 0: $q->where('g_electronica', 0)->where('estado_anulado', 0); break;
                    case 1: $q->where('g_electronica', 1); break;
                    case 2: $q->where('estado_anulado', 1); break;
                }
            }
            if ($v = $request->get('value')) {
                $q->where(function($qq) use ($v) {
                    $qq->where('cod_guia', 'like', "%{$v}%")
                    ->orWhereHas('cliente', function($c) use ($v) {
                        $c->where('nombre','like',"%{$v}%")
                            ->orWhere('numero_documento','like',"%{$v}%");
                    });
                });
            }
            $ids = $ids->merge($q->pluck('id'))->unique()->values();
        }

        if ($ids->isEmpty()) {
            return back()->with('warning', 'No hay guías para descargar.');
        }

        if ($ids->count() === 1) {
            return $this->downloadSinglePDF($ids->first());
        }

        $guias = GuiaRemisionManual::with(['cliente','almacen'])
            ->whereIn('id', $ids)->get();

        if ($guias->isEmpty()) {
            return back()->with('warning', 'Las guías seleccionadas no existen.');
        }

        @ini_set('zlib.output_compression', 'Off');
        while (ob_get_level() > 0) { @ob_end_clean(); }

        $tmpPath = tempnam(sys_get_temp_dir(), 'grm_') . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open($tmpPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'No se pudo crear el archivo ZIP.');
        }

        $empresa = Empresa::first();

        foreach ($guias as $g) {
            try {
                $guia_remision_m = GuiaRemisionManual::with([
                    'almacen','cliente','vehiculo','vehiculo_publicos','personal','user_personal.personal',
                ])->findOrFail($g->id);

                $guia_remision_m_reg = GuiaRemisionMRegistros::with([
                    'producto.marcas_i_producto','producto.unidad_i_producto',
                ])->where('guia_remision_m_id', $g->id)->get();

                $i = 1; $tota = [];
                $textoQR = $this->generarTextoQRGuiaRemisionManual($guia_remision_m, $ids);
                $qrCode  = $this->generarImagenQR($textoQR);

                $pdf = \PDF::loadView('transaccion.venta.guia_remision.guia_manual.pdf',
                        compact('empresa','guia_remision_m','guia_remision_m_reg','i','tota','textoQR','qrCode'))
                        ->setPaper('a4');

                $filename = 'GR-'.$g->cod_guia.'.pdf';
                $zip->addFromString($filename, $pdf->output());
            } catch (\Exception $e) {
                continue;
            }
        }

        $zip->close();

        if (!file_exists($tmpPath) || filesize($tmpPath) < 1000) {
            @unlink($tmpPath);
            return back()->with('error', 'El ZIP resultó vacío o incompleto.');
        }

        $downloadName = 'GRM_'.now('America/Lima')->format('Ymd_His').'.zip';

        return response()->streamDownload(function() use ($tmpPath) {
            $fh = fopen($tmpPath, 'rb');
            while (!feof($fh)) {
                echo fread($fh, 1048576);
                flush();
            }
            fclose($fh);
            @unlink($tmpPath);
        }, $downloadName, [
            'Content-Type'        => 'application/zip',
            'Content-Description' => 'File Transfer',
            'Content-Transfer-Encoding' => 'binary',
            'Cache-Control'       => 'private, no-transform, no-store, must-revalidate',
            'Pragma'              => 'public',
        ]);
    }

    private function downloadSinglePDF(int $id)
    {
        try {
            $empresa = Empresa::first();

            $guia_remision_m = GuiaRemisionManual::with([
                'almacen','cliente','vehiculo','vehiculo_publicos','personal','user_personal.personal',
            ])->find($id);

            if (!$guia_remision_m) {
                return back()->with('error', 'Guía manual no encontrada.');
            }

            $guia_remision_m_reg = GuiaRemisionMRegistros::with([
                'producto.marcas_i_producto','producto.unidad_i_producto',
            ])->where('guia_remision_m_id', $id)->get();

            $i = 1;
            $tota = [];
            $textoQR = $this->generarTextoQRGuiaRemisionManual($guia_remision_m, $id);
            $qrCode  = $this->generarImagenQR($textoQR);

            $pdf = \PDF::loadView('transaccion.venta.guia_remision.guia_manual.pdf',
                compact('empresa','guia_remision_m','guia_remision_m_reg','i','tota','textoQR','qrCode'))
                ->setPaper('a4');

            $nombre = 'GRM_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $guia_remision_m->cod_guia ?? ('ID_'.$guia_remision_m->id)) . '.pdf';

            return $pdf->download($nombre);

        } catch (\Throwable $e) {
            return back()->with('error', 'Error al generar el PDF: '.$e->getMessage());
        }
    }

    public function pdfLink($id)
    {
        $empresa = Empresa::first();

        $guia_remision_m = GuiaRemisionManual::with([
            'almacen', 'cliente',
            'vehiculo', 'vehiculo_publicos',
            'personal', 'user_personal.personal',
        ])->findOrFail($id);

        $guia_remision_m_reg = GuiaRemisionMRegistros::with([
            'producto.marcas_i_producto',
            'producto.unidad_i_producto',
        ])->where('guia_remision_m_id', $guia_remision_m->id)->get();

        $i = 1;
        $tota = [];
        $textoQR = $this->generarTextoQRGuiaRemisionManual($guia_remision_m, $id);
        $qrCode  = $this->generarImagenQR($textoQR);

        $pdf = \PDF::loadView(
            'transaccion.venta.guia_remision.guia_manual.pdf',
            compact('empresa', 'guia_remision_m', 'guia_remision_m_reg', 'i', 'tota','textoQR','qrCode')
        );

        return $pdf->stream('GRM - '.$guia_remision_m->cod_guia.'.pdf');
    }

    /**
     * Genera el texto (URL) del código QR para la guía de remisión manual
     *
     * @param \App\GuiaRemisionManual $guia_remision_m
     * @param int $id
     * @return string
     */
    private function generarTextoQRGuiaRemisionManual($guia_remision_m, $id)
    {
        try {
            // Genera la URL completa para el pdfLink
            $url = route('guia_remision_manual.pdfLink', $id);

            return $url;

        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Genera la imagen QR en formato base64
     *
     * @param string $texto
     * @return string|null
     */
    private function generarImagenQR($texto)
    {
        try {
            if (empty($texto)) {
                return null;
            }

            $qr = QrCode::format('svg')
                        ->size(200)
                        ->errorCorrection('Q')
                        ->margin(1)
                        ->encoding('UTF-8')
                        ->generate($texto);

            if (empty($qr)) {
                return null;
            }

            $base64 = base64_encode($qr);

            return 'data:image/svg+xml;base64,' . $base64;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function whatsappSendMultiple(Request $request)
    {
        $numero = $request->numero;
        $guiaIds = $request->guia_ids;

        $mensaje = "";

        foreach ($guiaIds as $id) {
            $guia_r_m = GuiaRemisionManual::find($id);
            if ($guia_r_m) {
                $codigo_g_r = $guia_r_m->cod_guia;
                $pdfUrl = route('remision_m.pdf', $id) . "?archivo=GuíaRemisión_{$codigo_g_r}";

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }
}
