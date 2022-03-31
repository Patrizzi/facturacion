<?php

namespace App\Http\Controllers;
use App\Cliente;
use App\Empresa;
use App\NotaVenta;
use App\Personal;
use App\Almacen;
use App\Producto;
use App\Servicios;
use App\Banco;
use App\Moneda;
use App\Forma_pago;
use App\kardex_entrada;
use App\NotaVentaRegistro;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
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
        $almacen =Almacen::all();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen_primero =Almacen::first();
        $user_login =auth()->user();
        return view('transaccion.venta.nota_venta.index',compact('nota_venta','conteo_almacen','almacen_primero','user_login','almacen'));
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
      $moneda=Moneda::all();
      $forma_pagos= Forma_pago::all();
      $servicios = Servicios::all();
      $productos=Producto::all();
      $user_login =auth()->user();

      $empresa=Empresa::first();
      return view('transaccion.venta.nota_venta.create',compact('empresa','clientes','forma_pagos','moneda','productos','servicios','user_login','cod_nota_venta','almacen'));

  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //contador de valores de articulos
        $articulo = $request->articulo;
        $count_articulo=count($articulo);

        $almacen=Almacen::where('id',$request->almacen)->first();
        $count_nota_venta=NotaVenta::where('almacen_id',$request->almacen)->count();
        $count_nota_venta++;
        $sucursal_nr = str_pad($request->almacen, 3, "0", STR_PAD_LEFT);
        $correlativo=str_pad($count_nota_venta, 8, "0", STR_PAD_LEFT);
        $cod_nota_venta="NV ".$sucursal_nr."-".$correlativo;


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
        $nota_venta->save();

        for($i=0;$i<$count_articulo;$i++){
            $reg_nota_v= new NotaVentaRegistro();
            $reg_nota_v->nota_venta_id=$nota_venta->id;
            $reg_nota_v->producto=$request->get('articulo')[$i];
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

      return view('transaccion.venta.nota_venta.show',compact('nota_venta','nota_venta_re','empresa','banco','banco_count','servicios','productos'));

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
        return $pdf->download('PDF-DOC-'.$archivo.'.pdf');
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
        $nota_venta = NotaVenta::where('id',$id)->first();
        if($nota_venta->estado == 0){              
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
                if($request->get('n_registros_ori')[$h] == "existente"){
                    $nota_venta_upd_new = NotaVentaRegistro::find($request->get('elem_delete')[$h]);
                    $nota_venta_upd_new->producto= $request->get('articulo')[$h];
                    $nota_venta_upd_new->cantidad= $request->get('cantidad')[$h];
                    $nota_venta_upd_new->precio_nacional= $request->get('precio')[$h];
                    $nota_venta_upd_new->save();
                }else{
                    $nota_venta_upd =new NotaVentaRegistro;
                    $nota_venta_upd->nota_venta_id = $nota_venta->id;
                    $nota_venta_upd->producto= $request->get('articulo')[$h];
                    $nota_venta_upd->cantidad= $request->get('cantidad')[$h];
                    $nota_venta_upd->precio_nacional= $request->get('precio')[$h];
                    $nota_venta_upd->save();
                }
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
}
