<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Categoria;
use App\ConfiguracionGuiaIngresos;
use App\Empresa;
use App\guia_r_traslado_registro;
use App\InventarioInicial;
use App\Kardex_entrada;
use App\Moneda;
use App\Motivo;
use App\Producto;
use App\Provedor;
use App\TipoCambio;
use App\User;
use App\kardex_entrada_registro;
use App\GuiaRTraslado;
use App\MotivoTraslado;
use App\Personal;
use Carbon\Carbon;
use DB;
use App\Stock_producto;
use App\Stock_almacen;
use App\TransportePublico;
use App\Vehiculo;
use Illuminate\Http\Request;

class KardexEntradaDistribucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kardex_distribucion=Kardex_entrada::where('tipo_registro_id',"3")->get();
        // return count($kardex_distribucion);
        if (count($kardex_distribucion) != 0) {
            // return "a";
            foreach($kardex_distribucion as $index => $kd){
                // return $kd;
                $cantidad_tot[$index] = kardex_entrada_registro::where('kardex_entrada_id', $kd->id)->sum('cantidad_inicial');
                $cantidad_prod[$index] = kardex_entrada_registro::where('kardex_entrada_id', $kd->id)->count();
                $guia_remi_kardex_dist = GuiaRTraslado::where('id_kardex',$kd->id)->first();
                if(isset($guia_remi_kardex_dist)){
                    $kd->cod_guia_remisio = $guia_remi_kardex_dist->cod_guia;
                }else{
                    $kd->cod_guia_remisio =  'Sin guia';
                }
            }
            
        } else {
            // return "b";
            $cantidad_tot = 0 ;
            $cantidad_prod = 0;
        }
        
        // return $kardex_distribucion;
        $almacen = Almacen::all();

        // return kardex_entrada_registro::where('kardex_entrada_id', 96)->sum('cantidad_inicial');
        return view('inventario.kardex.entrada.distribucion_producto.index',compact('kardex_distribucion','almacen', 'cantidad_tot','cantidad_prod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kardex_entrada=Kardex_entrada::where('almacen_id',1)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',1)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','!=','0')->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','!=','0')->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
             return redirect()->route('kardex-entrada-Distribucion.index')->with('repite', 'No hay productos en el almacen principal!');
        }

        $lista=array_values(array_unique($prod));
        sort($lista, SORT_NUMERIC);
        $lista_count=count($lista);

        for($x=0;$x<$lista_count;$x++){
           $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }
        // return $productos;

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $almacenes=Almacen::where('estado','0')->where('id','!=',1)->get();
        $alm_principal=Almacen::where('id',1)->first();

        $categorias=Categoria::all();
        $user_login =auth()->user()->id;
        $usuario=User::where('id',$user_login)->first();


         //* Creacion en primera instancia sobre activar o no el boton de Crear Guia de Remision
         $configuracion = ConfiguracionGuiaIngresos::where('tipo_guia','kardex_distribucion')->first();
         // return $configuracion;
         if(!isset($configuracion)){
             //* Guardar por primera vez el estado y retornar variable que si o no
             $configuracion_gui = new ConfiguracionGuiaIngresos();
             $configuracion_gui->nombre = 'remision_kardex';
             $configuracion_gui->tipo_guia = 'kardex_distribucion';
             $configuracion_gui->estado = 0;
             $configuracion_gui->save();
         }
         $check_config =  ConfiguracionGuiaIngresos::where('tipo_guia','kardex_distribucion')->first();
        //  return $check_config;
         //*
        return view('inventario.kardex.entrada.distribucion_producto.create',compact('almacenes','productos','categorias','usuario','alm_principal','check_config'));
        //   manipulacion de la vista create para kardex dependiendo de los productosgit pushgit
    }
    public function ajax_direccion_almacen(Request $request){
        $almacen = $request->get('almacen');
        $almacen_encontrado=Almacen::where('id',$almacen)->first();
        return $almacen_encontrado->direccion.' - '.$almacen_encontrado->cod_postal;
    }
    
    public function stock_ajax_distribucion(Request $request){
        // return $request;
        $articulo=$request->get('articulo');
        $id=explode(" ",$articulo);
        $almacen_encontrado=Almacen::where('id',1)->first();

        // //buscador del almacen perteneciente kardex_entrada
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                    $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('producto_id',$id[0])->get();
                    foreach( $nueva as $nuevas){
                        $id_kardex_entrada_registro[]=$nuevas->id;
                    }
            }
        }
        $stock=Kardex_entrada_registro::whereIn('id',$id_kardex_entrada_registro)->where('estado',1)->sum('cantidad');

        return $stock;
    }

    // public function guia_interna(Request $request){

    //     $empresa = Empresa::first();
    //     $ultima_entrada = GuiaRTraslado::orderby('created_at','DESC')->first();
    //     // return $ultima_entrada;

    //     if(isset($ultima_entrada)){
    //       $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
    //       $numero++;
    //       $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
    //       $codigo_guia='GRT'.'-'.$cantidad_registro;
    //     }else{
    //       $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
    //       $codigo_guia='GRT'.'-'.$cantidad_registro;
    //     }
        
    //     $motivo_traslado = MotivoTraslado::all();
    //     $vehiculo = Vehiculo::where('estado_activo', 0)->get();
    //     $transporte_publico = TransportePublico::where('estado', 0)->get();

    //     // return $vehiculo;
    //     return view('inventario.kardex.guias.guia',compact('empresa','codigo_guia','motivo_traslado','vehiculo','transporte_publico'));
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $var = $request->get('past1');
        // return $var;
        if($request->get('estado_check') != null){
            // return "b";
            $almacen_str = $sep_esc = explode(' \ ',$request->get('almacen'));
            $almacen_receptor = Almacen::where('id',$almacen_str[0])->first();
            $almacen_principal  = Almacen::where('id', 1)->first();
            // $transporte = $request->get('');
            $observacion = $request->get('observacion');
            $motivo = $request->get('motivo');
            $fecha_emision = Carbon::now()->format('d/m/Y');
            // return $fecha_emision;
            $empresa = Empresa::first();
            
            // return $ultima_entrada;
            foreach($request->get('registro_opt') as $item => $articulo){
                $productos[] = Producto::where('id', $articulo)->first();
                $stock[] =  Stock_almacen::where('almacen_id',1)->where('producto_id',$productos[$item]->id)->first();
                $unidad[] = $request->get('unidades')[$item];
                $cantidad[] = $request->get('cantidad')[$item];
                $sep_esc = explode(' ',$productos[$item]->peso);
                $peso[] = $sep_esc[0];
            }
            // return $productos;
            $codigo_guia = GuiaRTraslado::codigo_guia_tr();
            // return  $codigo_guia;
            // $motivo_traslado = MotivoTraslado::all();
            $vehiculo = Vehiculo::where('estado_activo', 0)->get();
            $transporte_publico = TransportePublico::where('estado', 0)->get();
            $personal = Personal::where('id', '!=', 1)->where('licencia','!=', null)->get();

            $punto_partida = $request->get('punto_partida');
            $llegada = $request->get('llegada');

            return view('inventario.kardex.guias.guia_distribucion',compact('empresa','codigo_guia','almacen_receptor','observacion','productos','stock','unidad','cantidad','peso','almacen_principal','fecha_emision','motivo','vehiculo','transporte_publico','personal','fecha_emision','punto_partida','llegada'));

        }
        // return "a";
        // return $request;

        $codigo_guia_doc = GuiaRTraslado::codigo_guia_tr();
        // return $request;

        //Variables de entorno
        $almacen_input=$request->input('almacen');
        
        $almacen = explode(' ',$almacen_input);
        $almacen_json=Almacen::where('id',$almacen[0])->first();  
        // return $almacen_json;
        


        // return $request;

        //Cantidades extraidas
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);
        //Articulos
        $articulo_prod = $request->input('registro_opt');
        $articulo_p=count($articulo_prod);

        //Primer verificacion de articulos en validacion del if

        //validacion para la no incersion de dobles articulos
        $count = array_count_values($articulo_prod);
        foreach ($count as $producto => $cantidad2) {
            if ($cantidad2 >= 2) {
                return redirect()->route('kardex-entrada-Distribucion.create')->with('repite', 'Error de insercion de articulos doble!');
            }
        }

        //Validacion para cantidad
        for ($i=0; $i < $articulo_p; $i++){
            $articulo_c=$articulo_prod[$i];
            $cantidad_c=$request->get('cantidad')[$i];
            $consulta_cantidad=Stock_producto::where('producto_id',$articulo_c)->first();
            if ($cantidad_c > $consulta_cantidad->stock) {
                return redirect()->route('kardex-entrada-Distribucion.create')->with('repite', 'Cantidad mayor al Stock!');
            }
        }
        // return $request;

        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }


        //creacion del codigo guia
        // $codigo_guia="GD-00000002";
        $ultima_entrada = Kardex_entrada::where('tipo_registro_id','=','3')->orderby('created_aT','DESC')->first();

        if(isset($ultima_entrada)){
          $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
          $numero++;
          $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
          $codigo_guia='GD'.'-'.$cantidad_registro;
        }else{
          $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
          $codigo_guia='GD'.'-'.$cantidad_registro;
        }
        //fin codigo guia
        // return $request;


        if($articulo_p == $count_cantidad_p){
            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            $kardex_entrada=new Kardex_entrada();
            $kardex_entrada->motivo_id=1;
            $kardex_entrada->codigo_guia=$codigo_guia;
            $kardex_entrada->provedor_id=1;
            $kardex_entrada->guia_remision="NN";
            $kardex_entrada->categoria_id='1';
            $kardex_entrada->factura="0";
            $kardex_entrada->almacen_id=$almacen_json->id;
            $kardex_entrada->almacen_emisor_id=1;
            $kardex_entrada->almacen_receptor_id=$almacen_json->id;
            $kardex_entrada->moneda_id=1;
            $kardex_entrada->tipo_registro_id=3;
            $kardex_entrada->estado=1;
            $kardex_entrada->user_id=auth()->user()->id;
            $kardex_entrada->informacion="0";
            $kardex_entrada->save();


            //* Guardado de la Guia de Remision Remitente (opcionasl(?))
            if($request->get('past1') == 'view_store'){
                $tipo_trans = $request->get('tipo_transporte');
                $guia_tras = new GuiaRTraslado;
                $guia_tras->id_kardex = $kardex_entrada->id;
                $guia_tras->cod_guia = $codigo_guia_doc;
                $guia_tras->motivo = $kardex_entrada->motivo->nombre;
                
                $guia_tras->tipo_transporte = $tipo_trans;
                if ($tipo_trans == 1) {
                    $guia_tras->vehiculo_publico = $request->get('vehiculo_publico');
                } elseif ($tipo_trans == 2) {
                    $guia_tras->vehiculo_id = $request->get('vehiculo');
                    $guia_tras->conductor_id = $request->get('conductor');
                }
                
                $guia_tras->fecha_emision = $request->get('fec_emision');
                $guia_tras->fecha_entrega = $request->get('fecha_entrega');
                $guia_tras->almacen_emisor = 1;
                $guia_tras->almacen_receptor = $almacen_json->id;
                $guia_tras->observaciones = $request->get('observaciones');
                $guia_tras->estado = 0; //* ESTADO 0 = ACTIVO
                $guia_tras->save();
            }

           
            //contador de valores de articulos (re verificacion)
            $articulo = $request->input('registro_opt');
            $count_articulo=count($articulo);

            $cantidad= $request->input('cantidad');
            $count_cantidad=count($cantidad);
            // return $count_articulo;
            if($count_articulo == $count_cantidad ){
                for($i=0;$i<$count_articulo;$i++){

                     //* KARDEX REGISTRO para documento
                    
                    if($request->get('past1') == 'view_store'){
                        $guia_tra_reg = new guia_r_traslado_registro();
                        $guia_tra_reg->id_guia_r_traslado = $guia_tras->id;
                        $guia_tra_reg->producto_id = $articulo_prod[$i];
                        $guia_tra_reg->stock = $request->get('stock')[$i];
                        $guia_tra_reg->unidad = $request->get('unidades')[$i];
                        $guia_tra_reg->cantidad = $request->get('cantidad')[$i];
                        $guia_tra_reg->cantidad_total = $request->get('total')[$i];
                        $guia_tra_reg->numero_series = $request->get('n_series')[$i];
                        $guia_tra_reg->peso = $request->get('peso_tot')[$i];
                        $guia_tra_reg->save();
                    }
                    //Creacion del nuevo registro de kardex entrada
                    $kardex_entrada_registro=new kardex_entrada_registro();
                    $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                    $kardex_entrada_registro->producto_id=$articulo_prod[$i];
                    $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                    $kardex_entrada_registro->precio_nacional=0;
                    $kardex_entrada_registro->precio_extranjero=0;
                    $kardex_entrada_registro->cambio=$cambio->compra;
                    $kardex_entrada_registro->unidad=$request->get('unidades')[$i];
                    $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                    $kardex_entrada_registro->unidad_cantidad=$request->get('unidades')[$i] *  $request->get('cantidad')[$i];
                    $kardex_entrada_registro->estado=1;
                    // $kardex_entrada_registro->estado_devolucion;
                    $kardex_entrada_registro->tipo_registro_id=3;
                    $kardex_entrada_registro->almacen_id=$kardex_entrada->almacen_id;
                    $kardex_entrada_registro->save();

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('tipo_registro_id','=',1)->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('tipo_registro_id','=',1)->sum('cantidad');


                    //buble para la cantidad

                    $cantidad=0;
                    foreach($comparacion as $comparaciones){
                        $cantidad=$comparaciones->cantidad+$cantidad;
                    }
                    // return $cantidad;
                    if(isset($comparacion)){
                        $var_cantidad_entrada=$kardex_entrada_registro->cantidad;

                        $contador=0;
                        foreach ($comparacion as $p) {
                            if($p->cantidad>$var_cantidad_entrada){
                                $cantidad_mayor=$p->cantidad;
                                $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                                $p->cantidad=$cantidad_final;
                                if($cantidad_final==0){
                                    $p->estado=0;
                                    $p->save();
                                    break;
                                }else{
                                    $p->save();
                                    break;
                                }
                            }elseif($p->cantidad==$var_cantidad_entrada){
                                $p->cantidad=0;
                                $p->estado=0;
                                $p->save();
                                break;
                            }
                            else{
                                $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                                $p->cantidad=0;
                                $p->estado=0;
                                $p->save();

                            }

                        }
                    }
                    //$almacen_json = Almacen saliente
                    $almacen_principal = Almacen::where('principal','1')->first();
                    // return $almacen_principal->id;
                    //suma de cantidades a la tabla por alamacen secundario elegido
                    Stock_almacen::ingreso($almacen_json->id,$articulo_prod[$i],$kardex_entrada_registro->cantidad);
                    //resta de cantidades a la tabla principal
                    Stock_almacen::egreso($almacen_principal->id,$articulo_prod[$i],$kardex_entrada_registro->cantidad);
                }
            kardex_entrada_registro::stock_producto_precio();
            }else{
                return "Error fatal: por favor comunicarse con soporte inmediatamente";
            }
        }else{
            return redirect()->route('kardex-entrada-Distribucion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
          // return "error campo de tabla";
        }
        // return $comparacion

        return redirect()->route('kardex-entrada-Distribucion.index');
        // return "exito";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $mi_empresa=Empresa::first();
      $moneda_nacional=Moneda::where('id','1')->first();
      $moneda_extranjera=Moneda::where('id','2')->first();
      $kardex_entradas=Kardex_entrada::find($id);
      $kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
      $almacen = Almacen::where('principal','1')->first();
      $guia_r_traslado = GuiaRTraslado::where('id_kardex', $kardex_entradas->id)->first();
      if(isset($guia_r_traslado)){
        $guia_r_tras_reg = guia_r_traslado_registro::where('id_guia_r_traslado', $guia_r_traslado->id )->get();
      }else{
        $guia_r_traslado = [0];
        $guia_r_tras_reg = [0,0];
      }
      return view('inventario.kardex.entrada.distribucion_producto.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera','almacen','guia_r_traslado','guia_r_tras_reg'));
      // return $kardex_entradas;
    }

    public function print($id){
        $mi_empresa=Empresa::first();
        $moneda_nacional=Moneda::where('id','1')->first();
        $moneda_extranjera=Moneda::where('id','2')->first();
        $kardex_entradas=Kardex_entrada::find($id);
        $kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
        $almacen = Almacen::where('principal','1')->first();
        $guia_r_traslado = GuiaRTraslado::where('id_kardex', $kardex_entradas->id)->first();
        $guia_r_tras_reg = guia_r_traslado_registro::where('id_guia_r_traslado', $guia_r_traslado->id )->get();
        return view('inventario.kardex.guias.guia_distr_print',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera','almacen','guia_r_traslado','guia_r_tras_reg'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


    }

  }
