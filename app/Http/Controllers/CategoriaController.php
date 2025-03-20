<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Familia;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categoria::all();
        $conteo=Categoria::where('estado','0')->count();
        // return $conteo;
        return view('configuracion_general.categoria.index',compact('categorias','conteo'));
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
        // contador par codigo
        $suma=Categoria::all()->count();
        $suma ++;
        $cien=1000+$suma;
        $contador=substr($cien,1);

        $nombre=$request->get('descripcion');
        if (empty($nombre)) {
            return redirect()->route('categoria.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);
        // return redirect()->route('categoria.index');

        }
        $nombre=strtoupper($nombre);

        $categoria=new Categoria;
        $categoria->codigo=$contador;
        $categoria->descripcion=$nombre;
        $categoria->estado='0';
        $categoria->save();

        return redirect()->route('categoria.index');
        // return $nombre;
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
        $estado=$request->get('estado');
        if($estado=='on'){$estado_numero='0';}
        else{$estado_numero='1';}

        $nombre=$request->get('descripcion');
        $nombre=strtoupper($nombre);
        $categoria=Catgoria::efind($id);
        $categoria->estado=$estado_numero;
        $categoria->save();

        return redirect()->route('categoria.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function create_with_ajax(Request $request){
        // Obtener el contador de manera eficiente
        $contador = (Categoria::max('id') ?? 0) + 1;
        $codigo = str_pad($contador, 4, '0', STR_PAD_LEFT);

        // Crear la categoria
        Categoria::create([
            'codigo'         => $codigo,
            'descripcion'    => $request->get('descripcion_categoria') ?? 'Sin descripción',
            'estado'         => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Categoria creada correctamente']);
    }
    public function change_state(Request $request){

        $categoria = Categoria::find($request->get('id'));
        if($categoria->estado == 0){
            $categoria->estado = 1;
        }else{
            $categoria->estado = 0;
        }
        $categoria->save();

        return response()->json(['success' => true, 'message' => 'Estado de la categoria actualizado correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('categoria_edit_id');
        $categoria=Categoria::find($id);
        $cant_activo=Categoria::where('estado',0)->count();
        $unico=Categoria::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_categoria = 0;
      }
        $categoria->codigo=strtoupper($request->get('codigo_categoria'));
        $categoria->descripcion=strtoupper($request->get('descripcion_categoria'));
        $categoria->save();
        return response()->json(['success' => true, 'categoria' => $categoria]);
    }
}
