<?php
namespace App\Http\Controllers;
use App\Garantia;
use App\Validez;
use Illuminate\Http\Request;

class ValidezController extends Controller
{

    public function index()
    {
        $validez=Validez::all();
        $conteo=Validez::where('estado',0)->count();
        return view('configuracion_general.validez.index',compact('validez','conteo'));
    }


    public function store(Request $request)
    {
        $validez=new Validez;
        $validez->descripcion=$request->get('descripcion');
        $validez->estado='0';
        $validez->save();

        return redirect()->route('validez.index');
    }


    public function update(Request $request, $id)
    {
         //ESTADO
        $estado = $request->get('estado');
        $nombre=$request->get('descripcion');

        if($estado == "on" ){ $estado_vali = 0;}
        else{ $estado_vali = 1;}
        if (empty($nombre)) {return redirect()->route('validez.index')->withErrors(['Descripción Vacía, Debe ingresar Registros']);}

        $cant_activo=Validez::where('estado',0)->count();
        $unico=Validez::where('id',$id)->where('estado',0)->first();

        if ($cant_activo==1 && isset($unico)) { $estado_vali = 0; }

        $validez=Validez::find($id);
        $validez->descripcion=$nombre;
        $validez->estado=$estado_vali;
        $validez->save();

        return redirect()->route('validez.index');

    }

    public function create_with_ajax(Request $request){
        // Obtener el contador de manera eficiente
        $contador = (Validez::max('id') ?? 0) + 1;
        $id = str_pad($contador, 2, '0', STR_PAD_LEFT);

        // Crear la validez
        Validez::create([
            'id'         => $id,
            'descripcion'    => $request->get('descripcion_validez') ?? 'Sin descripción',
            'estado'         => '0',
        ]);

        return response()->json(['success' => true, 'message' => 'Validez creada correctamente']);
    }
    public function change_state(Request $request){

        $validez = Validez::find($request->get('id'));
        if($validez->estado == 0){
            $validez->estado = 1;
        }else{
            $validez->estado = 0;
        }
        $validez->save();

        return response()->json(['success' => true, 'message' => 'Estado de la validez actualizado correctamente']);
    }

    public function edit_ajax(Request $request){

        $id = $request->get('validez_edit_id');
        $validez=Validez::find($id);
        $cant_activo=Validez::where('estado',0)->count();
        $unico=Validez::where('id',$id)->where('estado',0)->first();
        if ($cant_activo==1 && isset($unico)) {
          $estado_validez = 0;
      }
        $validez->descripcion=strtoupper($request->get('descripcion_validez'));
        $validez->save();
        return response()->json(['success' => true, 'validez' => $validez]);
    }
}
