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
use Illuminate\Support\Facades\Schema;
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

<<<<<<< HEAD
public function importar(Request $request){
=======

    /**
     * Importa productos desde un archivo Excel o CSV
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importar(Request $request)
    {
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
        // Validar el archivo Excel
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv,txt'
        ]);

        try {
            // Obtener el archivo cargado
            $archivo = $request->file('excel');

            // Determinar si es un CSV o un Excel
            $extension = $archivo->getClientOriginalExtension();

            if (in_array($extension, ['csv', 'txt'])) {
                // Para archivos CSV
                $datos = [];
                $handle = fopen($archivo->getRealPath(), 'r');

                if ($handle !== false) {
                    // Leer línea por línea
                    $lineNumber = 0;
                    while (($fila = fgetcsv($handle)) !== false) {
                        $lineNumber++;
                        $datos[$lineNumber] = $fila;
                    }
                    fclose($handle);
                }
            } else {
                // Para archivos Excel
                $spreadsheet = IOFactory::load($archivo->getRealPath());
                $hoja = $spreadsheet->getActiveSheet();

                // Obtener el rango de celdas con datos
                $highestRow = $hoja->getHighestRow();
                $highestColumn = $hoja->getHighestColumn();
                $range = 'A1:' . $highestColumn . $highestRow;

                // Obtener las filas del Excel como un array
                $datos = $hoja->rangeToArray($range, null, true, false, false);
            }

            // Verificar que hay datos
            if (empty($datos)) {
                return redirect()->back()->with('error', 'El archivo no contiene datos.');
            }

            // Determinar si la primera fila son los encabezados
            $primeraFila = array_shift($datos); // Extraer la primera fila
            $encabezados = [];

            // Limpiar encabezados y convertirlos a formato compatible
            foreach ($primeraFila as $encabezado) {
                $encabezados[] = trim((string)$encabezado);
            }

            // Mapeo de encabezados del Excel a campos de la base de datos
            $columnas = [];
            foreach ($encabezados as $i => $encabezado) {
                $campoNormalizado = $this->normalizarNombreCampo((string)$encabezado);
                if (!empty($campoNormalizado)) {
                    $columnas[$campoNormalizado] = $i;
                }
            }

            // Pre-cargar datos de las tablas relacionadas para evitar múltiples consultas
            $tipoAfectaciones = $this->obtenerMapeoTipoAfectaciones();
            $categorias = $this->obtenerMapeoCategorias();
            $familias = $this->obtenerMapeoFamilias();
            $subfamilias = $this->obtenerMapeoSubfamilias();
            $marcas = $this->obtenerMapeoMarcas();
            $unidadesMedida = $this->obtenerMapeoUnidadesMedida();
            $estados = $this->obtenerMapeoEstados();

            $totalRegistros = 0;
            $actualizados = 0;
            $nuevos = 0;
            $errores = [];

            // Procesar filas de datos
            foreach ($datos as $numeroFila => $fila) {
                // Verificar que la fila tiene datos
                if (empty($fila) || count(array_filter($fila)) < 3) {
                    continue; // Saltar filas vacías o con pocos datos
                }

                // Obtener valores para campos clave
                $codigoOriginal = isset($columnas['codigo_original']) && isset($fila[$columnas['codigo_original']])
                    ? trim((string)$fila[$columnas['codigo_original']]) : null;
                $codigoProducto = isset($columnas['codigo_producto']) && isset($fila[$columnas['codigo_producto']])
                    ? trim((string)$fila[$columnas['codigo_producto']]) : null;
                $nombre = isset($columnas['nombre']) && isset($fila[$columnas['nombre']])
                    ? trim((string)$fila[$columnas['nombre']]) : null;

<<<<<<< HEAD
                // Si todas las claves están vacías, saltamos esta fila
                $productos = Producto::all();
                $producto = $productos->first(function ($p) use ($codigoOriginal, $codigoProducto, $nombre) {
                    return $this->normalizarTexto($p->codigo_original) === $this->normalizarTexto($codigoOriginal)
                        && $this->normalizarTexto($p->codigo_producto) === $this->normalizarTexto($codigoProducto)
                        && $this->normalizarTexto($p->nombre) === $this->normalizarTexto($nombre);
                });


=======
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
                // Preparar consulta para buscar si el producto ya existe
                $query = Producto::query();

                if (!empty($codigoOriginal)) {
<<<<<<< HEAD
    $query->where('codigo_original', $codigoOriginal);
}

if (!empty($codigoProducto)) {
    $query->where('codigo_producto', $codigoProducto);
}

if (!empty($nombre)) {
    $query->where('nombre', $nombre);
}

=======
                    $query->where('codigo_original', $codigoOriginal);
                }

                if (!empty($codigoProducto)) {
                    $query->where('codigo_producto', $codigoProducto);
                }

                if (!empty($nombre)) {
                    $query->where('nombre', $nombre);
                }

                // Si no hay criterios de búsqueda suficientes, continuar con la siguiente fila
                if (empty($codigoOriginal) && empty($codigoProducto) && empty($nombre)) {
                    $errores[] = "Error en fila " . ($numeroFila + 2) . ": No hay datos suficientes para identificar el producto.";
                    continue;
                }
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5

                $producto = $query->first();

                // Preparar los datos a guardar
                $datosProducto = [];
                foreach ($columnas as $nombreBD => $indiceColumna) {
                    // Verificar si el índice existe en la fila
                    if (isset($fila[$indiceColumna]) && $fila[$indiceColumna] !== null && $fila[$indiceColumna] !== '') {
                        $valor = trim((string)$fila[$indiceColumna]);

                        // Para campos que son foreign keys, convertir texto a ID
                        switch ($nombreBD) {
                            case 'tipo_afectacion_id':
<<<<<<< HEAD
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($tipoAfectaciones, $valor, 1, Tipo_afectacion::class, 'informacion');
    break;
case 'categoria_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($categorias, $valor, 1, Categoria::class, 'descripcion');
    break;
case 'familia_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($familias, $valor, 1, Familia::class, 'descripcion');
    break;
case 'subfamilia_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($subfamilias, $valor, 1, Subfamilia::class, 'descripcion');
    break;
case 'marca_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($marcas, $valor, 1, Marca::class, 'nombre');
    break;
case 'unidad_medida_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($unidadesMedida, $valor, 1, Unidad_medida::class, 'medida');
    break;
case 'estado_id':
    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($estados, $valor, 1, Estado::class, 'nombre');
    break;

=======
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($tipoAfectaciones, $valor, 1, Tipo_afectacion::class, 'informacion');
                                break;
                            case 'categoria_id':
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($categorias, $valor, 1, Categoria::class, 'descripcion');
                                break;
                            case 'familia_id':
                                // Para familia, siempre redirigir a ID 16 si no existe
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($familias, $valor, 16, Familia::class, 'descripcion');
                                break;
                            case 'subfamilia_id':
                                // Para subfamilia, puede ser NULL si la familia no existe
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($subfamilias, $valor, null, Subfamilia::class, 'descripcion');
                                break;
                            case 'marca_id':
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($marcas, $valor, 1, Marca::class, 'nombre');
                                break;
                            case 'unidad_medida_id':
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($unidadesMedida, $valor, 1, Unidad_medida::class, 'medida');
                                break;
                            case 'estado_id':
                                $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($estados, $valor, 1, Estado::class, 'nombre');
                                break;
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
                            case 'estado_anular':
                                // Convertir texto a valor booleano (0 o 1)
                                $valorBooleano = 1; // Por defecto activo
                                if (in_array(strtolower($valor), ['no', 'false', '0', 'inactivo', 'anulado'])) {
                                    $valorBooleano = 0;
                                }
                                $datosProducto[$nombreBD] = $valorBooleano;
                                break;
                            default:
                                $datosProducto[$nombreBD] = $valor;
                                break;
                        }
                    }
                }

                try {
                    if ($producto) {
                        // Actualizar producto existente
                        $producto->update($datosProducto);
                        $actualizados++;
                    } else {
                        // Agregar campos requeridos con valores por defecto si no están presentes
                        $camposRequeridos = [
                            'codigo_original' => $codigoOriginal ?? '',
                            'codigo_producto' => $codigoProducto ?? '',
                            'nombre' => $nombre ?? '',
                            'utilidad' => $datosProducto['utilidad'] ?? 0,
                            'precio_venta' => $datosProducto['precio_venta'] ?? null,
                            'descuento1' => $datosProducto['descuento1'] ?? 0,
                            'descuento2' => $datosProducto['descuento2'] ?? 0,
                            'descuento_maximo' => $datosProducto['descuento_maximo'] ?? 0,
                            'origen' => $datosProducto['origen'] ?? 'Desconocido',
                            'descripcion' => $datosProducto['descripcion'] ?? '',
                            'detalle' => $datosProducto['detalle'] ?? '',
                            'garantia' => $datosProducto['garantia'] ?? 0,
                            'peso' => $datosProducto['peso'] ?? 0,
                            'stock_minimo' => $datosProducto['stock_minimo'] ?? 0,
                            'stock_maximo' => $datosProducto['stock_maximo'] ?? 0,
                            'foto' => $datosProducto['foto'] ?? null,
<<<<<<< HEAD

=======
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
                            'archivo' => $datosProducto['archivo'] ?? null,
                            'estado_anular' => $datosProducto['estado_anular'] ?? 1,
                            'tipo_afectacion_id' => $datosProducto['tipo_afectacion_id'] ?? 1,
                            'categoria_id' => $datosProducto['categoria_id'] ?? 1,
                            'familia_id' => $datosProducto['familia_id'] ?? 16, // ID fijo para Familia que no existe
                            'subfamilia_id' => $datosProducto['subfamilia_id'] ?? null, // Puede ser NULL
                            'marca_id' => $datosProducto['marca_id'] ?? 1,
                            'unidad_medida_id' => $datosProducto['unidad_medida_id'] ?? 1,
                            'estado_id' => $datosProducto['estado_id'] ?? 1,
                        ];

                        // Combinar datos extraídos con valores por defecto
                        $datosCompletos = array_merge($camposRequeridos, $datosProducto);

                        // Crear nuevo producto
                        Producto::create($datosCompletos);
                        $nuevos++;
                    }

                    $totalRegistros++;
                } catch (\Exception $e) {
                    // Registrar error específico para esta fila
                    $errores[] = "Error en fila " . ($numeroFila + 2) . ": " . $e->getMessage();
                }
            }

            // Verificar si hay errores para mostrar
            if (!empty($errores)) {
                // Limitar la cantidad de errores mostrados para no sobrecargar la respuesta
                $erroresMostrados = array_slice($errores, 0, 5);
                $mensajeError = implode('<br>', $erroresMostrados);

                if (count($errores) > 5) {
                    $mensajeError .= '<br>... y ' . (count($errores) - 5) . ' errores más.';
                }

                return redirect()->back()->with('warning', "Importación parcial: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados). Algunos registros tuvieron errores: <br>" . $mensajeError);
            }

            if ($totalRegistros > 0) {
                return redirect()->back()->with('success', "Importación completada: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados).");
            } else {
                return redirect()->back()->with('warning', "No se encontraron productos válidos para importar.");
            }

        } catch (\Exception $e) {
            // Capturar cualquier error y devolver mensaje detallado
            return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage() . ' en línea ' . $e->getLine());
        }
    }

    /**
     * Normaliza el nombre de un campo para hacerlo compatible con la base de datos
     *
     * @param string $nombre
     * @return string
     */
    private function normalizarNombreCampo($nombre)
    {
        // Convertir a minúsculas y quitar espacios extras
        $nombre = strtolower(trim($nombre));

        // Mapeo de nombres comunes a nombres de campos en la base de datos
        // Optimizado para los campos específicos mencionados en los requisitos
        $mapeo = [
            'codigo producto' => 'codigo_producto',
            'codigo_producto' => 'codigo_producto',
            'codigoproducto' => 'codigo_producto',
            'codigo original' => 'codigo_original',
            'codigo_original' => 'codigo_original',
            'codigooriginal' => 'codigo_original',
            'nombre' => 'nombre',
            'utilidad' => 'utilidad',
            'descripcion' => 'descripcion',
            'detalle' => 'detalle',
            'origen' => 'origen',
            'garantia' => 'garantia',
            'peso' => 'peso',
            'stock minimo' => 'stock_minimo',
            'stock_minimo' => 'stock_minimo',
            'stockminimo' => 'stock_minimo',
            'stock maximo' => 'stock_maximo',
            'stock_maximo' => 'stock_maximo',
            'stockmaximo' => 'stock_maximo',
            'estado anular' => 'estado_anular',
            'estado_anular' => 'estado_anular',
            'estadoanular' => 'estado_anular',
            'tipo afectacion' => 'tipo_afectacion_id',
            'tipo_afectacion' => 'tipo_afectacion_id',
            'categoria' => 'categoria_id',
            'familia' => 'familia_id',
            'subfamilia' => 'subfamilia_id',
            'marca' => 'marca_id',
            'unidad medida' => 'unidad_medida_id',
            'unidad_medida' => 'unidad_medida_id',
            'estado' => 'estado_id',
        ];

        // Buscar coincidencias exactas primero
        if (isset($mapeo[$nombre])) {
            return $mapeo[$nombre];
        }

        // Buscar coincidencias parciales, priorizando por exactitud del match
        $mejorCoincidencia = '';
        $mayorPuntuacion = 0;

        foreach ($mapeo as $clave => $valor) {
            // Si la clave está contenida en el nombre
            if (strpos($nombre, $clave) !== false) {
                $puntuacion = strlen($clave) / strlen($nombre); // Proporción de coincidencia
                if ($puntuacion > $mayorPuntuacion) {
                    $mejorCoincidencia = $valor;
                    $mayorPuntuacion = $puntuacion;
                }
            }
        }

        return $mejorCoincidencia;
    }

    /**
     * Busca un ID en el mapeo basado en el nombre o texto
<<<<<<< HEAD
=======
     * Si no encuentra y el modelo es proporcionado, crea un nuevo registro según las reglas específicas
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
     *
     * @param array $mapeo Array asociativo [id => nombre]
     * @param string $texto Texto a buscar
     * @param int $valorPorDefecto Valor por defecto si no se encuentra
     * @param string|null $modelo Nombre de la clase del modelo
     * @param string $campo Campo a usar para la búsqueda y creación
     * @return int ID encontrado, creado o valor por defecto
     */
<<<<<<< HEAD
private function buscarIdEnMapeo(&$mapeo, $texto, $valorPorDefecto = 1, $modelo = null, $campo = 'descripcion')
{
    $textoNormalizado = $this->normalizarTexto($texto);

    // Búsqueda exacta
    foreach ($mapeo as $id => $nombre) {
        if ($this->normalizarTexto($nombre) === $textoNormalizado) {
            return $id;
        }
    }

    // Búsqueda parcial
    foreach ($mapeo as $id => $nombre) {
        if (strpos($this->normalizarTexto($nombre), $textoNormalizado) !== false ||
            strpos($textoNormalizado, $this->normalizarTexto($nombre)) !== false) {
            return $id;
        }
=======
    private function buscarIdEnMapeo(&$mapeo, $texto, $valorPorDefecto = 1, $modelo = null, $campo = 'descripcion')
    {
        // Si el texto está vacío, devuelve el valor por defecto
        if (empty($texto)) {
            return $valorPorDefecto;
        }

        $textoNormalizado = $this->normalizarTexto($texto);

        // Búsqueda exacta
        foreach ($mapeo as $id => $nombre) {
            if ($this->normalizarTexto($nombre) === $textoNormalizado) {
                return $id;
            }
        }

        // Búsqueda parcial
        foreach ($mapeo as $id => $nombre) {
            if (strpos($this->normalizarTexto($nombre), $textoNormalizado) !== false ||
                strpos($textoNormalizado, $this->normalizarTexto($nombre)) !== false) {
                return $id;
            }
        }

        // Reglas específicas para cada modelo
        if ($modelo && !empty($texto)) {
            // Para Familia, siempre retornar 16 si no existe
            if ($modelo === Familia::class) {
                return 16; // ID fijo para registros que no existen
            }

            // Para Subfamilia, retorna NULL si la familia no existe
            if ($modelo === Subfamilia::class) {
                // Verificar si hay alguna familia relacionada con este texto
                $familia = Familia::where('descripcion', 'like', '%' . $texto . '%')->first();
                if (!$familia) {
                    return null; // Retorna NULL si no existe la familia
                }
            }

            // Solo crear nuevos registros para estos modelos específicos
            if (in_array($modelo, [Tipo_afectacion::class, Categoria::class, Marca::class])) {
                $datos = [$campo => $texto];

                // Preparar los datos según el modelo
                $this->prepararDatos($modelo, $datos);

                // Crear el nuevo registro
                $nuevo = $modelo::create($datos);

                // Actualizar el mapeo con el nuevo id
                $mapeo[$nuevo->id] = $nuevo->$campo;
                return $nuevo->id;
            }
        }

        // Valores por defecto específicos para cada modelo
        if ($modelo === Unidad_medida::class || $modelo === Estado::class) {
            return $valorPorDefecto; // Usar el valor por defecto proporcionado
        }

        // Para cualquier otro caso
        return $valorPorDefecto;
    }

    /**
     * Prepara los datos necesarios para crear un nuevo registro en la tabla correspondiente
     *
     * @param string $modelo Nombre de la clase del modelo
     * @param array &$datos Datos a preparar (modificados por referencia)
     */
    private function prepararDatos($modelo, &$datos)
    {
        switch ($modelo) {
            case Tipo_afectacion::class:
                $ultimoCodigo = $modelo::max('codigo') ?? 0;
                $datos['codigo'] = $ultimoCodigo + 1;
                break;

            case Categoria::class:
                $ultimoCodigo = $modelo::orderByRaw('LENGTH(codigo) DESC, codigo DESC')->value('codigo') ?? '0';
                $numero = intval($ultimoCodigo) + 1;
                $datos['codigo'] = str_pad($numero, 3, '0', STR_PAD_LEFT);
                break;

            case Marca::class:
                $ultimoCodigo = Marca::max('codigo');
                $nuevoCodigo = $ultimoCodigo ? str_pad(intval($ultimoCodigo) + 1, 5, '0', STR_PAD_LEFT) : '00001';
                $datos['codigo'] = $nuevoCodigo;
                $datos['abreviatura'] = strtoupper(substr($datos['nombre'] ?? $datos['descripcion'], 0, 2));
                $datos['nombre_empresa'] = $datos['nombre'] ?? $datos['descripcion'];
                $datos['telefono'] = '';
                $datos['descripcion'] = $datos['descripcion'] ?? 'sin descripcion';
                $datos['imagen'] = '';
                break;

            case Subfamilia::class:
                // Para subfamilia, necesitamos manejar la relación con Familia
                $datos['estado'] = 0;

                // Intentamos encontrar la familia por su descripción
                $familia = Familia::where('descripcion', 'like', '%' . ($datos['descripcion'] ?? '') . '%')->first();

                // Si no se encuentra la familia, no se debe crear la subfamilia (retornará NULL en buscarIdEnMapeo)
                if ($familia) {
                    // Contamos la cantidad de subfamilias asociadas a esa familia
                    $subfamiliaCantidad = Subfamilia::where('id_familia', $familia->id)->count() + 1;

                    // Generamos la letra basada en el ID de la familia
                    $letra = chr(64 + min($familia->id, 26)); // Aseguramos que no exceda el alfabeto

                    // Obtenemos el último código de subfamilia para esa familia
                    $ultimoCodigo = Subfamilia::where('id_familia', $familia->id)
                        ->orderBy('codigo', 'desc')
                        ->pluck('codigo')
                        ->first();

                    // Generamos el nuevo código
                    $nuevoCodigo = $ultimoCodigo ? str_pad(intval($ultimoCodigo) + 1, 3, '0', STR_PAD_LEFT) : '001';

                    // Generamos la ubicación
                    $ubicacion = $familia->id . $letra . $nuevoCodigo;

                    // Asignamos los valores
                    $datos['ubicacion'] = $ubicacion;
                    $datos['codigo'] = $nuevoCodigo;
                    $datos['id_familia'] = $familia->id;
                }
                break;

            case Unidad_medida::class:
                $medida = $datos['descripcion'] ?? 'Generico';
                $datos['medida'] = $medida;
                $abreviatura = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $medida), 0, 3));
                $datos['simbolo'] = $abreviatura ?: 'ND';
                $datos['unidad'] = 12.00;
                break;
        }

        // Agregar campos comunes
        $this->agregarCamposExtras($modelo, $datos);
>>>>>>> e59afdf6a7e343fb8571fe270d05f883ebb721c5
    }

    // Si no se encuentra, crear nuevo registro si se proporciona modelo
    if ($modelo && $texto !== '') {
        $datos = [$campo => $texto];
        $this->prepararDatos($modelo, $datos);

        // Crear el nuevo registro
        $nuevo = $modelo::create($datos);

        // Actualizar el mapeo con el nuevo id
        $mapeo[$nuevo->id] = $nuevo->$campo;
        return $nuevo->id;
    }

    return $valorPorDefecto;
}

private function prepararDatos($modelo, &$datos)
{
    switch ($modelo) {
        case Tipo_afectacion::class:
            $ultimoCodigo = $modelo::max('codigo') ?? 0;
            $datos['codigo'] = $ultimoCodigo + 1;
            break;

        case Categoria::class:
            $ultimoCodigo = $modelo::orderByRaw('LENGTH(codigo) DESC, codigo DESC')->value('codigo') ?? '0';
            $numero = intval($ultimoCodigo) + 1;
            $datos['codigo'] = str_pad($numero, 3, '0', STR_PAD_LEFT);
            break;

case Subfamilia::class:
    $datos['estado'] = 0;

    // Intentamos encontrar la familia por su descripción
    $familia = Familia::where('descripcion', $datos['descripcion'])->first();

    // Si no se encuentra una familia, asignamos el id 16 (OTROS)
    if (!$familia) {
        $familia = Familia::find(16); // ID 16 es OTROS
    }

    // Si encontramos una familia válida
    if ($familia) {
        // Contamos la cantidad de subfamilias asociadas a esa familia y le sumamos 1
        $subfamiliaCantidad = Subfamilia::where('id_familia', $familia->id)->count() + 1;

        // Generamos la letra (basada en el ID de la familia, asegurando que sea un valor alfabético válido)
        $letra = chr(64 + $familia->id); // Asegúrate de que el ID de la familia es mayor que 0

        // Obtenemos el último código de subfamilia para esa familia
        $ultimoCodigo = Subfamilia::where('id_familia', $familia->id)
            ->orderBy('codigo', 'desc')
            ->pluck('codigo')
            ->first();

        // Generamos el nuevo código, incrementando el último código o iniciando con '001'
        $nuevoCodigo = $ultimoCodigo ? str_pad(intval($ultimoCodigo) + 1, 3, '0', STR_PAD_LEFT) : '001';

        // Generamos la ubicación combinando familia, letra y código
        $ubicacion = $familia->id . $letra . $nuevoCodigo;

        // Asignamos los valores al array de datos
        $datos['ubicacion'] = $ubicacion;
        $datos['codigo'] = $nuevoCodigo;
    } else {
        // Si no se encuentra ninguna familia, se asigna una ubicación por defecto
        $datos['ubicacion'] = '16P001'; // Asignando una ubicación predeterminada si no se encuentra la familia
        $datos['codigo'] = '001'; // Código por defecto
    }
    break;


    break;

        case Marca::class:
            $ultimoCodigo = Marca::max('codigo');
            $nuevoCodigo = $ultimoCodigo ? str_pad(intval($ultimoCodigo) + 1, 5, '0', STR_PAD_LEFT) : '00001';
            $datos['codigo'] = $nuevoCodigo;
            $datos['abreviatura'] = strtoupper(substr($datos['nombre'], 0, 2));
            $datos['nombre_empresa'] = $datos['descripcion'];  // Asumiendo que el texto contiene el nombre completo
            $datos['telefono'] = '';
            $datos['descripcion'] = $datos['descripcion'] ?? 'sin descripcion';
            $datos['imagen'] = '';
            break;

        case UnidadMedida::class:
            // Si no se proporcionó 'descripcion', usar un texto de fallback
            $medida = $datos['descripcion'] ?? 'Generico';

            // Asignamos la 'medida' al dato
            $datos['medida'] = $medida;

            // Abreviatura segura: 3 primeras letras alfabéticas del nombre de la medida, en mayúsculas
            $abreviatura = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $medida), 0, 3));

            // Si la abreviatura está vacía, asignamos 'ND' (No Definido)
            $datos['simbolo'] = $abreviatura ?: 'ND';

            // Valor por defecto para la unidad
            $datos['unidad'] = 12.00;

            break;





        case Familia::class:
            $nuevo = $modelo::create([
                'descripcion' => $datos['descripcion'],
                'codigo' => 'TEMP',  // Temporal
                'ubicacion' => 'TEMP', // Temporal
            ]);
            $nuevo->codigo = str_pad($nuevo->id, 3, '0', STR_PAD_LEFT);
            $nuevo->ubicacion = $nuevo->id . chr(64 + $nuevo->id); // 1A, 2B, etc.
            $nuevo->save();
            break;
    }

    // Verificar y agregar las columnas `estado`, `updated_at`, y `created_at` solo si existen
    $this->agregarCamposExtras($modelo, $datos);
}

private function agregarCamposExtras($modelo, &$datos)
{
    // Verificar si la columna 'estado' existe
    if (Schema::hasColumn((new $modelo)->getTable(), 'estado')) {
        $datos['estado'] = 0; // Si existe, añadir 'estado'
    }

    // Verificar si la columna 'updated_at' existe
    if (Schema::hasColumn((new $modelo)->getTable(), 'updated_at')) {
        $datos['updated_at'] = now();
    }

    // Verificar si la columna 'created_at' existe
    if (Schema::hasColumn((new $modelo)->getTable(), 'created_at')) {
        $datos['created_at'] = now();
    }
}




private function normalizarTexto($texto)
{
    // Elimina tildes y convierte a mayúsculas
    $texto = trim($texto);
    $texto = mb_strtoupper($texto, 'UTF-8'); // Mayúsculas
    $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); // Quita tildes
    return preg_replace('/[^A-Z0-9 ]/', '', $texto); // Elimina caracteres especiales
}


    /**
     * Agrega campos comunes a los datos según el esquema de la tabla
     *
     * @param string $modelo Nombre de la clase del modelo
     * @param array &$datos Datos a modificar (por referencia)
     */
    private function agregarCamposExtras($modelo, &$datos)
    {
        // Verificar si la columna 'estado' existe
        if (Schema::hasColumn((new $modelo)->getTable(), 'estado') && !isset($datos['estado'])) {
            $datos['estado'] = 0; // Por defecto inactivo
        }

        // Agregar timestamps si existen en la tabla
        if (Schema::hasColumn((new $modelo)->getTable(), 'updated_at')) {
            $datos['updated_at'] = now();
        }

        if (Schema::hasColumn((new $modelo)->getTable(), 'created_at')) {
            $datos['created_at'] = now();
        }
    }

    /**
     * Normaliza un texto para facilitar comparaciones
     *
     * @param string $texto Texto a normalizar
     * @return string Texto normalizado
     */
    private function normalizarTexto($texto)
    {
        if (empty($texto)) return '';

        // Elimina tildes y convierte a mayúsculas
        $texto = trim($texto);
        $texto = mb_strtoupper($texto, 'UTF-8'); // Mayúsculas
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto); // Quita tildes
        return preg_replace('/[^A-Z0-9 ]/', '', $texto); // Elimina caracteres especiales
    }


    /**
     * Obtiene un mapeo de IDs a nombres para TipoAfectacion
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoTipoAfectaciones()
    {
        // Ajusta esto según tu modelo y estructura de tabla
        return Tipo_afectacion::pluck('informacion', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para Categoria
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoCategorias()
    {
        return Categoria::pluck('descripcion', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para Familia
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoFamilias()
    {
        return Familia::pluck('descripcion', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para Subfamilia
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoSubfamilias()
    {
        return Subfamilia::pluck('descripcion', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para Marca
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoMarcas()
    {
        return Marca::pluck('nombre', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para UnidadMedida
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoUnidadesMedida()
    {
        return Unidad_medida::pluck('medida', 'id')->toArray();
    }

    /**
     * Obtiene un mapeo de IDs a nombres para Estado
     *
     * @return array [id => nombre]
     */
    private function obtenerMapeoEstados()
    {
        return Estado::pluck('nombre', 'id')->toArray();
    }
}