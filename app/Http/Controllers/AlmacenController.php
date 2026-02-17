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
        $almacenes=Almacen::all();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $personal=Personal::where('estado',1)->get();
        $cod_guia_almacen = Codigo_guia_almacen::all();
        return view('configuracion_general.almacen.index',compact('almacenes','personal','conteo_almacen','cod_guia_almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $this->validate($request,[
            'nombre' => ['required'],
            'abreviatura' => ['required','unique:almacen'],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
            'ubigeo' => ['required', 'max:6', 'min:6'],
        ]);

        $almacen=new Almacen;
        $almacen->nombre=$request->get('nombre');
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');
        $almacen->cod_postal=$request->get('ubigeo');
        $almacen->descripcion=$request->get('descripcion');
        $almacen->estado='0';
        $almacen->principal='0';
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
      
        $productos= Producto::get();
        foreach($productos as $producto){
            $stock_almacen=new Stock_almacen;
            $stock_almacen->producto_id=$producto->id;
            $stock_almacen->almacen_id=$almacen->id;
            $stock_almacen->stock=0;
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
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $this->validate($request,[
            'nombre' => ['required','unique:almacen,nombre,'.$id],
            'abreviatura' => ['required','unique:almacen,abreviatura,'.$id],
            'responsable' => ['required'],
            'direccion' => ['required'],
            'descripcion' => ['required'],
            'cod_sunat' => ['required','unique:cod_guia_almacen,cod_sunat,'.$id.',almacen_id'],
        ]);

        $estado=$request->get('estado');
        if($estado=='on'){
            $estado_numero='0';
        }
        else{
            $estado_numero='1';
        }

        // OBTENCION DE CAMPOS
        $nr_fac=$request->get('cod_fac');
        $nr_bol=$request->get('cod_bol');
        $nr_guia=$request->get('cod_guia');
        $nr_nota_c=$request->get('cod_credito');
        $nr_nota_c_b=$request->get('cod_credito_b');
        $nr_nota_d=$request->get('cod_debito');
        $nr_factura_m=$request->get('cod_factura_m');
        $nr_boletaa_m=$request->get('cod_boleta_m');
        $nr_remision_m=$request->get('cod_remision_m');
        // $almacen=Almacen::where('id', $id)->first();
        $almacen=Almacen::find($id);
        $almacen->nombre=$request->get('nombre');
        $almacen->abreviatura=$request->get('abreviatura');
        $almacen->responsable=$request->get('responsable');
        $almacen->direccion=$request->get('direccion');

        $almacen->descripcion=$request->get('descripcion');
        $almacen->estado=$estado_numero;
        $almacen->save();
        //INSERCION EL LA TABLA DE CODGIGO
        $cod_guia_almacen = Codigo_guia_almacen::where('almacen_id',$id)->first();
        $cod_guia_almacen->cod_sunat=$request->get('cod_sunat');
        if(is_numeric($cod_guia_almacen->cod_factura) and is_numeric($nr_fac)){
            $cod_guia_almacen->serie_factura=$request->get('serie_factura');
            $cod_guia_almacen->cod_factura=$request->get('cod_fac');
        }
        if(is_numeric($cod_guia_almacen->cod_boleta) and is_numeric($nr_bol)){
            $cod_guia_almacen->serie_boleta=$request->get('serie_boleta');
            $cod_guia_almacen->cod_boleta=$request->get('cod_bol');
        }
        if(is_numeric($cod_guia_almacen->cod_remision) and is_numeric($nr_guia)){
            $cod_guia_almacen->serie_remision=$request->get('serie_remision');
            $cod_guia_almacen->cod_remision=$request->get('cod_guia');
        }
        if(is_numeric($cod_guia_almacen->cod_nota_credito) and is_numeric($nr_nota_c)){
            $cod_guia_almacen->serie_nota_credito=$request->get('serie_credito');
            $cod_guia_almacen->cod_nota_credito=$request->get('cod_credito');
        }
        if(is_numeric($cod_guia_almacen->cod_nota_credito_b) and is_numeric($nr_nota_c_b)){
            $cod_guia_almacen->serie_nota_credito_b=$request->get('serie_credito_b');
            $cod_guia_almacen->cod_nota_credito_b=$request->get('cod_credito_b');
        }
        if(is_numeric($cod_guia_almacen->cod_nota_debito) and is_numeric($nr_nota_d)){
            $cod_guia_almacen->serie_nota_debito=$request->get('serie_debito');
            $cod_guia_almacen->cod_nota_debito=$request->get('cod_debito');
        }
        if(is_numeric($cod_guia_almacen->cod_factura_m) and is_numeric($nr_factura_m)){
            $cod_guia_almacen->serie_factura_m=$request->get('serie_factura_m');
            $cod_guia_almacen->cod_factura_m=$request->get('cod_factura_m');
        }
        if(is_numeric($cod_guia_almacen->cod_boleta_m) and is_numeric($nr_boletaa_m)){
            $cod_guia_almacen->serie_boleta_m=$request->get('serie_boleta_m');
            $cod_guia_almacen->cod_boleta_m=$request->get('cod_boleta_m');
        }
        if(is_numeric($cod_guia_almacen->cod_boleta_m) and is_numeric($nr_boletaa_m)){
            $cod_guia_almacen->serie_boleta_m=$request->get('serie_boleta_m');
            $cod_guia_almacen->cod_boleta_m=$request->get('cod_boleta_m');
        }
        if(is_numeric($cod_guia_almacen->cod_remision_m) and is_numeric($nr_boletaa_m)){
            $cod_guia_almacen->serie_remision_m=$request->get('serie_remision_m');
            $cod_guia_almacen->cod_remision_m=$request->get('cod_remision_m');
        }
        $cod_guia_almacen->save();
        return redirect()->route('almacen.index');

  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {


    }
}
