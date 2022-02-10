<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturacion_m;
use App\Facturacion_registro_m;
use App\Forma_pago;
use App\Cliente;
use App\Personal;
use App\Personal_venta;
use App\Igv;
use App\Producto;
use App\Servicios;
use App\Almacen;
use App\TipoCambio;
use App\Moneda;
use App\Empresa;
use App\Tipo_operacion_f;

use Carbon\Carbon;

class FacturacionMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturacion=Facturacion_m::all();
        return view('transaccion.venta.facturacion.facturacion_manual.index', compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

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
        $sucursal=1;
        $sucursal=Almacen::where('id',$sucursal)->first();

        // Servicios
        $servicios=Servicios::where('estado_anular',0)->get();

        if(count($servicios) == 0){
            return redirect()->route('servicios.index');
        }
        if(count($servicios) == 0){
            return back()->withErrors(['No hay Servicios Agregados: '.$sucursal->nombre.'']);
        }

        $servicios=Servicios::where('estado_anular',1)->get();

        // Tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        // Moneda
        $moneda=Moneda::get();

        // Número de factura
        $factura_numero="FA01-000001";

        // Empresa
        $empresa=Empresa::first();

        // Tipo de operación
        $tipo_operacion = Tipo_operacion_f::all();

        return view('transaccion.venta.facturacion.facturacion_manual.create',compact('productos','servicios','forma_pagos','clientes','personales','igv','moneda','p_venta','empresa','categoria','factura_numero','empresa','tipo_operacion'));
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
        
        // obtención de Cliente
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();

        // obtención de Código de factura
        $factura_numero="F001-000001";

        // obtención de buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        // obtención de Tipo de operación
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();

        // Guardado de facturación manual
        $facturacion=new facturacion_m;
        $facturacion->codigo_fac=$factura_numero;
        $facturacion->almacen_id =1;
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->guia_remision=$request->get('guia_r');
        $facturacion->cliente_id=$cliente_buscador->id;
        $facturacion->moneda_id=$request->get('moneda');
        $facturacion->forma_pago_id=$request->get('forma_pago');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->fecha_vencimiento=$request->get('fecha_vencimiento');
        $facturacion->cambio=$cambio->paralelo;
        $facturacion->observacion=$request->get('observacion');
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo_operacion_id= $busca_ope->id;
        $facturacion->tipo_documento_id = 2;
        $facturacion->save();

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores de articulo
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        // Registro de artículos
        if($count_articulo = $count_cantidad){

            // Bucle para registro de productos o servicios 
            for($i=0;$i<$count_articulo;$i++){

                // Llamado de producto y servicio para su diferenciación y registro propio
                $producto = Producto::where('codigo_producto',$producto_id[$i])->first();
                $servicio=Servicios::where('codigo_servicio',$producto_id[$i])->where('estado_anular',0)->first();

                if(isset($producto)){ //Guardado de facturación registro solo para productos 

                    $facturacion_registro= new Facturacion_registro_m();
                    $facturacion_registro->facturacion_m_id=$facturacion->id;
                    $facturacion_registro->producto_id=$producto->id;
                    $facturacion_registro->numero_serie=$request->get('numero_serie')[$i];
                    if($request->get('descripcion_item')[$i] == null){ 
                        $facturacion_registro->descripcion_item = null;
                    }else{ 
                        $facturacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $facturacion_registro->precio=$request->get('precio')[$i];
                    $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                    $facturacion_registro->descuento=$request->get('descuento')[$i];
                    $facturacion_registro->save();

                    //modificación para los tipos de afectación al producto y guardado a facturación
                    $facturacion_2=Facturacion_m::find($facturacion->id);
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $facturacion_2->op_gravada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    $facturacion_2->save();

                }else{ //Guardado de facturación registro solo para servicios 
                    
                    $facturacion_registro=new Facturacion_registro_m();
                    $facturacion_registro->facturacion_id=$facturacion->id;
                    $facturacion_registro->servicio_id=$servicio->id;
                    $facturacion_registro->precio=$request->get('precio')[$i];
                    $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                    $facturacion_registro->descuento=$request->get('cantidad')[$i];
                    $facturacion_registro->save(); 

                    //modificación para los tipos de afectación al servicio y guardado a facturación
                    $facturacion_2=Facturacion_m::find($facturacion->id);
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $facturacion_2->op_gravada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio*$facturacion_registro->cantidad,2);
                    }
                    $facturacion_2->save();

                } // Final de guardado de facturación registro solo para productos 

            }// Final de bucle para registro de productos o servicios 

        } // Final de registro de artículos
        



        return "guardado completo";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Redirección para mostrar el inventario inicial
        
        $existe_id=Facturacion::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('facturacion.index'); }

        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $j = 1;
        
        return view('transaccion.venta.facturacion.facturacion_manual.show', compact('j','facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
