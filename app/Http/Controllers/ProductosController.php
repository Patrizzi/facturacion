<?php

namespace App\Http\Controllers;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

    // API EXTERNA

    public function onlyProduct($id){

        $producto = Producto::find($id);
        if(!isset($producto)){
            $data = ['msg'=>"Producto no encontrado"];
            return response()->json($data,200);
        }
        // Busqueda de stock
        $data_stock = Stock_producto::where('producto_id', $producto->id)->get();

        $array_end =[
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->nombre,
            'precio_soles' => $data_stock->sum('precio_nacional'),
            'stock' => $data_stock->sum('stock')
        ];

        return json_encode($array_end);
    }
    public function allProduct(){

        $productos = Producto::get();
        // Busqueda de stock
        foreach ($productos as $key => $producto) {
            $data_stock = Stock_producto::where('producto_id', $producto->id)->get();
            $array_end[$key] =[
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'descripcion' => $producto->nombre,
                'precio_soles' => $data_stock->sum('precio_nacional'),
                'stock' => $data_stock->sum('stock')
            ];
        }



        return json_encode($array_end);
    }
public function importar(Request $request)
    {
        // Validar el archivo Excel
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls'
        ]);

        // Obtener el archivo cargado
        $archivo = $request->file('excel');
        $spreadsheet = IOFactory::load($archivo->getRealPath());
        $hoja = $spreadsheet->getActiveSheet();

        // Iterar sobre las filas del Excel
        foreach ($hoja->getRowIterator() as $row) {
            // Leer las celdas de cada fila del Excel
            $codigoOriginal = $hoja->getCell('B' . $row->getRowIndex())->getValue();
            $codigoProducto = $hoja->getCell('C' . $row->getRowIndex())->getValue();
            $nombre = $hoja->getCell('D' . $row->getRowIndex())->getValue();

            // Buscar si el producto ya existe (según los tres campos únicos)
            $producto = Producto::where('codigo_original', $codigoOriginal)
                               ->orWhere('codigo_producto', $codigoProducto)
                               ->orWhere('nombre', $nombre)
                               ->first();

            if ($producto) {
                // Si existe, solo actualizar los campos presentes en el Excel
                $producto->codigo_original = $codigoOriginal ?: $producto->codigo_original;
                $producto->codigo_producto = $codigoProducto ?: $producto->codigo_producto;
                $producto->nombre = $nombre ?: $producto->nombre;

                // Actualizar utilidad si existe en el Excel
                $utilidad = $hoja->getCell('E' . $row->getRowIndex())->getValue();
                $producto->utilidad = $utilidad !== null ? $utilidad : $producto->utilidad;

                $precio_venta= $hoja->getCell('F' . $row->getRowIndex())->getValue();
                $producto->precio_venta = $precio_venta !== null ? $precio_venta : $producto->precio_venta;

                $descuento1= $hoja->getCell('G' . $row->getRowIndex())->getValue();
                $producto->descuento1 = $descuento1 !== null ? $descuento1 : $producto->descuento1;

                $descuento2= $hoja->getCell('H' . $row->getRowIndex())->getValue();
                $producto->descuento2 = $descuento2 !== null ? $descuento2 : $producto->descuento2;

                $descuento_maximo= $hoja->getCell('I' . $row->getRowIndex())->getValue();
                $producto->descuento_maximo = $descuento_maximo !== null ? $descuento_maximo : $producto->descuento_maximo;

                /*$origen= $hoja->getCell('J' . $row->getRowIndex())->getValue();
                $producto->origen = $origen !== null ? $origen : $producto->origen;*/

                // Asignar valores predeterminados para campos faltantes (como 'origen')
                $producto->origen = $hoja->getCell('J' . $row->getRowIndex())->getValue() ?? 'Desconocido'; // Asignar un valor por defecto

                $descripcion= $hoja->getCell('K' . $row->getRowIndex())->getValue();
                $producto->descripcion = $descripcion !== null ? $descripcion : $producto->descripcion;

                $detalle= $hoja->getCell('L' . $row->getRowIndex())->getValue();
                $producto->detalle = $detalle !== null ? $detalle : $producto->detalle;

                $garantia= $hoja->getCell('M' . $row->getRowIndex())->getValue();
                $producto->garantia = $garantia !== null ? $garantia : $producto->garantia;

                $peso= $hoja->getCell('N' . $row->getRowIndex())->getValue();
                $producto->peso = $peso !== null ? $peso : $producto->peso;

                $stock_minimo= $hoja->getCell('O' . $row->getRowIndex())->getValue();
                $producto->stock_minimo = $stock_minimo !== null ? $stock_minimo : $producto->stock_minimo;

                $stock_maximo= $hoja->getCell('P' . $row->getRowIndex())->getValue();
                $producto->stock_maximo = $stock_maximo !== null ? $stock_maximo : $producto->stock_maximo;

                $foto= $hoja->getCell('Q' . $row->getRowIndex())->getValue();
                $producto->foto = $foto !== null ? $foto : $producto->foto;

                $archivo= $hoja->getCell('R' . $row->getRowIndex())->getValue();
                $producto->archivo = $archivo !== null ? $archivo : $producto->archivo;

                $estado_anular= $hoja->getCell('S' . $row->getRowIndex())->getValue();
                $producto->estado_anular = $estado_anular !== null ? $estado_anular : $producto->estado_anular;

                $tipo_afectacion_id= $hoja->getCell('T' . $row->getRowIndex())->getValue();
                $producto->tipo_afectacion_id = $tipo_afectacion_id !== null ? $tipo_afectacion_id : $producto->tipo_afectacion_id;

                $categoria_id= $hoja->getCell('U' . $row->getRowIndex())->getValue();
                $producto->categoria_id = $categoria_id !== null ? $categoria_id : $producto->categoria_id;

                $familia_id= $hoja->getCell('V' . $row->getRowIndex())->getValue();
                $producto->familia_id = $familia_id !== null ? $familia_id : $producto->familia_id;

                $subfamilia_id= $hoja->getCell('W' . $row->getRowIndex())->getValue();
                $producto->subfamilia_id = $subfamilia_id !== null ? $subfamilia_id : $producto->subfamilia_id;

                $marca_id= $hoja->getCell('X' . $row->getRowIndex())->getValue();
                $producto->marca_id = $marca_id !== null ? $marca_id : $producto->marca_id;

                $unidad_medida_id= $hoja->getCell('Y' . $row->getRowIndex())->getValue();
                $producto->unidad_medida_id = $unidad_medida_id !== null ? $unidad_medida_id : $producto->unidad_medida_id;

                $estado_id= $hoja->getCell('Z' . $row->getRowIndex())->getValue();
                $producto->estado_id = $estado_id !== null ? $estado_id : $producto->estado_id;

                // Guardar los cambios
                $producto->save();
            } else {
                // Si no existe, crear un nuevo producto
                Producto::create([
                    'codigo_original' => $codigoOriginal,
                    'codigo_producto' => $codigoProducto,
                    'nombre' => $nombre,
                    'utilidad' => $hoja->getCell('E' . $row->getRowIndex())->getValue() ?? 0,
                    'precio_venta' => $hoja->getCell('F' . $row->getRowIndex())->getValue() ?? 0,
                    'descuento1' => $hoja->getCell('G' . $row->getRowIndex())->getValue() ?? 0,
                    'descuento2' => $hoja->getCell('H' . $row->getRowIndex())->getValue() ?? 0,
                    'descuento_maximo' => $hoja->getCell('I' . $row->getRowIndex())->getValue() ?? 0,
                    'origen' => $hoja->getCell('J' . $row->getRowIndex())->getValue() ?? 'Desconocido', // Asignar valor predeterminado
                    // Puedes agregar los otros campos de manera similar si lo necesitas:
                    'descripcion' => $hoja->getCell('K' . $row->getRowIndex())->getValue() ?? '',
                    'detalle' => $hoja->getCell('L' . $row->getRowIndex())->getValue() ?? '',
                    'garantia' => $hoja->getCell('M' . $row->getRowIndex())->getValue() ?? 0,
                    'peso' => $hoja->getCell('N' . $row->getRowIndex())->getValue() ?? 0,
                    'stock_minimo' => $hoja->getCell('O' . $row->getRowIndex())->getValue() ?? 0,
                    'stock_maximo' => $hoja->getCell('P' . $row->getRowIndex())->getValue() ?? 0,
                    'foto' => $hoja->getCell('Q' . $row->getRowIndex())->getValue() ?? '',
                    'archivo' => $hoja->getCell('R' . $row->getRowIndex())->getValue() ?? '',
                    'estado_anular' => $hoja->getCell('S' . $row->getRowIndex())->getValue() ?? 1,
                    'tipo_afectacion_id' => $hoja->getCell('T' . $row->getRowIndex())->getValue() ?? 1,
                    'categoria_id' => $hoja->getCell('U' . $row->getRowIndex())->getValue() ?? 1,
                    'familia_id' => $hoja->getCell('V' . $row->getRowIndex())->getValue() ?? 1,
                    'subfamilia_id' => $hoja->getCell('W' . $row->getRowIndex())->getValue() ?? 1,
                    'marca_id' => $hoja->getCell('X' . $row->getRowIndex())->getValue() ?? 1,
                    'unidad_medida_id' => $hoja->getCell('Y' . $row->getRowIndex())->getValue() ?? 1,
                    'estado_id' => $hoja->getCell('Z' . $row->getRowIndex())->getValue() ?? 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Productos importados y actualizados correctamente.');
    }

}
