<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Banco;
use App\Cliente;
use App\ComprobantesVentas;
use App\Cotizacion;
use App\CotizacionManual;
use App\Empresa;
use App\Forma_pago;
use App\Garantia;
use App\Moneda;
use App\TipoCambio;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\Personal;
use App\Producto;
use App\Servicios;
use App\Igv;
use App\kardex_entrada;
use App\Stock_producto;
use App\Ventas_registro;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NotaVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $nota_venta=NotaVenta::all();
        $totales = [];
        foreach($nota_venta as $index =>  $nota_ventas){    
            $total = 0;
            $suma = 0;
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota_ventas->id)->get();
            foreach($nota_venta_reg as $nota_venta_regs){
                $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
            }
            $suma += $total;
            $totales[$index] = $suma;
        }
        
        // return $totales;
        $almacen =Almacen::all();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen_primero =Almacen::first();
        $user_login =auth()->user();
        return view('transaccion.venta.nota_venta.index',compact('nota_venta','conteo_almacen','almacen_primero','user_login','almacen','totales'));
    }
    
    public function precio_sugerido(Request $request){
        $item = $request->item;
        $moneda_nota = $request->moneda;
        $pro_serv = explode(" \ ", $item);
        
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$moneda_nota;
        // return $moneda_seleccion;
        if(isset($pro_serv[1])){
            $producto = Producto::where('nombre',$pro_serv[0])->where('descripcion',$pro_serv[1])->first();
            $servicios = Servicios::where('nombre',$pro_serv[0])->where('descripcion',$pro_serv[1])->first();
        }else{
            $producto = Producto::where('nombre',$pro_serv[0])->first();
            $servicios = Servicios::where('nombre',$pro_serv[0])->first();
        }
        
        // if(!isset($producto) && !isset($servicios)){
        //     $pro_precio = 0;
        //     // return $pro_precio;
        // }
        $igv = Igv::first();
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(isset($producto)){
            $producto_pre = Stock_producto::where('producto_id',$producto->id)->first();

            
            if($moneda->id == $moneda_registrada){
                if ($moneda->tipo == 'nacional') {
                    $utilidad=$producto_pre->precio_nacional*($producto_pre->producto->utilidad-$producto_pre->producto->descuento1)/100;
                    $precio_base=round($producto_pre->precio_nacional+$utilidad,2);

                }else {
                    $utilidad=$producto_pre->precio_extranjero*($producto_pre->producto->utilidad-$producto_pre->producto->descuento1)/100;
                    $precio_base=round($producto_pre->precio_extranjero+$utilidad,2);
                }
            }else{
                if ($moneda->tipo == 'extranjera') {
                    $utilidad=$producto_pre->precio_extranjero*($producto_pre->producto->utilidad-$producto_pre->producto->descuento1)/100;
                    $precio_base=round(($producto_pre->precio_extranjero+$utilidad) *$cambio->paralelo ,2);
                }else{
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $utilidad=$producto_pre->precio_extranjero*($producto_pre->producto->utilidad-$producto_pre->producto->descuento1)/100;
                    $precio_base=round(($producto_pre->precio_extranjero+$utilidad) / $cambio->paralelo ,2);
                }
            }
            $igv = $precio_base * ($igv->igv_total/100);
            $pro_precio = round($precio_base + $igv,2);
        }elseif(isset($servicios)){
            if($moneda->id == $moneda_registrada){
                if($moneda->tipo =='nacional'){
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv=$servicios->precio_nacional*($servicios->utilidad)/100;
                    $precio_base=($servicios->precio_nacional + $utilidad_serv);
                }else{
                    $utilidad_serv=$servicios->precio_extranjero*($servicios->utilidad)/100;
                    $precio_base=($servicios->precio_extranjero + $utilidad_serv);
                }
            }else{
                if($moneda->tipo =='extranjera'){
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv=$servicios->precio_nacional*($servicios->utilidad)/100;
                    $precio_base=($servicios->precio_nacional + $utilidad_serv)/$cambio->paralelo;
                }else{
                    $utilidad_serv=$servicios->precio_extranjero*($servicios->utilidad)/100;
                    $precio_base=( $servicios->precio_extranjero + $utilidad_serv)/$cambio->paralelo;
                }
            }
            $igv = $precio_base * ($igv->igv_total/100);
            $pro_precio = round($precio_base + $igv,2);
        }else{
            $pro_precio = 0;
        }

        return $pro_precio;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $almacen=Almacen::where('id',$request->almacen)->first();
        $count_nota_venta=NotaVenta::where('almacen_id',$request->almacen)->count();
        $count_nota_venta++;
        $sucursal_nr = str_pad($request->almacen, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($count_nota_venta, 8, "0", STR_PAD_LEFT);
        $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;


        $clientes=Cliente::all();
        $garantia=Garantia::where('estado',0)->get();
        $moneda=Moneda::all();
        $forma_pagos= Forma_pago::all();
        $servicios = Servicios::where('estado_anular', 0)->get();
        $productos=Producto::where('estado_anular', 1)->get();
        $user_login =auth()->user();
        $igv = Igv::first();
        $empresa=Empresa::first();
        return view('transaccion.venta.nota_venta.create',compact('garantia','empresa','clientes','forma_pagos','moneda','productos','servicios','user_login','cod_nota_venta','almacen','igv'));

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
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);
        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id_name[$i]=strstr($articulos[$i], '|');
            $producto_id_2[$i]=strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i]=substr(strstr($producto_id_2[$i], ' '),2);
            $producto_name[$i]=explode(' | ',$producto_id_3[$i])[2];
            
        }
        // return $producto_name;
        // return explode(' | ',$producto_id_name[0]);
        //contador de valores de articulos
        $articulo = $request->articulo;
        $count_articulo=count($articulo);

        $almacen=Almacen::where('id',$request->almacen)->first();
        $count_nota_venta=NotaVenta::where('almacen_id',$request->almacen)->count();
        $count_nota_venta++;
        $sucursal_nr = str_pad($request->almacen, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($count_nota_venta, 8, "0", STR_PAD_LEFT);
        $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;

        $submit = $request->get('submit');
        $nota_venta=new NotaVenta;
        $nota_venta->cod_nota_venta=$cod_nota_venta;
        $nota_venta->cliente_id=$request->cliente;
        $nota_venta->almacen_id=$request->almacen;
        $nota_venta->forma_pago=$request->forma_pago;
        $nota_venta->garantia=$request->garantia;
        $nota_venta->moneda_id=$request->moneda;
        $nota_venta->fecha_emision=$request->fecha_emision;
        $nota_venta->observacion=$request->observacion;
        $nota_venta->user_registrado=auth()->user()->id;
        if($submit == 2){
            $nota_venta->estado_vigente = 1;
        }
        $nota_venta->save();

        for($i=0;$i<$count_articulo;$i++){
            $reg_nota_v= new NotaVentaRegistro();
            $reg_nota_v->nota_venta_id=$nota_venta->id;
            $reg_nota_v->producto= $producto_name[$i];
            $reg_nota_v->descripcion=$request->get('descripcion_item')[$i];
            $reg_nota_v->cantidad=$request->get('cantidad')[$i];
            $reg_nota_v->precio_nacional=$request->get('precio')[$i];
            $reg_nota_v->save();
        }
        
        
     return redirect()->route('nota_venta.show',$nota_venta->id);
        // return $nota_venta;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        $servicios = Servicios::all();
        $productos=Producto::all();
        $empresa=Empresa::first();
        $nota_venta=NotaVenta::where('id',$id)->first();
        $nota_venta_re=NotaVentaRegistro::where('nota_venta_id',$id)->get();
        $banco=Banco::where('estado',0)->get();
        $banco_count=$banco->count();
        $count_reg = count($nota_venta_re);
        $igv = Igv::first();
        // return var_dump($nota_venta_re[0]->precio_nacional+"3");
        return view('transaccion.venta.nota_venta.show',compact('nota_venta','nota_venta_re','empresa','banco','banco_count','servicios','productos','count_reg','igv'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // $existe_id=kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        // $existe_id=NotaVenta::where('id',$id)->first();
        // if(empty($existe_id)){ return redirect()->route('nota_venta.index'); }
        
        $empresa=Empresa::first();

        $nota_venta = NotaVenta::where('id',$id)->first();
        $nota_venta_re = NotaVentaRegistro::where('nota_venta_id',$id)->get();
        $banco=Banco::where('estado',0)->get();
        $banco_count=$banco->count();

        return view('transaccion.venta.nota_venta.print',compact('nota_venta','nota_venta_re','empresa','banco','banco_count'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id){
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // $existe_id=kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        // $existe_id=NotaVenta::where('id',$id)->first();
        // if(empty($existe_id)){ return redirect()->route('nota_venta.index'); }

        $empresa=Empresa::first();

        $nota_venta = NotaVenta::where('id',$id)->first();
        $nota_venta_re = NotaVentaRegistro::where('nota_venta_id',$id)->get();
        $banco=Banco::where('estado',0)->get();
        $banco_count=$banco->count();
        $archivo = $nota_venta->cod_nota_venta.'-'.$empresa->ruc;
        // return view('transaccion.venta.nota_venta.pdf',compact('empresa','nota_venta','nota_venta_re','banco','banco_count'));
        $pdf = PDF::loadView('transaccion.venta.nota_venta.pdf',compact('empresa','nota_venta','nota_venta_re','banco','banco_count'));
        return $pdf->download('NotaV '.$nota_venta->cod_nota_venta.'.pdf');
    }
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
        // return $requesXt;

        
        // return $sep_esc;
        $nota_venta = NotaVenta::where('id',$id)->first();
        if($nota_venta->estado == 0 && $nota_venta->estado_vigente == 0){              
            $nota_registros = NotaVentaRegistro::where('nota_venta_id',$nota_venta->id)->get();
            // REGISTROS EXISTENTES
            $n_registros_ori = $request->get('n_registros_ori');
            $n_r_ori_c = count($n_registros_ori);

            $var =$request->get('elem_delete');
            // return array_count_values();
            // ELIMINAR LOS QUE ESTAN DELETE
            if( isset( $var )){
                $nota_registros_delete = NotaVentaRegistro::where('nota_venta_id',$nota_venta->id)->whereNotIn('id', $request->get('elem_delete'))->get();
            }else{
                $nota_registros_delete = NotaVentaRegistro::where('nota_venta_id',$nota_venta->id)->get();
            }
            // return $nota_registros_delete;
            for ($i=0; $i < count($nota_registros_delete) ; $i++) { 
                NotaVentaRegistro::Destroy($nota_registros_delete[$i]->id);
            }   
            //nuevos registros
            for ($h=0; $h < $n_r_ori_c ; $h++) { 
                if (strpos($request->get('articulo')[$h], ' | ') == true) {
                    $art = $request->get('articulo')[$h];
                    $sep_esc = explode(' | ',$art);
                    $producto_id = $sep_esc[3];
                }else{
                    $producto_id = $request->get('articulo')[$h];
                }
                
                if($request->get('n_registros_ori')[$h] == "existente"){
                    $nota_venta_upd_new = NotaVentaRegistro::find($request->get('elem_delete')[$h]);
                    $nota_venta_upd_new->producto= $producto_id;
                    $nota_venta_upd_new->descripcion= $request->get('article_descripcion')[$h];
                    $nota_venta_upd_new->cantidad= $request->get('cantidad')[$h];
                    $nota_venta_upd_new->precio_nacional= $request->get('precio')[$h];
                    $nota_venta_upd_new->save();
                }else{
                   
                    $nota_venta_upd =new NotaVentaRegistro;
                    $nota_venta_upd->nota_venta_id = $nota_venta->id;
                    $nota_venta_upd->producto= $producto_id;
                    $nota_venta_upd->descripcion= $request->get('article_descripcion')[$h];
                    $nota_venta_upd->cantidad= $request->get('cantidad')[$h];
                    $nota_venta_upd->precio_nacional= $request->get('precio')[$h];
                    $nota_venta_upd->save();
                }
            }
            $submit=$request->get('submit');
            if($submit == 2){
                $nota_venta_esta_v=NotaVenta::find($nota_venta->id);
                $nota_venta_esta_v->estado_vigente = 1;   
                $nota_venta_esta_v->save();
            }
        }
        return back();
    }
    public function anulacion(Request $request, $id){
        $nota_venta = NotaVenta::find($id);
        $nota_venta->observacion =  $request->get('observacion');
        $nota_venta->estado = 1;
        $nota_venta->save();
        return back();
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
    public function ticket(Request $request, $id)
    {
        $nota_venta=NotaVenta::find($id);
        $nota_registro=NotaVentaRegistro::where('nota_venta_id',$id)->get();
        $empresa=Empresa::first();
        $moneda = Moneda::where('id',$nota_venta->moneda_id)->first();
        $igv=Igv::first();
        return view('transaccion.venta.nota_venta.ticket',compact('nota_venta','nota_registro','empresa','igv','moneda'));
    }


    //* NUEVA VISTA PARA /VENTAS - NOTA VENTA 
    public function index2(){
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);

        
        $almacen = Almacen::get();
        $count_all_ventas = ComprobantesVentas::count_day_ventas();
        
        return view('transaccion.venta.nota_venta.index2',compact('count_month_ventas', 'almacen' ,'count_all_ventas'));
    }
}
    
            /*foreach($nota_venta_reg as $nota_venta_regs){
                $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
             }

            // condicional soles
            if($moneda->id == "1"){ //Si es soles retorno soles
                if($notaV->moneda->id == "1"){ //soles
                    $subtotal = $notaV->op_gravada + $notaV->op_inafecta + $notaV->op_exonerada;    
                    $totales +=  $subtotal + ($notaV->op_gravada * ($igv->igv_total/100));
                }else{  //dolares
                    $subtotal_sin = $notaV->op_gravada + $notaV->op_inafecta + $notaV->op_exonerada;    
                    $subtotal = $subtotal_sin * $notaV->cambio;
                    $subtotal_dol = $notaV->op_gravada * $notaV->cambio;
                    $totales +=  $subtotal + ($subtotal_dol * ($igv->igv_total/100));
                }
                // $total = "1";
                // return $total;
            }else{ // Si no retorno Dolares

                if($notaV->moneda->id == "1"){ //dolares
                    $subtotal_sin = $notaV->op_gravada + $notaV->op_inafecta + $notaV->op_exonerada;
                    $subtotal = $subtotal_sin / $notaV->cambio;
                    $subtotal_dol = $notaV->op_gravada / $notaV->cambio;
                    $totales +=  $subtotal + ($notaV->op_gravada / ($igv->igv_total/100));
                }else{  //soels
                    $subtotal = $notaV->op_gravada + $notaV->op_inafecta + $notaV->op_exonerada;    
                    $totales +=  $subtotal + ($notaV->op_gravada * ($igv->igv_total/100));
                }
                // $total = "2";
            }
        }*/