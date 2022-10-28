<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Unidad_medida;
use App\Categoria;
use App\Marca;
use App\Estado;
use App\Familia;
use App\Subfamilia;
use App\kardex_entrada_registro;
use App\Moneda;
use App\Stock_almacen;
use App\Tipo_afectacion;
use App\Stock_producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        // $stok=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        $marcas=Marca::all();
        $productos=Producto::all();
        return view('producto_servicios.productos.index',compact('productos','marcas'));
    }

    public function index_ajax(){
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $monedas=Moneda::all();
        $familias=Familia::where('estado',0)->get();
        $marcas=Marca::where('estado',0)->get();
        $estados=Estado::all();
        $categorias=Categoria::where('descripcion','PRODUCTOS')->first();
        $unidad_medidas=Unidad_medida::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $moneda_principal=Moneda::where('principal',1)->first();
        return view('producto_servicios.productos.create',compact('unidad_medidas','categorias','marcas','estados','familias','monedas','tipo_afectacion','moneda_principal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        
        // return $request;
        $this->validate($request,[
            'codigo_original' => ['unique:productos,codigo_original'],
            'nombre' => ['required:productos,nombre'],
        ],[
            'codigo_original.unique' => 'El codigo alternativo ya existe',
        ]);

        $id_producto=$request->get('marca_id');
        $marca= Marca::where("id","=",$id_producto)->first();
        $abreviatura=$marca->abreviatura;
        $marca_cantidad= Producto::where("marca_id","=",$id_producto)->count();
        $marca_cantidad++;
        $contador=1000000;
        $marca_cantidad=$contador+$marca_cantidad;
        $marca_cantidad=(string)$marca_cantidad;
        $marca_cantidad=substr($marca_cantidad,1);
        $codigo=$abreviatura.'-'.$marca_cantidad;

        $codigo_original=$request->get('codigo_original');
        if (isset($codigo_original)){$codigo_original=$request->get('codigo_original');}
        else{$codigo_original=$codigo;}

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name);
        }else{
            $name='producto.svg';
        }
        if($request->hasFile('archivo_producto')){
            $file =$request->file('archivo_producto');
            $name_file =$codigo_original.'-'.$file->getClientOriginalName();
            $destinationPath_file = public_path('/archivos/productos/fichas/');
            $file->move($destinationPath_file,$name_file);
        }else{
            $name_file = null;
        }

        $peso=$request->get('peso');
        $simbolo=$request->get('simbolo');

        

        $producto=new Producto;
        $producto->codigo_producto=$codigo;
        $producto->codigo_original=$codigo_original;
        $producto->categoria_id=1;
        $producto->familia_id=$request->get('familia_id');
        $producto->subfamilia_id=$request->get('sub_familia_id');
        $producto->marca_id=$request->get('marca_id');
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->estado_id=1;
        $producto->origen='Producto Nacional';
        if($request->get('descuento1')) {$producto->descuento1=$request->get('descuento1');}else{$producto->descuento1=0;}
        if($request->get('descuento2')) {$producto->descuento2=$request->get('descuento2');}else{$producto->descuento2=0;}
        if($request->get('utilidad')) {$producto->utilidad=$request->get('utilidad');}else{$producto->utilidad=0;}
        if($request->get('stock_minimo')) {$producto->stock_minimo=$request->get('stock_minimo');}else{$producto->stock_minimo=0;}
        if($request->get('stock_maximo')) {$producto->stock_maximo=$request->get('stock_maximo');}else{$producto->stock_maximo=0;}
        if($request->get('descuento_maximo')) {$producto->descuento_maximo=$request->get('descuento_maximo');}else{$producto->descuento_maximo=0;}
        if($request->get('garantia')) {$producto->garantia=$request->get('garantia');}else{$producto->garantia='0 Meses';}
        $producto->unidad_medida_id=$request->get('unidad_medida_id');
        $producto->peso=$peso.' '.$simbolo;
        $producto->tipo_afectacion_id = $request->get('tipo_afectacion');
        $producto->foto=$name;
        $producto->archivo=$name_file;
        $producto->estado_anular='1';
        $producto->save();

        Stock_almacen::new($producto->id);
        Stock_producto::new($producto->id);

        return redirect()->route('productos.show',$producto->id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $precio_promedio=Stock_producto::where('producto_id',$id)->first();
        // return $precio_promedio->precio_nacional;

       $producto=Producto::find($id);
       $pro_peso=$producto->peso;

       $simbolo = strstr($pro_peso, ' ',false);
       $peso = strstr($pro_peso, ' ',true);

       $moneda_principal=Moneda::where('principal',1)->first();
       $familias=Familia::all();
       $subfamilias=Subfamilia::where('id_familia',$producto->familia_id)->where('estado',0)->get();
    
       $marcas=Marca::all();
       $estados=Estado::all();
       $categorias=Categoria::all();
       $unidad_medidas=Unidad_medida::all();
       $tipo_afectacion = Tipo_afectacion::all();
       $producto=Producto::find($id);
       if ($producto== null) {
        return response()->view("errors.404_registros_no_foud",[],404);
    }
    return view('producto_servicios.productos.show',compact('unidad_medidas','categorias','marcas','estados','familias','moneda_principal','producto','peso','simbolo','tipo_afectacion','precio_promedio','subfamilias'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $precio_promedio=Stock_producto::where('producto_id',$id)->first();
        // // return $precio_promedio->precio_nacional;

        // $producto=Producto::find($id);
        // $pro_peso=$producto->peso;

        // $simbolo = strstr($pro_peso, ' ',false);
        // $peso = strstr($pro_peso, ' ',true);

        // $moneda_principal=Moneda::where('principal',1)->first();
        // $familias=Familia::all();
        // $subfamilias=Subfamilia::where('familia_id',$producto->familia_id)->first();
        
        // $marcas=Marca::all();
        // $estados=Estado::all();
        // $categorias=Categoria::all();
        // $unidad_medidas=Unidad_medida::all();
        // $tipo_afectacion = Tipo_afectacion::all();
        // return view('producto_servicios.productos.edit',compact('unidad_medidas','categorias','marcas','estados','familias','moneda_principal','producto','peso','simbolo','tipo_afectacion','precio_promedio','subfamilias'));
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
        // return $request;
        $name =NULL;
        $this->validate($request,[
            'codigo_original' => ['required','unique:productos,codigo_original,'.$id],
        ],[
            'codigo_original.unique' => 'El codigo alternativo ya existe',
        ]);

        $codigo_original=$request->get('codigo_original');

        $archivo_prod = Producto::where('id',$id)->first();
        if (isset($codigo_original)) {$codigo_original=$request->get('codigo_original');}
        else{$codigo_original=$request->get('codigo');}

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name);
        }
        if($request->hasFile('archivo_producto')){
            $file =$request->file('archivo_producto');
            $name_file =$codigo_original.'-'.$file->getClientOriginalName();
            $destinationPath_file = public_path('/archivos/productos/fichas/');
            $file->move($destinationPath_file,$name_file);
        }else{
            $name_file = $archivo_prod->archivo;
        }

    if ($request->get('peso')) {$peso=$request->get('peso');  }else{$peso=0;  }
    $simbolo=$request->get('simbolo');

    $codigo_original=$request->get('codigo_original');
    if (isset($codigo_original)) {$codigo_original=$request->get('codigo_original');}
    else{$codigo_original=$request->get('codigo');}

    // Estado
    if ( $request->get('estado_id')){$estado=1;}
    else{ $estado=2;}
    // Estado


        $producto=Producto::find($id);
        if($request->get('nombre') == NULL){$producto->nombre=$producto->nombre;}else{$producto->nombre=$request->get('nombre');}
        $producto->codigo_original=$codigo_original;
        $producto->descripcion=$request->get('descripcion');
        $producto->estado_id=$estado;
        $producto->origen=$request->get('origen');

        if($request->get('descuento1') == null){$producto->descuento1=0;}else{$producto->descuento1=$request->get('descuento1');}
        if($request->get('descuento2') == null){$producto->descuento2=0;}else{$producto->descuento2=$request->get('descuento2');}
        if($request->get('descuento_maximo') == null){$producto->descuento_maximo=0;}else{$producto->descuento_maximo=$request->get('descuento_maximo');}
        if($request->get('utilidad') == null){$producto->utilidad=0;}else{$producto->utilidad=$request->get('utilidad');}
        if($request->get('garantia') == null){$producto->garantia='0 Meses';}else{$producto->garantia=$request->get('garantia');}
        if($request->get('stock_minimo') == null){$producto->stock_minimo=0 ;}else{$producto->stock_minimo=$request->get('stock_minimo');}
        if($request->get('stock_maximo') == null){$producto->stock_maximo=0;}else{$producto->stock_maximo=$request->get('stock_maximo');}
        $producto->precio_venta=$request->get('precio_venta');
        $producto->precio_impuesto='1';
        $producto->unidad_medida_id=$request->get('unidad_medida_id');
        $producto->peso=$peso.' '.$simbolo;
        $producto->tipo_afectacion_id = $request->get('tipo_afectacion');
        if($name){$producto->foto=$name;}
        $producto->archivo=$name_file;

        $producto->familia_id = $request->get('familia_id');
        $producto->subfamilia_id = $request->get('sub_familia_id');

        $producto->save();
        return redirect()->route('productos.show',$id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Validación para la anulacion Kardex Entrada
        $kardex_entrada=kardex_entrada_registro::where('producto_id',$id)->where('estado',1)->get()->first();
        // return $kardex_entrada;


        // Si el producto existe en cardex entrada
        if(isset($kardex_entrada->producto_id)){
            // NO ANULA EL PRODUCTO
            // $errors = "Para anular un producto, haga la salida de todo el stock en kardex";
            // return route('productos.index',compact('errors'));
            return redirect()->route('productos.index')->with('anulacion', 'Producto registrado en almacen, retire todo con una Guia de Salida para poder anular dicho producto.');
            // return "Error por tener producto en kardex, no se puede eliminar";
            // return $kardex_entrada;
        }else{
            $producto=Producto::find($id);
            $producto->codigo_original='Codigo Anulado N°'.$id;
            $producto->estado_anular='0';
            $producto->save();
            return redirect()->route('productos.index');
            // return '0';
        }

    }
}
