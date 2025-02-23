<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Codigo_guia_almacen;
use App\Banco;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Cuotas_credito;
use App\Detracciones;
use App\Guia_remision;
use App\Igv;
use App\Marcas;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Unidad_medida;
use App\User;
use App\Tipo_operacion_f;
use App\Ventas_registro;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\MedioPagoDetraccion;
use App\Nota_Credito;
use App\Nota_Debito;
use App\Stock_almacen;
use App\Stock_producto;
use App\TipoDetraccion;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;
use PDF;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        // $existe_id=kardex_entrada::where('estado',2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        $facturacion = Facturacion::all();
        if (count($facturacion) == 0) {
            $nota_credito[0] = null;
            $nota_debito[0] = null;
        } else {
            foreach ($facturacion as $key => $factura) {
                $nota_credito[$key] = Nota_Credito::where('facturacion_id', $factura->id)->first();
                $nota_debito[$key] = Nota_Debito::where('facturacion_id', $factura->id)->first();
                if (!isset($nota_credito[$key])) {
                    $nota_credito[$key] = null;
                }
                if (!isset($nota_debito[$key])) {
                    $nota_debito[$key] = null;
                }
            }
        }
        // return $facturacion;

        // return $nota_credito;
        $igv = Igv::first();
        $user_login = auth()->user();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        // return $facturacion;
        return view('transaccion.venta.facturacion.index', compact('facturacion', 'user_login', 'conteo_almacen', 'almacen', 'almacen_primero', 'igv', 'nota_credito', 'nota_debito'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $msg = "Ejemplo rapido";
        return response()->json(array('msg' => $msg), 200);
    }

    // creacion para productos
    public function create(Request $request)
    {

        $almacen = $request->get('almacen');
        $sucursal = Almacen::where('id', $almacen)->first();

        $inventario_inicial = Kardex_entrada::count();
        $servicios = Servicios::count();
        if ($inventario_inicial == 0 && $servicios == 0) {
            return back()->withErrors(['No hay Productos o Servicios Agregados: ' . $sucursal->nombre . '']);
        }
        // $kardex_prod=kardex_entrada_registro::join("productos","kardex_entrada_registro.producto_id","productos.id")
        // ->where('estado',1)->get();

        $almacen = $request->get('almacen');
        $kardex_entrada = Kardex_entrada::where('almacen_id', $almacen)->get();
        $kardex_entrada_count = Kardex_entrada::where('almacen_id', $almacen)->count();

        //return $kardex_entrada;
        foreach ($kardex_entrada as $kardex_entradas) {
            $kadex_entrada_id[] = $kardex_entradas->id;
        }

        for ($x = 0; $x < $kardex_entrada_count; $x++) {
            if (Kardex_entrada_registro::where('kardex_entrada_id', $kadex_entrada_id[$x])->where('estado', 1)->where('tipo_registro_id', '!=', 2)->get()) {
                $nueva = Kardex_entrada_registro::where('kardex_entrada_id', $kadex_entrada_id[$x])->where('estado', 1)->where('tipo_registro_id', '!=', 2)->get();
                foreach ($nueva as $nuevas) {
                    $prod[] = $nuevas->producto_id;
                }
            }
        }

        $servicios = Servicios::where('estado_anular', 0)->get();
        //validacion si hay prductos en el almacen
        if (!isset($prod)) {
            // return back()->withErrors(['No hay productos en el Almacen con nombre: '.$sucursal->nombre.'']);
            $prod = [0, 0];
        }
        if (count($servicios) == 0) {
            // return back()->withErrors(['No hay Servicios Agregados: '.$sucursal->nombre.'']);
            $servicios == null;
        }
        if (!isset($prod) && count($servicios) == 0) {
            return back()->withErrors(['No hay Productos o Servicios Agregados: ' . $sucursal->nombre . '']);
        }

        // return $nueva;
        $lista = array_values(array_unique($prod));
        $lista_count = count($lista);
        // return $lista_count;

        for ($x = 0; $x < $lista_count; $x++) {
            $validacion[$x] = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->where('id', $lista[$x])->first();
            if (!$validacion[$x] == NULL) {
                $productos[] = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->where('id', $lista[$x])->first();
            }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        // return $kardex_prod;

        //aplicamiento de logica para llamar un producto hacia kardex
        $moneda = Moneda::where('principal', '1')->first();

        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // if ($moneda->tipo == 'nacional') {
        //     foreach ($productos as $index => $producto) {
        //         $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
        //         $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
        //         $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
        //         $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
        //     }
        // }else{
        //     foreach ($productos as $index => $producto) {
        //         $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
        //         $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
        //         $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
        //         $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
        //     }
        // }

        $forma_pagos = Forma_pago::all();
        $clientes = Cliente::where('documento_identificacion', 'ruc')->get();
        $personales = Personal::all();
        $p_venta = Personal_venta::where('estado', '0')->get();
        $igv = Igv::first();
        $empresa = Empresa::first();
        $personal_contador = Facturacion::all()->count();
        $suma = $personal_contador + 1;
        $categoria = 'producto';
        $tipo_operacion = Tipo_operacion_f::all();
        $detraccion = TipoDetraccion::all();
        $medio_pago = MedioPagoDetraccion::all();
        $tipo_cambio = TipoCambio::latest()->first();
        // return $tipo_cambio;
        // $empresa = Empresa::all();
        // obtencion de la sucursal

        //obtencion del almacen
        $sucursal = Almacen::where('id', $almacen)->first();
        $cod_guia = Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
        // return $sucursal;
        $factura_cod_fac = $cod_guia->cod_factura;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        } else {
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura = Facturacion::where('almacen_id', $sucursal->id)->latest()->first();
            $factura_num = $ultima_factura->codigo_fac;
            $factura_num_string_porcion = explode("-", $factura_num);
            $factura_num_string = $factura_num_string_porcion[1];
            $factura_num = (int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura', 'DESC')->latest()->first();
            //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if ($factura_num == 99999999) {
                $ultima_factura = $almacen_codigo->serie_factura + 1;
                $factura_num = 00000000;
            } else {
                $ultima_factura = $cod_guia->serie_factura;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero = "F" . $sucursal_nr . "-" . $factura_nr;

        /*Servicio*/


        $sucursal = $request->get('almacen');
        $sucursal = Almacen::where('id', $sucursal)->first();

        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $moneda = Moneda::where('principal', '1')->first();

        // if($moneda->tipo =='nacional'){
        //     foreach ($servicios as $index2 => $servicio) {
        //         $precio_prom[]=$servicio->precio_nacional;
        //         $utilidad_Serv[]=$servicio->precio_nacional*($servicio->utilidad/100);
        //         $array2[]=round($servicio->precio_nacional+$utilidad_Serv[$index2],2);
        //     }
        // }else{
        //     foreach ($servicios as $index2 => $servicio) {
        //         $precio_prom[]=$servicio->precio_extranjero;
        //         $utilidad_Serv[]=$servicio->precio_extranjero*($servicio->utilidad/100);
        //         $array2[]=round($servicio->precio_extranjero+$utilidad_Serv[$index2],2);
        //     }
        // }
        /*Servicio*/

        $fecha_hoy = Carbon::now();
        $fecha_1 = $fecha_hoy->format('Y-m-d');
        // return $modifiedMutable;

        return view('transaccion.venta.facturacion.create', compact('forma_pagos', 'clientes', 'personales', 'igv', 'moneda', 'p_venta', 'empresa', 'suma', 'categoria', 'factura_numero', 'sucursal', 'empresa', 'tipo_operacion', 'fecha_1', 'medio_pago', 'detraccion', 'tipo_cambio'));
    }

    public function create_ms(Request $request)
    {

        $inventario_inicial = Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ($inventario_inicial->estado == 1) {
                return redirect()->route('kardex-entrada.show', $inventario_inicial->id);
            }
        }

        $almacen_p = $request->get('almacen');
        $kardex_entrada = Kardex_entrada::where('almacen_id', $almacen_p)->get();
        $kardex_entrada_count = Kardex_entrada::where('almacen_id', $almacen_p)->count();

        //return $kardex_entrada;
        foreach ($kardex_entrada as $kardex_entradas) {
            $kadex_entrada_id[] = $kardex_entradas->id;
        }

        for ($x = 0; $x < $kardex_entrada_count; $x++) {
            if (Kardex_entrada_registro::where('kardex_entrada_id', $kadex_entrada_id[$x])->where('estado', 1)->where('tipo_registro_id', '!=', 2)->get()) {
                $nueva = Kardex_entrada_registro::where('kardex_entrada_id', $kadex_entrada_id[$x])->where('estado', 1)->where('tipo_registro_id', '!=', 2)->get();
                foreach ($nueva as $nuevas) {
                    $prod[] = $nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if (!isset($prod)) {
            return redirect()->route('facturacion.index')->with('repite', 'No hay productos en el almacen seleccionado');
        }

        // return $nueva;
        $lista = array_values(array_unique($prod));
        $lista_count = count($lista);
        // return $lista_count;

        for ($x = 0; $x < $lista_count; $x++) {
            $validacion[$x] = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->where('id', $lista[$x])->first();
            if (!$validacion[$x] == NULL) {
                $productos[] = Producto::where('estado_anular', 1)->where('estado_id', '!=', 2)->where('id', $lista[$x])->first();
            }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
        $moneda = Moneda::where('principal', '0')->first();

        $tipo_cambio = TipoCambio::latest('created_at')->first();

        if ($moneda->tipo == 'extranjera') {
            foreach ($productos as $index => $producto) {
                $utilidad[] = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') * ($producto->utilidad - $producto->descuento1) / 100;
                $array[] = round((Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') + $utilidad[$index]) / $tipo_cambio->paralelo, 2);
                $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id', $almacen_p)->sum('stock');
                $array_promedio[] = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') / $tipo_cambio->paralelo, 2);
            }
        } else {
            foreach ($productos as $index => $producto) {
                $utilidad[] = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') * ($producto->utilidad - $producto->descuento1) / 100;
                $array[] = round((Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') + $utilidad[$index]) * $tipo_cambio->paralelo, 2);
                $array_cantidad[] = Stock_almacen::where('producto_id', $producto->id)->where('almacen_id', $almacen_p)->sum('stock');
                $array_promedio[] = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') * $tipo_cambio->paralelo, 2);
            }
        }

        $forma_pagos = Forma_pago::all();
        $clientes = Cliente::where('documento_identificacion', 'ruc')->get();

        $personales = Personal::all();
        $p_venta = Personal_venta::where('estado', '0')->get();
        $igv = Igv::first();
        $empresa = Empresa::first();
        $personal_contador = Facturacion::all()->count();
        $suma = $personal_contador + 1;
        $categoria = 'producto';
        $tipo_operacion = Tipo_operacion_f::all();

        // obtencion de la sucursal
        $almacen = $request->get('almacen');

        //obtencion del almacen
        $sucursal = Almacen::where('id', $almacen)->first();
        $cod_guia = Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
        $factura_cod_fac = $cod_guia->cod_factura;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        } else {
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura = Facturacion::where('almacen_id', $sucursal->id)->latest()->first();
            $factura_num = $ultima_factura->codigo_fac;
            $factura_num_string_porcion = explode("-", $factura_num);
            $factura_num_string = $factura_num_string_porcion[1];
            $factura_num = (int)$factura_num_string;
            //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura', 'DESC')->latest()->first();
            if ($factura_num == 99999999) {
                $ultima_factura = $almacen_codigo->serie_factura + 1;
                $factura_num = 00000000;
            } else {
                $ultima_factura = $cod_guia->serie_factura;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero = "F" . $sucursal_nr . "-" . $factura_nr;

        // Servicio
        $servicios = Servicios::where('estado_anular', 0)->get();

        $almacen = $request->get('almacen');

        //obtencion del almacen
        $sucursal = Almacen::where('id', $almacen)->first();

        if (count($servicios) == 0) {
            return back()->withErrors(['No hay Servicios Agregados: ' . $sucursal->nombre . '']);
        }

        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $moneda = Moneda::where('principal', '0')->first();

        if ($moneda->tipo == 'extranjera') {
            foreach ($servicios as $index2 => $servicio) {
                $precio_prom[] = round($servicio->precio_nacional / $tipo_cambio->paralelo, 2);
                $utilidad_Serv[] = $servicio->precio_nacional * ($servicio->utilidad) / 100;
                $array2[] = round(($servicio->precio_nacional + $utilidad_Serv[$index2]) / $tipo_cambio->paralelo, 2);
            }
        } else {
            foreach ($servicios as $index2 => $servicio) {
                $precio_prom[] = round($servicio->precio_extranjero * $tipo_cambio->paralelo, 2);
                $utilidad_Serv[] = $servicio->precio_extranjero * ($servicio->utilidad) / 100;
                $array2[] = round(($servicio->precio_extranjero + $utilidad_Serv[$index2]) * $tipo_cambio->paralelo, 2);
            }
        }
        return view('transaccion.venta.facturacion.create_ms', compact('productos', 'forma_pagos', 'clientes', 'personales', 'array', 'array_cantidad', 'igv', 'moneda', 'p_venta', 'array_promedio', 'empresa', 'suma', 'categoria', 'factura_numero', 'sucursal', 'tipo_operacion', 'servicios', 'precio_prom', 'array2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id_moneda)
    {
        // return $request;
        $articulo = $request->input('articulo');

        // return $articulo;
        $facturacion_input = $request->get('facturacion');

        //codigo para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p = count($cantidad_p);

        for ($i = 0; $i < $count_cantidad_p; $i++) {
            $articulos[$i] = $request->input('articulo')[$i];
            $producto_id_name[$i] = strstr($articulos[$i], '|');
            $producto_id_2[$i] = strstr($producto_id_name[$i], ' ');
            $producto_id_3[$i] = substr(strstr($producto_id_2[$i], ' '), 1);
            $producto_id[$i] = strstr($producto_id_3[$i], ' ', true);
        }

        $count_articulo = count($articulo);

        $comisionista = $request->get('comisionista');
        if ($comisionista != "" and $comisionista != "Sin comision - 0") {
            $numero = strstr($comisionista, '-', true);

            $cod_vendedor = Personal_venta::where('cod_vendedor', $numero)->first();
            $id_personal = $cod_vendedor->id;

            $comisionista_buscador = Personal_venta::where('id', $id_personal)->first();
            //Comision segun comisionista
            $comi = $comisionista_buscador->comision;
            $comision_id = $comisionista_buscador->id;
        } else {
            $comi = 0;
        }

        //Convertir nombre del cliente a id
        $cliente_nombre = $request->get('cliente');
        // $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador = Cliente::where('id', $cliente_nombre)->first();

        // FORMA DE PAGO
        $forma_pago_id = $request->get('forma_pago');
        // $formapago= Forma_pago::find($forma_pago_id);
        if ($forma_pago_id == 1) {
            $val = $request->get('fecha_vencimiento');

            $nuevafechas = date('d-m-Y', strtotime(($val)));
        } else {
            $fecha_pago_forma = $request->input('fecha_pago');
            $contador_for_1 = count($fecha_pago_forma);
            for ($c = 0; $c < $contador_for_1; $c++) {
                $val = $fecha_pago_forma[$c];
            }

            $nuevafechas = date('d-m-Y', strtotime(($val)));
        }



        //buscador al cambio
        $cambio = TipoCambio::where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if (!$cambio) {
            return "error por no hacer el cambio diario";
        }

        // CODIGO FACTURACION
        // obtencion de la sucursal
        $almacen = $request->get('almacen');

        //obtencion del almacen
        $almacen_id = Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id', $almacen_id->id)->first();
        $factura_cod_fac = $sucursal->cod_factura;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal->serie_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        } else {
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura = Facturacion::where('almacen_id', $almacen_id->id)->latest()->first();
            $factura_num = $ultima_factura->codigo_fac;
            $factura_num_string_porcion = explode("-", $factura_num);
            $factura_num_string = $factura_num_string_porcion[1];
            $factura_num = (int)$factura_num_string;
            //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL --> SOLO PARA STORE
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura', 'DESC')->latest()->first();
            if ($factura_num == 99999999) {
                $ultima_factura = $almacen_codigo->serie_factura + 1;
                $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                $almacen_save_last->serie_factura = $almacen_codigo->serie_factura + 1;
                $almacen_save_last->save();
                $factura_num = 00000000;
            } else {
                $ultima_factura = $sucursal->serie_factura;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr = str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero = "F" . $sucursal_nr . "-" . $factura_nr;

        //calculo para el stock del producto
        $almacen_producto_validacion = $request->get('almacen');

        for ($i = 0; $i < $count_articulo; $i++) {
            $producto_servicio = Producto::where('codigo_producto', $producto_id[$i])->first();
            // return $producto_servicio;
            if (isset($producto_servicio->id)) {

                $kardex_entrada_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->get();
                $kardex_entrada_count_v = Kardex_entrada::where('almacen_id', $almacen_producto_validacion)->count();
                //return $kardex_entrada;
                foreach ($kardex_entrada_v as $kardex_entradas_v) {
                    $kadex_entrada_id_v[] = $kardex_entradas_v->id;
                }

                // return   $kardex_entrada_v;
                // return $kadex_entrada_id_v;
                for ($x = 0; $x < $kardex_entrada_count_v; $x++) {
                    if (Kardex_entrada_registro::where('producto_id', $producto_servicio->id)->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first()) {
                        $nueva_v[] = Kardex_entrada_registro::where('producto_id', $producto_servicio->id)->where('kardex_entrada_id', $kadex_entrada_id_v[$x])->first();
                    }
                }

                $comparacion_v = $nueva_v;
                //buble para la cantidad
                $cantidad_v = 0;
                foreach ($comparacion_v as $comparaciones_v) {
                    $cantidad_v = $comparaciones_v->cantidad + $cantidad_v;
                }
                // return $nueva_v;
                $cantidad_entrada = $request->get('cantidad')[$i];
                if ($cantidad_v < $cantidad_entrada) {
                    return "cantidad mayor al stock";
                }
            } else {
            }
        }
        // return $comparacion_v;
        // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
        $coin = $request->get('moneda');
        $id_moneda = Moneda::where('nombre', $coin)->first();

        $operacion = $request->get('tipo_operacion');
        $nombre = strstr($operacion, '-', true);
        $busca_ope = Tipo_operacion_f::where('codigo', $nombre)->first();

        $facturacion = new facturacion;
        $facturacion->codigo_fac = $factura_numero;
        $facturacion->almacen_id = $request->get('almacen');
        $facturacion->orden_compra = $request->get('orden_compra');
        $facturacion->guia_remision = $request->get('guia_r');
        $facturacion->cliente_id = $cliente_buscador->id;
        $facturacion->moneda_id = $id_moneda->id;
        $facturacion->forma_pago_id = $request->get('forma_pago');
        $facturacion->fecha_emision = $request->get('fecha_emision');
        $facturacion->fecha_vencimiento = $nuevafechas;
        $facturacion->cambio = $cambio->paralelo;
        $facturacion->observacion = $request->get('observacion');
        $facturacion->comisionista = $comi;
        $facturacion->user_id = auth()->user()->id;
        $facturacion->estado = '0';
        $facturacion->tipo = 'producto';
        $facturacion->tipo_operacion_id = $busca_ope->id;
        $facturacion->tipo_documento_id = 2;
        $facturacion->save();

        $precio_final_igv = $request->get('precio_final_igv');
        $sub_total_sin_igv = $request->get('sub_total_sin_igv');

        if (isset($comision_id)) {
            $comisionista_porcentaje = Personal_venta::where('id', $comision_id)->first();
            $comisionista = new Ventas_registro;
            $comisionista->comisionista = $comision_id;
            $comisionista->tipo_moneda = $id_moneda;
            $comisionista->estado_aprobado = '0';
            $comisionista->estado_pagado = '0';
            $comisionista->estado_anular_fac_bol = '0';
            $comisionista->monto_final_fac_bol = $precio_final_igv;
            $porcentaje = 100 + $comisionista_porcentaje->comision;
            $comisionista->monto_comision = (100 * $sub_total_sin_igv / $porcentaje) * $comisionista_porcentaje->comision / 100;
            // $comisionista->id_coti_produc=$cotizador;
            $comisionista->id_fac = $facturacion->id;
            $comisionista->observacion = 'Factura';
            $comisionista->save();
        }
        // modificacion para que se cierre el codigo en almacen
        $factura_primera = Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if (is_numeric($factura_primera->cod_factura)) {
            $factura_primera->cod_factura = 'NN';
            $factura_primera->save();
        }
        //FORMA DE PAGO
        if ($facturacion->forma_pago_id == 2) {

            $fecha_pago = $request->input('fecha_pago');
            $contador_for = count($fecha_pago);
            $monto_pago = $request->input('monto_pago');
            // foreach($contador_for as $cuotas => $index ){
            for ($c = 0; $c < $contador_for; $c++) {
                $cuota_cred = new Cuotas_credito;
                $cuota_cred->facturacion_id = $facturacion->id;
                $cuota_cred->numero_cuota = $c + 1;
                $cuota_cred->monto = $monto_pago[$c];
                $cuota_cred->fecha_pago = $fecha_pago[$c];
                $cuota_cred->save();
            }
        }
        // return $request;
        // Detracciones
        $tipo_op = $request->get('tipo_operacion');
        $tipo_ex = explode(' ', $tipo_op);
        if($tipo_ex[0] == '1001' || $tipo_ex[0] == '1002' || $tipo_ex[0] == '1003' ||$tipo_ex[0] == '1004'){
            //
            // $detracciones = Tipo_operacion_f::where('codigo', $tipo_ex[0])->first();
            $fact_detra = new Detracciones();
            $fact_detra->factura_id = $facturacion->id;
            $fact_detra->id_cod_tipo_detraccion = $request->get('tipo_detraccion');
            $fact_detra->id_cod_medio_pago = $request->get('medio_pago_detraccion');
            $fact_detra->monto_total_factura = $request->get('precio_final_igv');
            $fact_detra->porcentaje_detraccion = $request->get('porcentaje_detraccion');
            $fact_detra->monto_detraccion = $request->get('total_detraccion');
            $fact_detra->estado = 1;
            $fact_detra->save();
        }
        // return $tipo_ex[0];
       

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad = count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check = count($check);

        //validacion dependiendo de la amoneda escogida
        $moneda = Moneda::where('principal', 1)->first();
        $moneda_registrada = $facturacion->moneda_id;
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        if ($count_articulo = $count_cantidad = $count_check) {
            for ($i = 0; $i < $count_articulo; $i++) {


                $producto_servicio = Producto::where('codigo_producto', $producto_id[$i])->first();
                // return $producto_servicio;
                if (isset($producto_servicio)) {
                    $facturacion_registro = new Facturacion_registro();
                    $facturacion_registro->facturacion_id = $facturacion->id;
                    $facturacion_registro->producto_id = $producto_servicio->id;
                    $facturacion_registro->numero_serie = $request->get('numero_serie')[$i];
                    if ($request->get('descripcion_item')[$i] == null) {
                        $facturacion_registro->descripcion_item = null;
                    } else {
                        $facturacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    $producto = Producto::where('id', $producto_servicio->id)->where('estado_id', 1)->where('estado_anular', 1)->first();
                    // return $producto;
                    //stock --------------------------------------------------------
                    $stock = Stock_almacen::where('producto_id', $producto_servicio->id)->where('almacen_id', $almacen)->sum('stock');
                    $facturacion_registro->stock = $stock;

                    //precio --------------------------------------------------------
                    if ($moneda->id == $moneda_registrada) {
                        if ($moneda->tipo == 'nacional') {
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                            $array2 = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional'), 2);
                            $facturacion_registro->promedio_original = $array2;
                            // respectividad de la moneda deacurdo al id
                            $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') * ($producto->utilidad - $producto->descuento1) / 100;
                            $array = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') + $utilidad, 2);
                            $facturacion_registro->precio = $array;
                        } else {
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                            $array2 = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero'), 2);
                            $facturacion_registro->promedio_original = $array2;
                            // validacion para la otra moneda con igv paralelo
                            $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') * ($producto->utilidad - $producto->descuento1) / 100;
                            $array = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') + $utilidad, 2);
                            $facturacion_registro->precio = $array;
                        }
                    } else {
                        if ($moneda->tipo == 'extranjera') {
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                            $array2 = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') * $cambio->paralelo, 2);
                            $facturacion_registro->promedio_original = $array2;
                            // respectividad de la moneda deacuerdo al id
                            $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') * ($producto->utilidad - $producto->descuento1) / 100;
                            $array = round((Stock_producto::where('producto_id', $producto->id)->avg('precio_extranjero') + $utilidad) * $cambio->paralelo, 2);
                            $facturacion_registro->precio = $array;
                        } else {
                            //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                            $array2 = round(Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') / $cambio->paralelo, 2);
                            $facturacion_registro->promedio_original = $array2;
                            // validacion para la otra moneda con igv paralelo
                            $utilidad = Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') * ($producto->utilidad - $producto->descuento1) / 100;
                            $array = round((Stock_producto::where('producto_id', $producto->id)->avg('precio_nacional') + $utilidad) / $cambio->paralelo, 2);
                            $facturacion_registro->precio = $array;
                        }
                    }
                    $facturacion_registro->cantidad = $request->get('cantidad')[$i];
                    $facturacion_registro->descuento = $request->get('check_descuento')[$i];
                    $facturacion_registro->comision = $comi;
                    //precio unitario descuento ----------------------------------------
                    $desc_comprobacion = $request->get('check_descuento')[$i];
                    if ($desc_comprobacion <> 0) {
                        $facturacion_registro->precio_unitario_desc = $array - ($array2 * $desc_comprobacion / 100);
                    } else {
                        $facturacion_registro->precio_unitario_desc = $array;
                    }
                    //precio unitario comision ----------------------------------------
                    if ($desc_comprobacion <> 0) {
                        $factura_desc = round($array - ($array2 * $desc_comprobacion / 100), 2);
                        $facturacion_registro->precio_unitario_comi = round($factura_desc + ($factura_desc * $comi / 100), 2);
                    } else {
                        $facturacion_registro->precio_unitario_comi = round($array + ($array * $comi / 100), 2);
                    }
                    $facturacion_2 = Facturacion::find($facturacion->id);
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Gravado') !== false) {
                        $facturacion_2->op_gravada += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Exonerado') !== false) {
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    if (strpos($producto->tipo_afec_i_producto->informacion, 'Inafecto') !== false) {
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    // return $cotizacion_registro->precio_unitario_comi;
                    $facturacion_2->save();
                    $facturacion_registro->save();

                    //empieza la busqueda total

                    //en caso haya guia de remision esto ya no se efectua
                    if ($facturacion->guia_remision == "0") {
                        $almacen = $facturacion->almacen_id;

                        $nueva = Kardex_entrada_registro::where('producto_id', $facturacion_registro->producto_id)->where('almacen_id', $almacen)->where('estado', 1)->get();

                        $comparacion = $nueva;
                        //buble para la cantidad
                        $cantidad = 0;
                        foreach ($comparacion as $comparaciones) {
                            $cantidad = $comparaciones->cantidad + $cantidad;
                        }

                        if (isset($comparacion)) {
                            $var_cantidad_entrada = $facturacion_registro->cantidad;
                            $contador = 0;
                            foreach ($comparacion as $p) {
                                if ($p->cantidad > $var_cantidad_entrada) {
                                    $cantidad_mayor = $p->cantidad;
                                    $cantidad_final = $cantidad_mayor - $var_cantidad_entrada;
                                    $p->cantidad = $cantidad_final;
                                    if ($cantidad_final == 0) {
                                        $p->estado = 0;
                                        $p->save();
                                        break;
                                    } else {
                                        $p->save();
                                        break;
                                    }
                                } elseif ($p->cantidad == $var_cantidad_entrada) {
                                    $p->cantidad = 0;
                                    $p->estado = 0;
                                    $p->save();
                                    break;
                                } else {
                                    $var_cantidad_entrada = $var_cantidad_entrada - $p->cantidad;
                                    $p->cantidad = 0;
                                    $p->estado = 0;
                                    $p->save();
                                }
                            }
                        }
                        //Resta en la tabla stock almacen
                        Stock_almacen::egreso($facturacion->almacen_id, $producto->id, $facturacion_registro->cantidad);
                        //resta de cantidades de productos para la tabla stock productos
                        $stock_productos = Stock_producto::where('producto_id', $producto->id)->first();
                        $stock_productos->stock = $stock_productos->stock - $facturacion_registro->cantidad;
                        $stock_productos->save();
                    }
                } else {
                    $servicio = Servicios::where('codigo_servicio', $producto_id[$i])->where('estado_anular', 0)->first();
                    // return   $servicio;
                    $facturacion_registro = new Facturacion_registro();
                    $facturacion_registro->facturacion_id = $facturacion->id;
                    $facturacion_registro->servicio_id = $servicio->id;
                    //Precio -----------------------------------------------------------------------------------------
                    if ($moneda->id == $moneda_registrada) {
                        if ($moneda->tipo == 'nacional') {
                            $precio_prom = $servicio->precio_nacional;
                            $facturacion_registro->promedio_original = $precio_prom;
                            $utilidad = $servicio->precio_nacional * ($servicio->utilidad) / 100;
                            $array = $servicio->precio_nacional + $utilidad;
                        } else {
                            $precio_prom = $servicio->precio_extranjero;
                            $facturacion_registro->promedio_original = $precio_prom;
                            $utilidad = $servicio->precio_extranjero * ($servicio->utilidad) / 100;
                            $array = $servicio->precio_extranjero + $utilidad;
                            // return '1';
                        }
                    } else {
                        if ($moneda->tipo == 'extranjera') {
                            $precio_prom = $servicio->precio_extranjero * $tipo_cambio->paralelo;
                            $facturacion_registro->promedio_original = $precio_prom;
                            $utilidad = $servicio->precio_extranjero * ($servicio->utilidad) / 100;
                            $array = round(($servicio->precio_extranjero + $utilidad) * $tipo_cambio->paralelo, 2);
                            // return '2';
                        } else {
                            $precio_prom = $servicio->precio_nacional / $tipo_cambio->paralelo;
                            $facturacion_registro->promedio_original = $precio_prom;
                            $utilidad = $servicio->precio_nacional * ($servicio->utilidad) / 100;
                            $array = round(($servicio->precio_nacional + $utilidad) / $tipo_cambio->paralelo, 2);
                            // return $array;
                        }
                    }


                    $facturacion_registro->precio = $array;
                    $facturacion_registro->cantidad = $request->get('cantidad')[$i];
                    $facturacion_registro->comision = $comi;
                    $descuento_verificacion = $request->get('check_descuento')[$i];
                    $facturacion_registro->descuento = $descuento_verificacion;
                    if ($request->get('descripcion_item')[$i] == null) {
                        $facturacion_registro->descripcion_item = null;
                    } else {
                        $facturacion_registro->descripcion_item = $request->get('descripcion_item')[$i];
                    }
                    if ($descuento_verificacion <> 0) {
                        $facturacion_registro->precio_unitario_desc = $array - ($precio_prom * $descuento_verificacion / 100);
                    } else {
                        $facturacion_registro->precio_unitario_desc = $array;
                    }
                    //precio unitario comision ----------------------------------------
                    if ($descuento_verificacion <> 0) {
                        $prec_uni_des = $array - ($precio_prom * $descuento_verificacion / 100);
                        $facturacion_registro->precio_unitario_comi = ($prec_uni_des + ($prec_uni_des * $comi / 100));
                    } else {
                        $facturacion_registro->precio_unitario_comi = $array + ($array * $comi / 100);
                    }

                    $facturacion_2 = Facturacion::find($facturacion->id);
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Gravado') !== false) {
                        $facturacion_2->op_gravada += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Exonerado') !== false) {
                        $facturacion_2->op_exonerada += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    if (strpos($servicio->tipo_afec_i_serv->informacion, 'Inafecto') !== false) {
                        $facturacion_2->op_inafecta += round($facturacion_registro->precio_unitario_comi * $facturacion_registro->cantidad, 2);
                    }
                    // return $cotizacion_registro->precio_unitario_comi;
                    $facturacion_2->save();

                    $facturacion_registro->save();
                }
            }
            Kardex_entrada_registro::stock_producto_precio();
            if($facturacion->forma_pago_id == 2){
                Facturacion::revision_cuotas($facturacion->id);
            }
            
        } else {
            return redirect()->route('facturacion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('facturacion.show', $facturacion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = kardex_entrada::where('estado', 2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id = Facturacion::where('id', $id)->first();
        if (empty($existe_id)) {
            return redirect()->route('facturacion.index');
        }

        $empresa = Empresa::first();
        $facturacion = Facturacion::find($id);
        $facturacion_registro = Facturacion_registro::where('facturacion_id', $id)->get();
        $sum = 0;
        $igv = Igv::first();
        $sub_total = 0;
        $banco = Banco::where('estado', 0)->get();
        $j = 1;

        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_id', $facturacion->id)->first();
        }else{
            $detraccion = 'not';
        }
        return view('transaccion.venta.facturacion.show', compact('j', 'facturacion', 'empresa', 'facturacion_registro', 'sum', 'igv', 'sub_total', 'banco','detraccion'));

        if ($facturacion->id_cotizador_servicio == NULL) {
            return view('transaccion.venta.facturacion.show', compact('j', 'facturacion', 'empresa', 'facturacion_registro', 'sum', 'igv', 'sub_total', 'banco'));
        } else {
            return view('transaccion.venta.facturacion.show_servicio', compact('facturacion', 'empresa', 'facturacion_registro', 'sum', 'igv', 'sub_total', 'banco'));
        }
    }

    function print($id)
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id = kardex_entrada::where('estado', 2)->first();
        // if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id = Facturacion::where('id', $id)->first();
        if (empty($existe_id)) {
            return redirect()->route('facturacion.index');
        }

        $empresa = Empresa::first();
        $facturacion = Facturacion::find($id);
        $facturacion_registro = Facturacion_registro::where('facturacion_id', $id)->get();
        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_id', $facturacion->id)->first();
            if ($facturacion->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $facturacion->id)->get();
            }else{
                $cuotas = "not";   
            }
        }else{
            $detraccion = "not";
            $cuotas = "not";
        }
        $sum = 0;
        $igv = Igv::first();
        $sub_total = 0;
        $banco = Banco::where('estado', 0)->get();
        $j = 1;
        return view('transaccion.venta.facturacion.print', compact('j', 'facturacion', 'empresa', 'facturacion_registro', 'sum', 'igv', 'sub_total', 'banco', 'detraccion','cuotas'));
    }

    public function pdf(Request $request, $id)
    {
        $name = $request->get('name');
        // $regla=$cotizacion->tipo;
        $empresa = Empresa::first();
        $facturacion = Facturacion::find($id);
        $facturacion_registro = Facturacion_registro::where('facturacion_id', $id)->get();
        if($facturacion->tipo_operacion_id == 12 || $facturacion->tipo_operacion_id == 13 || $facturacion->tipo_operacion_id == 14 ||$facturacion->tipo_operacion_id == 15 ){
            $detraccion = Detracciones::where('factura_id', $facturacion->id)->first();
            if ($facturacion->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $facturacion->id)->get();
            }else{
                $cuotas = "not";   
            }
        }else{
            $detraccion = "not";
            $cuotas = "not";
        }
        $sum = 0;
        $igv = Igv::first();
        $sub_total = 0;
        $banco = Banco::where('estado', 0)->get();
        $banco_count = Banco::where('estado', '0')->count();
        $i = 1;

        // $archivo=$name.'_'.$id;
        // return view('transaccion.venta.facturacion.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));

        $pdf = PDF::loadView('transaccion.venta.facturacion.pdf', compact('facturacion', 'empresa', 'facturacion_registro', 'sum', 'igv', 'sub_total', 'banco', 'banco_count', 'i','detraccion','cuotas'));
        return $pdf->download('Factura - ' . $facturacion->codigo_fac . '.pdf');

        // return view('transaccion.venta.facturacion.print', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
    }

    public function show_boleta(Request $request, $id)
    {
        return view('transaccion.venta.facturacion.boleta');
    }

    public function create_boleta()
    {
        return view('transaccion.venta.facturacion.create_boleta');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facturacion = Facturacion::find($id);
        return view('transaccion.venta.facturacion.edit', compact('facturacion'));
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
        // return $id;
        $factura = Facturacion::where('id', $id)->first();
        if ($factura->comisionista != 0) {
            $venta_registro = Ventas_registro::where('id_facturacion', $id)->first();
            $id_venta_r = $venta_registro->id;

            $venta = Ventas_registro::where('id', $id_venta_r)->first();
            $venta->estado_fac = 1;
            $venta->save();
        }
        $fac = Facturacion::where('id', $id)->first();
        $fac->estado = 1;
        $fac->save();

        return redirect()->route('facturacion.index');
    }
    public function ticket(Request $request, $id)
    {

        $facturacion = Facturacion::find($id);
        $facturacion_registro = Facturacion_registro::where('facturacion_id', $id)->get();
        $empresa = Empresa::first();
        $moneda = Moneda::where('id', $facturacion->moneda_id)->first();
        $igv = Igv::first();
        return view('transaccion.venta.facturacion.ticket', compact('facturacion', 'facturacion_registro', 'empresa', 'igv', 'moneda'));
    }

    public function anulacion(Request $request)
    {

        $id = $request->get('id_fact');
        $factura = Facturacion::where('id', $id)->first();
        // return $factura;
        $factura->estado = 1;
        $factura->f_electronica = 2;
        $factura->save();


        //FACTURAS CON GUIA DE REMISION
        if ($factura->guia_remision == "0") {
            $factura_reg = Facturacion_registro::where('facturacion_id', $factura->id)->get();
            // return
            //DESCUENTO DE STOCK 
            foreach ($factura_reg as $fact_reg) {
                // return $fact_reg;
                if ($fact_reg->producto_id  != null) {
                    Stock_almacen::ingreso($factura->almacen_id, $fact_reg->producto_id, $fact_reg->cantidad);
                    // return "a";
                }
            }
            kardex_entrada_registro::stock_producto_precio();
        }
        return redirect()->back();
    }
    public function ajax_remision(Request $request)
    {
        $id_cli = $request->get('id_cliente');
        // buscar guias de remision por cliente que no este enviadas a la sunat

        $guias = Guia_remision::where('cliente_id', $id_cli)->where('g_electronica', 0)->get();
        // return count($guias);

        if (count($guias) != 0) {
            foreach ($guias as $guias_r) {
                $guias_cod[] = $guias_r->cod_guia;
            }
            return $guias_cod;
        } else {
            $guias_cod = "vacio";
            return $guias_cod;
        }
    }
}
