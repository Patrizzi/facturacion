<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas=Marca::all();
        $conteo=Marca::where('estado','0')->count();
        return view('configuracion_general.marca.index',compact('marcas','conteo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configuracion_general.marca.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'abreviatura' => ['required','unique:marcas,abreviatura'],
        ],[
            'abreviatura.unique' => 'La abreviatura insertada en el Producto ya existe',
        ]);
        if($request->hasfile('imagen')){
            $imagen =$request->file('imagen');
            $nombre_imagen = time().$imagen->getClientOriginalName();
            // $imagen =$request->file('imagen');
            $destinationPath = public_path('/archivos/imagenes/marcas/');
            $imagen->move($destinationPath,$nombre_imagen);
        }else{
            $nombre_imagen=$request->get('imagen');
        }
        $suma=Marca::all()->count();
        $suma ++;
        $cien=100000+($suma);
        $contador=substr($cien,1);
        $descripcion=$request->get('descripcion');
        if (!isset($descripcion)) {$descripcion='Sin descripcion'; }
        $marca=new Marca;
        $marca->nombre=strtoupper($request->get('nombre'));
        $marca->codigo=$contador;
        $marca->abreviatura=strtoupper($request->get('abreviatura'));
        $marca->nombre_empresa=strtoupper($request->get('nombre_empresa'));
        $marca->telefono=strtoupper($request->get('telefono'));
        $marca->descripcion=$descripcion;
        $marca->imagen=$nombre_imagen;
        $marca->estado='0';
        $marca->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marca=Marca::find($id);
        return view('configuracion_general.marca.edit',compact('marca'));
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

        if($request->hasfile('imagen')){
            $imagen =$request->file('imagen');
            $nombre_imagen = time().$imagen->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/marcas/');
            $imagen->move($destinationPath,$nombre_imagen);
        }else{
            $nombre_imagen=$request->get('imagenes');
        }

        //ESTADO
        $estado = $request->get('estado');
        if($estado == "on"){
            $estado_marca = 0;
        }else{
            $estado_marca = 1;
        }

        $cant_activo=Marca::where('estado',0)->count();
        $unico=Marca::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_marca = 0;
      }

        // return $estado;
        $marca=Marca::find($id);
        $marca->nombre=strtoupper($request->get('nombre'));
        // $marca->abreviatura=strtoupper($request->get('abreviatura'));
        $marca->nombre_empresa=strtoupper($request->get('nombre_empresa'));
        $marca->telefono=strtoupper($request->get('telefono'));
        $marca->descripcion=$request->get('descripcion');
        $marca->imagen=$nombre_imagen;
        $marca->estado=$estado_marca;
        $marca->save();

        return redirect()->route('marca.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca=Marca::findOrFail($id);
        $marca->delete();

        return redirect()->route('marca.index');
    }

    public function create_with_ajax(Request $request){

        // Manejo de la imagen
        if ($request->hasFile('file_marca')) {
            $imagen = $request->file('file_marca');
            $nombre_imagen = time() . '_' . $imagen->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/marcas/');
            $imagen->move($destinationPath, $nombre_imagen);
        } else {
            $nombre_imagen = null;
        }
    
        // Obtener el contador de manera eficiente
        $contador = (Marca::max('id') ?? 0) + 1;
        $codigo = str_pad($contador, 5, '0', STR_PAD_LEFT);
    
        // Crear la marca
        Marca::create([
            'nombre'         => $request->get('nombre_marca') ?? '',
            'codigo'         => $codigo,
            'abreviatura'    => $request->get('abreviatura_marca') ?? '',
            'nombre_empresa' => $request->get('nombre_empresa') ?? '',
            'telefono'       => $request->get('telefono_marca') ?? '',
            'descripcion'    => $request->get('descripcion_marca') ?? 'Sin descripción',
            'imagen'         => $nombre_imagen,
            'estado'         => '0',
        ]);
    
        return response()->json(['success' => true, 'message' => 'Marca creada correctamente']);
    }

    public function change_state(Request $request){

        $marca = Marca::find($request->get('id'));
        if($marca->estado == 0){
            $marca->estado = 1;
        }else{
            $marca->estado = 0;
        }
        $marca->save();

        return response()->json(['success' => true, 'message' => 'Estado de la marca actualizado correctamente']);
    }

    public function edit_ajax(Request $request){
        
        $id = $request()->get('id');
        if($request->hasfile('imagen')){
            $imagen =$request->file('imagen');
            $nombre_imagen = time().$imagen->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/marcas/');
            $imagen->move($destinationPath,$nombre_imagen);
        }else{
            $nombre_imagen=$request->get('imagenes');
        }

        $cant_activo=Marca::where('estado',0)->count();
        $unico=Marca::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_marca = 0;
      }

        // return $estado;
        $marca=Marca::find($id);
        $marca->nombre=strtoupper($request->get('nombre'));
        // $marca->abreviatura=strtoupper($request->get('abreviatura'));
        $marca->nombre_empresa=strtoupper($request->get('nombre_empresa'));
        $marca->telefono=strtoupper($request->get('telefono'));
        $marca->descripcion=$request->get('descripcion');
        $marca->imagen=$nombre_imagen;
        $marca->save();
        return response()->json(['success' => true, 'marca' => $marca]);
    }

}
