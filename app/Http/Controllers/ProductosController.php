<?php

namespace App\Http\Controllers;

use App\Almacen;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Producto;
use App\Unidad_medida;
use App\Categoria;
use App\Marca;
use App\Estado;
use App\Exports\TestExport;
use App\Familia;
use App\Subfamilia;
use App\kardex_entrada_registro;
use App\Moneda;
use App\Servicios;
use App\Stock_almacen;
use App\Tipo_afectacion;
use App\Stock_producto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()

    // {
    //     // PRODUCTOS ACTIVOS
    //     // $stok=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
    //     $marcas=Marca::all();
    //     $productos=Producto::all();
    //     return view('producto_servicios.productos.index',compact('productos','marcas'));
    // }

    public function index(Request $request)

    {
        // PRODUCTOS ACTIVOS
        // $stok=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        $s_statics = Servicios::porcentaje_servicios();
        $p_statics = Producto::porcentaje_productos();
        $barra_statics = Marca::barras_marcas();
        // return  $barra_statics;
        //de create:
        $monedas=Moneda::all();
        $familias=Familia::where('estado',0)->get();
        $marcas=Marca::where('estado',0)->get();
        $estados=Estado::all();
        $categorias=Categoria::where('descripcion','PRODUCTOS')->first();
        $unidad_medidas=Unidad_medida::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $moneda_principal=Moneda::where('principal',1)->first();
        $subfamilias=Subfamilia::all();

        $productos = Producto::get();

        $codigoProdGenerado     = null;
        $codigoOriginalGenerado = null;

        if ($marcas->isNotEmpty()) {
            $primera = $marcas->first();
            $cnt     = Producto::where('marca_id', $primera->id)->count() + 1;
            $suffix  = substr(1000000 + $cnt, 1);
            $cod     = "{$primera->abreviatura}-{$suffix}";

            $codigoProdGenerado     = $cod;
            $codigoOriginalGenerado = $cod;
        }

        $filtro = $request->stock;
        $productosFiltrados = [];

        foreach($productos as $producto) {
            $stockProducto = Stock_producto::where('producto_id', $producto->id)->first();
            if ($stockProducto) {
                $stockProductoMin = $producto->stock_minimo;
                $stockProductoMax = $producto->stock_maximo;
                $productoSt = $stockProducto->stock;

                if($filtro == 'bajo' && $productoSt <= $stockProductoMin) {
                    $productosFiltrados[] = $producto;
                } else if($filtro == 'alto' && $productoSt >= $stockProductoMax) {
                    $productosFiltrados[] = $producto;
                } else if(!$filtro) {
                    $productosFiltrados[] = $producto;
                }
            } else {
                if (!$filtro) {
                    $productosFiltrados[] = $producto;
                } else if ($filtro == 'bajo') {
                    $productosFiltrados[] = $producto;
                }
            }
        }




        //return view('producto_servicios.productos.index',compact('p_statics', 's_statics'));
        return view('producto_servicios.productos.index',compact('p_statics', 's_statics','unidad_medidas','categorias','marcas','estados','familias','monedas','tipo_afectacion','moneda_principal','subfamilias', 'productosFiltrados','filtro','codigoProdGenerado', 'codigoOriginalGenerado','barra_statics'));
    }


    // PRODUCTOS INACTIVOS
    public function index2(){
        $s_statics = Servicios::porcentaje_servicios();
        $p_statics = Producto::porcentaje_productos();
        return view('producto_servicios.productos.index2', compact('p_statics','s_statics'));
    }
    // PRODUCTOS ANULADOS
    public function index3(){
        $s_statics = Servicios::porcentaje_servicios();
        $p_statics = Producto::porcentaje_productos();
        return view('producto_servicios.productos.index3', compact('p_statics','s_statics'));
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
        $monedas = Moneda::all();
        $familias = Familia::where('estado', 0)->get();
        $marcas = Marca::where('estado', 0)->get();
        $estados = Estado::all();
        $categorias = Categoria::where('descripcion', 'PRODUCTOS')->first();
        $unidad_medidas = Unidad_medida::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $moneda_principal=Moneda::where('principal',1)->first();
        $subfamilias=Subfamilia::all();
        $codigoProdGenerado = null;
        if ($marcas->isNotEmpty()) {
            $primeraMarca = $marcas->first();
            $cnt = Producto::where('marca_id', $primeraMarca->id)->count() + 1;
            $suffix = substr(1000000 + $cnt, 1);
            $codigoProdGenerado = "{$primeraMarca->abreviatura}-{$suffix}";
        }
        return view('producto_servicios.productos.create',compact('unidad_medidas','categorias','marcas','estados','familias','monedas','tipo_afectacion','moneda_principal','subfamilias','codigoProdGenerado'));
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
        $this->validate($request, [
            // 'codigo_original' => ['required','unique:productos,codigo_original'],
            'nombre'          => ['required'],
            'origen'          => ['required','string'],
        ]);
        //$this->validate($request, [
        //    'codigo_original' => ['unique:productos,codigo_original'],
        //    'nombre' => ['required:productos,nombre'],
        //], [
        //    'codigo_original.unique' => 'El codigo alternativo ya existe',
        //]);

        $id_producto = $request->get('marca_id');
        $marca = Marca::where("id", "=", $id_producto)->first();
        $abreviatura = $marca->abreviatura;
        $marca_cantidad = Producto::where("marca_id", "=", $id_producto)->count();
        $marca_cantidad++;
        $contador = 1000000;
        $marca_cantidad = $contador + $marca_cantidad;
        $marca_cantidad = (string)$marca_cantidad;
        $marca_cantidad = substr($marca_cantidad, 1);

        $codigo = $abreviatura . '-' . $marca_cantidad;

        $codigo_original = $request->get('codigo_original');
        if (isset($codigo_original)) {
           $codigo_original = $request->get('codigo_original');
        } else {
           $codigo_original = $codigo;
        }
        // $codigo_original = $request->input('codigo_original');


        if ($request->hasfile('foto_producto')) {
            $image1 = $request->file('foto_producto');
            $name = time() . $image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath, $name);
        } else {
            $name = 'producto.svg';
        }
        if ($request->hasFile('archivo_producto')) {
            $file = $request->file('archivo_producto');
            $name_file = $codigo_original . '-' . $file->getClientOriginalName();
            $destinationPath_file = public_path('/archivos/productos/fichas/');
            $file->move($destinationPath_file, $name_file);
        } else {
            $name_file = null;
        }

        $peso = $request->get('peso');
        $simbolo = $request->get('simbolo');


        $producto = new Producto;
        $producto->codigo_producto  = $codigo;
        $producto->codigo_original  = $codigo_original;
        $producto->categoria_id = 1;
        $producto->familia_id = $request->get('familia_id');
        $producto->subfamilia_id = $request->get('sub_familia_id');
        $producto->marca_id = $request->get('marca_id');
        $producto->nombre = $request->get('nombre');
        $producto->descripcion = $request->get('descripcion');
        $producto->estado_id = 1;
        $producto->origen = $request->input('origen');
        $producto->estado_id = $request->estado_producto_store;
        if ($request->get('descuento1')) {
            $producto->descuento1 = $request->get('descuento1');
        } else {
            $producto->descuento1 = 0;
        }
        if ($request->get('descuento2')) {
            $producto->descuento2 = $request->get('descuento2');
        } else {
            $producto->descuento2 = 0;
        }
        if ($request->get('utilidad')) {
            $producto->utilidad = $request->get('utilidad');
        } else {
            $producto->utilidad = 0;
        }
        if ($request->get('stock_minimo')) {
            $producto->stock_minimo = $request->get('stock_minimo');
        } else {
            $producto->stock_minimo = 0;
        }
        if ($request->get('stock_maximo')) {
            $producto->stock_maximo = $request->get('stock_maximo');
        } else {
            $producto->stock_maximo = 0;
        }
        if ($request->get('descuento_maximo')) {
            $producto->descuento_maximo = $request->get('descuento_maximo');
        } else {
            $producto->descuento_maximo = 0;
        }
        if ($request->get('garantia')) {
            $producto->garantia = $request->get('garantia');
        } else {
            $producto->garantia = '0 Meses';
        }
        $producto->unidad_medida_id = $request->get('unidad_medida_id');
        $producto->peso = $peso . ' ' . $simbolo;
        $producto->tipo_afectacion_id = $request->get('tipo_afectacion');
        $producto->foto = $name;
        $producto->archivo = $name_file;
        $producto->estado_anular = '1';
        $producto->detalle = $request->get('detalle');
        $producto->save();

        Stock_almacen::new($producto->id);
        Stock_producto::new($producto->id);

        if ($request->ajax()) {
            return response()->json([
                'success'  => true,
                'producto' => $producto,
                'message'  => 'Producto creado correctamente'
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto guardado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $precio_promedio = Stock_producto::where('producto_id', $id)->first();
        // return $precio_promedio->precio_nacional;

        $producto = Producto::find($id);
        $pro_peso = $producto->peso;

        $simbolo = strstr($pro_peso, ' ', false);
        $peso = strstr($pro_peso, ' ', true);

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
        $producto = Producto::findOrFail($id);
        return response()->json($producto);
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
        // dd($request->all());
        $isAjax = $request->ajax() || $request->has('_method');

        $isImport = !$isAjax && !$request->hasFile('foto') && !$request->hasFile('archivo');

        try {
            $producto = Producto::findOrFail($id);

            if ($isAjax) {
                $request->validate([
                    'nombre' => 'required|string',
                    'codigo_producto' => 'required|string|max:100',
                    'codigo_original' => 'required|string|max:100',
                    'marca_id' => 'required|exists:marcas,id',
                    'origen' => 'required|string|max:100',
                    'stock' => 'nullable|integer|min:0',
                    'stock_minimo' => 'required|integer|min:0',
                    'stock_maximo' => 'required|integer|min:0',
                    'unidad_medida_id' => 'required|exists:unidad_medida,id',
                    'garantia' => 'required|string|max:100',
                    'familia_id' => 'required|exists:familias,id',
                    'subfamilia_id' => 'required|exists:subfamilias,id',
                    'precio_nacional' => 'nullable|numeric|min:0',
                    'descripcion' => 'nullable|string|max:255',
                ]);
                // return $request;
            } elseif (!$isImport) {
                $this->validate($request, [
                    'codigo_original' => ['required', 'unique:productos,codigo_original,' . $id],
                ], [
                    'codigo_original.unique' => 'El codigo alternativo ya existe',
                ]);
            }
            // return $request;
            // $name = null;
            // $name_file = $producto->archivo;

            // if (!$isAjax && !$isImport) {
                if ($request->hasFile('foto')) {
                    $image1 = $request->file('foto');
                    $name = time() . $image1->getClientOriginalName();
                    $destinationPath = public_path('/archivos/imagenes/productos/');
                    $image1->move($destinationPath, $name);
                }

                if ($request->hasFile('archivo')) {
                    $file = $request->file('archivo');
                    $codigo_original = $request->get('codigo_original') ?: $request->get('codigo');
                    $name_file = $codigo_original . '-' . $file->getClientOriginalName();
                    $destinationPath_file = public_path('/archivos/productos/fichas/');
                    $file->move($destinationPath_file, $name_file);
                }
            // }
                // dd($request->hasFile('archivo'));
            if ($isAjax) {
                $peso = $request->peso_cantidad . ' ' . $request->peso_unidad;
                $producto->update([
                    'nombre' => $request->nombre,
                    'codigo_producto' => $request->codigo_producto,
                    'codigo_original' => $request->codigo_original,
                    'marca_id' => $request->marca_id,
                    'origen' => $request->origen,
                    'peso' => $peso,
                    // 'stock' => $request->stock,
                    'stock_minimo' => $request->stock_minimo,
                    'precio_venta' => $request->precio_venta,
                    'stock_maximo' => $request->stock_maximo,
                    'descuento1' => $request->descuento_1,
                    'descuento2' => $request->descuento_2,
                    'descuento_maximo' => $request->descuento_max,
                    'utilidad' => $request->utilidad,
                    'precio_compra' => $request->precio_nacional,
                    'precio_venta' => $request->precio_venta,
                    'unidad_medida_id' => $request->unidad_medida_id,
                    'garantia' => $request->garantia,
                    'familia_id' => $request->familia_id,
                    'subfamilia_id' => $request->subfamilia_id,
                    'detalle' => $request->detalle,
                    'descripcion' => $request->descripcion,
                    'detalle' => $request->detalle,
                    'archivo' => $name_file ?? $producto->archivo,
                    'foto' => $name ?? $producto->foto,
                    'estado_id' => $request->estado_id,
                ]);

            } elseif ($isImport) {

                $producto->update($request->all());
            } else {

                $codigo_original = $request->get('codigo_original') ?: $request->get('codigo');

                $estado = $request->get('estado_id') ? 1 : 2;

                $peso = $request->get('peso') ?: 0;
                $simbolo = $request->get('simbolo');

                if ($request->get('nombre') != null) {
                    $producto->nombre = $request->get('nombre');
                }

                $producto->codigo_original = $codigo_original;
                $producto->descripcion = $request->get('descripcion');
                $producto->estado_id = $estado;
                $producto->origen = $request->get('origen');

                $producto->descuento1 = $request->get('descuento_1') ?: 0;
                $producto->descuento2 = $request->get('descuento_2') ?: 0;
                $producto->descuento_maximo = $request->get('descuento_max') ?: 0;
                $producto->utilidad = $request->get('utilidad') ?: 0;
                $producto->garantia = $request->get('garantia') ?: '0 Meses';
                $producto->stock_minimo = $request->get('stock_minimo') ?: 0;
                $producto->stock_maximo = $request->get('stock_maximo') ?: 0;

                $producto->precio_venta = $request->get('precio_venta');
                // $producto->precio_impuesto = '1';
                $producto->unidad_medida_id = $request->get('unidad_medida_id');
                $producto->peso = $peso . ' ' . $simbolo;
                $producto->tipo_afectacion_id = $request->get('tipo_afectacion');

                if ($name) {
                    $producto->foto = $name;
                }
                $producto->archivo = $name_file;

                $producto->familia_id = $request->get('familia_id');
                $producto->subfamilia_id = $request->get('sub_familia_id');

                $producto->save();
            }

            if ($isAjax) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto actualizado correctamente',
                    'producto' => $producto
                ]);
            } elseif ($isImport) {
                return true;
            } else {
                return redirect()->route('productos.show', $id);
            }

        } catch (Exception $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el producto: ' . $e->getMessage()
                ], 500);
            } elseif ($isImport) {
                throw $e;
            } else {
                return back()->withErrors(['error' => 'Error al actualizar el producto: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->get('id_producto');
        // Validación para la anulacion Kardex Entrada
        $kardex_entrada = kardex_entrada_registro::where('producto_id', $id)->where('estado', 1)->get()->first();
        // return $kardex_entrada;
        $producto=Producto::find($id);
        // Si el producto existe en cardex entrada
        if (isset($kardex_entrada->producto_id)) {
            // NO ANULA EL PRODUCTO
            // $errors = "Para anular un producto, haga la salida de todo el stock en kardex";
            // return route('productos.index',compact('errors'));
            if($producto->estado_id == 0){
                return redirect()->route('productos.index')->with('anulacion', 'Producto registrado en almacen, retire todo con una Guia de Salida para poder anular dicho producto.');
            }else{
                return redirect()->route('productos.index2')->with('anulacion', 'Producto registrado en almacen, retire todo con una Guia de Salida para poder anular dicho producto.');
            }
            // return "Error por tener producto en kardex, no se puede eliminar";
            // return $kardex_entrada;
        }else{

            $producto->codigo_original='Codigo Anulado N°'.$id;
            $producto->estado_anular='0';
            $producto->save();
            return redirect()->back();
            // return '0';
        }

    }

     /**
     * Importa productos desde un archivo Excel o CSV
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importar(Request $request)
{
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
        $erroresImagenes = [];

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

            // ✅ CORRECCIÓN: Búsqueda más flexible de productos existentes
            $producto = null;

            // Buscar por codigo_original si existe
            if (!empty($codigoOriginal)) {
                $producto = Producto::where('codigo_original', $codigoOriginal)->first();
            }

            // Si no se encontró por codigo_original, buscar por codigo_producto
            if (!$producto && !empty($codigoProducto)) {
                $producto = Producto::where('codigo_producto', $codigoProducto)->first();
            }

            // Si aún no se encontró, buscar por nombre
            if (!$producto && !empty($nombre)) {
                $producto = Producto::where('nombre', $nombre)->first();
            }

            // Preparar los datos a guardar
            $datosProducto = [];
            foreach ($columnas as $nombreBD => $indiceColumna) {
                // Verificar si el índice existe en la fila
                if (isset($fila[$indiceColumna]) && $fila[$indiceColumna] !== null && $fila[$indiceColumna] !== '') {
                    $valor = trim((string)$fila[$indiceColumna]);

                    // Para campos que son foreign keys, convertir texto a ID
                    switch ($nombreBD) {
                        case 'tipo_afectacion_id':
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

            // ✅ CORRECCIÓN: Generar código si no existe
            if (empty($codigoOriginal)) {
                $marcaId = $datosProducto['marca_id'] ?? 1;
                $marca = Marca::find($marcaId);
                $abreviatura = $marca ? $marca->abreviatura : 'XXX';
                $marca_cantidad = Producto::where('marca_id', $marcaId)->count() + 1;
                $codigoSecuencial = str_pad($marca_cantidad, 6, '0', STR_PAD_LEFT);
                $codigoOriginal = $abreviatura . '-' . $codigoSecuencial;

                // Asegurar que el código generado sea único
                while (Producto::where('codigo_original', $codigoOriginal)->exists()) {
                    $marca_cantidad++;
                    $codigoSecuencial = str_pad($marca_cantidad, 6, '0', STR_PAD_LEFT);
                    $codigoOriginal = $abreviatura . '-' . $codigoSecuencial;
                }
            }

            // Asegurar que los códigos estén en datosProducto
            if (!isset($datosProducto['codigo_original']) || empty($datosProducto['codigo_original'])) {
                $datosProducto['codigo_original'] = $codigoOriginal;
            }
            if (!isset($datosProducto['codigo_producto']) || empty($datosProducto['codigo_producto'])) {
                $datosProducto['codigo_producto'] = $codigoProducto ?: $codigoOriginal;
            }
            if (!isset($datosProducto['nombre']) || empty($datosProducto['nombre'])) {
                $datosProducto['nombre'] = $nombre;
            }

            // Procesar imagen
            if (!empty($datosProducto['foto']) && filter_var($datosProducto['foto'], FILTER_VALIDATE_URL)) {
                $urlImagen = trim($datosProducto['foto']);
                $rutaDestino = public_path('archivos/imagenes/productos/');

                try {
                    if (!file_exists($rutaDestino)) {
                        mkdir($rutaDestino, 0755, true);
                    }

                    $respuesta = Http::timeout(10)->withHeaders([
                        'User-Agent' => 'Mozilla/5.0'
                    ])->get($urlImagen);

                    if ($respuesta->successful()) {
                        $extensionesImagen = [
                            'image/jpeg' => 'jpg',
                            'image/png' => 'png',
                            'image/gif' => 'gif',
                            'image/webp' => 'webp',
                            'image/bmp' => 'bmp',
                            'image/svg+xml' => 'svg'
                        ];

                        $mime = $respuesta->header('Content-Type');
                        $extension = $extensionesImagen[$mime] ?? null;

                        if ($extension) {
                            $nombreArchivo = md5($urlImagen) . '.' . $extension;
                            file_put_contents($rutaDestino . $nombreArchivo, $respuesta->body());
                            $datosProducto['foto'] = $nombreArchivo;
                        } else {
                            $datosProducto['foto'] = 'producto.svg';
                            $erroresImagenes[] = "Fila " . ($numeroFila + 2) . ": la URL no corresponde a una imagen válida.";
                        }
                    } else {
                        $datosProducto['foto'] = 'producto.svg';
                    }
                } catch (Exception $e) {
                    $datosProducto['foto'] = 'producto.svg';
                }
            } else {
                $datosProducto['foto'] = 'producto.svg';
            }

            try {
                if ($producto) {
                    // ✅ ACTUALIZAR PRODUCTO EXISTENTE
                    $producto->update($datosProducto);
                    $actualizados++;
                } else {
                    // ✅ CREAR NUEVO PRODUCTO - Verificar campos mínimos
                    if (empty($datosProducto['codigo_original']) || empty($datosProducto['nombre'])) {
                        $errores[] = "Error en fila " . ($numeroFila + 2) . ": Faltan datos obligatorios (código o nombre).";
                        continue;
                    }

                    // Preparar datos completos para creación
                    $datosCompletos = [
                        'codigo_original' => $datosProducto['codigo_original'],
                        'codigo_producto' => $datosProducto['codigo_producto'] ?? $datosProducto['codigo_original'],
                        'nombre' => $datosProducto['nombre'],
                        'utilidad' => $datosProducto['utilidad'] ?? 0,
                        'precio_venta' => $datosProducto['precio_venta'] ?? 0,
                        'descuento1' => $datosProducto['descuento1'] ?? 0,
                        'descuento2' => $datosProducto['descuento2'] ?? 0,
                        'descuento_maximo' => $datosProducto['descuento_maximo'] ?? 0,
                        'origen' => $datosProducto['origen'] ?? 'Producto nacional',
                        'descripcion' => $datosProducto['descripcion'] ?? '',
                        'detalle' => $datosProducto['detalle'] ?? '',
                        'garantia' => $datosProducto['garantia'] ?? '0 Meses',
                        'peso' => $datosProducto['peso'] ?? '0 gramos',
                        'stock_minimo' => $datosProducto['stock_minimo'] ?? 0,
                        'stock_maximo' => $datosProducto['stock_maximo'] ?? 0,
                        'foto' => $datosProducto['foto'] ?? 'producto.svg',
                        'archivo' => $datosProducto['archivo'] ?? null,
                        'estado_anular' => $datosProducto['estado_anular'] ?? 1,
                        'tipo_afectacion_id' => $datosProducto['tipo_afectacion_id'] ?? 1,
                        'categoria_id' => $datosProducto['categoria_id'] ?? 1,
                        'familia_id' => $datosProducto['familia_id'] ?? 16,
                        'subfamilia_id' => $datosProducto['subfamilia_id'],
                        'marca_id' => $datosProducto['marca_id'] ?? 1,
                        'unidad_medida_id' => $datosProducto['unidad_medida_id'] ?? 1,
                        'estado_id' => $datosProducto['estado_id'] ?? 1,
                    ];

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

        // ✅ ELIMINAR CÓDIGO DUPLICADO DE PROCESAMIENTO DE IMAGEN
        // (Ya se procesa arriba en el bucle)

        // Verificar si hay errores para mostrar
        if (!empty($errores)) {
            // Limitar la cantidad de errores mostrados para no sobrecargar la respuesta
            $erroresMostrados = array_slice($errores, 0, 5);
            $mensajeError = implode('<br>', $erroresMostrados);

            if (count($errores) > 5) {
                $mensajeError .= '<br>... y ' . (count($errores) - 5) . ' errores más.';
            }

            return redirect()->back()->with(
                'warning',
                "Importación parcial: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados). Algunos registros tuvieron errores: <br>"
                    . $mensajeError
            );
        }

        if ($totalRegistros > 0) {
            $mensaje = "Importación completada: $totalRegistros registros procesados ($nuevos nuevos, $actualizados actualizados).";
            if (!empty($erroresImagenes)) {
                $mensaje .= "<br><strong>Advertencias:</strong><br>" . implode('<br>', array_slice($erroresImagenes, 0, 5));
                if (count($erroresImagenes) > 5) {
                    $mensaje .= "<br>... y " . (count($erroresImagenes) - 5) . " advertencias más.";
                }
                return redirect()->back()->with('warning', $mensaje);
            }
            return redirect()->back()->with('success', $mensaje);
        } else {
            return redirect()->back()->with('warning', "No se encontraron productos válidos para importar.");
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al importar: ' . $e->getMessage() . ' en línea ' . $e->getLine());
    }
}

    public function generateCodigoProducto(Request $request)
    {
        $marca = Marca::findOrFail($request->marca_id);
        $abre  = $marca->abreviatura;

        $maxSeq = Producto::where('codigo_producto', 'like', "{$abre}-%")
            ->select(DB::raw("MAX(CAST(SUBSTRING_INDEX(codigo_producto,'-', -1) AS UNSIGNED)) AS max_seq"))
            ->value('max_seq')
            ?? 0;

        $nextSeq = str_pad($maxSeq + 1, 6, '0', STR_PAD_LEFT);

        $codigo = "{$abre}-{$nextSeq}";

        return response()->json([
            'codigo_producto' => $codigo
        ]);
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
            'foto' => 'foto',
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
     * Si no encuentra y el modelo es proporcionado, crea un nuevo registro según las reglas específicas
     *
     * @param array $mapeo Array asociativo [id => nombre]
     * @param string $texto Texto a buscar
     * @param int $valorPorDefecto Valor por defecto si no se encuentra
     * @param string|null $modelo Nombre de la clase del modelo
     * @param string $campo Campo a usar para la búsqueda y creación
     * @return int ID encontrado, creado o valor por defecto
     */
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
            if (
                strpos($this->normalizarTexto($nombre), $textoNormalizado) !== false ||
                strpos($textoNormalizado, $this->normalizarTexto($nombre)) !== false
            ) {
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

        public function tipoAfectacion()
    {
        // suponiendo que tu FK es tipo_afectacion_id
        return $this->belongsTo(Tipo_afectacion::class, 'tipo_afectacion_id');
    }

    public function exportTodo(){
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $productos = Producto::all();

        $almacenes = Almacen::all();

        $headers = [
            'Código Producto',
            'Código Original',
            'Nombre',
            'Utilidad',
            'Precio Venta',
            'Precio Impuesto',
            'Descuento 1',
            'Descuento 2',
            'Descuento Máximo',
            'Descripción',
            'Detalle',
            'Origen',
            'Garantía',
            'Peso',
            'Stock Mínimo',
            'Stock Máximo',
            'Stock',
            'Estado Anular',
            'Tipo Afectación',
            'Categoría',
            'Familia',
            'Subfamilia',
            'Marca',
            'Unidad Medida',
            'Estado'
        ];

        foreach ($almacenes as $almacen) {
            $headers[] = $almacen->nombre;
        }

        $rows = [$headers];

        foreach ($productos as $producto) {
            $estadoAnular = $producto->estado_anular;
            if($estadoAnular == 1) {
                $anulado = 'Si';
            } else {
                $anulado = 'No';
            }

            $tipoAfectacion = optional($producto->tipo_afec_i_producto)->informacion;
            $categoria = optional($producto->categoria_i_producto)->descripcion;
            $familia = optional($producto->familia_i_producto)->descripcion;
            $subFamillia = optional($producto->subfamilia_i_producto)->descripcion;
            $marca = optional($producto->marcas_i_producto)->nombre;
            $unidadMedida = optional($producto->unidad_i_producto)->medida;
            $productoEstado = optional($producto->estado_i_producto)->nombre;
            $stockProducto = optional($producto->stock_producto)->stock ?? 0;

            $row = [
                $producto->codigo_producto,
                $producto->codigo_original,
                $producto->nombre,
                $producto->utilidad,
                $producto->precio_venta,
                $producto->precio_impuesto,
                $producto->descuento1,
                $producto->descuento2,
                $producto->descuento_maximo,
                $producto->descripcion,
                $producto->detalle,
                $producto->origen,
                $producto->garantia,
                $producto->peso,
                $producto->stock_minimo,
                $producto->stock_maximo,
                $stockProducto,
                $anulado,
                $tipoAfectacion,
                $categoria,
                $familia,
                $subFamillia,
                $marca,
                $unidadMedida,
                $productoEstado
            ];

            foreach ($almacenes as $almacen) {
                $stockAlmacen = Stock_almacen::where('producto_id', $producto->id)
                                        ->where('almacen_id', $almacen->id)
                                        ->first();

                $row[] = $stockAlmacen ? $stockAlmacen->stock : 0;
            }

            $rows[] = $row;
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

        $fecha = now('America/Lima')->format('d-m-Y');
        return Excel::download($export, 'Productos_' . $fecha . '.xlsx');
    }

    public function exportSelectedProducts(Request $request){
        if (ob_get_contents()) {
            ob_end_clean();
        }

        $ids = $request->input('ids');

        if (empty($ids)) {
            return back()->with('error', 'No se seleccionaron productos');
        }

        $productIds = explode(',', $ids);
        $productos = Producto::whereIn('id', $productIds)->get();
        $almacenes = Almacen::all();

        $headers = [
            'Código Producto', 'Código Original', 'Nombre', 'Utilidad', 'Precio Venta',
            'Precio Impuesto', 'Descuento 1', 'Descuento 2', 'Descuento Máximo',
            'Descripción', 'Detalle', 'Origen', 'Garantía', 'Peso', 'Stock Mínimo',
            'Stock Máximo', 'Stock', 'Estado Anular', 'Tipo Afectación', 'Categoría',
            'Familia', 'Subfamilia', 'Marca', 'Unidad Medida', 'Estado'
        ];

        foreach ($almacenes as $almacen) {
            $headers[] = $almacen->nombre;
        }

        $rows = [$headers];

        foreach ($productos as $producto) {
            $anulado = $producto->estado_anular == 1 ? 'Si' : 'No';
            $tipoAfectacion = optional($producto->tipo_afec_i_producto)->informacion;
            $categoria = optional($producto->categoria_i_producto)->descripcion;
            $familia = optional($producto->familia_i_producto)->descripcion;
            $subFamillia = optional($producto->subfamilia_i_producto)->descripcion;
            $marca = optional($producto->marcas_i_producto)->nombre;
            $unidadMedida = optional($producto->unidad_i_producto)->medida;
            $productoEstado = optional($producto->estado_i_producto)->nombre;
            $stockProducto = optional($producto->stock_producto)->stock ?? 0;

            $row = [
                $producto->codigo_producto, $producto->codigo_original, $producto->nombre,
                $producto->utilidad, $producto->precio_venta, $producto->precio_impuesto,
                $producto->descuento1, $producto->descuento2, $producto->descuento_maximo,
                $producto->descripcion, $producto->detalle, $producto->origen,
                $producto->garantia, $producto->peso, $producto->stock_minimo,
                $producto->stock_maximo, $stockProducto, $anulado, $tipoAfectacion,
                $categoria, $familia, $subFamillia, $marca, $unidadMedida, $productoEstado
            ];

            foreach ($almacenes as $almacen) {
                $stockAlmacen = Stock_almacen::where('producto_id', $producto->id)
                                        ->where('almacen_id', $almacen->id)
                                        ->first();
                $row[] = $stockAlmacen ? $stockAlmacen->stock : 0;
            }

            $rows[] = $row;
        }

        $export = new class($rows) implements FromArray, WithEvents {
            private $rows;
            public function __construct($rows) { $this->rows = $rows; }
            public function array(): array { return $this->rows; }
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

        $fecha = now('America/Lima')->format('d-m-Y');

        return Excel::download($export, 'Productos_Seleccionados_' . $fecha . '.xlsx');
    }

    public function desactivarProducto($producto_id) {
        try {

            $producto = Producto::findOrFail($producto_id);
            $estadoActivoId = Estado::where('nombre', 'ACTIVO')->value('id');
            $estadoDesactivoId = Estado::where('nombre', 'DESACTIVO')->value('id');
            $estadoDescontinuadoId = Estado::where('nombre', 'DESCONTINUADO')->value('id');

            if($producto->estado_id == $estadoDescontinuadoId) {
                return redirect()->route('productos.index')->with('warning', 'Advertencia. Este producto está descontinuado');
            }

            if($producto->stock_producto->stock !== 0) {
                return redirect()->route('productos.index')->with('warning', 'Advertencia. Este producto tiene stock');
            }

            if($producto->estado_id !== $estadoActivoId) {
                return redirect()->route('productos.index')->with('warning', 'Solo se pueden desactivar productos activos');
            }

            $producto->estado_id = $estadoDesactivoId;
            $producto->save();

            return redirect()->route('productos.index')->with('success', 'Producto desactivado correctamente');

        } catch (Exception $e) {

            // return $e;
            return redirect()->route('productos.index')->with('error', 'Error. Inténtelo más tarde');

        }
    }

}
