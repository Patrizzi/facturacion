<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Personal;
use App\Codigo_guia_almacen;
use App\Stock_producto;
use App\Stock_almacen;
use App\Producto;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{

    // public function __construct(){
    //     $this->middleware('permission:configuracion_general-almacenes.index',['only' => ['index']]);
    //     $this->middleware('permission:configuracion_general-almacenes.create',['only' => ['create']]);
    //     $this->middleware('permission:configuracion_general-almacenes.store',['only' => ['store']]);
    //     $this->middleware('permission:configuracion_general-almacenes.show',['only' => ['show']]);
    //     $this->middleware('permission:configuracion_general-almacenes.edit',['only' => ['edit']]);
    //     $this->middleware('permission:configuracion_general-almacenes.update',['only' => ['update']]);
    //     $this->middleware('permission:configuracion_general-almacenes.destroy',['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Almacen::all();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $personal = Personal::where('estado', 1)->get();
        $cod_guia_almacen = Codigo_guia_almacen::all();
        return view('configuracion_general.almacen.index', compact('almacenes', 'personal', 'conteo_almacen', 'cod_guia_almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

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
            'almacen_nombre_create' => ['required', 'unique:almacen,nombre'],
            'almacen_abreviatura_create' => ['required', 'unique:almacen,abreviatura'],
            'almacen_responsable_create' => ['required'],
            'almacen_direccion_create' => ['required'],
            'almacen_descripcion_create' => ['required'],
            'almacen_sunat_create' => ['required', 'unique:cod_guia_almacen,cod_sunat,' . ',almacen_id'],
            'sunat_factura_create' => ['unique:cod_guia_almacen,serie_factura,' . ',almacen_id'],
            'sunat_boleta_create' => ['unique:cod_guia_almacen,serie_boleta,' . ',almacen_id'],
            'sunat_remision_create' => ['unique:cod_guia_almacen,serie_remision,' . ',almacen_id'],
            'sunat_factura_m_create' => ['unique:cod_guia_almacen,serie_factura_m,' . ',almacen_id'],
            'sunat_boleta_m_create' => ['unique:cod_guia_almacen,serie_boleta_m,' . ',almacen_id'],
            'sunat_remision_m_create' => ['unique:cod_guia_almacen,serie_remision_m,' . ',almacen_id'],
            'sunat_credit_fact_create' => ['unique:cod_guia_almacen,serie_nota_credito,' . ',almacen_id'],
            'sunat_credit_bol_create' => ['unique:cod_guia_almacen,serie_nota_credito_b,' . ',almacen_id'],
            'sunat_debito_create' => ['unique:cod_guia_almacen,serie_nota_debito,' . ',almacen_id'],
        ], [
            'almacen_nombre_create.required' => 'Debe ingresar el nombre del almacén.',
            'almacen_nombre_create.unique' => 'Ya existe un almacén con ese nombre.',

            'almacen_abreviatura_create.required' => 'Debe ingresar la abreviatura.',
            'almacen_abreviatura_create.unique' => 'La abreviatura ya se encuentra registrada.',

            'almacen_responsable_create.required' => 'Debe seleccionar un responsable.',
            'almacen_direccion_create.required' => 'Debe ingresar la dirección.',
            'almacen_descripcion_create.required' => 'Debe ingresar la descripción.',

            'almacen_sunat_create.required' => 'Debe seleccionar un código SUNAT.',
            'almacen_sunat_create.unique' => 'El código SUNAT ya está asignado a otro almacén.',

            'sunat_factura_create.unique' => 'La serie de factura ya está registrada.',
            'sunat_boleta_create.unique' => 'La serie de boleta ya está registrada.',
            'sunat_remision_create.unique' => 'La serie de guía de remisión ya está registrada.',

            'sunat_factura_m_create.unique' => 'La serie de factura manual ya está registrada.',
            'sunat_boleta_m_create.unique' => 'La serie de boleta manual ya está registrada.',
            'sunat_remision_m_create.unique' => 'La serie de guía de remisión manual ya está registrada.',

            'sunat_credit_fact_create.unique' => 'La serie de nota de crédito (factura) ya está registrada.',
            'sunat_credit_bol_create.unique' => 'La serie de nota de crédito (boleta) ya está registrada.',
            'sunat_debito_create.unique' => 'La serie de nota de débito ya está registrada.',
        ]);

        $almacen = new Almacen;
        $almacen->nombre = $request->get('almacen_nombre_create');
        $almacen->abreviatura = $request->get('almacen_abreviatura_create');
        $almacen->responsable = $request->get('almacen_responsable_create');
        $almacen->direccion = $request->get('almacen_direccion_create');
        $almacen->cod_postal = $request->get('almacen_ubigeo_create');
        $almacen->descripcion = $request->get('almacen_descripcion_create');
        $almacen->estado = '0';
        $almacen->principal = '0';
        $almacen->save();

        $new_series = Codigo_guia_almacen::new_series($request);
        $new_correlative = Codigo_guia_almacen::new_correlative($request);

        $cod_guia_almacen = new Codigo_guia_almacen;
        $cod_guia_almacen->cod_sunat = $request->get('cod_sunat');
        $cod_guia_almacen->almacen_id = $almacen->id;
        $cod_guia_almacen->serie_factura = $new_series['factura'];
        $cod_guia_almacen->cod_factura = $new_correlative['factura'];
        $cod_guia_almacen->serie_boleta = $new_series['boleta'];
        $cod_guia_almacen->cod_boleta = $new_correlative['boleta'];
        $cod_guia_almacen->serie_remision = $new_series['remision'];
        $cod_guia_almacen->cod_remision = $new_correlative['remision'];
        $cod_guia_almacen->serie_factura_m = $new_series['factura_m'];
        $cod_guia_almacen->cod_factura_m = $new_correlative['factura_m'];
        $cod_guia_almacen->serie_boleta_m = $new_series['boleta_m'];
        $cod_guia_almacen->cod_boleta_m = $new_correlative['boleta_m'];
        $cod_guia_almacen->serie_remision_m = $new_series['remision_m'];
        $cod_guia_almacen->cod_remision_m = $new_correlative['remision_m'];
        $cod_guia_almacen->serie_nota_credito = $new_series['credito_fact'];
        $cod_guia_almacen->cod_nota_credito = $new_correlative['credito_fact'];
        $cod_guia_almacen->serie_nota_credito_b = $new_series['credito_bol'];
        $cod_guia_almacen->cod_nota_credito_b = $new_correlative['credito_bol'];
        $cod_guia_almacen->serie_nota_debito = $new_series['debito'];
        $cod_guia_almacen->cod_nota_debito = $new_correlative['debito'];
        $cod_guia_almacen->save();
        // return $new_series;
        //INSERCION EN LA NUEVA TABLA PARA CODIGOS

        $productos = Producto::get();
        foreach ($productos as $producto) {
            $stock_almacen = new Stock_almacen;
            $stock_almacen->producto_id = $producto->id;
            $stock_almacen->almacen_id = $almacen->id;
            $stock_almacen->stock = 0;
            $stock_almacen->save();
        }
        return redirect()->route('almacen.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {}
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'almacen_nombre_create' => ['required', 'unique:almacen,nombre,' . $id],
            'almacen_abreviatura_create' => ['required', 'unique:almacen,abreviatura,' . $id],
            'almacen_responsable_create' => ['required'],
            'almacen_direccion_create' => ['required'],
            'almacen_descripcion_create' => ['required'],
            'almacen_sunat_create' => ['required', 'unique:cod_guia_almacen,cod_sunat,' . $id . ',almacen_id'],
            'sunat_factura_create' => ['unique:cod_guia_almacen,serie_factura,' . $id . ',almacen_id'],
            'sunat_boleta_create' => ['unique:cod_guia_almacen,serie_boleta,' . $id . ',almacen_id'],
            'sunat_remision_create' => ['unique:cod_guia_almacen,serie_remision,' . $id . ',almacen_id'],
            'sunat_factura_m_create' => ['unique:cod_guia_almacen,serie_factura_m,' . $id . ',almacen_id'],
            'sunat_boleta_m_create' => ['unique:cod_guia_almacen,serie_boleta_m,' . $id . ',almacen_id'],
            'sunat_remision_m_create' => ['unique:cod_guia_almacen,serie_remision_m,' . $id . ',almacen_id'],
            'sunat_credit_fact_create' => ['unique:cod_guia_almacen,serie_nota_credito,' . $id . ',almacen_id'],
            'sunat_credit_bol_create' => ['unique:cod_guia_almacen,serie_nota_credito_b,' . $id . ',almacen_id'],
            'sunat_debito_create' => ['unique:cod_guia_almacen,serie_nota_debito,' . $id . ',almacen_id'],
        ], [
            'almacen_nombre_create.required' => 'Debe ingresar el nombre del almacén.',
            'almacen_nombre_create.unique' => 'Ya existe un almacén con ese nombre.',

            'almacen_abreviatura_create.required' => 'Debe ingresar la abreviatura.',
            'almacen_abreviatura_create.unique' => 'La abreviatura ya se encuentra registrada.',

            'almacen_responsable_create.required' => 'Debe seleccionar un responsable.',
            'almacen_direccion_create.required' => 'Debe ingresar la dirección.',
            'almacen_descripcion_create.required' => 'Debe ingresar la descripción.',

            'almacen_sunat_create.required' => 'Debe seleccionar un código SUNAT.',
            'almacen_sunat_create.unique' => 'El código SUNAT ya está asignado a otro almacén.',

            'sunat_factura_create.unique' => 'La serie de factura ya está registrada.',
            'sunat_boleta_create.unique' => 'La serie de boleta ya está registrada.',
            'sunat_remision_create.unique' => 'La serie de guía de remisión ya está registrada.',

            'sunat_factura_m_create.unique' => 'La serie de factura manual ya está registrada.',
            'sunat_boleta_m_create.unique' => 'La serie de boleta manual ya está registrada.',
            'sunat_remision_m_create.unique' => 'La serie de guía de remisión manual ya está registrada.',

            'sunat_credit_fact_create.unique' => 'La serie de nota de crédito (factura) ya está registrada.',
            'sunat_credit_bol_create.unique' => 'La serie de nota de crédito (boleta) ya está registrada.',
            'sunat_debito_create.unique' => 'La serie de nota de débito ya está registrada.',
        ]);


        $almacen = Almacen::find($id);
        $almacen->nombre = $request->get('almacen_nombre_create');
        $almacen->abreviatura = $request->get('almacen_abreviatura_create');
        $almacen->responsable = $request->get('almacen_responsable_create');
        $almacen->direccion = $request->get('almacen_direccion_create');
        $almacen->cod_postal = $request->get('almacen_ubigeo_create');
        $almacen->descripcion = $request->get('almacen_descripcion_create');
        $almacen->save();

        //INSERCION EL LA TABLA DE CODGIGO
        $cod_sunat_alm = Codigo_guia_almacen::where('almacen_id', $id)->first();
        $cod_sunat_alm->cod_sunat = $request->get('almacen_sunat_create');

        if ($request->has('sunat_factura_create')) {
            $cod_sunat_alm->serie_factura = $request->sunat_factura_create;
        }
        if ($request->has('correlativo_factura_create')) {
            $cod_sunat_alm->cod_factura = $request->correlativo_factura_create;
        }

        if ($request->has('sunat_boleta_create')) {
            $cod_sunat_alm->serie_boleta = $request->sunat_boleta_create;
        }
        if ($request->has('correlativo_boleta_create')) {
            $cod_sunat_alm->cod_boleta = $request->correlativo_boleta_create;
        }

        if ($request->has('sunat_remision_create')) {
            $cod_sunat_alm->serie_remision = $request->sunat_remision_create;
        }
        if ($request->has('correlativo_remision_create')) {
            $cod_sunat_alm->cod_remision = $request->correlativo_remision_create;
        }

        if ($request->has('sunat_factura_m_create')) {
            $cod_sunat_alm->serie_factura_m = $request->sunat_factura_m_create;
        }
        if ($request->has('correlativo_factura_m_create')) {
            $cod_sunat_alm->cod_factura_m = $request->correlativo_factura_m_create;
        }

        if ($request->has('sunat_boleta_m_create')) {
            $cod_sunat_alm->serie_boleta_m = $request->sunat_boleta_m_create;
        }
        if ($request->has('correlativo_boleta_m_create')) {
            $cod_sunat_alm->cod_boleta_m = $request->correlativo_boleta_m_create;
        }

        if ($request->has('sunat_remision_m_create')) {
            $cod_sunat_alm->serie_remision_m = $request->sunat_remision_m_create;
        }
        if ($request->has('correlativo_remision_m_create')) {
            $cod_sunat_alm->cod_remision_m = $request->correlativo_remision_m_create;
        }

        if ($request->has('sunat_credit_fact_create')) {
            $cod_sunat_alm->serie_nota_credito = $request->sunat_credit_fact_create;
        }
        if ($request->has('correlativo_credit_fact_create')) {
            $cod_sunat_alm->cod_nota_credito = $request->correlativo_credit_fact_create;
        }

        if ($request->has('sunat_credit_bol_create')) {
            $cod_sunat_alm->serie_nota_credito_b = $request->sunat_credit_bol_create;
        }
        if ($request->has('correlativo_credit_bol_create')) {
            $cod_sunat_alm->cod_nota_credito_b = $request->correlativo_credit_bol_create;
        }

        if ($request->has('sunat_debito_create')) {
            $cod_sunat_alm->serie_nota_debito = $request->sunat_debito_create;
        }
        if ($request->has('correlativo_debito_create')) {
            $cod_sunat_alm->cod_nota_debito = $request->correlativo_debito_create;
        }

        $cod_sunat_alm->save();

        return response()->json([
            'success' => true,
            'message' => 'Guardado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {}
    
    public function change_state(Request $request)
    {

        $categoria = Almacen::find($request->get('id'));
        if ($categoria->estado == 0) {
            $categoria->estado = 1;
        } else {
            $categoria->estado = 0;
        }
        $categoria->save();

        return response()->json(['success' => true, 'message' => 'Estado de la categoria actualizado correctamente']);
    }

    public function cod_sunat($id)
    {
        $almacen = Almacen::with('cod_sunat')->find($id);
        return response()->json([
            'config' => $almacen->cod_sunat,
            'last_factura' => Codigo_guia_almacen::search_last_fact($id),
            'last_boleta' => Codigo_guia_almacen::search_last_bol($id),
            'last_remision' => Codigo_guia_almacen::search_last_remision($id),
            'last_factura_m' => Codigo_guia_almacen::search_last_factura_m($id),
            'last_boleta_m' => Codigo_guia_almacen::search_last_boleta_m($id),
            'last_remision_m' => Codigo_guia_almacen::search_last_remision_m($id),
            'last_credito_f' => Codigo_guia_almacen::search_last_credito_f($id),
            'last_credito_b' => Codigo_guia_almacen::search_last_credito_b($id),
            'last_debito' => Codigo_guia_almacen::search_last_debito($id)
            // ...
        ]);
    }
}
