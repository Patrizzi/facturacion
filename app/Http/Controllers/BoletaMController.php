<?php

namespace App\Http\Controllers;

use App\boleta_m;
use App\Igv;
use App\Codigo_guia_almacen;
use App\Almacen;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use App\Forma_pago;
use App\Cliente;
use App\Producto;
use App\TipoCambio;
use App\Moneda;
use App\Empresa;
use App\Tipo_operacion_f;
use Illuminate\Http\Request;

class BoletaMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boleta = Boleta_m::get();
        $igv = Igv::first();
        return view('transaccion.venta.boleta.boleta_manual.index', compact('boleta','igv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Forma de pago
        $forma_pagos=Forma_pago::all();

        // Cliente
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        // Personal
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();

        // Igv
        $igv=Igv::first();

        // Categoria
        $categoria='producto';
        
        // Productos
        $productos=Producto::where('estado_anular',1)->get();

        // Sucursal
        

        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::where('principal','1')->first();

        // Número de factura
        // $factura_numero="BB01-000001";
         // Empresa
        $empresa=Empresa::first();

        // Tipo de operación
        $tipo_operacion = Tipo_operacion_f::all();

        //Almacen
        $almacenes = Almacen::all();
        //cODIGO
        $sucursal =Almacen::where('id', '1')->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $cod_boleta_m = $cod_guia->cod_boleta_m;
        if(is_numeric($cod_boleta_m)){
            //expresion del numero de boleta
            $cod_boleta_m++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $boleta_nr = str_pad($cod_boleta_m, 8, "0", STR_PAD_LEFT);
        }else {
            //expresion del numero de boleta
            //GENERACION DEL N BOLETA
            $ultima_boleta = Boleta_m::where('almacen_id',$sucursal->id)->lastest()->first();
            $boleta_num = $ultima_boleta->cod_boleta_m;
            $boleta_num_string = explode("-", $boleta_num);
            $boleta_num_str = $boleta_num_string[1];
            $boleta_num = (int)$boleta_num_str;

            $almacen_codigo = Cod_guia_almacen::orderBy('serie_boleta_m','DESC')->lastest()->first();
            //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta_m+1;
                $boleta_num = 00000000;
            }else{
                $boleta_num = $cod_guia->serie_boleta_m;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 2, "0", STR_PAD_LEFT);
            $boleta_nr = str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero = "BA".$sucursal_nr."-".$boleta_nr;
        // return $boleta_numero;
        return view('transaccion.venta.boleta.boleta_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','factura_numero','empresa','tipo_operacion','almacenes','sucursal','boleta_numero'));

    }

    public function change_almacen_tipo(Request $request){
        // return $request;
        $almacen = $request->get('almacen');
        $sucursal =Almacen::where('id', $almacen)->first();
            // return $sucursal;
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $cod_guia_all = Codigo_guia_almacen::where('almacen_id', '!=' ,$sucursal->id)->get();

        $last_numb=Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
        if(!isset($last_numb) && !is_numeric($cod_guia->cod_boleta_m)){
            $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
            $almacen_igual->cod_boleta_m = 0;
            $almacen_igual->save();
        }
        foreach($cod_guia_all as $cod_gui){
            $serie_fac_m = $cod_gui->serie_boleta_m;
            if($cod_guia->serie_boleta_m == $serie_fac_m ){
                // $var[] = $cod_guia->serie_factura_m+1;
                $almacen_igual = Codigo_guia_almacen::find($sucursal->id);
                $almacen_igual->serie_boleta_m = $cod_guia->serie_boleta_m+1;
                $almacen_igual->save();
            }else{
                // $var[] = 0;
            }
        }

        $boleta_cod=$cod_guia->cod_boleta_m;
        if (is_numeric($boleta_cod)) {
            // expresión del numero de factura
            $boleta_cod++;
            $sucursal_nr = str_pad($cod_guia->serie_boleta_m, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($boleta_cod, 8, "0", STR_PAD_LEFT);
        }else{
                // expresión del numero de factura
                // GENERACIÓN DE NUMERO DE FACTURA
            $ultima_factura=Boleta_m::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_bol;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta_m','DESC')->latest()->first();
                //CONDICIONAL PARA QUE EMPIECE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_boleta_m+1;
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_boleta_m;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 2, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $boleta_numa="BA".$sucursal_nr."-".$factura_nr;
        return $boleta_numa;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //código para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id_name[$i]=strstr($articulos[$i], '|');
            $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),1);
            $producto_id[$i]=strstr($producto_id_3[$i], ' ', true);
            
        }
        return $producto_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function show(boleta_manual $boleta_manual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function edit(boleta_manual $boleta_manual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, boleta_manual $boleta_manual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\boleta_manual  $boleta_manual
     * @return \Illuminate\Http\Response
     */
    public function destroy(boleta_manual $boleta_manual)
    {
        //
    }
}
