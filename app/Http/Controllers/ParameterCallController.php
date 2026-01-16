<?php

namespace App\Http\Controllers;

// * Importing of models
use App\Producto;
use App\Servicios;
use App\Almacen;
use App\Boleta;
use App\Boleta_m;
use App\Boleta_registro;
use App\Boleta_registros_m;
use App\CategoriasEventos;
use App\Moneda;
use App\Stock_producto;
use App\Stock_almacen;
use App\Cliente;
use App\ComprobantesVentas;
use App\Empresa;
use App\TipoCambio;
use App\Kardex_entrada;
use App\helpers;
use App\Tipo_operacion_f;
use App\TipoDetraccion;
use App\User;
use CifrasEnLetras;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_TransportException;

use Illuminate\Http\Request;

class ParameterCallController extends Controller
{
    // * (description) es una función para obtener los datos requeridos del articulo (producto-servicio),devolviendo descripción, precio, stock y otros
    public function description(Request $request)
    {
        // return $request;
        //Obtención de la moneda
        $money = $request->get('moneda');
        $money_id = Moneda::where('id', $money)->first();
        // return $money_id;
        //Obtención del articulo
        $article = $request->get('articulo');
        $id = explode(" | ", $article); //separador del articulo por espacio

        //Obtención del almacén
        $store = $request->get('almacen');
        $branch_office = Almacen::where('id', $store)->first(); //obtención del almacén por el id

        //validación en caso se envié campo vacíos
        if ($article == NULL) {
            return response()->json(['error' => 'No existe ningún artículo'], 400);
        }
        // return $id;
        //Obtención de los datos del articulo (producto-servicio)
        $product = Producto::where('id', $id[0])->where('codigo_producto', $id[1])->where('codigo_original', $id[2])->first();
        $service = Servicios::where('id', $id[0])->where('codigo_servicio', $id[1])->where('codigo_original', $id[2])->first();
        // return $product;
        // OPCIONE PARA BUSCAR SIN ERRORES, CODIGO[2] ES UNICO PRODUCTO TIENE 8 CEROS Y SERVICIO 6 CEROS
        // $product=Producto::where('codigo_producto',$id[2])->first();
        // $service=Servicios::where('codigo_servicio',$id[2])->first();

        //Obtención del tipo de cambio
        $tipo_cambio = TipoCambio::latest('created_at')->first();


        //obtención de moneda en caso sea la principal
        if ($money_id->principal == 1) {
            $moneda = Moneda::where('principal', '1')->first();
            //Diferenciador de producto y servicio
            if (isset($product)) {
                //Calculo de array para precio, stock en (PRODUCTO)
                if ($moneda->tipo == 'nacional') {
                    $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                    $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad), 2);
                    $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                    $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional'), 2);
                } else {
                    $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                    $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad), 2);
                    $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                    $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero'), 2);
                }
                //Guardado de variables
                $identifier = 'product';
                $utility = $utilidad;
                $price = $array;
                $amount = $array_cantidad;
                $average = $array_promedio;
                $description = $product->descripcion;
                $discount = $product->descuento2;
                $afectacion_explode = explode(" ", $product->tipo_afec_i_producto->informacion);
                $afectacion = $afectacion_explode[0];
            } else {
                if ($moneda->tipo == 'nacional') {
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                    $array2 = round($service->precio_nacional + $utilidad_serv, 2);
                    $array_promedio_serv = ($service->precio_nacional);
                } else {
                    $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                    $array2 = round($service->precio_extranjero + $utilidad_serv, 2);
                    $array_promedio_serv = ($service->precio_extranjero);
                }
                //Guardado de variables
                $identifier = 'service';
                $utility = $utilidad_serv;
                $price = $array2;
                $amount = 100;
                $average = $array_promedio_serv;
                $description = $service->descripcion;
                $discount = $service->descuento;
                $afectacion_explode = explode(" ", $service->tipo_afec_i_serv->informacion);
                $afectacion = $afectacion_explode[0];
            }
        } else {
            $moneda = Moneda::where('principal', '0')->first();
            //Diferenciador de producto y servicio
            if (isset($product)) {
                //Calculo de array para precio, stock en (PRODUCTO)
                if ($moneda->tipo == 'extranjera') {
                    $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                    $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad) / $tipo_cambio->paralelo, 2);
                    $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                    $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') / $tipo_cambio->paralelo, 2);
                } else {
                    $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                    $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad) * $tipo_cambio->paralelo, 2);
                    $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                    $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * $tipo_cambio->paralelo, 2);
                }
                //Guardado de variables
                $identifier = 'product';
                $utility = $utilidad;
                $price = $array;
                $amount = $array_cantidad;
                $average = $array_promedio;
                $description = $product->descripcion;
                $discount = $product->descuento2;
                $afectacion_explode = explode(" ", $product->tipo_afec_i_producto->informacion);
                $afectacion = $afectacion_explode[0];
            } else {
                if ($moneda->tipo == 'extranjera') {
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                    $array2 = round(($service->precio_nacional + $utilidad_serv) / $tipo_cambio->paralelo, 2);
                    $array_promedio_serv = ($service->precio_nacional) / $tipo_cambio->paralelo;
                } else {
                    $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                    $array2 = round(($service->precio_extranjero + $utilidad_serv) * $tipo_cambio->paralelo, 2);
                    $array_promedio_serv = $service->precio_extranjero / $tipo_cambio->paralelo;
                }
                //Guardado de variables
                $identifier = 'service';
                $utility = $utilidad_serv;
                $price = $array2;
                $amount = 100;
                $average = $array_promedio_serv;
                $description = $service->descripcion;
                $discount = $service->descuento;
                $afectacion_explode = explode(" ", $service->tipo_afec_i_serv->informacion);
                $afectacion = $afectacion_explode[0];
            }
        }

        // * (data) es un array donde se alojaran todos los campos requeridos para devolverlos de forma correcta
        $data = [
            'id' => $identifier,
            'description' => $description,
            'price' => $price,
            'amount' => $amount,
            'average' => $average,
            'utility' => $utility,
            'discount' => $discount,
            'afectacion' => $afectacion,
            'moneda' => $moneda,
        ];

        return $data;
    }

    // * Llamado de la tabla clientes
    public function getClients(Request $request)
    {
        $search = $request->search;
        $tipo = $request->tipo_coti;
        $default = $request->select_default;

        if ($tipo == '1') { //Factura
            if ($search == '') {
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento', 'documento_identificacion')->where('documento_identificacion', 'RUC')->limit(5)->get();
            } else {
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento', 'documento_identificacion')->where('documento_identificacion', 'RUC')->where(function ($query) use ($search) {
                    $query->where('nombre', 'like', '%' . $search . '%')->orWhere('numero_documento', 'like', '%' . $search . '%');
                })->limit(5)->get();
            }
        } else if ($tipo == '0') { //Boleta
            if ($search == '') {
                // $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento')->where('documento_identificacion', '!=', 'RUC')->limit(5)->get();
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento')->limit(5)->get();
            } else {
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento', 'documento_identificacion')->where('documento_identificacion', 'DNI')->where(function ($query) use ($search) {
                    $query->where('nombre', 'like', '%' . $search . '%')->orWhere('numero_documento', 'like', '%' . $search . '%');
                })->limit(5)->get();
            }
        } else { // All : ESTE ELSE ES EXCLUYENTE SI ES UNA BOLETA O FACTURA PARA EL LLAMADO DE RUC O DNI
            if ($search == '') {
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento')->limit(5)->get();
            } else {
                $employees = Cliente::orderby('created_at', 'desc')->select('id', 'nombre', 'numero_documento', 'documento_identificacion')->where('nombre', 'like', '%' . $search . '%')->orWhere('numero_documento', 'like', '%' . $search . '%')->limit(5)->get();
            }
        }
        // return $tipo;
        $response = array();
        if (isset($default)) {
            $default_cli = Cliente::where('id', $default)->first();
            $response[] = array(
                "id" => $default_cli->id,
                "nombre" => $default_cli->nombre,
                "numero_documento" => $default_cli->numero_documento
            );
        }
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "nombre" => $employee->nombre,
                "numero_documento" => $employee->numero_documento
            );
        }
        return response()->json($response);
    }



    // * Llamado de la tabla artículos (PRODUCTOS - SERVICIOS)
    public function getArticles(Request $request)
    {
        $search = $request->search;
        $almacen = $request->almacen;
        $tipo_doc = $request->tipo_doc;
        if ($search == '') {
            $products = Producto::orderby('nombre', 'desc')->select('id', 'codigo_producto', 'codigo_original', 'nombre')->where('codigo_producto', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%')->limit(5)->get();
            $services = Servicios::orderby('nombre', 'asc')->select('id', 'codigo_servicio', 'codigo_original', 'nombre', 'estado_anular')->where('codigo_servicio', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%')->limit(5)->get();
        } else {
            $products = Producto::orderby('nombre', 'asc')->select('id', 'codigo_producto', 'codigo_original', 'nombre')->where('codigo_producto', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->limit(5)->get();
            $services = Servicios::orderby('nombre', 'asc')->select('id', 'codigo_servicio', 'codigo_original', 'nombre', 'estado_anular')->where('nombre', 'like', '%' . $search . '%')->orWhere('codigo_servicio', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->limit(5)->get();
        }
        //Productos a array
        if ($almacen != 0) {
            if ($tipo_doc == 'manual') {
                $products_array = array();
                foreach ($products as $product) {
                    $stock_almacen = Stock_almacen::where('almacen_id', $almacen)->where('producto_id', $product->id)->first();
                    if ($stock_almacen->producto_ids->estado_anular == "1") {
                        $products_array[] = array(
                            "id" => $product->id,
                            "nombre" => $product->nombre,
                            "codigo" => $product->codigo_producto,
                            "codigo_original" => $product->codigo_original,
                            "tipo" => 'producto'
                        );
                    }
                }
            } else {
                $products_array = array();
                foreach ($products as $product) {
                    $stock_almacen = Stock_almacen::where('almacen_id', $almacen)->where('producto_id', $product->id)->first();
                    if ($stock_almacen->stock > "0") {
                        $products_array[] = array(
                            "id" => $product->id,
                            "nombre" => $product->nombre,
                            "codigo" => $product->codigo_producto,
                            "codigo_original" => $product->codigo_original,
                            "tipo" => 'producto'
                        );
                    }
                }
            }
        } else {
            if ($tipo_doc == 'manual') {
                $products_array = array();
                foreach ($products as $product) {
                    $stock_almacen = Stock_almacen::where('producto_id', $product->id)->first();
                    if ($stock_almacen->producto_ids->estado_anular == "1") {
                        $products_array[] = array(
                            "id" => $product->id,
                            "nombre" => $product->nombre,
                            "codigo" => $product->codigo_producto,
                            "codigo_original" => $product->codigo_original,
                            "tipo" => 'producto'
                        );
                    }
                }
            } else {
                $products_array = array();
                foreach ($products as $product) {
                    $stock_almacen = Stock_almacen::where('producto_id', $product->id)->first();
                    if ($stock_almacen->stock > "0") {
                        $products_array[] = array(
                            "id" => $product->id,
                            "nombre" => $product->nombre,
                            "codigo" => $product->codigo_producto,
                            "codigo_original" => $product->codigo_original,
                            "tipo" => 'producto'
                        );
                    }
                }
            }
        }

        //Servicios a arraygit
        $services_array = array();
        foreach ($services as $service) {
            if ($service->estado_anular == "0") {
                $services_array[] = array(
                    "id" => $service->id,
                    "nombre" => $service->nombre,
                    "codigo" => $service->codigo_servicio,
                    "codigo_original" => $service->codigo_original,
                    "tipo" => 'servicio'
                );
            }
        }
        // return $services;
        $articles = array();
        $articles = array_merge($products_array, $services_array);

        return $articles;
    }

    //* Llamado de moneda para la diferenciación de la principal y secundaria
    public function getMoney(Request $request)
    {
        if ($request->status == 1) {
            $money = Moneda::where('principal', 1)->first();
            $money->status = 0;
            $other_money = Moneda::where('principal', 0)->first();
            $money->other = $other_money->nombre;
        } else {
            $money = Moneda::where('principal', 0)->first();
            $money->status = 1;
            $other_money = Moneda::where('principal', 1)->first();
            $money->other = $other_money->nombre;
        }

        return $money;
    }

    //* Verificacion de credenciales para el usuario en correo
    public function checkEmailCredential(Request $request)
    {
        // return $request;
        $smtpAddress = $request->smtpAddress;
        $port = $request->port;
        $encryption = $request->encryption;
        $yourEmail = $request->yourEmail;
        $yourPassword = $request->yourPassword;

        try {
            $transport = (new Swift_SmtpTransport($smtpAddress, $port, $encryption))
                ->setUsername($yourEmail)
                ->setPassword($yourPassword);
            $mailer = new Swift_Mailer($transport);
            $mailer->getTransport()->start();
        } catch (Swift_TransportException $e) {
            return 1;
        } catch (Exception $e) {
            return 1;
        }
        return 0;
    }
    public function getNFactura(Request $request)
    {
        $search = $request->n_factura;


        // search 0 = no existe
        // search 1 = existe

        $n_factura = Kardex_entrada::where('factura', $search)->first();
        if ($search == "0") {
            $var_vuelta = 0;
        } elseif (isset($n_factura)) {
            $var_vuelta = 1;
        } else {
            $var_vuelta = 0;
        }

        return $var_vuelta;
    }


    //* LLamado para convertir de numero a letras con php
    public function getNumberLetter(Request $request)
    {
        $number = $request->numeros;
        $moneda = $request->moneda;
        $end2 = number_format(round($number, 2), 2);
        $end = round($number, 2);

        $v = new CifrasEnLetras();
        $letra = ($v->convertirEurosEnLetras($end));
        $letra_final = ucfirst(strstr($letra, 'soles', true));
        $end_final_point = strstr($end2, '.', false);
        $end_final = str_replace('.', ' ', $end_final_point);

        $convertido = "Son : " . "$letra_final" . "con" . "$end_final" . "/100 " . $moneda;
        return $convertido;
    }
    //* LLAMADO PARA AJAX PRODUCTO EN GUIA REMISION NORMAL Y MANUAL
    public function ajax_remision(Request $request)
    {
        $search = $request->search;
        if ($search == '') {
            $productos = Producto::orderby('nombre', 'desc')->select('id', 'codigo_producto', 'codigo_original', 'nombre', 'estado_anular')->where('codigo_producto', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%')->limit(5)->get();
        } else {
            $productos = Producto::orderby('nombre', 'asc')->select('id', 'codigo_producto', 'codigo_original', 'nombre', 'estado_anular')->where('codigo_producto', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%')->orWhere('codigo_original', 'like', '%' . $search . '%')->limit(5)->get();
        }
        foreach ($productos as $prods) {
            if ($prods->estado_anular == "1") {
                $products_array[] = array(
                    "id" => $prods->id,
                    "cod_prod" => $prods->codigo_producto,
                    "cod_origi" => $prods->codigo_original,
                    "nombre" => $prods->nombre
                );
            }
        }
        return $products_array;
    }
    public function color_set(Request $request)
    {
        // return $request;
        $category = CategoriasEventos::where('id', $request->color)->first();
        return response()->json($category->color);
    }
    public function search_category(Request $request)
    {
        $category = CategoriasEventos::where('id', $request->get('categoria'))->first();
        return $category;
    }
    public function search_users(Request $request)
    {
        $user = User::where('estado', 1)->get();
        return $user;
    }
    public function search_tipo_operacion(Request $request)
    {
        $tipo_operacion = TipoDetraccion::where('id', $request->get('id_tipo_detra'))->first();
        return $tipo_operacion;
    }

    public function search_product(Request $request)
    {
        $money = $request->get('moneda');
        $money_id = Moneda::where('id', $money)->first();
        $store = $request->get('almacen');

        $search = $request->articulo;
        //Obtención del tipo de cambio
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // OBTENCION DE LOS ARTICULOS A BUSCAR
        $orderProduct = $search == '' ? 'desc' : 'asc';
        $orderService = 'asc';

        $products = Producto::orderby('nombre', $orderProduct)
            ->select('id', 'codigo_producto', 'codigo_original', 'nombre')
            ->where(function ($query) use ($search) {
                $query->where('codigo_producto', 'like', '%' . $search . '%')
                    ->orWhere('codigo_original', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            })
            ->get();

        $services = Servicios::orderby('nombre', $orderService)
            ->select('id', 'codigo_servicio', 'codigo_original', 'nombre', 'estado_anular')
            ->where(function ($query) use ($search) {
                $query->where('codigo_servicio', 'like', '%' . $search . '%')
                    ->orWhere('codigo_original', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            })
            ->get();

        if ($money_id->principal == 1) {
            $moneda = Moneda::where('principal', '1')->first();
            if (count($products) > 0) {
                foreach ($products as $key1 => $single_product) {
                    $product = Producto::find($single_product->id);
                    if ($moneda->tipo == 'nacional') {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad), 2);
                        $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional'), 2);
                    } else {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad), 2);
                        $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero'), 2);
                    }
                    $afectacion = explode(" ", $product->tipo_afec_i_producto->informacion);

                    //Guardado de variables
                    $data_all[] = [
                        'identifier' => 'product',
                        'id' => $product->id,
                        'codigo' => $product->codigo_producto . " | " . $product->codigo_original,
                        'nombre' => $product->nombre,
                        'description' => $product->descripcion,
                        'utility' => $utilidad,
                        'price' => $array,
                        'stock' => $array_cantidad,
                        'average' => $array_promedio,
                        'discount' => $product->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
            if (count($services) > 0) {
                foreach ($services as $key2 => $single_service) {
                    $service = Servicios::find($single_service->id);
                    if ($moneda->tipo == 'nacional') {
                        //Calculo de array para precio, stock en (SERVICIO)
                        $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                        $array2 = round($service->precio_nacional + $utilidad_serv, 2);
                        $array_promedio_serv = ($service->precio_nacional);
                    } else {
                        $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                        $array2 = round($service->precio_extranjero + $utilidad_serv, 2);
                        $array_promedio_serv = ($service->precio_extranjero);
                    }
                    $afectacion = explode(" ", $service->tipo_afec_i_serv->informacion);
                    $data_all[] = [
                        'identifier' => 'service',
                        'id' => $service->id,
                        'codigo' => $service->codigo_servicio . " | " . $service->codigo_original,
                        'nombre' => $service->nombre,
                        'description' => $service->descripcion,
                        'utility' => $utilidad_serv,
                        'price' => $array2,
                        'stock' => 100,
                        'average' => $array_promedio_serv,
                        'discount' => $service->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
        } else {
            $moneda = Moneda::where('principal', '0')->first();
            if (count($products) > 0) {
                foreach ($products as $key3 => $single_product) {
                    $product = Producto::find($single_product->id);
                    if ($moneda->tipo == 'extranjera') {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad) / $tipo_cambio->paralelo, 2);
                        $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') / $tipo_cambio->paralelo, 2);
                    } else {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad) * $tipo_cambio->paralelo, 2);
                        $array_cantidad = Stock_almacen::where('producto_id', $product->id)->where('almacen_id', $store)->pluck('stock')->first();
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * $tipo_cambio->paralelo, 2);
                    }
                    $afectacion = explode(" ", $product->tipo_afec_i_producto->informacion);
                    $data_all[] = [
                        'identifier' => 'product',
                        'id' => $product->id,
                        'codigo' => $product->codigo_producto . " | " . $product->codigo_original,
                        'nombre' => $product->nombre,
                        'description' => $product->descripcion,
                        'utility' => $utilidad,
                        'price' => $array,
                        'stock' => $array_cantidad,
                        'average' => $array_promedio,
                        'discount' => $product->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
            if (count($services) > 0) {
                foreach ($services as $key4 => $single_service) {
                    $service = Servicios::find($single_service->id);
                    if ($moneda->tipo == 'extranjera') {
                        //Calculo de array para precio, stock en (SERVICIO)
                        $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                        $array2 = round(($service->precio_nacional + $utilidad_serv) / $tipo_cambio->paralelo, 2);
                        $array_promedio_serv = ($service->precio_nacional) / $tipo_cambio->paralelo;
                    } else {
                        $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                        $array2 = round(($service->precio_extranjero + $utilidad_serv) * $tipo_cambio->paralelo, 2);
                        $array_promedio_serv = $service->precio_extranjero / $tipo_cambio->paralelo;
                    }
                    $afectacion = explode(" ", $service->tipo_afec_i_serv->informacion);
                    $data_all[] = [
                        'identifier' => 'service',
                        'id' => $service->id,
                        'codigo' => $service->codigo_servicio . " | " . $service->codigo_original,
                        'nombre' => $service->nombre,
                        'description' => $service->descripcion,
                        'utility' => $utilidad_serv,
                        'price' => $array2,
                        'stock' => 100,
                        'average' => $array_promedio_serv,
                        'discount' => $service->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
        }
        // * (data) es un array donde se alojaran todos los campos requeridos para devolverlos de forma correcta
        if (count($products) == 0 && count($services) == 0) {
            return response()->json([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        return response(json_encode($data_all), 200)->header('content-type', 'text/plain');
    }
    public function search_product_manual(Request $request)
    {
        // FALTA OBTENCION DEL IGV
        $money = $request->get('moneda');
        $money_id = Moneda::where('id', $money)->first();
        $store = $request->get('almacen');

        //igv

        $search = $request->articulo;
        //Obtención del tipo de cambio
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // OBTENCION DE LOS ARTICULOS A BUSCAR
        $orderProduct = $search == '' ? 'desc' : 'asc';
        $orderService = 'asc';

        $products = Producto::orderby('nombre', $orderProduct)
            ->select('id', 'codigo_producto', 'codigo_original', 'nombre')
            ->where(function ($query) use ($search) {
                $query->where('codigo_producto', 'like', '%' . $search . '%')
                    ->orWhere('codigo_original', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            })
            ->get();

        $services = Servicios::orderby('nombre', $orderService)
            ->select('id', 'codigo_servicio', 'codigo_original', 'nombre', 'estado_anular')
            ->where(function ($query) use ($search) {
                $query->where('codigo_servicio', 'like', '%' . $search . '%')
                    ->orWhere('codigo_original', 'like', '%' . $search . '%')
                    ->orWhere('nombre', 'like', '%' . $search . '%');
            })
            ->get();

        if ($money_id->principal == 1) {
            $moneda = Moneda::where('principal', '1')->first();
            if (count($products) > 0) {
                foreach ($products as $key1 => $single_product) {
                    $product = Producto::find($single_product->id);
                    if ($moneda->tipo == 'nacional') {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad), 2);
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional'), 2);
                    } else {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad), 2);
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero'), 2);
                    }
                    $afectacion = explode(" ", $product->tipo_afec_i_producto->informacion);

                    //Guardado de variables
                    $data_all[] = [
                        'identifier' => 'product',
                        'id' => $product->id,
                        'codigo' => $product->codigo_producto . " | " . $product->codigo_original,
                        'nombre' => $product->nombre,
                        'description' => $product->descripcion,
                        'utility' => $utilidad,
                        'price' => $array,
                        'average' => $array_promedio,
                        'discount' => $product->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
            if (count($services) > 0) {
                foreach ($services as $key2 => $single_service) {
                    $service = Servicios::find($single_service->id);
                    if ($moneda->tipo == 'nacional') {
                        //Calculo de array para precio, stock en (SERVICIO)
                        $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                        $array2 = round($service->precio_nacional + $utilidad_serv, 2);
                        $array_promedio_serv = ($service->precio_nacional);
                    } else {
                        $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                        $array2 = round($service->precio_extranjero + $utilidad_serv, 2);
                        $array_promedio_serv = ($service->precio_extranjero);
                    }
                    $afectacion = explode(" ", $service->tipo_afec_i_serv->informacion);
                    $data_all[] = [
                        'identifier' => 'service',
                        'id' => $service->id,
                        'codigo' => $service->codigo_servicio . " | " . $service->codigo_original,
                        'nombre' => $service->nombre,
                        'description' => $service->descripcion,
                        'utility' => $utilidad_serv,
                        'price' => $array2,
                        'average' => $array_promedio_serv,
                        'discount' => $service->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
        } else {
            $moneda = Moneda::where('principal', '0')->first();
            if (count($products) > 0) {
                foreach ($products as $key3 => $single_product) {
                    $product = Producto::find($single_product->id);
                    if ($moneda->tipo == 'extranjera') {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') + $utilidad) / $tipo_cambio->paralelo, 2);
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_nacional') / $tipo_cambio->paralelo, 2);
                    } else {
                        $utilidad = Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * ($product->utilidad - $product->descuento1) / 100;
                        $array = round((Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') + $utilidad) * $tipo_cambio->paralelo, 2);
                        $array_promedio = round(Stock_producto::where('producto_id', $product->id)->avg('precio_extranjero') * $tipo_cambio->paralelo, 2);
                    }
                    $afectacion = explode(" ", $product->tipo_afec_i_producto->informacion);
                    $data_all[] = [
                        'identifier' => 'product',
                        'id' => $product->id,
                        'codigo' => $product->codigo_producto . " | " . $product->codigo_original,
                        'nombre' => $product->nombre,
                        'description' => $product->descripcion,
                        'utility' => $utilidad,
                        'price' => $array,
                        'average' => $array_promedio,
                        'discount' => $product->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
            if (count($services) > 0) {
                foreach ($services as $key4 => $single_service) {
                    $service = Servicios::find($single_service->id);
                    if ($moneda->tipo == 'extranjera') {
                        //Calculo de array para precio, stock en (SERVICIO)
                        $utilidad_serv = $service->precio_nacional * ($service->utilidad) / 100;
                        $array2 = round(($service->precio_nacional + $utilidad_serv) / $tipo_cambio->paralelo, 2);
                        $array_promedio_serv = ($service->precio_nacional) / $tipo_cambio->paralelo;
                    } else {
                        $utilidad_serv = $service->precio_extranjero * ($service->utilidad) / 100;
                        $array2 = round(($service->precio_extranjero + $utilidad_serv) * $tipo_cambio->paralelo, 2);
                        $array_promedio_serv = $service->precio_extranjero / $tipo_cambio->paralelo;
                    }
                    $afectacion = explode(" ", $service->tipo_afec_i_serv->informacion);
                    $data_all[] = [
                        'identifier' => 'service',
                        'id' => $service->id,
                        'codigo' => $service->codigo_servicio . " | " . $service->codigo_original,
                        'nombre' => $service->nombre,
                        'description' => $service->descripcion,
                        'utility' => $utilidad_serv,
                        'price' => $array2,
                        'average' => $array_promedio_serv,
                        'discount' => $service->descuento2,
                        'afectacion' => $afectacion[0],
                        'moneda' => $moneda,
                    ];
                }
            }
        }
        // * (data) es un array donde se alojaran todos los campos requeridos para devolverlos de forma correcta
        if (count($products) == 0 && count($services) == 0) {
            return response()->json([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        return response(json_encode($data_all), 200)->header('content-type', 'text/plain');
    }


    public static function verifyPermissionAccess($permisos = [])
    {
        $access = false;
        $user = auth()->user();
        $permisosUsuario = $user->getAllPermissions()->pluck("name");
        // $permisos = ["inicio", "adminpermision", "transacciones-ventas"];

        foreach ($permisos as $permiso) {
            if (in_array($permiso, $permisosUsuario->toArray())) {
                $access = true;
                break;
            }
        }

        return $access;
    }

    public function producto_codigo_original(Request $request)
    {
        $codigo = $request->codigo;
        $producto = Producto::where('codigo_original', $codigo)->first();
        // return $producto;
        if (!isset($producto->codigo_original)) {
            return response()->json(['status' => 'ok', 'mensaje' => 'Código libre']);
        } else {
            return response()->json(['status' => 'error', 'mensaje' => 'Codigo Existente']);
        }
    }

    public function consulta_comprobante(Request $request)
    {
        $empresa = Empresa::first();
        $tipo = $request->tipo;
        if (strlen($request->correlativo) != 8) {
            $new_correlativo = str_pad($request->correlativo, 8, "0", STR_PAD_LEFT);
            $codigo = $request->serie . '-' . $new_correlativo;
        } else {
            $codigo = $request->serie . '-' . $request->correlativo;
        }
        if (isset($request->ruc_emisor)) {
            $ruc_emisor = $empresa->ruc;
            if (!$ruc_emisor) {
                return [
                    'success' => false,
                    'error' => 'Datos no coinciden'
                ];
            }
        }
        switch ($tipo) {
            case 'boleta':
                $respuesta = ComprobantesVentas::validar_boleta($request->cliente, $codigo, $request->fecha_emision, $request->monto_total);
                break;
            case 'factura':
                $respuesta = ComprobantesVentas::validar_factura($request->cliente, $codigo, $request->fecha_emision, $request->monto_total);
                break;
            case 'guia_remision':
                $respuesta = ComprobantesVentas::validar_remision($request->cliente, $codigo, $request->fecha_emision);
                break;
            case 'nota_debito':
                $respuesta = ComprobantesVentas::validar_debito($request->cliente, $codigo, $request->fecha_emision, $request->monto_total);
                break;
            case 'nota_credito':
                $respuesta = ComprobantesVentas::validar_credito($request->cliente, $codigo, $request->fecha_emision, $request->monto_total);
                break;
        }
        return response()->json($respuesta);
    }
}
