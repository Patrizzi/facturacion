<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Cliente;
use App\Empresa;
use App\Forma_pago;
use App\Garantia;
use App\Igv;
use App\Kardex_entrada;
use App\Moneda;
use App\Personal;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Unidad_medida;
use App\Validez;
use App\kardex_entrada_registro;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CotizacionOtrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // Migracion nuevav
        $garantia=Garantia::where('estado',0)->get();
        $validez=Validez::where('estado',0)->get();
        if (count($garantia)==0) {
         $garantia_new=new Garantia;
         $garantia_new->descripcion='Sin Garantia';
         $garantia_new->estado='0';
         $garantia_new->save();
     }
     if (count($validez)==0) {
         $validez_new=new Validez;
         $validez_new->descripcion='1 dia';
         $validez_new->estado='0';
         $validez_new->save();
     }
        // Migracion nueva
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=Kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        $clientes=Cliente::all();
        $moneda=Moneda::all();
        $forma_pagos= Forma_pago::all();
        $igv=Igv::first();
        $servicios = Servicios::all();
        $productos=Producto::all();

        $empresa=Empresa::first();
        return view('transaccion.venta.cotizacion.otros.create',compact('garantia','validez','igv','empresa','clientes','forma_pagos','moneda','productos','servicios'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $tipo_coti = $request->get('tipo_coti');
        // return $tipo_coti;
        /*IMPRENSION*/
       //  if($print==1){
        $name = $request->get('name');

        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();

         //Convertir nombre del cliente a id
        $cliente_id=$request->get('cliente');
        $nombre = strstr($cliente_id, '-',true);
        $cliente_id=Cliente::where('numero_documento',$nombre)->first();

        $user_login =auth()->user();
        $personal=Personal::where('id',$user_login->personal_id)->first();

        $codigo=$request->get('codigo');
        $fecha_emision=$request->get('fecha_emision');
        $forma_pago_id=$request->get('forma_pago');

        $moneda=$request->get('moneda');
        $moneda_id=Moneda::where('id',$moneda)->first();

        $validez=$request->get('validez');
        $garantia=$request->get('garantia');
        $observacion=$request->get('observacion');
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);
        $cantidad_p = $request->input('cantidad');

        
        $count_cantidad_p=count($cantidad_p);

        // $igv=Igv::first();

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
            $producto_codigo[$i]=Producto::where('id',$producto_id[$i])->first();
        }

        for($i=0;$i<$count_articulo;$i++){
            $cantidad[]=$request->input('cantidad')[$i];
            $precio[]=$request->input('precio_s_igv')[$i];
            $precio_igv[]=$request->input('precio_c_igv')[$i];
        }
        $sub_total = $request->input('subtotal');
        $igv = $request->input('igv');
        $total_final = $request->input('total_final');
        //Numeor a letras vartiables
        $igv_p=round($total_final,2);
        $end=round($total_final,2);
        $end2=number_format(round($total_final,2),2);

        if ($name=='print') {
           return view('transaccion.venta.cotizacion.otros.print',compact('tipo_coti','producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','precio_igv','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
        }elseif ($name=='pdf'){
            $pdf=PDF::loadView('transaccion.venta.cotizacion.otros.pdf',compact('tipo_coti','producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','precio_igv','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
            return $pdf->download('COTPF 001-0000000'.$codigo.'.pdf');
        }elseif ($name=='correo'){
            $date_sp = Carbon::now();
            $data_g = str_replace(' ', '_',$date_sp);
            $carbon_sp = str_replace(':','-',$data_g);
            $date = $carbon_sp;
            $redic='mailbox';
            $clientes=$cliente_id->email;
            $rutapdf = 'transaccion.venta.cotizacion.pdf';
            $name = 'COTPF 001-0000000';

            // return $cotizacion;
            $archivo=$name.$codigo.".pdf";
            $pdf=PDF::loadView('transaccion.venta.cotizacion.otros.pdf',compact('producto_codigo','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos','personal','sub_total','igv','total_final','igv_p','end','end2'));
            $especif = $carbon_sp.$archivo;
            $contenido=$pdf->download();
            Storage::disk($redic)->put($especif,$contenido);
            return view('mailbox.create',compact('archivo','clientes','redic','date'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

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
