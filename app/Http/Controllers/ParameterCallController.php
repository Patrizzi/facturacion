<?php

namespace App\Http\Controllers;

// * Importing of models
use App\Producto;
use App\Servicios;
use App\Almacen;
use App\Moneda;
use App\Stock_producto;
use App\Stock_almacen;
use App\Cliente;
use App\TipoCambio;
use App\Kardex_entrada;
use App\helpers;
use CifrasEnLetras;

use Illuminate\Http\Request;

class ParameterCallController extends Controller
{
    // * (description) es una función para obtener los datos requeridos del articulo (producto-servicio),devolviendo descripción, precio, stock y otros  
    public function description(Request $request)
    {
        // return $request;
        //Obtención de la moneda
        $money=$request->get('moneda');
        $money_id=Moneda::where('id',$money)->first();
        // return $money_id;
        //Obtención del articulo
        $article=$request->get('articulo');
        $id=explode(" ",$article); //separador del articulo por espacio

        //Obtención del almacén
        $store=$request->get('almacen');
        $branch_office=Almacen::where('id',$store)->first(); //obtención del almacén por el id

        //validación en caso se envié campo vacíos
        if($article==NULL){
            return response()->json(['error'=>'No existe ningún artículo'],400);
        }

        //Obtención de los datos del articulo (producto-servicio)
        $product=Producto::where('id',$id[0])->where('codigo_producto',$id[2])->where('codigo_original',$id[4])->first();
        $service=Servicios::where('id',$id[0])->where('codigo_servicio',$id[2])->where('codigo_original',$id[4])->first();

        //Obtención del tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        
        //obtención de moneda en caso sea la principal
        if($money_id->principal==1){
            $moneda=Moneda::where('principal','1')->first();
            //Diferenciador de producto y servicio
            if(isset($product)){
                //Calculo de array para precio, stock en (PRODUCTO)
                if ($moneda->tipo == 'nacional') {
                    $utilidad=Stock_producto::where('producto_id',$product->id)->avg('precio_nacional')*($product->utilidad-$product->descuento1)/100;
                    $array=round((Stock_producto::where('producto_id',$product->id)->avg('precio_nacional')+$utilidad),2);
                    $array_cantidad=Stock_almacen::where('producto_id',$product->id)->where('almacen_id',$store)->pluck('stock')->first();
                    $array_promedio=round(Stock_producto::where('producto_id',$product->id)->avg('precio_nacional'),2);
                }else{
                    $utilidad=Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero')*($product->utilidad-$product->descuento1)/100;
                    $array=round((Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero')+$utilidad),2);
                    $array_cantidad=Stock_almacen::where('producto_id',$product->id)->where('almacen_id',$store)->pluck('stock')->first();
                    $array_promedio=round(Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero'),2);
                }
                //Guardado de variables
                $identifier= 'product';
                $utility= $utilidad;
                $price=$array;
                $amount=$array_cantidad;
                $average=$array_promedio;
                $description= $product->descripcion;
                $discount=$product->descuento2;
                $afectacion_explode=explode(" ",$product->tipo_afec_i_producto->informacion);
                $afectacion=$afectacion_explode[0];
            }else{
                if($moneda->tipo =='nacional'){
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv=$service->precio_nacional*($service->utilidad)/100;
                    $array2=round($service->precio_nacional+$utilidad_serv,2);
                    $array_promedio_serv=($service->precio_nacional);
                }else{
                    $utilidad_serv=$service->precio_extranjero*($service->utilidad)/100;
                    $array2=round($service->precio_extranjero+$utilidad_serv,2);
                    $array_promedio_serv=($service->precio_extranjero);
                }
                //Guardado de variables
                $identifier= 'service';
                $utility= $utilidad_serv;
                $price=$array2;
                $amount=10;
                $average=$array_promedio_serv;
                $description= $service->descripcion;
                $discount=$service->descuento;
                $afectacion_explode=explode(" ",$service->tipo_afec_i_serv->informacion);
                $afectacion=$afectacion_explode[0];
            }
        }else{
            $moneda=Moneda::where('principal','0')->first();
            //Diferenciador de producto y servicio
            if(isset($product)){
                //Calculo de array para precio, stock en (PRODUCTO)
                if ($moneda->tipo == 'extranjera') {
                    $utilidad=Stock_producto::where('producto_id',$product->id)->avg('precio_nacional')*($product->utilidad-$product->descuento1)/100;
                    $array=round((Stock_producto::where('producto_id',$product->id)->avg('precio_nacional')+$utilidad)/$tipo_cambio->paralelo,2);
                    $array_cantidad=Stock_almacen::where('producto_id',$product->id)->where('almacen_id',$store)->pluck('stock')->first();
                    $array_promedio=round(Stock_producto::where('producto_id',$product->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
                }else{
                    $utilidad=Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero')*($product->utilidad-$product->descuento1)/100;
                    $array=round((Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero')+$utilidad)*$tipo_cambio->paralelo,2);
                    $array_cantidad=Stock_almacen::where('producto_id',$product->id)->where('almacen_id',$store)->pluck('stock')->first();
                    $array_promedio=round(Stock_producto::where('producto_id',$product->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
                }
                //Guardado de variables
                $identifier= 'product';
                $utility= $utilidad;
                $price=$array;
                $amount=$array_cantidad;
                $average=$array_promedio;
                $description= $product->descripcion;
                $discount=$product->descuento2;
                $afectacion_explode=explode(" ",$product->tipo_afec_i_producto->informacion);
                $afectacion=$afectacion_explode[0];
            }else{
                if($moneda->tipo =='extranjera'){
                    //Calculo de array para precio, stock en (SERVICIO)
                    $utilidad_serv=$service->precio_nacional*($service->utilidad)/100;
                    $array2=round(($service->precio_nacional+$utilidad_serv)/$tipo_cambio->paralelo,2);
                    $array_promedio_serv=($service->precio_nacional)/$tipo_cambio->paralelo;
                }else{
                    $utilidad_serv=$service->precio_extranjero*($service->utilidad)/100;
                    $array2=round(($service->precio_extranjero+$utilidad_serv)*$tipo_cambio->paralelo,2);
                    $array_promedio_serv=$service->precio_extranjero/$tipo_cambio->paralelo;
                }
                //Guardado de variables
                $identifier= 'service';
                $utility= $utilidad_serv;
                $price=$array2;
                $amount=10;
                $average=$array_promedio_serv;
                $description= $service->descripcion;
                $discount=$service->descuento;
                $afectacion_explode=explode(" ",$service->tipo_afec_i_serv->informacion);
                $afectacion=$afectacion_explode[0];
            }
        }
        
        // * (data) es un array donde se alojaran todos los campos requeridos para devolverlos de forma correcta
        $data=[
            'id'=>$identifier,
            'description'=>$description,	
            'price'=>$price,
            'amount'=>$amount,
            'average'=>$average,
            'utility'=>$utility,
            'discount'=>$discount,	
            'afectacion'=>$afectacion,
            'moneda'=>$moneda,
        ]; 

        return $data;
    }

    // * Llamado de la tabla clientes
    public function getClients(Request $request){
        $search = $request->search;
        $tipo = $request->tipo_coti;
        if($tipo == '1'){ //Factura
            if($search == ''){
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento','documento_identificacion')->where('documento_identificacion','RUC')->limit(5)->get();
            }else{
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento','documento_identificacion')->where('documento_identificacion','RUC')->where(function($query) use ($search){
                    $query->where('nombre', 'like', '%' .$search . '%')->orWhere('numero_documento', 'like', '%' .$search . '%');
                })->limit(5)->get();
            }
        }else if($tipo == '0'){ //Boleta
            if($search == ''){
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento')->where('documento_identificacion','DNI')->limit(5)->get();
            }else{
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento','documento_identificacion')->where('documento_identificacion','DNI')->where(function($query) use ($search){
                    $query->where('nombre', 'like', '%' .$search . '%')->orWhere('numero_documento', 'like', '%' .$search . '%');
                })->limit(5)->get();
            }
        }else{ // TODO : ESTE ELSE ES EXCLUYENTE SI ES UNA BOLETA O FACTURA PARA EL LLAMADO DE RUC O DNI
            if($search == ''){
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento')->limit(5)->get();
            }else{
                $employees = Cliente::orderby('created_at','desc')->select('id','nombre','numero_documento','documento_identificacion')->where('nombre', 'like', '%' .$search . '%')->orWhere('numero_documento', 'like', '%' .$search . '%')->limit(5)->get();
            }
        }
        // return $tipo;
        $response = array();
        foreach($employees as $employee){
           $response[] = array(
                "id"=>$employee->id,
                "nombre"=>$employee->nombre,
                "numero_documento"=>$employee->numero_documento 
           );
        }
        return response()->json($response);
    }

    

    // * Llamado de la tabla artículos (PRODUCTOS - SERVICIOS)
    public function getArticles(Request $request){
        $search = $request->search;
        if($search == ''){
            $products = Producto::orderby('nombre','desc')->select('id','codigo_producto','codigo_original','nombre')->where('codigo_producto', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->orWhere('nombre', 'like', '%' .$search . '%')->limit(5)->get();
            $services = Servicios::orderby('nombre','asc')->select('id','codigo_servicio','codigo_original','nombre')->where('codigo_servicio', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->orWhere('nombre', 'like', '%' .$search . '%')->limit(5)->get();
        }else{
            $products = Producto::orderby('nombre','asc')->select('id','codigo_producto','codigo_original','nombre')->where('codigo_producto', 'like', '%' .$search . '%')->orWhere('nombre', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->limit(5)->get();
            $services = Servicios::orderby('nombre','asc')->select('id','codigo_servicio','codigo_original','nombre')->where('nombre', 'like', '%' .$search . '%')->orWhere('codigo_servicio', 'like', '%' .$search . '%')->orWhere('codigo_original', 'like', '%' .$search . '%')->limit(5)->get();
        }

        //Productos a array
        $products_array = array();
        foreach($products as $product){
           $products_array[] = array(
                "id"=>$product->id,
                "nombre"=>$product->nombre,
                "codigo"=>$product->codigo_producto,
                "codigo_original"=>$product->codigo_original,
                "tipo"=>'producto'
           );
        }

        //Servicios a array
        $services_array = array();
        foreach($services as $service){
            $services_array[] = array(
                 "id"=>$service->id,
                 "nombre"=>$service->nombre,
                 "codigo"=>$service->codigo_servicio,
                 "codigo_original"=>$service->codigo_original,
                 "tipo"=>'servicio'
            );
         }

        $articles = array();
        $articles = array_merge($products_array,$services_array);

        return $articles;

    }

    //* Llamado de moneda para la diferenciación de la principal y secundaria
    public function getMoney(Request $request){
        if($request->status == 1){
            $money=Moneda::where('principal',1)->first();
            $money->status=0;
            $other_money=Moneda::where('principal',0)->first();
            $money->other=$other_money->nombre;
        }else{
            $money=Moneda::where('principal',0)->first();
            $money->status=1;
            $other_money=Moneda::where('principal',1)->first();
            $money->other=$other_money->nombre;
        }
        
        return $money;
    }
    public function getNFactura(Request $request){
        $search = $request->n_factura;
        

        // search 0 = no existe
        // search 1 = existe
    
        $n_factura = Kardex_entrada::where('factura', $search)->first();
        if($search == "0"){
            $var_vuelta = 0;
        }elseif( isset($n_factura) ){
            $var_vuelta = 1;
        }else{
            $var_vuelta = 0;
        }
            
        return $var_vuelta;
    }
    

    //* LLamado para convertir de numero a letras con php 
    public function getNumberLetter(Request $request){
        $number = $request->numeros;
        $moneda = $request->moneda;
        $end2=number_format(round($number, 2),2);
        $end=round($number, 2);

        $v=new CifrasEnLetras() ;
        $letra=($v->convertirEurosEnLetras($end));
        $letra_final = ucfirst(strstr($letra, 'soles',true));
        $end_final_point=strstr($end2, '.', false);
        $end_final=str_replace('.', ' ',$end_final_point);

        $convertido = "Son : "."$letra_final"."con"."$end_final"."/100 ".$moneda;
        return $convertido;
    }
}
