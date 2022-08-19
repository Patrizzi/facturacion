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
use Barryvdh\DomPDF\Facade as PDF;

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
        return view('transaccion.venta.guia_remision.guia_manual.index',compact('guia_remision','almacen','conteo_almacen','almacen_primero','user_login'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = Empresa::first();
        $clientes = Cliente::get();
        $almacen = Almacen::get();
        $motivo_traslado = MotivoTraslado::all();
        $vehiculo = Vehiculo::where('estado_activo',0)->get();
        $transporte_publico = TransportePublico::where('estado',0)->get();
        $personal = Personal::where('id','!=',1)->get();
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
        return view('transaccion.venta.guia_remision.guia_manual.create',compact('empresa','clientes','almacen','motivo_traslado','vehiculo','transporte_publico','personal','productos','codigo_guia'));
    }

    public function ajax_producto(Request $request){
        $search = $request->search;
        if($search == ''){
            $productos = Producto::orderby('nombre','desc')->select('id','codigo_producto','codigo_original','nombre')->where('codigo_producto', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->orWhere('nombre', 'like', '%' .$search . '%')->limit(5)->get();
        }else{
            $productos = Producto::orderby('nombre','asc')->select('id','codigo_producto','codigo_original','nombre')->where('codigo_producto', 'like', '%' .$search . '%')->orWhere('nombre', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->limit(5)->get();
        }
        foreach($productos as $prods){
            $products_array[] = array(
                "id"=>$prods->id,
                "cod_prod"=>$prods->codigo_producto,
                "cod_origi"=>$prods->codigo_original,
                "nombre"=>$prods->nombre
            );
        }
        return $products_array;
    }
    public function peso_ajax(Request $request){
        $article = $request->get('articulo');
        $id = explode(" ",$article);

        $product = Producto::where('id',$id[0])->where('codigo_producto',$id[2])->where('codigo_original',$id[4])->first();

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
        // return $request
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

        
        /* Guardado en tabla  */
        $guia_remision_m = new GuiaRemisionManual();
        $guia_remision_m->cod_guia = $codigo_guia;
        $guia_remision_m->almacen_id = $almacen;
        $guia_remision_m->cliente_id = $cliente;
        $guia_remision_m->fecha_emision = $fecha_emision;
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
        $guia_remision_m = GuiaRemisionManual::find($id);
        $guia_remision_m_reg = GuiaRemisionMRegistros::where('guia_remision_m_id', $guia_remision_m->id)->get();
        
        
        // return $guia_remision_m_reg;
        return view('transaccion.venta.guia_remision.guia_manual.show',compact('guia_remision_m','guia_remision_m_reg','empresa'));
    }
    public function pdf($id){
        $empresa = Empresa::first();
        $guia_remision_m = GuiaRemisionManual::find($id);
        $guia_remision_m_reg = GuiaRemisionMRegistros::where('guia_remision_m_id', $guia_remision_m->id)->get();
        $i = 1;
        $pdf=PDF::loadView('transaccion.venta.guia_remision.guia_manual.pdf',compact('guia_remision_m','guia_remision_m_reg','empresa','i'));
        return $pdf->download('GuiaRemisionM - '.'.pdf');

        // return $guia_remision_m;
                
    }

    public function print($id)
    {
        $empresa = Empresa::first();
        $guia_remision_m = GuiaRemisionManual::find($id);
        $guia_remision_m_reg = GuiaRemisionMRegistros::where('guia_remision_m_id', $guia_remision_m->id)->get();
        
        
        // return $guia_remision_m_reg;
        return view('transaccion.venta.guia_remision.guia_manual.print',compact('guia_remision_m','guia_remision_m_reg','empresa'));
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
    public function destroy($id)
    {
        //
    }
}
