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
use App\Imports\ProductosImport;
use Maatwebsite\Excel\Facades\Excel;


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
            'archivo' => 'required|mimes:xlsx,xls,csv,txt'
        ], [
            'archivo.required' => 'Debes seleccionar un archivo para importar.',
            'archivo.mimes' => 'El archivo debe ser un Excel (.xlsx, .xls) o CSV.'
        ]);

        try {
            // Obtener el archivo cargado
            $archivo = $request->file('archivo');
            $extension = $archivo->getClientOriginalExtension();

            // Procesar el archivo según su tipo (Excel o CSV)
            if (in_array($extension, ['csv', 'txt'])) {
                $datos = $this->procesarCSV($archivo);
            } else {
                $datos = $this->procesarExcel($archivo);
            }

            // Verificar que hay datos
            if (empty($datos)) {
                return redirect()->back()->with('error', 'El archivo no contiene datos.');
            }

            // Procesar encabezados
            $primeraFila = array_shift($datos);
            $encabezados = $this->procesarEncabezados($primeraFila);

            // Precargar datos de las tablas relacionadas
            $tipoAfectaciones = $this->obtenerMapeo('Tipo_afectacion', 'informacion');
            $categorias = $this->obtenerMapeo('Categoria', 'descripcion');
            $familias = $this->obtenerMapeo('Familia', 'descripcion');
            $subfamilias = $this->obtenerMapeo('Subfamilia', 'descripcion');
            $marcas = $this->obtenerMapeo('Marca', 'nombre');
            $unidadesMedida = $this->obtenerMapeo('Unidad_medida', 'medida');
            $estados = $this->obtenerMapeo('Estado', 'nombre');

            $totalRegistros = 0;
            $actualizados = 0;
            $nuevos = 0;
            $errores = [];

            // Procesar filas de datos
            foreach ($datos as $numeroFila => $fila) {
                if (empty($fila) || count(array_filter($fila)) < 3) {
                    continue; // Saltar filas vacías o con pocos datos
                }

                $producto = $this->buscarProductoExistente($fila, $encabezados);

                // Preparar los datos a guardar
                $datosProducto = $this->prepararDatosProducto($fila, $encabezados, [
                    'tipo_afectacion_id' => $tipoAfectaciones,
                    'categoria_id' => $categorias,
                    'familia_id' => $familias,
                    'subfamilia_id' => $subfamilias,
                    'marca_id' => $marcas,
                    'unidad_medida_id' => $unidadesMedida,
                    'estado_id' => $estados,
                ]);

                try {
                    if ($producto) {
                        $producto->update($datosProducto);
                        $actualizados++;
                    } else {
                        Producto::create($datosProducto);
                        $nuevos++;
                    }

                    $totalRegistros++;
                } catch (\Exception $e) {
                    $errores[] = "Error en fila " . ($numeroFila + 2) . ": " . $e->getMessage();
                }
            }

            // Verificar si hay errores para mostrar
            if (!empty($errores)) {
                $mensajeError = implode('<br>', array_slice($errores, 0, 5));
                if (count($errores) > 5) {
                    $mensajeError .= '<br>... y ' . (count($errores) - 5) . ' errores más.';
                }

                return redirect()->back()->with('warning', "Importación parcial: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados). Algunos registros tuvieron errores: <br>" . $mensajeError);
            }

            return redirect()->back()->with('success', "Importación completada: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados).");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage() . ' en línea ' . $e->getLine());
        }
    }


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

    private function buscarIdEnMapeo($mapeo, $texto, $valorPorDefecto = 1)
    {
        // Normalizar el texto para búsqueda
        $textoNormalizado = trim(strtolower($texto));

        // Búsqueda exacta
        foreach ($mapeo as $id => $nombre) {
            if (strtolower(trim($nombre)) === $textoNormalizado) {
                return $id;
            }
        }

        // Búsqueda parcial
        foreach ($mapeo as $id => $nombre) {
            if (strpos(strtolower($nombre), $textoNormalizado) !== false ||
                strpos($textoNormalizado, strtolower($nombre)) !== false) {
                return $id;
            }
        }

        // Si no se encuentra, intentar crear el registro si es posible
        // (Esta parte se implementaría según las reglas de negocio)

        return $valorPorDefecto;
    }

    private function procesarExcel($archivo)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo->getRealPath());
        $hoja = $spreadsheet->getActiveSheet();
        $datos = $hoja->toArray(null, true, true, false);

        // Remover filas vacías
        return array_filter($datos, function ($fila) {
            return !empty(array_filter($fila));
        });
    }

    private function procesarEncabezados($fila)
    {
        $encabezados = [];

        foreach ($fila as $index => $nombreColumna) {
            $nombreNormalizado = $this->normalizarNombreCampo($nombreColumna);
            if (!empty($nombreNormalizado)) {
                $encabezados[$nombreNormalizado] = $index;
            }
        }

        return $encabezados;
    }

    private function obtenerMapeo($modelo, $campo)
    {
        // Construir el nombre del modelo completo
        $modeloCompleto = "\\App\\" . $modelo;

        // Verificar que el modelo exista
        if (!class_exists($modeloCompleto)) {
            throw new \Exception("El modelo {$modeloCompleto} no existe.");
        }

        // Obtener los datos del modelo en formato [id => campo]
        return $modeloCompleto::pluck($campo, 'id')->toArray();
    }

    private function buscarProductoExistente(array $fila, array $encabezados)
    {
        // Obtener los posibles identificadores del producto
        $codigoOriginal = $encabezados['codigo_original'] ?? null;
        $codigoProducto = $encabezados['codigo_producto'] ?? null;
        $nombre = $encabezados['nombre'] ?? null;

        $query = Producto::query();

        if ($codigoOriginal && !empty($fila[$codigoOriginal])) {
            $query->orWhere('codigo_original', trim($fila[$codigoOriginal]));
        }

        if ($codigoProducto && !empty($fila[$codigoProducto])) {
            $query->orWhere('codigo_producto', trim($fila[$codigoProducto]));
        }

        if ($nombre && !empty($fila[$nombre])) {
            $query->orWhere('nombre', trim($fila[$nombre]));
        }

        // Retornar el primer producto que coincida
        return $query->first();
    }

    private function prepararDatosProducto(array $fila, array $encabezados, array $relaciones)
    {
        $datosProducto = [];

        foreach ($encabezados as $nombreCampo => $indiceColumna) {
            // Verificar si el campo tiene datos
            if (isset($fila[$indiceColumna]) && $fila[$indiceColumna] !== null && $fila[$indiceColumna] !== '') {
                $valor = trim($fila[$indiceColumna]);

                // Manejar campos que son foreign keys
                if (isset($relaciones[$nombreCampo])) {
                    $datosProducto[$nombreCampo] = $this->buscarIdEnMapeo($relaciones[$nombreCampo], $valor, 1);
                } else {
                    // Para campos no relacionados, usar el valor directamente
                    switch ($nombreCampo) {
                        case 'estado_anular':
                            $valorBooleano = 1; // Por defecto activo
                            if (in_array(strtolower($valor), ['no', 'false', '0', 'inactivo', 'anulado'])) {
                                $valorBooleano = 0;
                            }
                            $datosProducto[$nombreCampo] = $valorBooleano;
                            break;
                        case 'peso':
                            // Si el campo "peso" está vacío, establecer como 0
                            $datosProducto[$nombreCampo] = empty($valor) ? '0' : $valor;
                            break;
                        default:
                            $datosProducto[$nombreCampo] = $valor;
                            break;
                    }
                }
            }
        }

        // Agregar campos requeridos con valores por defecto si no están presentes
        $datosProducto = array_merge([
            'utilidad' => 0,
            'precio_venta' => 0,
            'descuento1' => 0,
            'descuento2' => 0,
            'descuento_maximo' => 0,
            'origen' => 'Desconocido',
            'descripcion' => '',
            'detalle' => '',
            'garantia' => '0 Meses',
            'peso' => '0',
            'stock_minimo' => 0,
            'stock_maximo' => 0,
            'foto' => '',
            'archivo' => '',
            'estado_anular' => 1,
            'tipo_afectacion_id' => 1,
            'categoria_id' => 1,
            'familia_id' => 1,
            'subfamilia_id' => 1,
            'marca_id' => 1,
            'unidad_medida_id' => 1,
            'estado_id' => 1,
        ], $datosProducto);

        return $datosProducto;
    }

    private function obtenerMapeoTipoAfectaciones()
    {
        // Ajusta esto según tu modelo y estructura de tabla
        return Tipo_afectacion::pluck('informacion', 'id')->toArray();
    }

    private function obtenerMapeoCategorias()
    {
        return Categoria::pluck('descripcion', 'id')->toArray();
    }

    private function obtenerMapeoFamilias()
    {
        return Familia::pluck('descripcion', 'id')->toArray();
    }

    private function obtenerMapeoSubfamilias()
    {
        return Subfamilia::pluck('descripcion', 'id')->toArray();
    }

    private function obtenerMapeoMarcas()
    {
        return Marca::pluck('nombre', 'id')->toArray();
    }

    private function obtenerMapeoUnidadesMedida()
    {
        return Unidad_medida::pluck('medida', 'id')->toArray();
    }

    private function obtenerMapeoEstados()
    {
        return Estado::pluck('nombre', 'id')->toArray();
    }
}
