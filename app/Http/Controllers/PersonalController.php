<?php

namespace App\Http\Controllers;

use App\Pais;
use App\Personal;
use App\Personal_datos_laborales;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personales=Personal::where('id','!=',1)->get();
        $i = 1;
        return view('planilla.datos_generales.index',compact('personales','i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises=Pais::all();
        return view('planilla.datos_generales.create',compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if($request->hasfile('foto')){
            $image =$request->file('foto');
            $nr_documento= $request->get('numero_documento');
            $name = $nr_documento."-".$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        else{
            $name="perfil.svg";
        }
        // Personal::create(request()->all());
        $personal=new Personal;
        $personal->nombres=$request->get('nombres');
        $personal->apellidos=$request->get('apellidos');
        $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
        $personal->celular=$request->get('celular');
        $personal->telefono=$request->get('telefono');
        $personal->email=$request->get('email');
        $personal->genero=$request->get('genero');
        $personal->documento_identificacion=$request->get('documento_identificacion');
        $personal->numero_documento=$request->get('numero_documento');
        $personal->nacionalidad=$request->get('nacionalidad');
        $personal->estado_civil=$request->get('estado_civil');
        $personal->nivel_educativo=$request->get('nivel_educativo');
        $personal->profesion=$request->get('profesion');
        $personal->direccion=$request->get('direccion');
        $personal->licencia=$request->get('licencia');
        $personal->estado=1;
        $personal->usuario_registrado=0;
        $personal->estado_trabajador_laboral='Activo';
        $personal->foto=$name;
        $personal->save();



        $personal_dl=new Personal_datos_laborales;
        $personal_dl->personal_id=$personal->id;
        $personal_dl->fecha_vinculacion=$request->get('fecha_vinculacion');
        $personal_dl->fecha_retiro=$request->get('fecha_retiro');
        $personal_dl->forma_pago=$request->get('forma_pago');
        $personal_dl->salario=$request->get('salario');
        $personal_dl->categoria_ocupacional=$request->get('categoria_ocupacional');
        $personal_dl->estado_trabajador='Activo';
        $personal_dl->sede=$request->get('sede');
        $personal_dl->turno=$request->get('turno');
        $personal_dl->departamento_area=$request->get('departamento_area');
        $personal_dl->cargo=$request->get('cargo');
        $personal_dl->tipo_trabajador=$request->get('tipo_trabajador');
        $personal_dl->tipo_contrato=$request->get('tipo_contrato');
        $personal_dl->regimen_pensionario=$request->get('regimen_pensionario');
        $personal_dl->afiliacion_salud=$request->get('afiliacion_salud');
        $personal_dl->banco_renumeracion=$request->get('banco_renumeracion');
        $personal_dl->numero_cuenta=$request->get('numero_cuenta');
        $personal_dl->save();
        return redirect()->route('personal.show', $personal->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personales=Personal::find($id);
        $paises=Pais::all();
        $persona=Personal_datos_laborales::where('personal_id',$personales->id)->first();
        return view('planilla.datos_generales.show',compact('personales','persona','paises'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paises=Pais::all();
        $personales=Personal::find($id);
        return view('planilla.datos_generales.edit',compact('personales','paises'));
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
        $personal=Personal::find($id);
        if($request->hasfile('foto')){
            $image =$request->file('foto');
            $nr_documento= $request->get('numero_documento');
            $name = $nr_documento."-".$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);


            $personal->nombres=$request->get('nombres');
            $personal->apellidos=$request->get('apellidos');
            $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
            $personal->celular=$request->get('celular');
            $personal->telefono=$request->get('telefono');
            $personal->email=$request->get('email');
            $personal->genero=$request->get('genero');
            $personal->documento_identificacion=$request->get('documento_identificacion');
            $personal->numero_documento=$request->get('numero_documento');
            $personal->nacionalidad=$request->get('nacionalidad');
            $personal->estado_civil=$request->get('estado_civil');
            $personal->nivel_educativo=$request->get('nivel_educativo');
            $personal->profesion=$request->get('profesion');
            $personal->direccion=$request->get('direccion');
            $personal->licencia=$request->get('licencia');
            $personal->foto=$name;
            $personal->save();
        }else{
            // $file_path=(public_path().'profile/images/'.$personal->image);
            $personal->nombres=$request->get('nombres');
            $personal->apellidos=$request->get('apellidos');
            $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
            $personal->celular=$request->get('celular');
            $personal->telefono=$request->get('telefono');
            $personal->email=$request->get('email');
            $personal->genero=$request->get('genero');
            $personal->documento_identificacion=$request->get('documento_identificacion');
            $personal->numero_documento=$request->get('numero_documento');
            $personal->nacionalidad=$request->get('nacionalidad');
            $personal->estado_civil=$request->get('estado_civil');
            $personal->nivel_educativo=$request->get('nivel_educativo');
            $personal->profesion=$request->get('profesion');
            $personal->direccion=$request->get('direccion');
            $personal->licencia=$request->get('licencia');
            // $personal->foto=$file_path;
            $personal->save();
        }
        // return redirect()->route('personal.index');
        return redirect()->route('personal.show', $personal->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal=Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('personal.index');
    }
}



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

            // Procesar filas de datos
foreach ($datos as $numeroFila => $fila) {
    // Verificar que la fila tiene datos
    if (empty($fila) || count(array_filter($fila)) < 3) {
        continue; // Saltar filas vacías o con pocos datos
    }

    // Obtener valores para campos clave
    $codigoOriginal = isset($columnas['codigo_original']) && isset($fila[$columnas['codigo_original']])
        ? trim((string)$fila[$columnas['codigo_original']]) : null;

    $codigoProducto = $codigoOriginal; // En caso de que lo necesites también

    $nombre = isset($columnas['nombre']) && isset($fila[$columnas['nombre']])
        ? trim((string)$fila[$columnas['nombre']]) : null;

    // Preparar consulta para buscar si el producto ya existe
    $query = Producto::query();

    if (!empty($codigoOriginal)) {
        $query->where('codigo_original', $codigoOriginal);
    }

    if (!empty($nombre)) {
        $query->where('nombre', $nombre);
    }

    // Si no hay criterios de búsqueda suficientes, continuar con la siguiente fila
    if (empty($codigoOriginal) && empty($codigoProducto) && empty($nombre)) {
        $errores[] = "Error en fila " . ($numeroFila + 2) . ": No hay datos suficientes para identificar el producto.";
        continue;
    }

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
                    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($tipoAfectaciones, $valor, 1, Tipo_afectacion::class, 'informacion');
                    break;
                case 'categoria_id':
                    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($categorias, $valor, 1, Categoria::class, 'descripcion');
                    break;
                case 'familia_id':
                    $datosProducto[$nombreBD] = $this->buscarIdEnMapeo($familias, $valor, 16, Familia::class, 'descripcion');
                    break;
                case 'subfamilia_id':
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

                try {
                    if ($producto) {
                        // Actualizar producto existente
                        $producto->update($datosProducto);
                        $actualizados++;
                    } else {
                        // Agregar campos requeridos con valores por defecto si no están presentes
                        // Si código original viene vacío, genera un código basado en marca
if (empty($codigoOriginal)) {
    // Si marca está seteada correctamente
    $marcaId = $datosProducto['marca_id'] ?? 1;
    $marca = Marca::find($marcaId);
    $abreviatura = $marca ? $marca->abreviatura : 'XXX';

    $marca_cantidad = Producto::where('marca_id', $marcaId)->count() + 1;
    $codigoSecuencial = str_pad($marca_cantidad, 6, '0', STR_PAD_LEFT);

    $codigoOriginal = $abreviatura . '-' . $codigoSecuencial;
}
                        $camposRequeridos = [
                            'codigo_original' => $codigoOriginal ?? '',
                            'codigo_producto' => $codigoOriginal ?? '',
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

                       // Forzar duplicación de codigo_producto si no vino en el Excel
if (empty($datosProducto['codigo_producto']) && !empty($codigoOriginal)) {
    $datosProducto['codigo_producto'] = $codigoOriginal;
}

// Asegurar también que codigo_original esté definido (por si acaso)
if (empty($datosProducto['codigo_original']) && !empty($codigoOriginal)) {
    $datosProducto['codigo_original'] = $codigoOriginal;
}

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
