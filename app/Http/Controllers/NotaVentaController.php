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
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
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

    public function exportNotasVentas(Request $request)
{

    if (ob_get_contents()) {
            ob_end_clean();
        }
   $daterange = $request->get('daterange', date('01/m/Y') . ' - ' . date('t/m/Y'));
        $filter = $request->get('value');
        $tipo = $request->get('tipo_coti');

        $starDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $daterange)[1])->endOfDay();

        $query = NotaVenta::with(['cliente', 'almacen', 'user', 'moneda'])
        ->whereBetween('created_at', [$starDate, $endDate])
        ->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }

        if ($tipo !== null) {
            $query->where('tipo' , $tipo);
        }

    $notas = $query->get();

    $headers = [
        'Código Nota Venta',
        'Cotización',
        'Cotización Manual',
        'Cliente',
        'Almacén',
        'Forma de Pago',
        'Garantía',
        'Moneda',
        'Fecha Emisión',
        'Observación',
        //'Estado',
        'Estado Vigente',
        'Estado Pago',
        'Usuario Registrado',
    ];

    $rows = [$headers];

    foreach ($notas as $nota) {
        $cliente = optional($nota->cliente)->nombre ?? '';
        $almacen = optional($nota->almacen)->nombre ?? '';
        $moneda  = optional($nota->moneda)->nombre ?? '';
        $usuario = optional($nota->user)->name ?? '';
        $estado_vigente = $nota->estado_vigente == 1 ? 'Vigente' : 'No vigente';

        // hallando el estado de pago
        switch ($nota->estado_pago) {
            case 0:
                $estado_pago = 'Sin pago';
            break;

            case 1:
                $estado_pago = 'Adelantado';
            break;

            case 2:
                $estado_pago = 'Pagado';
            break;

            default:
            $estado_pago = 'Desconocido';
            break;
        }

        $rows[] = [
            $nota->cod_nota_venta,
            $nota->id_cotizacion,
            $nota->id_cotizacion_m,
            $cliente,
            $almacen,
            $nota->forma_pago,
            $nota->garantia,
            $moneda,
            $nota->fecha_emision,
            $nota->observacion,
            //$nota->estado,
            $estado_vigente,
            $estado_pago,
            $usuario
        ];
    }

    $export = new class($rows) implements FromArray, WithEvents {
        private $rows;

        public function __construct($rows) {
            $this->rows = $rows;
        }

        public function array(): array {
            return $this->rows;
        }

        public function registerEvents(): array {
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    foreach(range('A','Z') as $column) {
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                    foreach(range('A','Z') as $letter1) {
                        foreach(range('A','Z') as $letter2) {
                            $event->sheet->getColumnDimension($letter1.$letter2)->setAutoSize(true);
                        }
                    }
                },
            ];
        }
    };

    return Excel::download($export, 'notas_venta.xlsx');
}


public function printMultiple(Request $request)
{
    try {
        $notaIds = $request->input('nota_ids', []);
        
        // Si viene por query string (GET)
        if (empty($notaIds)) {
            $notaIds = $request->query('nota_ids', []);
        }
        
        // Asegurar que sea array
        if (!is_array($notaIds)) {
            $notaIds = explode(',', $notaIds);
        }
        
        // Filtrar IDs válidos
        $notaIds = array_filter($notaIds, function($id) {
            return !empty($id) && is_numeric($id) && $id > 0;
        });

        if (empty($notaIds)) {
            // Si es una petición AJAX o viene de JavaScript
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'No se seleccionaron notas de venta para imprimir.'
                ], 400);
            }
            return back()->withErrors(['No se seleccionaron notas de venta para imprimir.']);
        }

        $notas = NotaVenta::with(['cliente', 'moneda', 'almacen'])
            ->whereIn('id', $notaIds)
            ->get();

        if ($notas->isEmpty()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'No se encontraron las notas de venta seleccionadas.'
                ], 404);
            }
            return back()->withErrors(['No se encontraron las notas de venta seleccionadas.']);
        }

        // Recopilar datos para múltiples notas de venta
        $notasData = [];
        $empresa = Empresa::first();
        $igv = Igv::first();

        foreach ($notas as $nota) {
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota->id)->get();
            
            // Calcular totales
            $sub_total = 0;
            $total_igv = 0;
            $total_general = 0;
            
            foreach ($nota_venta_reg as $registro) {
                $sub_total += $registro->precio_nacional * $registro->cantidad;
            }
            
            $total_igv = $sub_total * ($igv->igv_total / 100);
            $total_general = $sub_total + $total_igv;

            $notasData[] = [
                'nota_venta' => $nota,
                'nota_venta_reg' => $nota_venta_reg,
                'sub_total' => $sub_total,
                'total_igv' => $total_igv,
                'total_general' => $total_general
            ];
        }

        // Si es petición AJAX, retornar JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $notasData,
                'empresa' => $empresa
            ]);
        }

        return view('transaccion.venta.nota_venta.print_multiple', compact(
            'notasData',
            'empresa',
            'igv'
        ));

    } catch (\Exception $e) {
        Log::error('Error en printMultiple: ' . $e->getMessage());
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'error' => 'Error al procesar la impresión múltiple: ' . $e->getMessage()
            ], 500);
        }
        
        return back()->withErrors(['Error al procesar la impresión múltiple: ' . $e->getMessage()]);
    }
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
