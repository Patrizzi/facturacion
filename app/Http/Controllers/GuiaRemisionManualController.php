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
            $agrupar_almacen=GuiaRemisionManual::where('almacen_id',$almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_remision_m, '-'), 1);
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
        
        return $product->peso;
    }
    public function almacen_remision_manual(Request $request){
        $almacen = $request->get('almacen');
        $id_almacen = Almacen::where('id',$almacen)->first();
        $almacen_serie_remision= Codigo_guia_almacen::where('almacen_id',$id_almacen->id)->first();/*Codigo que brinda sunat a cada sucursal*/
        $almacen_codigo = Codigo_guia_almacen::orderBy('serie_remision_m','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO
        
        if ($almacen_serie_remision->cod_remision_m=='NN') {
            $agrupar_almacen=GuiaRemisionManual::where('almacen_id',$almacen)->get()->last();
            $numero = substr(strstr($agrupar_almacen->cod_remision_m, '-'), 1);
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
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GuiaRemisionManual  $guiaRemisionManual
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
