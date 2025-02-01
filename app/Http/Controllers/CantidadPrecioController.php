<?php

namespace App\Http\Controllers;

use App\CantidadPrecio;
use App\Stock_producto;
use App\Producto;
use App\TipoCambio;
use App\Moneda;
use App\Stock_almacen;
use App\Igv;
use App\Empresa;
use App\Servicios;
use PDF;
use Illuminate\Http\Request;

class CantidadPrecioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $igv = Igv::get()->first();
        // $stock_producto = Stock_producto::get();
        // $count_stock_prod = count($stock_producto);
        // foreach ($stock_producto as $stock_productos) {
        //     $stock_produ[] = $stock_productos->id;
        // }

        // return $stock_producto;
        // for ($x=0; $x < $count_stock_prod ; $x++) {
        //     // foreach ($producto as $prod) {
        //         $productos[]=Stock_producto::where('id',$stock_produ[$x])->first();
        //     // }
        // }
        // return $stock_producto;
        $id_t1 = 1;
        $id_t2 = intval(1);

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        // return view('inventario.cantidades-precios.index',compact('stock_producto','i','tipo_cambio'));
        $producto = Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $producto_count = count($producto);
        if($producto_count == 0){
            return view('consulta.cantidades-precios.index',compact('stock_producto','id','tipo_cambio','precio_nacional','precio_extranjero','moneda_simb','moneda_nacional','moneda_extranjera','producto_count'));
        }
        // return $producto_count;
        foreach ($producto as $prod) {
            $produ_id[] = $prod->id;
        }
        // return $produ_id;
        for ($i=0; $i < $producto_count ; $i++) {
            // foreach ($producto as $prod) {
                $productos[]=Producto::where('id',$produ_id[$i])->first();
            // }
        }

        //  return $productos[169];
        $moneda=Moneda::where('principal',1)->first();


        if($moneda->tipo == "nacional"){
            foreach ($productos as $index => $producto) {
                //precio nacional
                $utilidad_precio_nac[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $precio_nacional[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad_precio_nac[$index]),2);
                //precio extranjero
                $utilidad_precio_ext[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $precio_extranjero[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad_precio_nac[$index])/$tipo_cambio->paralelo,2);
                $id[] = $producto->id;

            }
            // $moneda_simb = Moneda::where('tipo','nacional')->first();
        }else{
            foreach ($productos as $index => $producto) {
                //precio_nacional
                $utilidad_precio_nac[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $precio_nacional[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad_precio_nac[$index]),2);
                //precio_extranjero
                $utilidad_precio_ext[] = Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $precio_extranjero[] = round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad_precio_ext[$index])*$tipo_cambio->paralelo,2);
                $id[] = $producto->id;

            }
            // $moneda_simb = Moneda::where('tipo','extranjera')->first();
        }
        // return $id;
        $stock_producto = Stock_producto::whereIn('producto_id',$id)->get();
        // return $stock_producto;

        $moneda_nacional=Moneda::where('tipo','nacional')->first();
        $moneda_extranjera=Moneda::where('tipo','extranjera')->first();

         return view('consulta.cantidades-precios.index',compact('stock_producto','id_t1','id_t2','tipo_cambio','precio_nacional','precio_extranjero','moneda_nacional','moneda_extranjera','producto_count','igv'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::first();
        $producto_id = $request->input('producto_id');
        $prod_count = count($producto_id);
        $x = '1';

        $nuevo_stock = $request->input('stock_nuevo');
        // retu1rn $nuevo_stock;
        for ($i=0; $i <  $prod_count ; $i++) {
            $producto[] = Stock_producto::where('id',$producto_id[$i])->first();
        }
        // return view('consulta.cantidades-precios.show_pdf',compact('producto','x','empresa','nuevo_stock'));
        $pdf=PDF::loadView('consulta.cantidades-precios.show_pdf',compact('producto','x','empresa','nuevo_stock'));
        return $pdf->download('Productos.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function show(CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function edit(CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CantidadPrecio $cantidadPrecio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CantidadPrecio  $cantidadPrecio
     * @return \Illuminate\Http\Response
     */
    public function destroy(CantidadPrecio $cantidadPrecio)
    {
        //
    }

    public function index_servicio(){
        $igv = Igv::get()->first();
        $id_t1 = 1;
        $id_t2 = intval(1);

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $servicio = Servicios::where('estado_anular',0)->get();

        $servicio_count = count($servicio);
        if($servicio_count == 0){
            return view('consulta.cantidades-precios.index_servicios',compact('stock_producto','id','tipo_cambio','precio_nacional','precio_extranjero','moneda_simb','moneda_nacional','moneda_extranjera','servicio_count'));
        }
        // return $servicio;
        foreach ($servicio as $serv) {
            $servi_id[] = $serv->id;
        }

        for ($i=0; $i < $servicio_count ; $i++) {
            $servicios[]=Servicios::where('id',$servi_id[$i])->first();
        }

        $moneda=Moneda::where('principal',1)->first();

        // return $servicios;
        if($moneda->tipo == "nacional"){
            foreach ($servicios as $index => $servicio) {
                $servicio_first=Servicios::where('id',$servicio->id)->first();
                //precio nacional
                $utilidad_precio_nac[] = $servicio_first->precio_nacional*($servicio->utilidad)/100;
                $precio_nacional[] = round(($servicio_first->precio_nacional+$utilidad_precio_nac[$index]),2);
                //precio extranjero
                $utilidad_precio_ext[] = $servicio_first->precio_nacional*($servicio->utilidad)/100;
                $precio_extranjero[] = round(($servicio_first->precio_nacional+$utilidad_precio_nac[$index])/$tipo_cambio->paralelo,2);
                $id[] = $servicio->id;
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $servicio_first=Servicios::where('id',$servicio->id)->first();
                //precio_nacional
                $utilidad_precio_nac[] = $servicio_first->precio_extranjero*($servicio->utilidad)/100;
                $precio_nacional[] = round(($servicio_first->precio_extranjero+$utilidad_precio_nac[$index]),2);
                //precio_extranjero
                $utilidad_precio_ext[] = $servicio_first->precio_extranjero*($servicio->utilidad)/100;
                $precio_extranjero[] = round(($servicio_first->precio_extranjero+$utilidad_precio_ext[$index])*$tipo_cambio->paralelo,2);
                $id[] = $servicio->id;
            }
        }

        $moneda_nacional=Moneda::where('tipo','nacional')->first();
        $moneda_extranjera=Moneda::where('tipo','extranjera')->first();

        $servicio = Servicios::where('estado_anular',0)->get();

         return view('consulta.cantidades-precios.index_servicios',compact('id_t1','id_t2','tipo_cambio','precio_nacional','precio_extranjero','moneda_nacional','moneda_extranjera','servicio_count','igv','servicio'));
    }
}
