<?php

namespace App\Http\Controllers;

use App\Familia;
use App\Subfamilia;
use App\Marca;
use App\Moneda;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Tipo_afectacion;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use Barryvdh\DomPDF\Facade\Pdf;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicios::all();
        $s_statics = Servicios::porcentaje_servicios();
        $barra_statics = Marca::barras_familias_servicios();
        $moneda = Moneda::get();
        $familias = Familia::where('estado', 0)->get();
        $marcas = Marca::where('estado', 0)->get();
        $subfamilias = Subfamilia::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $tipo_cambio = TipoCambio::latest()->first();
        // return $statics;
        return view('producto_servicios.servicios.index', compact('barra_statics', 's_statics', 'servicios', 'moneda', 'marcas', 'familias', 'subfamilias', 'tipo_afectacion', 'tipo_cambio'));
    }
    // SERVICIOS INACTIVO
    public function index2()
    {
        $servicios = Servicios::all();
        $s_statics = Servicios::porcentaje_servicios();
        $barra_statics = Marca::barras_familias_servicios();
        $moneda = Moneda::get();
        $familias = Familia::where('estado', 0)->get();
        $marcas = Marca::where('estado', 0)->get();
        $subfamilias = Subfamilia::all();
        $tipo_afectacion = Tipo_afectacion::all();
        $tipo_cambio = TipoCambio::latest()->first();
        // return $statics;
        return view('producto_servicios.servicios.index2', compact('barra_statics', 's_statics', 'servicios', 'moneda', 'marcas', 'familias', 'subfamilias', 'tipo_afectacion', 'tipo_cambio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = Marca::all();
        $familias = Familia::all();
        $monedas = Moneda::all();
        $afectacion = Tipo_afectacion::all();
        return view('producto_servicios.servicios.create', compact('monedas', 'marcas', 'familias', 'afectacion'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //     $conteo = Servicios::all()->count();
        //     $suma = $conteo + 1;
        //     $servicio_nr = str_pad($suma, 8, "0", STR_PAD_LEFT);
        $codigo = Servicios::generar_codigo();
        // dd($codigo_servicio);
        // Tipo de cambio -------------------------------------------------------------------------------------
        $cambio = TipoCambio::latest('created_at')->first();

        //  Moneda --------------------------------------------------------------------------------------------
        $moneda_principal = Moneda::where('tipo', 'nacional')->first();
        $moneda_principal_id = $moneda_principal->id;
        $moneda_id = $request->get('moneda');

        if ($request->hasfile('foto')) {
            $image1 = $request->file('foto');
            $name = time() . $image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/servicios/');
            $image1->move($destinationPath, $name);
        } else {
            $name = "servicio.png";
        }

        $isAjax = $request->ajax() || $request->has('_method');
        if ($isAjax) {
            try {
                $servicio = Servicios::create([
                    'codigo_servicio' => $codigo,
                    'codigo_original' => $request->codigo ?? $codigo,
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion ?? " ",
                    'marca_id' => $request->marca_id,
                    'familia_id' => $request->familia_id,
                    'subfamilia_id' => $request->subfamilia_id != "null" ? $request->subfamilia_id : null,
                    'categoria' => 2,
                    'precio_nacional' => round($request->precio_nacional, 2),
                    'precio_extranjero' => round($request->precio_extranjero, 2),
                    'utilidad' => $request->utilidad ?? "0",
                    'descuento' => $request->descuento ?? "0",
                    'tipo_afectacion_id' => $request->afectacion_id,
                    'moneda_id' => $moneda_principal->id,
                    'foto' => $name,
                    'estado_activo' => '0',
                    'estado_anular' => '0'
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Servicio creado correctamente',
                    'data'    => $servicio
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el servicio: ' . $e->getMessage()
                ], 500);
            }
        }
        // return $request;



        // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
        if ($moneda_principal_id == $moneda_id) {
            $precio_nacional = $request->get('precio');
            $precio_extranjero = $precio_nacional / $cambio->paralelo;
        } else {
            $precio_extranjero = $request->get('precio');
            $precio_nacional = $precio_extranjero * $cambio->paralelo;
        }
        $codigo_original = $request->get('codigo_original');
        $servicios = new Servicios;
        $servicios->codigo_servicio = $codigo_servicio;

        if (isset($codigo_original)) {
            $servicios->codigo_original = $request->get('codigo_original');
        } else {
            $servicios->codigo_original = $codigo_servicio;
        }

        $servicios->moneda_id = $moneda_id;
        $servicios->marca_id = $request->get('marca_id');
        $servicios->familia_id = $request->get('familia_id');
        $servicios->subfamilia_id = $request->get('sub_familia_id');
        $servicios->nombre = $request->get('nombre');
        $servicios->categoria = 2;
        $servicios->precio_nacional = round($precio_nacional, 2);
        $servicios->precio_extranjero = round($precio_extranjero, 2);
        if ($request->get('descripcion')) {
            $servicios->descripcion = $request->get('descripcion');
        } else {
            $servicios->descripcion = ' ';
        }
        if ($request->get('descuento')) {
            $servicios->descuento = $request->get('descuento');
        } else {
            $servicios->descuento = 0;
        }
        if ($request->get('utilidad')) {
            $servicios->utilidad = $request->get('utilidad');
        } else {
            $servicios->utilidad = 0;
        }
        $servicios->foto = $name;
        $servicios->estado_anular = '0';
        $servicios->estado_activo = '0';
        $servicios->tipo_afectacion_id = $request->get('afectacion');

        $servicios->save();
        return redirect()->route('servicios.show', $servicios->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marcas = Marca::all();
        $familias = Familia::all();

        $moneda_principal = Moneda::where('tipo', 'nacional')->first();
        $afectacion = Tipo_afectacion::all();
        $moneda_principal_id = $moneda_principal->id;
        // $moneda_id=$request->get('moneda');

        $monedas = Moneda::all();
        $servicios = Servicios::find($id);
        $subfamilias = Subfamilia::where('id_familia', $servicios->familia_id)->get();
        // return view('producto_servicios.servicios.edit',compact('servicios','monedas','moneda_principal_id','marcas','familias','afectacion'));

        //    $servicios=Servicios::find($id);
        //    $monedas=Moneda::all();
        //    $moneda_nacional=Moneda::where('tipo','nacional')->first();
        //    $moneda_extranjera=Moneda::where('tipo','extranjera')->first();
        return view('producto_servicios.servicios.show', compact('servicios', 'monedas', 'moneda_principal_id', 'marcas', 'familias', 'afectacion', 'subfamilias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marcas = Marca::all();
        $familias = Familia::all();
        $moneda_principal = Moneda::where('tipo', 'nacional')->first();
        $afectacion = Tipo_afectacion::all();
        $moneda_principal_id = $moneda_principal->id;
        // $moneda_id=$request->get('moneda');

        $monedas = Moneda::all();
        $servicios = Servicios::find($id);
        return view('producto_servicios.servicios.edit', compact('servicios', 'monedas', 'moneda_principal_id', 'marcas', 'familias', 'afectacion'));
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
        $isAjax = $request->ajax() || $request->has('_method');

        $cambio = TipoCambio::latest('created_at')->first();
        $moneda_principal = Moneda::where('tipo', 'nacional')->first();
        $moneda_principal_id = $moneda_principal->id;
        $moneda_id = $request->get('moneda');
        try {
            // return $request
            if ($request->hasfile('foto')) {
                $image1 = $request->file('foto');
                $name = time() . $image1->getClientOriginalName();
                $destinationPath = public_path('/archivos/imagenes/servicios/');
                $image1->move($destinationPath, $name);
            }
            $servicio = Servicios::findOrFail($id);
            // Generar Cambio para precio nacional y precio extranjero ----------------------------------------------
            if ($isAjax) {
                $servicio->update([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion ?? " ",
                    'marca_id' => $request->marca_id,
                    'familia_id' => $request->familia_id,
                    'subfamilia_id' => $request->subfamilia_id != "null" ? $request->subfamilia_id : null,
                    'categoria' => 2,
                    'precio_nacional' => round($request->precio_nacional, 2),
                    'precio_extranjero' => round($request->precio_extranjero, 2),
                    'utilidad' => $request->utilidad ?? "0",
                    'descuento' => $request->descuento ?? "0",
                    'tipo_afectacion_id' => $request->tipo_afectacion_id,
                    'moneda_id' => $moneda_principal->id,
                    'foto' => $name ?? $servicio->foto,
                    'estado_activo' => '0',
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Servicio actualizado correctamente',
                    'servicio' => $servicio
                ]);
            } else {
                if ($moneda_principal_id == $moneda_id) {
                    $precio_nacional = $request->get('precio');
                    $precio_extranjero = $precio_nacional / $cambio->paralelo;
                } else {
                    $precio_extranjero = $request->get('precio');
                    $precio_nacional = $precio_extranjero * $cambio->paralelo;
                }

                // $servicio = Servicios::find($id);
                $servicio->moneda_id = $moneda_id;
                $servicio->codigo_original = $request->get('codigo_original');
                $servicio->familia_id = $request->get('familia_id');
                $servicio->subfamilia_id = $request->get('sub_familia_id');
                $servicio->nombre = $request->get('nombre');
                if ($request->get('descripcion')) {
                    $servicio->descripcion = $request->get('descripcion');
                } else {
                    $servicio->descripcion = '';
                }
                $servicio->descuento = $request->get('descuento');
                $servicio->utilidad = $request->get('utilidad');
                $servicio->precio_nacional = round($precio_nacional, 2);
                $servicio->precio_extranjero = round($precio_extranjero, 2);

                if ($name) {
                    $servicio->foto = $name;
                }
                $servicio->tipo_afectacion_id = $request->get('afectacion');
                $servicio->save();
                // return $servicio;
                return redirect()->route('servicios.show', $id);
            }
            // return $request->get('descripcion');
        } catch (Exception $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el Servicio: ' . $e->getMessage()
                ], 500);
            } else {
                return back()->withErrors(['error' => 'Error al actualizar el Servicio: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $requestl;
        $servicio = Servicios::find($id);
        $servicio->estado_anular = '1';
        $servicio->save();
        return response()->json([
            'success' => true,
            'message' => 'Servicio anulado correctamente',
            'servicio' => $servicio
        ]);
        // $
    }

    public function ftPdf($id)
    {
        // 1) Buscar servicio o lanzar 404 si no existe (evita null)
        $servicio = Servicios::with([
            'marca',
            'familia',
            'subfamilia',
            'moneda',
            'tipo_afectacion',
        ])->findOrFail($id);

        // 2) Preparar imagen en Base64 (prioriza foto real, si no existe usa svg/placeholder)
        $fotoBase64 = null;

        // Si tu "foto" guarda solo el nombre del archivo (ej: "abc.jpg")
        // y está en public/archivos/imagenes/servicios/
        $fotoNombre = $servicio->foto ?: 'servicio.svg';
        $fotoPath = public_path('archivos/imagenes/servicios/' . $fotoNombre);

        // Si no existe, intenta un fallback seguro
        if (!file_exists($fotoPath)) {
            $fotoPath = public_path('archivos/imagenes/servicios/servicio.svg');
        }

        // Convertir a base64 si existe
        if (file_exists($fotoPath)) {
            $ext = strtolower(pathinfo($fotoPath, PATHINFO_EXTENSION));

            // Dompdf suele llevarse mejor con png/jpg/jpeg. Si es svg, igual lo intentamos.
            $mime = match ($ext) {
                'jpg', 'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                default => 'application/octet-stream',
            };

            $fotoData = file_get_contents($fotoPath);
            if ($fotoData !== false) {
                $fotoBase64 = 'data:' . $mime . ';base64,' . base64_encode($fotoData);
            }
        }

        // 3) Generar PDF
        $pdf = \PDF::loadView('producto_servicios.servicios.ft_pdf', [
            'servicio'   => $servicio,
            'fotoBase64' => $fotoBase64,
        ])->setPaper('A4', 'portrait');

        // 4) Nombre del archivo (limpia por si hay espacios o caracteres raros)
        $codigo = $servicio->codigo_servicio ?? ('SERV_' . $servicio->id);
        $fileName = 'FT_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $codigo) . '.pdf';

        return $pdf->stream($fileName);
    }


    // public function generar_codigo_servicio(Request $request)
    // {

    //     try {
    //         // Tu lógica para generar el código del servicio
    //         $conteo = Servicios::all()->count();
    //         $suma = $conteo + 1;
    //         $servicio_nr = str_pad($suma, 8, "0", STR_PAD_LEFT);
    //         $codigo_servicio = "SERV-" . $servicio_nr;
    //         // return $codigo_servicio;

    //         return response()->json($codigo_servicio); // Esto es lo que AJAX espera
    //     } catch (\Exception $e) {
    //         // Devuelve el error para poder verlo en consola
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }
}
