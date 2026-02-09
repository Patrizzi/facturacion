<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Banco;
use App\Cliente;
use App\Cliente_sucursal;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Guia_remision;
use App\Igv;
use App\MotivoTraslado;
use App\Personal;
use App\Producto;
use App\TransportePublico;
use App\Vehiculo;
use App\g_remision_registro;
use App\Stock_almacen;
use App\Stock_producto;
use App\Kardex_entrada;
use App\moneda;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Arr;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Exports\GuiaRemisionExport;
use App\GuiaRemisionMRegistros;

class GuiaRemisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = Kardex_entrada::where('estado', 2)->first();
        if (empty($existe_id)) {
            return redirect()->route('kardex-entrada.index');
        }
        $vehiculo = Vehiculo::where('estado_activo', 1)->get();
        $transporte_publico = TransportePublico::where('estado', 0)->get();
        // return count($transporte_publico);
        if(count($vehiculo) == 0 && count($transporte_publico) == 0){
            $valor_error = 1;
            $message = "Para crear una Guia de Remision agrege un Vehiculo, ya sea <span class='url_def'>Publico o Privado</span> ";
        }else{
            $valor_error = 0;
            $message = "";
        }
        // return $message;
        $user_login = auth()->user();
        $guia_remision = Guia_remision::all();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $personal_conductor = Personal::where('id','!=', 1)->where('licencia', '!=', null)->get();

        
        return view('transaccion.venta.guia_remision.index', compact('guia_remision', 'almacen', 'conteo_almacen', 'almacen_primero', 'user_login','valor_error','message','personal_conductor'));
    }

    public function ajax_sucursal(Request $request){
        // return $request;
        $cliente = Cliente::where('id',$request->cliente)->first();
        $cliente_sucursal = Cliente_sucursal::where('cliente_id',$cliente->id)->get();
        // return ;
        if(count($cliente_sucursal) == 0){
            $sucursal[] = $cliente->direccion;
            $cod_post[] = $cliente->cod_postal;
            $data_array = array(
                "sucursal"=> $sucursal,
                "cod_postal"=> $cod_post,
            );
        }else{
            $array_suc[] = $cliente->direccion;
            $cod_postal[] = $cliente->cod_postal;
            $data_array = array(
                "sucursal"=> $array_suc,
                "cod_postal"=> $cod_postal,
            );
            foreach ($cliente_sucursal as $sucursales) {
                $array_suc[] = $sucursales->direccion.' - '.$sucursales->departamento.' - '.$sucursales->provincia.' - '.$sucursales->distrito;
                $cod_postal[] =  $sucursales->cod_postal;
            }
            $data_array = array(
                "sucursal"=>$array_suc,
                "cod_postal"=>$cod_postal,
            );
        }

        return $data_array;
    }
    /**q
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $inventario_inicial = Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ($inventario_inicial->estado == 1) {
                return redirect()->route('kardex-entrada.show', $inventario_inicial->id);
            }
        }

        // return "a";
        /*Codigo*/
        //Guardado de almacen para inventario-inicial
        $almacen = $request->get('almacen');
        $id_almacen = Almacen::where('id', $almacen)->first();
        $almacen_serie_remision = Codigo_guia_almacen::where('almacen_id', $id_almacen->id)->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision', 'DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO
        if ($almacen_serie_remision->cod_remision == 'NN') {
            $agrupar_almacen = Guia_remision::where('almacen_id', $almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
            if ($numero == 99999999) {
                $ultima_serie = $almacen_codigo->serie_remision + 1;
                $numero = 00000000;
            } else {
                $ultima_serie = $almacen_serie_remision->serie_remision;
            }
        } else {
            $numero = $almacen_serie_remision->cod_remision;
            $ultima_serie = $almacen_serie_remision->serie_remision;
        }

        $numero++;
        $cantidad_sucursal = str_pad($ultima_serie, 3, "0", STR_PAD_LEFT);
        $cantidad_registro = str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia = 'T' . $cantidad_sucursal . '-' . $cantidad_registro;

        /* Fin de Codigo*/

        $productos = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->get();

        foreach ($productos as $index => $producto) {
            $utilidad[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional') * ($producto->utilidad - $producto->descuento1) / 100;
            $array[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional') + $utilidad[$index];
            $array_cantidad[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->sum('cantidad');
            $array_promedio[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional');
        }

        $clientes = Cliente::all();
        $personal = Personal::where('id', '!=', 1)->where('licencia','!=', null)->get();
        $motivo_traslado = MotivoTraslado::all();
        $vehiculo = Vehiculo::where('estado_activo', 0)->get();
        $transporte_publico = TransportePublico::where('estado', 0)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        $fecha_hoy = Carbon::now();
        $fecha_1 = $fecha_hoy->format('Y-m-d');

        return view('transaccion.venta.guia_remision.create', compact('productos', 'clientes', 'array', 'array_cantidad', 'igv', 'array_promedio', 'empresa', 'vehiculo', 'motivo_traslado', 'codigo_guia', 'almacen', 'personal', 'transporte_publico','fecha_1','id_almacen'));
    }

    public function peso_stock(Request $request){
        $article = $request->get('articulo');
        $almacen = $request->get('almacen');
        $id = explode(" | ",$article);
        // return $id;
        $product = Producto::where('id',$id[0])->where('codigo_producto',$id[1])->where('codigo_original',$id[2])->first();

        $stock_almacen = Stock_almacen::where('almacen_id',$almacen)->where('producto_id', $product->id)->first();
        $sep_esc = explode(' ',$product->peso);
        $peso_pr = $sep_esc[0];
        $data=[
            'stock'=> $stock_almacen->stock,
            'peso'=> $peso_pr,
        ];
        return $data;
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
        /*Codigo*/
        //Guardado de almacen para inventario-inicial
        // return $request;
        $almacen = $request->get('almacen');
        $id_almacen = Almacen::where('id', $almacen)->first();
        $almacen_serie_remision = Codigo_guia_almacen::where('almacen_id', $id_almacen->id)->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision', 'DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO

        if ($almacen_serie_remision->cod_remision == 'NN') {
            $agrupar_almacen = Guia_remision::where('almacen_id', $almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
            if ($numero == 99999999) {
                $ultima_serie = $almacen_codigo->serie_remision + 1;
                $almacen_update = Codigo_guia_almacen::find($almacen_serie_remision->id);
                $almacen_update->serie_remision = $ultima_serie;
                $almacen_update->save();
                $numero = 00000000;
            } else {
                $ultima_serie = $almacen_serie_remision->serie_remision;
            }
        } else {
            $numero = $almacen_serie_remision->cod_remision;
            $ultima_serie = $almacen_serie_remision->serie_remision;
        }

        $numero++;
        $cantidad_sucursal = str_pad($ultima_serie, 3, "0", STR_PAD_LEFT);
        $cantidad_registro = str_pad($numero, 8, "0", STR_PAD_LEFT);
        $codigo_guia = 'T' . $cantidad_sucursal . '-' . $cantidad_registro;

        /* Fin de Codigo*/
        // return $request;
        //id del cliente de create_2
        $id_cliente = $request->get('cliente');
        // return $request;
        $id_cotizacion = $request->get('id');
        //Buscador Cliente
        // if (isset($id_cliente)) {
        //     $cliente_id = $request->get('cliente_id');
        // } else {
        //     $cliente_nombre = $request->get('cliente');
        //     $nombre = strstr($cliente_nombre, '-', true);
        //     $cliente_buscador = Cliente::where('numero_documento', $nombre)->first();
        //     $cliente_id = $cliente_buscador->id;
        // }
        $tipo_transporte = $request->get('tipo_transporte');

        //registro de productos de la tabla guia de remision
        $articulo = $request->input('articulo');
        $count_articulo = count($articulo);

        for ($i = 0; $i < $count_articulo; $i++) {
            $articulos_val[$i] = $request->input('articulo')[$i];
            $producto_id_val[$i] = strstr($articulos_val[$i], ' ', true);
        }
        // return $articulos_val;
        //validacion
        //calculo para el stock del producto
        $almacen_producto_validacion = $id_almacen->id;
        for ($i = 0; $i < $count_articulo; $i++) {
            $kardex_entrada_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->get();
            $kardex_entrada_count_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->count();

            //return $kardex_entrada;
            foreach ($kardex_entrada_v as $kardex_entradas_v) {
                $kadex_entrada_id_v[] = $kardex_entradas_v->id;
            }
            // return $kardex_entrada;
            for ($x = 0; $x < $kardex_entrada_count_v; $x++) {
                if (Kardex_entrada_registro::where('producto_id', $producto_id_val[$i])->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first()) {
                    $nueva_v[] = Kardex_entrada_registro::where('producto_id', $producto_id_val[$i])->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first();
                }
            }
            // return $nueva_v;
            $comparacion_v = $nueva_v;
            //buble para la cantidad
            $cantidad_v = 0;
            foreach ($comparacion_v as $comparaciones_v) {
                $cantidad_v = $comparaciones_v->cantidad + $cantidad_v;
            }
            // return $nueva_v;
            $cantidad_entrada = $request->get('cantidad')[$i];
            if ($cantidad_v < $cantidad_entrada) {
                return "cantidad mayor al stock";
            }
        }

        Cliente::cliente_update($id_cliente);

        //motivo traslado - cambio en opt
        $mt_tr = $request->get('motivo_traslado');



        $guia_remision = new Guia_remision;
        $guia_remision->cod_guia = $codigo_guia;
        $guia_remision->cliente_id = $id_cliente;
        $guia_remision->sucursal_cliente = $request->get('sucursal_cli');
        $guia_remision->cod_postal_cliente = $request->get('postal_input');
        $guia_remision->almacen_id = $id_almacen->id;
        $guia_remision->fecha_emision = $request->get('fecha_emision');
        $guia_remision->fecha_entrega = $request->get('fecha_entrega');

        if ($tipo_transporte == 1) {
            $guia_remision->vehiculo_publico = $request->get('vehiculo_publico');
        } elseif ($tipo_transporte == 2) {
            $guia_remision->vehiculo_id = $request->get('vehiculo');
            $guia_remision->conductor_id = $request->get('conductor');
        }
        $guia_remision->tipo_transporte = $tipo_transporte;

        //0= sin transporte
        //1= transporte publico
        //2= transporte privado

        $guia_remision->motivo_traslado = $request->get('motivo_traslado');
        if($request->get('button_submit') == 0){
            $guia_remision->estado = 0;
        }else{
            $guia_remision->estado = 1;
        }
        $guia_remision->observacion = $request->get('observacion');
        $guia_remision->estado_anulado = '0';
        $guia_remision->estado_registrado = '0';
        $guia_remision->user_id = auth()->user()->id;
        $guia_remision->save();

        $almacen = Codigo_guia_almacen::find($almacen_serie_remision->id);
        if (is_numeric($almacen->cod_remision)) {
            $almacen->cod_remision = 'NN';
            $almacen->save();
        }

        // if (isset($id_cliente)) {
        //     $cotizacion_estado_aprobado = Cotizacion::find($id_cotizacion);
        //     $cotizacion_estado_aprobado->estado_aprobado = '1';
        //     $cotizacion_estado_aprobado->save();
        // }



        $stock = $request->input('stock');
        $count_stock = count($stock);

        $cantidad = $request->input('cantidad');
        $count_cantidad = count($cantidad);

        $series = $request->input('series');
        $count_series = count($series);

        $peso = $request->input('peso');
        $count_peso = count($peso);
        // return $peso;
        for ($i = 0; $i < $count_articulo; $i++) {
            $articulos[$i] = $request->input('articulo')[$i];
            $producto_id[$i] = strstr($articulos[$i], ' ', true);
        }

        if ($count_articulo = $count_stock  = $count_cantidad = $count_series = $count_peso) {
            for ($i = 0; $i < $count_articulo; $i++) {
                $guia_remision_registro = new g_remision_registro;
                $guia_remision_registro->producto_id = $producto_id[$i];
                $guia_remision_registro->cantidad = $request->get('cantidad')[$i];
                $guia_remision_registro->numero_serie = $request->get('series')[$i];
                $guia_remision_registro->descripcion = $request->get('descripcion')[$i];
                $guia_remision_registro->guia_remision_id = $guia_remision->id;
                $guia_remision_registro->estado = 1;
                $guia_remision_registro->peso = $request->get('peso')[$i];
                $guia_remision_registro->save();

                // SOLO EL FINALIZAR HACE EL DESCUENTO DE STOCK
                if($request->get('button_submit') == 1){
                    $nueva = Kardex_entrada_registro::where('producto_id', $producto_id[$i])->where('almacen_id', $guia_remision->almacen_id)->where('estado', 1)->get();

                    $comparacion = $nueva;
                    //buble para la cantidad
                    $cantidad = 0;
                    foreach ($comparacion as $comparaciones) {
                        $cantidad = $comparaciones->cantidad + $cantidad;
                    }
                    if (isset($comparacion)) {
                        $var_cantidad_entrada = $guia_remision_registro->cantidad;
                        $contador = 0;
                        foreach ($comparacion as $p) {
                            if ($p->cantidad > $var_cantidad_entrada) {
                                $cantidad_mayor = $p->cantidad;
                                $cantidad_final = $cantidad_mayor - $var_cantidad_entrada;
                                $p->cantidad = $cantidad_final;
                                if ($cantidad_final == 0) {
                                    $p->estado = 0;
                                    $p->save();
                                    break;
                                } else {
                                    $p->save();
                                    break;
                                }
                            } elseif ($p->cantidad == $var_cantidad_entrada) {
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                                break;
                            } else {
                                $var_cantidad_entrada = $var_cantidad_entrada - $p->cantidad;
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                            }
                        }
                    }
                    //Resta en la tabla stock almacen
                    Stock_almacen::egreso($guia_remision->almacen_id, $producto_id[$i], $guia_remision_registro->cantidad);
                    //resta de cantidades de productos para la tabla stock productos
                    $stock_productos = Stock_producto::where('producto_id', $producto_id[$i])->first();
                    $stock_productos->stock = $stock_productos->stock - $guia_remision_registro->cantidad;
                    $stock_productos->save();
               }
            }
        } else {
            return "campos no completados";
        }

        return redirect()->route('guia_remision.show', $guia_remision->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = kardex_entrada::where('estado', 2)->first();
        if (empty($existe_id)) {
            return redirect()->route('kardex-entrada.index');
        }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id = Guia_remision::where('id', $id)->first();
        if (empty($existe_id)) {
            return redirect()->route('guia_remision.index');
        }

        $banco_count = Banco::where('estado', '0')->count();
        $guia_remision = Guia_remision::find($id);
        $guia_registro = g_remision_registro::where('guia_remision_id', $guia_remision->id)->get();
        $banco = Banco::where('estado', '0')->get();
        $empresa = Empresa::first();

        $textoQR = $this->generarTextoQRGuiaRemision($guia_remision, $id);
        $qrCode  = $this->generarImagenQR($textoQR);

        return view('transaccion.venta.guia_remision.print', compact('empresa', 'banco', 'guia_remision', 'guia_registro', 'banco_count','textoQR','qrCode'));
    }
    public function pdf(Request $request, $id)
    {
        $banco_count = Banco::where('estado', '0')->count();
        $guia_remision = Guia_remision::find($id);
        $guia_registro = g_remision_registro::where('guia_remision_id', $guia_remision->id)->get();
        $banco = Banco::where('estado', '0')->get();
        $empresa = Empresa::first();
        $y = 0;
        $textoQR = $this->generarTextoQRGuiaRemision($guia_remision, $id);
        $qrCode  = $this->generarImagenQR($textoQR);
        // $archivo=$name.$regla.$id.".pdf";
        $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact('guia_remision', 'guia_registro', 'banco', 'empresa', 'banco_count','y','textoQR','qrCode'));
        // return view('transaccion.venta.guia_remision.pdf', compact('guia_remision', 'guia_registro', 'banco', 'empresa', 'banco_count','y','textoQR','qrCode'));
        return $pdf->download('GR - '.$guia_remision->cod_guia .'.pdf');
    }

    public function show($id)
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = kardex_entrada::where('estado', 2)->first();
        if (empty($existe_id)) {
            return redirect()->route('kardex-entrada.index');
        }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id = Guia_remision::where('id', $id)->first();
        if (empty($existe_id)) {
            return redirect()->route('guia_remision.index');
        }


        $user_login = auth()->user();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        $conteo_almacen = Almacen::where('estado', 0)->count();

        $banco_count = Banco::where('estado', '0')->count();
        $guia_remision = Guia_remision::find($id);
        $guia_registro = g_remision_registro::where('guia_remision_id', $guia_remision->id)->get();
        // $suma_peso=sum($guia_registro->peso);
        // return $suma_peso;
        $banco = Banco::where('estado', '0')->get();
        $empresa = Empresa::first();

        // Datos para editar
        $motivo_traslado =  MotivoTraslado::all();
        $personal = Personal::where('id', '!=', 1)->where('licencia','!=', null)->get();
        $vehiculo = Vehiculo::where('estado_activo', 0)->get();
        $transporte_publico = TransportePublico::where('estado', 0)->get();

        return view('transaccion.venta.guia_remision.show', compact('empresa', 'banco', 'guia_remision', 'guia_registro', 'banco_count', 'user_login', 'almacen', 'almacen_primero', 'conteo_almacen','motivo_traslado','personal','vehiculo','transporte_publico'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('transaccion.venta.guia_remision.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        $guia_remision = Guia_remision::find($id);
        $id_cliente = $request->get('cliente');
        $tipo_transporte = $request->get('tipo_transporte');
        $articulo = $request->input('articulo');
        $count_articulo = count($articulo);

        for ($i = 0; $i < $count_articulo; $i++) {
            $articulos_val[$i] = $request->input('articulo')[$i];
            $producto_id_val[$i] = strstr($articulos_val[$i], ' ', true);
        }

        //* Revision de Stock Actual
        $almacen_producto_validacion = $guia_remision->almacen_id;
        for ($i = 0; $i < $count_articulo; $i++) {
            $kardex_entrada_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->get();
            $kardex_entrada_count_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->count();
            
            //return $kardex_entrada;
            foreach ($kardex_entrada_v as $kardex_entradas_v) {
                $kadex_entrada_id_v[] = $kardex_entradas_v->id;
            }
            // return $producto_id_val;
            // return $producto_id_val;
            for ($x = 0; $x < $kardex_entrada_count_v; $x++) {
                if (Kardex_entrada_registro::where('producto_id', $producto_id_val[$i])->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first()) {
                    $nueva_v[] = Kardex_entrada_registro::where('producto_id', $producto_id_val[$i])->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first();
                }
            }
            // return $nueva_v;
            $comparacion_v = $nueva_v;
            //buble para la cantidad
            $cantidad_v = 0;
            foreach ($comparacion_v as $comparaciones_v) {
                $cantidad_v = $comparaciones_v->cantidad + $cantidad_v;
            }
            // return $nueva_v;
            $cantidad_entrada = $request->get('cantidad')[$i];
            if ($cantidad_v < $cantidad_entrada) {
                return redirect()->back()->with('error', 'No se puede hacer el descuento, un producto tiene cantidad mayor al stock actual');
            }
        }


        
        $guia_remision->cliente_id = $id_cliente;
        $guia_remision->sucursal_cliente = $request->get('sucursal_cli');
        $guia_remision->cod_postal_cliente = $request->get('postal_input');
        $guia_remision->fecha_entrega = $request->get('fecha_entrega');
        $guia_remision->tipo_transporte = $tipo_transporte;

        if($tipo_transporte == 1){ // Si es publico
            $guia_remision->vehiculo_publico = $request->get('vehiculo_publico');
            // Setear Privado en null
            $guia_remision->vehiculo_id = null;
            $guia_remision->conductor_id = null;
        }else{
            $guia_remision->vehiculo_id = $request->get('vehiculo');
            $guia_remision->conductor_id = $request->get('conductor');
            // Setear Publico en null
            $guia_remision->vehiculo_publico = null;
        }
        $guia_remision->motivo_traslado = $request->get('motivo_traslado');
        if($request->get('button_submit') == 0){
            $guia_remision->estado = 0;
        }else{
            $guia_remision->estado = 1;
        }
        $guia_remision->observacion = $request->get('observacion');
        $guia_remision->save();
        // Registros

        $cantidad = $request->input('cantidad');
        $g_registros = g_remision_registro::where('guia_remision_id', $id)->get();

        for ($i = 0; $i < $count_articulo; $i++) {
            $articulos[$i] = $request->input('articulo')[$i];
            $producto_id[$i] = strstr($articulos[$i], ' ', true);
        }

        if($guia_remision->registros->count() == $cantidad){
            // Si es la misma cantidad se reemplaza
            foreach ($g_registros as $key => $reg) {
                $g_registros->producto_id = $producto_id[$key];
                $g_registros->cantidad = $request->get('cantidad')[$key];
                $g_registros->numero_serie = $request->get('series')[$key];
                $g_registros->descripcion = $request->get('descripcion')[$key];
                $g_registros->peso = $request->get('peso');
                $g_registros->save();
                if($request->get('button_submit') == 1){
                    $nueva = Kardex_entrada_registro::where('producto_id', $producto_id[$i])->where('almacen_id', $guia_remision->almacen_id)->where('estado', 1)->get();

                    $comparacion = $nueva;
                    //buble para la cantidad
                    $cantidad = 0;
                    foreach ($comparacion as $comparaciones) {
                        $cantidad = $comparaciones->cantidad + $cantidad;
                    }
                    if (isset($comparacion)) {
                        $var_cantidad_entrada = $g_registros->cantidad;
                        $contador = 0;
                        foreach ($comparacion as $p) {
                            if ($p->cantidad > $var_cantidad_entrada) {
                                $cantidad_mayor = $p->cantidad;
                                $cantidad_final = $cantidad_mayor - $var_cantidad_entrada;
                                $p->cantidad = $cantidad_final;
                                if ($cantidad_final == 0) {
                                    $p->estado = 0;
                                    $p->save();
                                    break;
                                } else {
                                    $p->save();
                                    break;
                                }
                            } elseif ($p->cantidad == $var_cantidad_entrada) {
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                                break;
                            } else {
                                $var_cantidad_entrada = $var_cantidad_entrada - $p->cantidad;
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                            }
                        }
                    }
                    //Resta en la tabla stock almacen
                    Stock_almacen::egreso($guia_remision->almacen_id, $producto_id[$i], $g_registros->cantidad);
                    //resta de cantidades de productos para la tabla stock productos
                    $stock_productos = Stock_producto::where('producto_id', $producto_id[$i])->first();
                    $stock_productos->stock = $stock_productos->stock - $g_registros->cantidad;
                    $stock_productos->save();
               }
            }
        }else{
            // Si no , se elimna y se vuelva a crear
            $eliminar_registros = g_remision_registro::where('guia_remision_id', $id)->delete();
            for ($i = 0; $i < $count_articulo; $i++) {
                $guia_remision_registro = new g_remision_registro;
                $guia_remision_registro->producto_id = $producto_id[$i];
                $guia_remision_registro->cantidad = $request->get('cantidad')[$i];
                $guia_remision_registro->numero_serie = $request->get('series')[$i];
                $guia_remision_registro->descripcion = $request->get('descripcion')[$i];
                $guia_remision_registro->guia_remision_id = $guia_remision->id;
                $guia_remision_registro->estado = 1;
                $guia_remision_registro->peso = $request->get('peso')[$i];
                $guia_remision_registro->save();

                // SOLO EL FINALIZAR HACE EL DESCUENTO DE STOCK
                if($request->get('button_submit') == 1){
                    $nueva = Kardex_entrada_registro::where('producto_id', $producto_id[$i])->where('almacen_id', $guia_remision->almacen_id)->where('estado', 1)->get();

                    $comparacion = $nueva;
                    //buble para la cantidad
                    $cantidad = 0;
                    foreach ($comparacion as $comparaciones) {
                        $cantidad = $comparaciones->cantidad + $cantidad;
                    }
                    if (isset($comparacion)) {
                        $var_cantidad_entrada = $guia_remision_registro->cantidad;
                        $contador = 0;
                        foreach ($comparacion as $p) {
                            if ($p->cantidad > $var_cantidad_entrada) {
                                $cantidad_mayor = $p->cantidad;
                                $cantidad_final = $cantidad_mayor - $var_cantidad_entrada;
                                $p->cantidad = $cantidad_final;
                                if ($cantidad_final == 0) {
                                    $p->estado = 0;
                                    $p->save();
                                    break;
                                } else {
                                    $p->save();
                                    break;
                                }
                            } elseif ($p->cantidad == $var_cantidad_entrada) {
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                                break;
                            } else {
                                $var_cantidad_entrada = $var_cantidad_entrada - $p->cantidad;
                                $p->cantidad = 0;
                                $p->estado = 0;
                                $p->save();
                            }
                        }
                    }
                    //Resta en la tabla stock almacen
                    Stock_almacen::egreso($guia_remision->almacen_id, $producto_id[$i], $guia_remision_registro->cantidad);
                    //resta de cantidades de productos para la tabla stock productos
                    $stock_productos = Stock_producto::where('producto_id', $producto_id[$i])->first();
                    $stock_productos->stock = $stock_productos->stock - $guia_remision_registro->cantidad;
                    $stock_productos->save();
               }
            }
        }
        return redirect()->route('guia_remision.show', $guia_remision->id)->with('success', 'La Guia de Remisión se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

            $guia_remision = Guia_remision::find($request->id_guia);
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
            
            Guia_remision::devolucion_guia_remision($guia_remision->id);

            return response()->json([
                'success' => true,
                'message' => 'Guía anulada correctamente',
                'guia_remision' => $guia_remision
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function seleccionar()
    {

        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = Kardex_entrada::where('estado', 2)->first();
        if (empty($existe_id)) {
            return redirect()->route('kardex-entrada.index');
        }

        $activos = Cotizacion::where('estado_aprovar', '1')->get();
        return view('transaccion.venta.guia_remision.selecionar_cotizacion', compact('activos'));
    }

    public function cotizacion($id)
    {
        $cotizacion = Cotizacion::find($id);
        $cotizacion_registro = Cotizacion_factura_registro::where('cotizacion_id', $id)->get();
        $cotizacion_registro_boleta = Cotizacion_boleta_registro::where('cotizacion_id', $id)->get();

        $productos = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->get();

        // SEPÁRADO POR MONEDAS TOMADO DE COTIZACION FACTURAR
        // $moneda1=Moneda::where('principal',1)->first();
        // $moneda2=Moneda::where('principal',0)->first();
        // $cotizacion_moneda = $cotizacion->moneda_id;
        // if($cotizacion_moneda==$moneda1->id){
        //     if ($moneda1->tipo == 'nacional') {
        //         foreach ($productos as $index => $producto) {
        //             $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
        //             $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
        //             $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        //             $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
        //         }
        //     }else{
        //         foreach ($productos as $index => $producto) {
        //             $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
        //             $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index];
        //             $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        //             $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
        //         }
        //     }
        // }elseif($cotizacion_moneda==$moneda2->id){
        //     if ($moneda2->tipo == 'extranjera'){
        //         foreach ($productos as $index => $producto) {
        //             $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
        //             $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
        //             $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        //             $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
        //         }
        //     }else{
        //         foreach ($productos as $index => $producto) {
        //             $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
        //             $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index];
        //             $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        //             $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
        //         }
        //     }
        // }

        foreach ($productos as $index => $producto) {
            $utilidad[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional') * ($producto->utilidad - $producto->descuento1) / 100;
            $array[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional') + $utilidad[$index];
            $array_cantidad[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->sum('cantidad');
            $array_promedio[] = kardex_entrada_registro::where('producto_id', $producto->id)->where('estado', 1)->avg('precio_nacional');
        }
        $clientes = Cliente::all();
        $vehiculo = Vehiculo::where('estado_activo', 0)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        return view('transaccion.venta.guia_remision.create_2', compact('cotizacion', 'productos', 'clientes', 'array', 'array_cantidad', 'igv', 'array_promedio', 'empresa', 'cotizacion_registro', 'vehiculo', 'cotizacion_registro_boleta'));
    }

    public function exportarGuias(Request $request)
    {
        $ids = $request->json('guia_ids');

        if (!empty($ids)) {
            $export = new GuiaRemisionExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new GuiaRemisionExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'tipo'   => $request->input('tipo_coti'),
            ]);
        }

        return Excel::download(
            $export,
            'Guías de Remisión_' . now('America/Lima')->format('Y-m-d') . '.xlsx'
        );
    }

    public function printMultiple(Request $request)
    {
        try {
            // Acepta 'guia_ids[]' (GET) o 'ids' (form oculto)
            $ids = $request->input('guia_ids', $request->input('ids', []));
            if (empty($ids) || !is_array($ids)) {
                return back()->withErrors(['No se seleccionaron guías para imprimir.']);
            }

            $guias = Guia_remision::with([
                    'cliente',
                    'vehiculo',
                    'personal',
                    'almacen',
                    // 'vehiculo_publicos', // <- quítalo si NO existe relación
                ])
                ->whereIn('id', $ids)
                ->get();

            if ($guias->count() !== count($ids)) {
                return back()->withErrors(['Algunas guías seleccionadas no existen.']);
            }

            $registros = g_remision_registro::with([
                    'producto.marcas_i_producto',
                    'producto.unidad_i_producto',
                ])
                ->whereIn('guia_remision_id', $ids)
                ->orderBy('guia_remision_id')
                ->orderBy('id')
                ->get()
                ->groupBy('guia_remision_id');

            $guiasData = [];
            foreach ($guias as $g) {

                $textoQR = $this->generarTextoQRGuiaRemision($g, $g->id);
                $qrCode  = $this->generarImagenQR($textoQR);

                $guiasData[] = [
                    'guia'      => $g,
                    'registros' => $registros[$g->id] ?? collect(),
                    'qrCode'    => $qrCode,
                ];
            }

            $empresa = Empresa::first();
            $banco   = Banco::where('estado','0')->get();
            $igv     = Igv::first();

            return view('transaccion.comprobantes.guia_remision.print_multiple', compact(
                'guiasData','empresa','banco','igv'
            ));

        } catch (\Exception $e) {
            return back()->withErrors(['Error al procesar la impresión múltiple: '.$e->getMessage()]);
        }
    }
    public function downloadMultiplePDFs(Request $request)
    {
        try {
            $guiaIds = $request->input('guia_ids', []);

            if (empty($guiaIds) || !is_array($guiaIds)) {
                return back()->with('error', 'No se seleccionaron guías de remisión para descargar.');
            }

            if (count($guiaIds) === 1) {
                return $this->downloadSinglePDF($guiaIds[0]);
            }

            $guias = Guia_remision::whereIn('id', $guiaIds)->get();

            if ($guias->count() !== count($guiaIds)) {
                return back()->with('error', 'Algunas guías de remisión seleccionadas no existen.');
            }

            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zipName = 'Guias_Remision_' . date('Y-m-d_H-i-s') . '.zip';
            $tempZip = $tempDir . DIRECTORY_SEPARATOR . $zipName;

            if (file_exists($tempZip)) {
                @unlink($tempZip);
            }

            $zip = new ZipArchive();

            if ($zip->open($tempZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return back()->with('error', 'Error al crear el archivo ZIP');
            }

            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', 0)->count();
            $empresa = Empresa::first();

            foreach ($guias as $guia_remision) {
                try {
                    $guia_registro = g_remision_registro::where('guia_remision_id', $guia_remision->id)->get();
                    $y = 1;
                    $textoQR = $this->generarTextoQRGuiaRemision($guia_remision, $id);
                    $qrCode  = $this->generarImagenQR($textoQR);

                    $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact(
                        'guia_remision',
                        'guia_registro',
                        'banco',
                        'empresa',
                        'banco_count',
                        'y',
                        'qrCode',
                        'textoQR'
                    ));

                    $pdfContent = $pdf->output();

                    $codigoGuia = preg_replace('/[^a-zA-Z0-9_-]/', '_', $guia_remision->cod_guia);
                    $fileName = 'GR_' . $codigoGuia . '.pdf';
                    $zip->addFromString($fileName, $pdfContent);

                } catch (\Exception $e) {
                    continue;
                }
            }

            $zip->close();
            unset($zip);
            clearstatcache(true, $tempZip);
            usleep(100000);

            if (!file_exists($tempZip) || filesize($tempZip) == 0) {
                @unlink($tempZip);
                return back()->with('error', 'El archivo ZIP no se creó correctamente');
            }

            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipName . '"');
            header('Content-Length: ' . filesize($tempZip));
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: public');

            readfile($tempZip);
            @unlink($tempZip);

            exit;

        } catch (\Exception $e) {
            return back()->with('error', 'Error al descargar guías de remisión: ' . $e->getMessage());
        }
    }

    private function downloadSinglePDF($id)
    {
        try {
            $guia_remision = Guia_remision::find($id);

            if (!$guia_remision) {
                return back()->with('error', 'Guía de remisión no encontrada.');
            }

            $guia_registro = g_remision_registro::where('guia_remision_id', $id)->get();
            $banco = Banco::where('estado', 0)->get();
            $banco_count = Banco::where('estado', 0)->count();
            $empresa = Empresa::first();
            $y = 1;
            $textoQR = $this->generarTextoQRGuiaRemision($guia_remision, $id);
            $qrCode  = $this->generarImagenQR($textoQR);

            $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact(
                'guia_remision',
                'guia_registro',
                'banco',
                'empresa',
                'banco_count',
                'y',
                'qrCode',
                'textoQR'
            ));

            return $pdf->download('GR_' . $guia_remision->cod_guia . '.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function pdfLink($id)
    {
        $banco_count = Banco::where('estado', '0')->count();
        $guia_remision = Guia_remision::find($id);
        $guia_registro = g_remision_registro::where('guia_remision_id', $guia_remision->id)->get();
        $banco = Banco::where('estado', '0')->get();
        $empresa = Empresa::first();
        $y = 0;
        $textoQR = $this->generarTextoQRGuiaRemision($guia_remision, $id);
        $qrCode  = $this->generarImagenQR($textoQR);

        $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact('guia_remision', 'guia_registro', 'banco', 'empresa', 'banco_count', 'y','qrCode','textoQR'));

        return $pdf->stream('GR - '.$guia_remision->cod_guia .'.pdf');
    }

    /**
     * Genera el texto (URL) del código QR para la guía de remisión
     *
     * @param \App\Guia_remision $guia_remision
     * @param int $id
     * @return string
     */
    private function generarTextoQRGuiaRemision($guia_remision, $id)
    {
        try {
            // Genera la URL completa para el preview del PDF
            $url = route('guia_remision.pdfLink', $id);

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
            $guia_r = Guia_remision::find($id);
            if ($guia_r) {
                $codigo = substr(md5($id . env('APP_KEY') . 'guia_remision'), 0, 22);

                $pdfUrl = url("guia_remision/share/{$codigo}");

                $mensaje .= "{$pdfUrl}\n";
            }
        }

        $mensajeCodificado = urlencode($mensaje);
        $whatsappUrl = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return redirect()->away($whatsappUrl);
    }

    public function descargarPorCodigo($codigo)
    {
        $guias_r = Guia_remision::all();

        foreach ($guias_r as $guia) {
            if (substr(md5($guia->id . env('APP_KEY') . 'guia_remision'), 0, 22) === $codigo) {
                return redirect()->route('pdf_guia', $guia->id);
            }
        }

        abort(404);
    }

    public function enviarCorreoDirecto(Request $request, $id)
    {
        try {
            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $guia_remision = Guia_remision::find($id);
            $guia_registro = G_remision_registro::where('guia_remision_id', $id)->get();
            $banco = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();
            $empresa = Empresa::first();

            // Generar PDF
            $archivo = 'PDF-DOC-' . $guia_remision->cod_guia . '-' . $empresa->ruc . ".pdf";
            $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact('guia_remision', 'guia_registro', 'banco', 'empresa', 'banco_count'));
            $content = $pdf->download();
            $especif = $date . $archivo;
            Storage::disk('mailbox')->put($especif, $content);

            $xml_file = null;
            if ($guia_remision->g_electronica == 1) {
                $xml_file = $empresa->ruc . '-09-' . $guia_remision->cod_guia . '.xml';
            }

            // Preparar correos
            $emails = $request->get('emails', []);
            $emails = array_filter($emails);

            if (empty($emails)) {
                Storage::disk('mailbox')->delete($especif);
                return response()->json([
                    'success' => false,
                    'message' => 'Debes ingresar al menos un correo.'
                ], 400);
            }

            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Guía de Remisión - " . $guia_remision->cod_guia;
            $mensaje_html = "Estimado cliente, adjuntamos la guía de remisión " . $guia_remision->cod_guia;
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            $correos_envios = array_merge($emails, [$config_email->email_backup]);
            $mails_array = array_filter($correos_envios);

            $pdfile = public_path() . '/archivos/' . $especif;

            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            $message->attach(\Swift_Attachment::fromPath($pdfile));

            // Adjuntar XML si existe
            if ($xml_file && file_exists(public_path() . '/facturas_electronicas/' . $xml_file)) {
                $xml_path = public_path() . '/facturas_electronicas/' . $xml_file;
                $message->attach(\Swift_Attachment::fromPath($xml_path));
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

                $mail = new EmailBandejaEnvios;
                $mail->id_usuario = auth()->user()->id;
                $mail->destinatario = $yourEmail;
                $mail->remitente = implode(', ', $emails);
                $mail->asunto = $titulo;
                $mail->mensaje = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado = '0';
                $mail->fecha_hora = Carbon::now();
                $mail->save();

                $archivo_pdf = new EmailBandejaEnviosArchivos;
                $archivo_pdf->id_bandeja_envios = $mail->id;
                $archivo_pdf->archivo = $archivo;
                $archivo_pdf->fecha_hora = $date;
                $archivo_pdf->save();

                if ($xml_file) {
                    $guardar_email_archivo = new EmailBandejaEnviosArchivos;
                    $guardar_email_archivo->id_bandeja_envios = $mail->id;
                    $guardar_email_archivo->archivo = $xml_file;
                    $guardar_email_archivo->fecha_hora = $date;
                    $guardar_email_archivo->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Correo enviado exitosamente a: ' . implode(', ', $emails)
                ]);
            }

            Storage::disk('mailbox')->delete($especif);
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Verifica tu configuración.'
            ], 500);

        } catch (\Exception $e) {
            if (isset($especif)) {
                Storage::disk('mailbox')->delete($especif);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function enviarCorreoMultiple(Request $request)
    {
        try {
            $email = $request->get('email');
            $guia_remision_ids = $request->get('guia_ids', []);

            if (empty($guia_remision_ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se seleccionaron guías de remisión para enviar.'
                ], 400);
            }

            if (empty($email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El correo electrónico es requerido.'
                ], 400);
            }

            $id_usuario = auth()->user()->id;
            $config_email = EmailConfiguraciones::where('id_usuario', $id_usuario)->first();

            if (!$config_email) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes configuración de email. Ve a configuración.'
                ], 400);
            }

            $fecha = Carbon::now();
            $data_g = str_replace(' ', '_', $fecha);
            $date = str_replace(':', '-', $data_g);

            $empresa = Empresa::first();
            $banco = Banco::where('estado', '0')->get();
            $banco_count = Banco::where('estado', '0')->count();

            // Configuración de email
            $yourEmail = $config_email->email;
            $firma = $config_email->firma;
            $alto = $config_email->alto_firma;
            $ancho = $config_email->ancho_firma;

            $titulo = "Guías de Remisión - " . count($guia_remision_ids) . " documento(s)";
            $mensaje_html = "Estimado cliente, adjuntamos las guías de remisión solicitadas.";
            $mensaje = view('email_html.email_send_layout', compact('empresa', 'mensaje_html', 'firma', 'alto', 'ancho'));

            // Agregar email backup si existe
            $correos_envios = [$email, $config_email->email_backup];
            $mails_array = array_filter($correos_envios);

            // Configurar transporte de email
            $transport = (new \Swift_SmtpTransport($config_email->smtp, $config_email->port, $config_email->encryption))
                ->setUsername($config_email->email)
                ->setPassword($config_email->password);
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();

            $message = (new \Swift_Message($yourEmail))
                ->setFrom([$yourEmail => $titulo])
                ->setTo($mails_array)
                ->setBody($mensaje, 'text/html');

            $archivos_temporales = [];
            $archivos_xml = [];

            // Generar y adjuntar cada PDF
            foreach ($guia_remision_ids as $guia_remision_id) {
                $guia_remision = Guia_remision::find($guia_remision_id);
                if (!$guia_remision) continue;

                $guia_registro = G_remision_registro::where('guia_remision_id', $guia_remision_id)->get();

                // Generar PDF
                $archivo = 'PDF-DOC-' . $guia_remision->cod_guia . '-' . $empresa->ruc . ".pdf";
                $pdf = PDF::loadView('transaccion.venta.guia_remision.pdf', compact('guia_remision', 'guia_registro', 'banco', 'empresa', 'banco_count'));
                $content = $pdf->download();
                $especif = $date . $archivo;
                Storage::disk('mailbox')->put($especif, $content);

                $pdfile = public_path() . '/archivos/' . $especif;
                $message->attach(\Swift_Attachment::fromPath($pdfile));

                $archivos_temporales[] = $especif;

                if ($guia_remision->g_electronica == 1) {
                    $xml_file = $empresa->ruc . '-09-' . $guia_remision->cod_guia . '.xml';
                    $xml_path = public_path() . '/facturas_electronicas/' . $xml_file;
                    if (file_exists($xml_path)) {
                        $message->attach(\Swift_Attachment::fromPath($xml_path));
                        $archivos_xml[] = $xml_file;
                    }
                }
            }

            // Enviar correo
            if ($mailer->send($message)) {
                $texto = strip_tags($mensaje_html);

                $mail = new EmailBandejaEnvios;
                $mail->id_usuario = auth()->user()->id;
                $mail->destinatario = $yourEmail;
                $mail->remitente = $email;
                $mail->asunto = $titulo;
                $mail->mensaje = $mensaje_html;
                $mail->mensaje_sin_html = $texto;
                $mail->estado = '0';
                $mail->fecha_hora = Carbon::now();
                $mail->save();

                // Guardar archivos PDF en bandeja
                foreach ($archivos_temporales as $archivo_temp) {
                    $archivo_pdf = new EmailBandejaEnviosArchivos;
                    $archivo_pdf->id_bandeja_envios = $mail->id;
                    $archivo_pdf->archivo = $archivo_temp;
                    $archivo_pdf->fecha_hora = $date;
                    $archivo_pdf->save();
                }

                foreach ($archivos_xml as $xml_file) {
                    $archivo_xml = new EmailBandejaEnviosArchivos;
                    $archivo_xml->id_bandeja_envios = $mail->id;
                    $archivo_xml->archivo = $xml_file;
                    $archivo_xml->fecha_hora = $date;
                    $archivo_xml->save();
                }

                $this->limpiarArchivosViejos(2880);

                return response()->json([
                    'success' => true,
                    'message' => 'Se enviaron ' . count($guia_remision_ids) . ' guía(s) de remisión exitosamente a: ' . $email
                ]);
            }

            foreach ($archivos_temporales as $archivo_temp) {
                Storage::disk('mailbox')->delete($archivo_temp);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo. Verifica tu configuración.'
            ], 500);

        } catch (\Exception $e) {
            if (isset($archivos_temporales) && !empty($archivos_temporales)) {
                foreach ($archivos_temporales as $archivo_temp) {
                    Storage::disk('mailbox')->delete($archivo_temp);
                }
            }
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function limpiarArchivosViejos($minutos = 2880)
    {
        try {
            $disk = Storage::disk('mailbox');
            $archivos = $disk->allFiles();

            foreach ($archivos as $file) {
                if (preg_match('/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}/', $file)) {
                    $lastModified = $disk->lastModified($file);
                    $tiempoTranscurrido = now()->timestamp - $lastModified;

                    if ($tiempoTranscurrido > ($minutos * 60)) {
                        $disk->delete($file);
                    }
                }
            }

        } catch (\Exception $e) {
        }
    }
}
